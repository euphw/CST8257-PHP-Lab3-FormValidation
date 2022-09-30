<?php error_reporting(E_ALL); ?>
<?php
session_start();  // start PHP session! 

extract($_POST);

//$name = $_GET["name"];
//$txtPIN = $_GET["txtPIN"];
$amountErrorMsg = '';
$rateErrorMsg = '';
$yearErrorMsg = '';
$nameErrorMsg = '';
$postalErrorMsg = '';
$phoneErrorMsg = '';
$emailErrorMsg = '';
$whenErrorMsg = '';
$isValuddated = true;

function ValidatePrincipal($amount) {
    if (!trim($amount)) {
        $amountErrorMsg = 'The principal amount can not be blank';
    } elseif (is_numeric($amount) == false || $amount <= 0) {
        $amountErrorMsg = 'The principal amount must be numeric and greater than 0';
    } else {
        $amountErrorMsg = '';
    }
    return $amountErrorMsg;
}

function ValidateRate($rate) {
    if (!trim($rate)) {
        $rateErrorMsg = 'The interest rate can not be blank';
    } elseif (is_numeric($rate) == false || $rate <= 0) {
        $rateErrorMsg = 'The interest rate must be numeric and non-negative';
    } else {
        $rateErrorMsg = '';
    }
    return $rateErrorMsg;
}

function ValidateYears($years) {
    if ($years <= 0 || $years > 20) {
        $yearErrorMsg = 'Number of years to deposit must be a numeric between 1 and 20.';
    } else {
        $yearErrorMsg = '';
    }
    return $yearErrorMsg;
}

function ValidateName($name) {
    if (!trim($name)) {
        $nameErrorMsg = 'The name can not be blank';
    } else {
        $nameErrorMsg = '';
    }
    return $nameErrorMsg;
}

function ValidatePostalCode($postalCode) {
    $pattern = '/^[a-zA-Z][0-9][a-zA-Z]\s*[0-9][a-zA-Z][0-9]$/';
    if (!trim($postalCode)) {
        $postalErrorMsg = 'Postal code can not be blank';
    } elseif (preg_match($pattern, $postalCode) == 1) {
        $postalErrorMsg = '';
    } else {
        $postalErrorMsg = 'Incorrect Postal Code';
    }
    return $postalErrorMsg;
}

function ValidatePhone($phone) {
    $pattern = '/^[2-9]\d\d-[1-9][1-9][1-9]-\d\d\d\d$/';
    if (!trim($phone)) {
        $phoneErrorMsg = 'Phone number can not be blank';
    } elseif (preg_match($pattern, $phone) == 1) {
        $phoneErrorMsg = '';
    } else {
        $phoneErrorMsg = 'Incorrect phone number';
    }
    return $phoneErrorMsg;
}

function ValidateEmail($email) {
    $pattern = '/\b[a-zA-Z0-9._%+-]+@(([a-zA-Z0-9-]+)\.)+[a-zA-Z]{2,4}\b/';
    if (!trim($email)) {
        $emailErrorMsg = 'Email can not be blank';
    } elseif (preg_match($pattern, $email) == 1) {
        $emailErrorMsg = '';
    } else {
        $emailErrorMsg = 'Incorrect email';
    }
    return $emailErrorMsg;
}

if (isset($btnLogin)) {

    $amountErrorMsg = ValidatePrincipal($amount);
    $rateErrorMsg = ValidateRate($rate);
    $yearErrorMsg = ValidateYears($years);
    $nameErrorMsg = ValidateName($name);
    $postalErrorMsg = ValidatePostalCode($postalCode);
    $phoneErrorMsg = ValidatePhone($phone);
    $emailErrorMsg = ValidateEmail($email);

    if (trim($amountErrorMsg) != null) {
        $isValuddated = false;
    }
    if (trim($rateErrorMsg) != null) {
        $isValuddated = false;
    }
    if (trim($yearErrorMsg) != null) {
        $isValuddated = false;
    }
    if (trim($nameErrorMsg) != null) {
        $isValuddated = false;
    }
    if (trim($postalErrorMsg) != null) {
        $isValuddated = false;
    }
    if (trim($phoneErrorMsg) != null) {
        $isValuddated = false;
    }
    if (trim($emailErrorMsg) != null) {
        $isValuddated = false;
    }

    if ($contactMethod == "Phone") {
        if (isset($times) == false) {
//            $isValuddated=false;
            $whenErrorMsg = "When preferred contact method is phone, you have to select one or more contact times";
            $isValuddated = false;
        }
    }

    if (isset($amount)) {
        $amountValue = $amount;
    } else {
        $amountValue = '';
    }

    if (isset($rate)) {
        $rateValue = $rate;
    } else {
        $rate = '';
    }


    if (isset($name)) {
        $nameValue = $name;
    } else {
        $nameValue = '';
    }

    if (isset($postalCode)) {
        $postalCodeValue = $postalCode;
    } else {
        $postalCodeValue = '';
    }

    if (isset($phone)) {
        $phoneValue = $phone;
    } else {
        $phoneValue = '';
    }

    if (isset($email)) {
        $emailValue = $email;
    } else {
        $emailValue = '';
    }


} else if (isset($btnReset)) {
    $amountErrorMsg = '';
    $rateErrorMsg = '';
    $yearErrorMsg = '';
    $nameErrorMsg = '';
    $postalErrorMsg = '';
    $phoneErrorMsg = '';
    $emailErrorMsg = '';
    $whenErrorMsg = '';
    $amountValue = '';
    $rateValue = '';
    $nameValue = '';
    $postalCodeValue = '';
    $phoneValue = '';
    $emailValue = '';
    $years = -1;
}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>Deposit Calculator</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <style>
            html{
                margin:20px;
            }
            .container {
                max-width:70% !important;/*Set your own width %; */
            }
            h1{
                padding-top:10px;
                text-align: left;
            }
            .error{
                color:red;
            }
        </style>
    </head>
    <body>

        <?php if (!isset($btnLogin) || $isValuddated == false) { ?>
            <form action='DepositCalculator.php' method='post' class="container">
                <h1>Deposit Calculator</h1>
                <div class="row g-3">
                    <div class="col-md-3">
                        <p class="form-label">Principal Amount:</p>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="amount" value="<?php echo $amountValue ?>">
                    </div>
                    <div class="col-md-6 error">
                        <?php echo'<p>' . $amountErrorMsg . '</p>'; ?>
                    </div>
                    <div class="col-md-3">
                        <label>Interest Rate:</label>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="rate" value="<?php echo $rateValue ?>">
                    </div>
                    <div class="col-md-6 error">
                        <?php echo'<p>' . $rateErrorMsg . '</p>'; ?>
                    </div>
                    <div class="col-md-3">
                        <label>Years to Deposit:</label>
                    </div>
                    <div class="col-md-3">   
                        <select name="years" class="form-select">
                            <option value=-1 selected>Select years...</option>
                            <?php
                            for ($i = 1; $i <= 20; $i++) {
                                echo'<option value="' . $i . '"';
                                if (isset($years) && $years == $i) {
                                    echo "selected";
                                }
                                echo'>' . $i . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                    <div class="col-md-6 error">
                        <?php echo'<p>' . $yearErrorMsg . '</p>'; ?>
                    </div>
                    <hr>
                    <div class="col-md-3">
                        <label>Name:</label>
                    </div>
                    <div class="col-md-3"> 
                        <input type="text" class="form-control" name="name" value="<?php echo $nameValue ?>">
                    </div>
                    <div class="col-md-6 error">
                        <?php echo'<p>' . $nameErrorMsg . '</p>'; ?>

                    </div>
                    <div class="col-md-3">
                        <label>Postal Code:</label>
                    </div>
                    <div class="col-md-3"> 
                        <input type="text" class="form-control" name="postalCode" value="<?php echo $postalCodeValue ?>">
                    </div>
                    <div class="col-md-6 error">
                        <?php echo'<p>' . $postalErrorMsg . '</p>'; ?>

                    </div>
                    <div class="col-md-3">
                        <label>Phone Number:</label>
                    </div>
                    <div class="col-md-3"> 
                        <input type="tel" class="form-control" name="phone" value="<?php echo $phoneValue ?>">
                    </div>
                    <div class="col-md-6 error">
                        <?php echo'<p>' . $phoneErrorMsg . '</p>'; ?>
                    </div>
                    <div class="col-md-3">
                        <label>Email Address:</label>
                    </div>
                    <div class="col-md-3"> 
                        <input type="text" class="form-control" name="email" value="<?php echo $emailValue ?>">
                    </div>
                    <div class="col-md-6 error">
                        <?php echo'<p>' . $emailErrorMsg . '</p>'; ?>
                    </div>
                    <hr>
                    <div class="col-md-3">
                        <label>Preferred Contact Method:</label>
                    </div>
                    <div class="col-md-3"> 
                        <input type = "radio" name = "contactMethod" value = "Phone" checked = "checked" />	  
                        <label>Phone</label>
                        <input type = "radio" name = "contactMethod" value = "Email" />
                        <label>Email</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <br>
                    <p>If phone is selected, when can we contact you?(check all applicable)</p>
                </div>
                <div class="row g-3">
                    <div class="col-md-2">
                        <input type="checkbox" name="times[ ]" value="morning" <?php
                        if (isset($_POST['times'])) {
                            if (in_array("morning", $_POST['times'])) {
                                echo 'checked';
                            }
                        }
                        ?>/>
                        <label >Morning</label>
                    </div>
                    <div class="col-md-2"> 
                        <input type="checkbox" name="times[ ]" value="afternoon" <?php
                        if (isset($_POST['times'])) {
                            if (in_array("afternoon", $_POST['times'])) {
                                echo 'checked';
                            }
                        }
                        ?> />
                        <label >Afternoon</label>
                    </div>
                    <div class="col-md-2 ">
                        <input type="checkbox" name="times[ ]" value="evening" <?php
                        if (isset($_POST['times'])) {
                            if (in_array("evening", $_POST['times'])) {
                                echo 'checked';
                            }
                        }
                        ?> />
                        <label >Evening</label>
                    </div>
                    <div class="col-md-6 error">
    <?php echo'<p>' . $whenErrorMsg . '</p>'; ?>
                    </div>
                </div>
                <br>
                <div class="row g-3">
                    <div class="col-md-3 ">
                        <input type='submit' class="btn btn-primary" name='btnLogin' value='Login' />&nbsp;&nbsp;
                    </div>
                    <div class="col-md-3">
                        <input type='submit' class="btn btn-secondary" name='btnReset' value='Clear' />
                    </div>        
                </div>
            </form>
        </body>
    </html>

    <?php
} else {
    echo"<h1>Thank you " . $name . ",for using our deposit calculator!</h1>";
    echo"<p>Our customer service department will call you ";
    foreach ($times as $time) {         //use foreach to iterate through an array
        echo "$time" . ",";
    }
    echo"at " . $phone . ".</p>";
    echo"<p>The following is the result of the calculation:</p>";

    echo'<table class="table table-striped">';
    print('<thead>
                      <tr>
                        <th scope="col">Year</th>
                        <th scope="col">Principal at Year Start</th>
                        <th scope="col">Interest for the Year</th>
                      </tr>
                    </thead>
                    <tbody>');

    for ($i = 1; $i <= $years; $i++) {
        echo "<tr>";
        echo '<th scope="row">';
        echo $i;
        echo'</th>';
        echo '<td>';
        echo "$" . sprintf("%.2f", $amount);
        echo "</td>";
        echo '<td>';
        $interest = $amount * $rate / 100;
        echo "$" . sprintf("%.2f", $interest);
        echo "</td>";
        echo "</tr>";
        $amount = $amount + $interest;
    }
    echo "</tbody>";
    echo "</table>";
}
?>
</body>
</html>
