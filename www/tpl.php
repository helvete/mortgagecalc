<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="index">

    <title>Salary calculator</title>
    <style>
        li {
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <h1>Mortgage calculator</h1>
    <div>
        <form method="POST">
            <table class="itseemsiliketablez">
                <tr><td>
                <label for="loan">Loan *</label>
                </td><td>
                <input type="text" name="loan" value="" />
                </td></tr>

                <tr><td>
                <label for="loan">Interest rate *</label>
                </td><td>
                <input type="text" name="interest" value="" />
                </td></tr>

                <tr><td>
                <label for="loan">Monthly payment *</label>
                </td><td>
                <input type="text" name="monthly" value="" />
                </td></tr>

                <tr><td>
                <label for="paymentstartat">First payment date (YYYY-MM-01) *</label>
                </td><td>
                <input type="text" name="paymentstartat" value="" />
                <tr><td>

                <label for="interestpaidbeforefirst">Interest paid before first payment</label>
                </td><td>
                <input type="text" name="interestpaidbeforefirst" value="0" />
                </td><td>

                <tr><td>
                <input type="submit" name="submit" value="Calculate" />
                </td><td>
            </table>
        </form>
    </div>
    <?php include(__DIR__ . "/disclaimer.html"); ?>
</body>
</html>
