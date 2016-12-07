<?php
    $subvar = 0; 
    $tipvar = 0;
    $customtip = 0;
    $splitvar = 0;
    $splitflag = 0;
    $billerr = 0;
    $tiperr = 0;
    $spliterr = 0;
    $tipflag = 0;
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Tip Calculator </title>
        <!-- this is where the css layout page goes -->
    </head>
    <body>
        <div id="content">
            <h1> Tip Calculator </h1>
            <form method="post">
                Bill subtotal: $ 
                <input type="text" name="subtotal" value="<?php 
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
                if($billerr) {
                    echo "Please enter a valid subtotal"; ?> <br> <?php
                    $billerr = 0;
                }
                ?>
                Tip percentage: <br>
                <?php
                for($tip = 10; $tip <= 25; $tip+=5) {
                    if($tip == 25) {
                        break;
                    }
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
                if(isset($_POST['tip']) && ($_POST['tip'] == 25)) {
                    echo "<input type=\"radio\" name=\"tip\" value=\"25\" checked=\"checked\">Enter %:";
                    $customtip = 1;
                }
                else {
                    echo "<input type=\"radio\" name=\"tip\" value=\"25\">Enter %:";
                } ?>
                <input type="text" name="tiptext" value="<?php
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
                ?>"> <br> <?php 
                if($tiperr && !$tipflag) {
                    echo "Please enter a valid tip amount"; ?> <br> <?php
                    $tiperr = 0;
                }
                ?>
                Split: 
                <input type="text" name="split" value="<?php 
                    if(isset($_POST['split'])) {
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
                    else {
                        echo '1';
                    } 
                ?>"> person(s) <br> <?php
                if($spliterr) {
                    echo "Please enter a valid split amount"; ?> <br> <?php 
                } 
                ?>
                <input type="submit" value="submit">
            </form>
            <p>
            <?php 
                if($subvar && $tipvar) {
                    if($splitflag) {
                        if($splitvar == 1) {
                            $tipamount = $subvar * ($tipvar/100);
                            $bill = $subvar + $tipamount;
                            echo "Tip: $" . number_format($tipamount, 2); ?> <br> <?php
                            echo "The total bill is: $" . number_format($bill, 2);                             
                        }
                        else {
                            $tipamount = $subvar * ($tipvar/100);
                            $bill = $subvar + $tipamount;
                            $splittip = $tipamount/$splitvar;
                            $splitbill = $bill/$splitvar;
                            echo "Tip: $" . number_format($tipamount, 2); ?> <br> <?php
                            echo "The total bill is: $" . number_format($bill, 2); ?> <br> <?php                      
                            echo "Split tip: $" . number_format($splittip, 2); ?> <br> <?php
                            echo "Split bill: $" . number_format($splitbill, 2);
                        }
                    }
                    else {
                        if(!$spliterr) {
                            $tipamount = $subvar * ($tipvar/100);
                            $bill = $subvar + $tipamount;
                            echo "Tip: $" . number_format($tipamount, 2); ?> <br> <?php
                            echo "The total bill is: $" . number_format($bill, 2);                            
                        }
                        else {
                            $spliterr = 0;
                        }
                    }
                }
            ?>
            </p>
    </body>
</html>
