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

mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

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

$index = 0;
while($index < count($_SESSION['shoppingCart'])){
    $assetname = $_SESSION['shoppingCart'][$index];
    $quantity = $_SESSION['shoppingCart'][$index+1];
    $queryAddDetail = "INSERT INTO OrderDetails (OrderID, AssetName, SupplierName, Quantity)
                         SELECT MAX(OrderID), $assetname, SupplierName, $quantity
                         FROM Orders, Assets
                         WHERE AssetName = $assetname
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
    $index += 2;
}

mysqli_commit($conn);
$_SESSION['feedbackString'] = "Your order has been placed.";
header("Location: ../Pages/AssetListings.php");
}
?>