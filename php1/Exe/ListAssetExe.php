<?php
session_start();
if(!isset($_SESSION['shoppingCart'])){
  $_SESSION['shoppingCart'] = array();
}
require_once '../misc/db_connection.php';
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: ../Exe/LogoutExe.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();
/****************************************************************/

$email = $_SESSION['email'];
$nameInput = "'" . $_POST['AssetName'] . "'";
$stockInput = "'" . $_POST['Stock'] . "'";
$priceInput = "'" . $_POST['Price'] . "'";
$imageInput = "'" . $_POST['Image'] . "'";

$queryAssetExists = "SELECT AssetName
                     FROM Assets
                     WHERE AssetName = $nameInput";

$resAssetExists = mysqli_query($conn, $queryAssetExists);

if(mysqli_num_rows($resAssetExists) === 1){
  $_SESSION['feedbackString'] = "Asset name already taken.";
  header("Location: ../Pages/ListAsset.php");
} else{
    $queryInsertAsset = "INSERT INTO Assets (AssetName, SupplierName, Stock, AssetPrice, AssetImage)
                         SELECT $nameInput, Company, $stockInput, $priceInput, $imageInput
                         FROM Employees
                         WHERE Email = $email;";

    mysqli_query($conn, $queryInsertAsset);
    $_SESSION['feedbackString'] = "Asset listed.";
    header("Location: ../Pages/ListAsset.php");
}
}
?>