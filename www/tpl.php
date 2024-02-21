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
        span.error {
            color: red;
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
                </td><td>
                    <span class='error'><?=$errors['loan']??''?></span>
                </td></tr>

                <tr><td>
                <label for="interest">Interest rate *</label>
                </td><td>
                <input type="text" name="interest" value="" />
                </td><td>
                    <span class='error'><?=$errors['interest']??''?></span>
                </td></tr>

                <tr><td>
                <label for="monthly">Monthly payment *</label>
                </td><td>
                <input type="text" name="monthly" value="" />
                </td><td>
                    <span class='error'><?=$errors['monthly']??''?></span>
                </td></tr>

                <tr><td>
                <label for="paymentstartat">First payment date (YYYY-MM-01) </label>
                </td><td>
                <input type="text" name="paymentstartat" value="" />
                </td><td>
                    <span class='error'><?=$errors['paymentstartat']??''?></span>
                <tr><td>

                <label for="interestpaidbeforefirst">Interest paid before first payment</label>
                </td><td>
                <input type="text" name="interestpaidbeforefirst" value="0" />
                </td><td>
                    <span class='error'><?=$errors['interestpaidbeforefirst']??''?></span>
                </td><td>

                <tr><td>
                    Early payment #1
                <label for="ep1payment">amount</label>
                </td><td>
                <input type="text" name="ep1payment" value="" />
                </td><td>
                <label for="ep1when">date</label>
                </td><td>
                <input type="text" name="ep1when" value="" />
                </td><td>
                    <span class='error'><?=$errors['ep1']??''?></span>
                </td></tr>

                <tr><td>
                    Early payment #2
                <label for="ep2payment">amount</label>
                </td><td>
                <input type="text" name="ep2payment" value="" />
                </td><td>
                <label for="ep2when">date</label>
                </td><td>
                <input type="text" name="ep2when" value="" />
                </td><td>
                    <span class='error'><?=$errors['ep2']??''?></span>
                </td></tr>

                <tr><td>
                    Early payment #3
                <label for="ep3payment">amount</label>
                </td><td>
                <input type="text" name="ep3payment" value="" />
                </td><td>
                <label for="ep3when">date</label>
                </td><td>
                <input type="text" name="ep3when" value="" />
                </td><td>
                    <span class='error'><?=$errors['ep3']??''?></span>
                </td></tr>

                <tr><td>
                    Early payment #4
                <label for="ep4payment">amount</label>
                </td><td>
                <input type="text" name="ep4payment" value="" />
                </td><td>
                <label for="ep4when">date</label>
                </td><td>
                <input type="text" name="ep4when" value="" />
                </td><td>
                    <span class='error'><?=$errors['ep4']??''?></span>
                </td></tr>

                <tr><td>
                <input type="submit" name="submit" value="Calculate" />
                </td><td>
            </table>
        </form>
        <br />
        <div>
            <b>
                Input numbers as float using <i>dot</i> as a decimal separator and <i>nothing</i> as thousands separator.
            </b>
        </div>
    </div>
    <?php include(__DIR__ . "/disclaimer.html"); ?>
</body>
</html>
