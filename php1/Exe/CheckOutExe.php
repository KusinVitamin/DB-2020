<?php
session_start();
if(!isset($_SESSION['shoppingCart'])){
  $_SESSION['shoppingCart'] = array();
}
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: ../Exe/LogoutExe.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();
require_once '../misc/db_connection.php';
/****************************************************************/

$FnameInput = "'" . $_POST['FnameInput'] . "'";
$LnameInput = "'" . $_POST['LnameInput'] . "'";
$PhoneInput = "'" . $_POST['PhoneInput'] . "'";
$EmailInput = "'" . $_POST['EmailInput'] . "'";
$AddressInput = "'" . $_POST['AddressInput'] . "'";
$PostalInput = "'" . $_POST['PostalInput'] . "'";
$TotalPrice = $_POST['TotalPrice'];

mysqli_autocommit($conn,FALSE);
$rollback = FALSE;

$queryContactExists = "SELECT ContactInfoID
                       FROM ContactInfo 
                       WHERE Fname = $FnameInput 
                       AND Lname = $LnameInput 
                       AND Pnumber = $PhoneInput 
                       AND Email = $EmailInput 
                       AND Address = $AddressInput 
                       AND PostalCode = $PostalInput;";

$resultContactExists = mysqli_query($conn, $queryContactExists);

if(mysqli_num_rows($resultContactExists) == 0){
    $queryInsertContact = "INSERT INTO ContactInfo (Fname, Lname, Pnumber, Email, Address, PostalCode)
              VALUES ($FnameInput, $LnameInput, $PhoneInput, $EmailInput, $AddressInput, $PostalInput);";

    mysqli_query($conn, $queryInsertContact);
}



$queryPlaceOrder = "INSERT INTO Orders (ContactInfoID, TotalPrice)
                    SELECT ContactInfoID, $TotalPrice
                    FROM ContactInfo
                    WHERE Fname = $FnameInput 
                    AND Lname = $LnameInput 
                    AND Pnumber = $PhoneInput 
                    AND Email = $EmailInput 
                    AND Address = $AddressInput 
                    AND PostalCode = $PostalInput;";

mysqli_query($conn, $queryPlaceOrder);

$_SESSION['feedbackString'] = "";
$index = 0;
while($index < count($_SESSION['shoppingCart'])){
    $assetName = $_SESSION['shoppingCart'][$index];
    $quantity = $_SESSION['shoppingCart'][$index+1];

    $queryCheckStock = "SELECT Stock
                        FROM Assets
                        WHERE AssetName = $assetName;";

    $resultCheckStock = mysqli_query($conn, $queryCheckStock);
    $row = mysqli_fetch_assoc($resultCheckStock);

    if($quantity > $row['Stock']){
        if($row['Stock'] == 0){
            $_SESSION['feedbackString'] .= $assetName . " ran out of stock since you added the item to your cart. The item has been removed from your cart.<br>";

            $removeIndex = $index;
            while($removeIndex < (count($_SESSION['shoppingCart']) - 2)){
                $_SESSION['shoppingCart'][$removeIndex] = $_SESSION['shoppingCart'][$removeIndex+2];
                $_SESSION['shoppingCart'][$removeIndex+1] = $_SESSION['shoppingCart'][$removeIndex+3];
                $removeIndex += 2;
            }
            array_pop($_SESSION['shoppingCart']);
            array_pop($_SESSION['shoppingCart']);
        
            $index -= 2;
        } else{
            $_SESSION['feedbackString'] .= "Stock of " . $assetName . " has been decreased to " . $row['Stock'] . " since you added the item to your cart. Your quantity of " . $quantity . " has been amended to the new maximum.<br>";
            $_SESSION['shoppingCart'][$index+1] = $row['Stock'];
        }
        $rollback = TRUE;
    } else{
        $queryAddDetail = "INSERT INTO OrderDetails (OrderID, AssetName, SupplierName, Quantity)
                            SELECT MAX(OrderID), $assetName, SupplierName, $quantity
                            FROM Orders, Assets
                            WHERE AssetName = $assetName
                            AND ContactInfoID
                            IN (SELECT ContactInfoID
                                FROM ContactInfo
                                WHERE Fname = $FnameInput 
                                AND Lname = $LnameInput 
                                AND Pnumber = $PhoneInput 
                                AND Email = $EmailInput 
                                AND Address = $AddressInput 
                                AND PostalCode = $PostalInput);";

        mysqli_query($conn, $queryAddDetail);

        $queryUpdateStock = "UPDATE Assets
                             SET Stock = Stock - $quantity
                             WHERE AssetName = $assetName;";

        mysqli_query($conn, $queryUpdateStock);
    }

    $index += 2;
}

mysqli_commit($conn);

if($rollback == FALSE){
    $_SESSION['feedbackString'] = "Your order has been placed.";
    unset($_SESSION['shoppingCart']);
    header("Location: ../Pages/AssetListings.php");
} else{
    $_SESSION['feedbackString'] .= "Your order was canceled.";
    mysqli_rollback($conn);
    header("Location: ../Pages/Shoppingcart.php");
}
}
?>