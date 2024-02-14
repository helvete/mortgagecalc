<?php

namespace helvete\MortgageCalc;

class Engine {

    public static function calculate(CalculationInput $inp): CalculationResult {
        $calc = new CalculationResult();
        $totalPaid = $inp->getInterestPaidBeforeFirst();

        $rest = $inp->getLoan();
        $monthRef = $inp->getPaymentStartAt();
        $ep = $inp->getEarlyPayments();
        while ($rest > 0) {
            $mInterest = $rest * $inp->getInterest() / 12 / 100;
            $mAnnuity = $inp->getMonthly() - $mInterest;
            $rest -= $mAnnuity;
            $earlyPaymentValue = $ep[$monthRef->format('Y-m')] ?? 0;
            if ($earlyPaymentValue) {
                $rest -= $earlyPaymentValue;
                $totalPaid += $earlyPaymentValue;
                $mAnnuity += $earlyPaymentValue;
            }
            $logMonth = clone $monthRef;
            $calc->addMonthlyStats(
                new MonthlyRecord($mInterest, $mAnnuity, $rest, $logMonth)
            );
            $monthRef->add(new \DateInterval('P1M'));
            $totalPaid += $inp->getMonthly();
        }
        $calc->setTotalPaid($totalPaid);
        return $calc;
    }
}

class MonthlyRecord {
    public function __construct(
        private float $interestPart,
        private float $annuityPart,
        private float $loanRemaining,
        private \DateTime $monthRef,
    ) {}

    public function getInterestPart(): float {
        return $this->interestPart;
    }

    public function getAnnuityPart(): float {
        return $this->annuityPart;
    }

    public function getLoanRemaining(): float {
        return $this->loanRemaining;
    }

    public function getMonthRef(): \DateTime {
        return $this->monthRef;
    }
}

class CalculationInput {
    private ?float $loan;
    private ?float $interest;
    private ?float $monthly;
    private ?\DateTime $paymentstartat;
    private ?float $interestpaidbeforefirst;
    private array $errors = [];
    private array $earlyPayments = [];

    public function __construct(
        array $post,
    ) {
        foreach ($post as $formName => $formVal) {
            if ($formName === 'submit') {
                continue;
            }
            if (property_exists($this, $formName)) {
                try {
                    if ($formName === 'paymentstartat') {
                        $this->$formName = new \DateTime($formVal);
                        continue;
                    }
                    $this->$formName = $formVal;
                    continue;
                } catch (\Throwable $t) {
                    $this->errors[$formName] = sprintf(
                        'Invalid format: %s',
                        $formVal ?: '""',
                    );
                    continue;
                }
            } elseif (preg_match('/^ep[1-2].*$/', $formName)) {
                continue;
            }
            $this->errors[$formName] = sprintf('Invalid input: %s', $formVal);
        }

        for ($i = 1; $i < 3; $i++) {
            if ($post["ep{$i}when"] && $post["ep{$i}payment"]) {
                try {
                    $dt = new \DateTime($post["ep{$i}when"]);
                    $this->earlyPayments[$dt->format('Y-m')]
                        = (float)$post["ep{$i}payment"];
                } catch (\Throwable $t) {
                    $this->errors["ep{$i}"] = 'Invalid format';
                    return;
                }
            }
        }
    }

    public function getLoan(): ?float {
       return $this->loan;
    }

    public function getInterest(): ?float {
       return $this->interest;
    }

    public function getMonthly(): ?float {
       return $this->monthly;
    }

    public function getPaymentStartAt(): ?\DateTime {
       return $this->paymentstartat;
    }

    public function getInterestPaidBeforeFirst(): ?float {
       return $this->interestpaidbeforefirst;
    }

    public function getErrors(): array {
        return $this->errors;
    }

    public function hasErrors(): bool {
        return (bool)count($this->errors);
    }

    public function getEarlyPayments(): array {
        return $this->earlyPayments;
    }
}

class CalculationResult {
    public function __construct(
        private float $totalPaid = 0.0,
        private array $monhlyStats = [],
    ) {}

    public function getTotalPaid(): float {
        return $this->totalPaid;
    }

    public function getMonthlyStats(): array {
        return $this->monhlyStats;
    }

    public function addMonthlyStats(MonthlyRecord $record): void {
        $this->monhlyStats[] = $record;
    }

    public function setTotalPaid(float $amount): void {
        $this->totalPaid = $amount;
    }
}
