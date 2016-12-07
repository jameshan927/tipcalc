<?php
    $subvar = 0;     // variable for subtotal
    $tipvar = 0;     // variable for tip
    $customtip = 0;  // variable for custom tip
    $splitvar = 0;   // variable for splitting
    $splitflag = 0;  // bool for split 
    $billerr = 0;    // bool for subtotal error 
    $tiperr = 0;     // bool for tip error 
    $spliterr = 0;   // bool for split error 
    $tipflag = 0;    // bool for tip
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Tip Calculator </title>
        <link rel="stylesheet" href="calc.css">
    </head>
    <body>
        <div id="content">
            <h1> Tip Calculator </h1>
            <form method="post">
                Bill subtotal: $ 
                <!-- text input box for subtotal,  checks if number and > 0 and saves the subtotal amount -->
                <!-- if not, sets the bill error flag and clears text input box -->
                <input type="text" id="subtotal" name="subtotal" value="<?php 
                    if(isset($_POST['subtotal'])) {
                        if(($_POST['subtotal'] > 0) && is_numeric($_POST['subtotal'])) {
                            echo $_POST['subtotal'];
                            $subvar = $_POST['subtotal'];
                        }
                        else {
                            echo '';
                            $billerr = 1;
                        }
                    }
                ?>"> <br> <?php 
                // if bill error flag is set, prints error message and resets bill error flag
                if($billerr) { ?> <p> <?php
                    echo "Please enter a valid subtotal"; ?> <br> </p> <?php
                    $billerr = 0;
                }
                ?>
                Tip percentage: <br>
                <?php
                // php for loop for tip with 10, 15, 20; 25 is for custom tip
                for($tip = 10; $tip <= 25; $tip+=5) {
                    if($tip == 25) {
                        break;
                    }
                    // if a tip amount is selected, sets the tip flag and saves tip amount
                    if(isset($_POST['tip']) && ($_POST['tip'] == $tip)) {
                        echo "<input type=\"radio\" name=\"tip\" value=\"{$tip}\" checked=\"checked\">{$tip}%";
                        $tipvar = $_POST['tip'];
                        $tipflag = 1;
                    } 
                    else {  
                        echo "<input type=\"radio\" name=\"tip\" value=\"{$tip}\">{$tip}%";
                    }
                }
                ?> <br>
                <?php
                // if custom tip is selected, sets the custom tip flag
                if(isset($_POST['tip']) && ($_POST['tip'] == 25)) {
                    echo "<input type=\"radio\" name=\"tip\" value=\"25\" checked=\"checked\">Enter %:";
                    $customtip = 1;
                }
                else {
                    echo "<input type=\"radio\" name=\"tip\" value=\"25\">Enter %:";
                } ?>
                <input type="text" id="tip" name="tiptext" value="<?php
                    // checks if custom tip amount is a number and > 0 and if custom tip flag is set then
                    // saves the custom tip amount
                    // if not, sets the custom tip error flag anc clears input text box
                    if(isset($_POST['tiptext'])) {
                        if(($_POST['tiptext'] > 0) && is_numeric($_POST['tiptext'])) { 
                            echo $_POST['tiptext'];
                            if($customtip) {
                                $tipvar = $_POST['tiptext'];
                            }
                        }
                        else {
                            echo '';
                            $tiperr = 1;
                        }
                    }
                ?>"> % <br> <?php 
                // if custom tip error flag is set and tip flag is not set, then print error message
                if($tiperr && !$tipflag) { ?> <p> <?php
                    echo "Please enter a valid tip amount"; ?> <br> </p> <?php
                    $tiperr = 0;
                }
                ?>
                Split: 
                <input type="text" id="split" name="split" value="<?php 
                    if(isset($_POST['split'])) {
                        // checks if split amount is a number and > 0, if it is, sets the split flag
                        // and saves the split amount
                        // if not sets split error flag and clears input text box
                        if(is_numeric($_POST['split']) && ($_POST['split'] > 0)) {
                            echo $_POST['split'];
                            $splitflag = 1;
                            $splitvar = $_POST['split'];
                        }
                        else {
                            echo '';
                            $spliterr = 1;
                        }
                    }
                    // default 1 person
                    else {
                        echo '1';
                    } 
                ?>"> person(s) <br> <?php
                // if split error flag is set, prints error message
                if($spliterr) { ?> <p> <?php
                    echo "Please enter a valid split amount"; ?> <br> </p> <?php 
                } 
                ?>
                <input type="submit" value="Submit">
            </form>
        </div>
        
            <p>
            <?php 
                // if there is a subtotal and a tip amount
                if($subvar && $tipvar) {
                    // check is split flag is set
                    if($splitflag) {
                        // if split number is 1
                        if($splitvar == 1) {
                            $tipamount = $subvar * ($tipvar/100);
                            $bill = $subvar + $tipamount; ?> <textarea rows="4" cols="30" readonly> <?php
                            echo "Tip: $" . number_format($tipamount, 2); ?> &#13;&#10; <?php
                            echo "The total bill is: $" . number_format($bill, 2);   ?> </textarea> <?php                          
                        }
                        // if split number is > 1
                        else {
                            $tipamount = $subvar * ($tipvar/100);
                            $bill = $subvar + $tipamount;
                            $splittip = $tipamount/$splitvar;
                            $splitbill = $bill/$splitvar; ?> <textarea rows="6" cols="30" readonly> <?php
                            echo "Tip: $" . number_format($tipamount, 2); ?> &#13;&#10; <?php
                            echo "The total bill is: $" . number_format($bill, 2); ?> &#13;&#10; &#13;&#10; <?php                      
                            echo "Split tip: $" . number_format($splittip, 2); ?> &#13;&#10; <?php
                            echo "Split bill: $" . number_format($splitbill, 2); ?> </textarea> <?php
                        }
                    }
                    // if split flag is not set
                    else {
                        // if split error flag is not set
                        if(!$spliterr) {
                            $tipamount = $subvar * ($tipvar/100);
                            $bill = $subvar + $tipamount; ?> <textarea rows="4" cols="30" readonly> <?php
                            echo "Tip: $" . number_format($tipamount, 2); ?> &#13;&#10; <?php
                            echo "The total bill is: $" . number_format($bill, 2); ?> </textarea> <?php                           
                        }
                        // reset split error flag
                        else {
                            $spliterr = 0;
                        }
                    }
                }
            ?>
            </p>
    </body>
</html>