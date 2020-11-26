<?php
session_start();
$feedbackString = "";
require_once 'db_connection.php';
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 120)) {
    header("Location: Logout.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();


$email = $_SESSION['email'];

$quantity = $_POST['Quantity'];
$assetName = "'" . $_POST['AssetName'] . "'";

if($quantity != ""){
    
}
}
?>