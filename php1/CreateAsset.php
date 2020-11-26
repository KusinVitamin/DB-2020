<?php
session_start();
$feedbackString = "";
require_once 'db_connection.php';
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 120)) {
    header("Location: Logout.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();


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
  $feedbackString = "Asset name already taken.";
  header("Location: ListAsset.php");
} else{
    $queryInsertAsset = "INSERT INTO Assets (AssetName, SupplierName, Stock, AssetPrice, AssetImage)
                         SELECT $nameInput, Company, $stockInput, $priceInput, $imageInput
                         FROM Employees
                         WHERE Email = $email;";

    mysqli_query($conn, $queryInsertAsset);
    $feedbackString = "Asset listed.";
    header("Location: ListAsset.php");
}
$_SESSION['feedbackString'] = $feedbackString;
}
?>