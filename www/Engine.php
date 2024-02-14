<?php

namespace helvete\MortgageCalc;

class Engine {

    public static function calculate(CalculationInput $inp): CalculationResult {
        $calc = new CalculationResult();
        $totalPaid = $inp->getInterestPaidBeforeFirst();

        $rest = $inp->getLoan();
        $monthRef = $inp->getPaymentStartAt();
        while ($rest > 0) {
            $mInterest = $rest * $inp->getInterest() / 12 / 100;
            $mAnnuity = $inp->getMonthly() - $mInterest;
            $rest -= $mAnnuity;
            #if ($dt->format('Y-m') === '2023-04') {
            #    $rest -= 710000;
            #    $totalPaid += 710000;
            #}
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
                        $t->getMessage(),
                    );
                }
            }
            $this->errors[$formName] = 'Invalid input';
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
