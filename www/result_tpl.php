<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="index">

    <title>Mortgage calculator</title>
    <style>
        li {
            line-height: 1.5;
        }
        tr.early td {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Mortgage calculator result</h1>
    <div>

        <div>
            Total paid: <b><?= number_format($result->getTotalPaid(), 2, thousands_separator: '') ?></b>
            <a href='/'>[new calculation]</a>
        </div>
        <br />
        <table border=1 class="itseemsiliketablez">
        <tr>
            <th>Month</th>
            <th>Interest part</th>
            <th>Annuity part</th>
            <th>Loan remaining</th>
        </tr>
<?php
foreach ($result->getMonthlyStats() as $stat) {
    printf(
        '<tr class="%s"><td>%s</td><td>%.2f</td><td>%.2f</td><td>%.2f</td></tr>',
        $stat->isEarlyPaymentIncluded() ? 'early' : '',
        $stat->getMonthRef()->format('d.m.Y'),
        $stat->getInterestPart(),
        $stat->getAnnuityPart(),
        $stat->getLoanRemaining(),
    );
}
?>
        </table>
    </div>
    <?php include(__DIR__ . "/disclaimer.html"); ?>
</body>
</html>
