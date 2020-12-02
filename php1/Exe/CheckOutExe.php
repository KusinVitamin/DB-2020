<?php
session_start();
if(!isset($_SESSION['shoppingCart'])){
    $_SESSION['shoppingCart'] = array();
}
require_once '../misc/db_connection.php';
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: ../Exe/LogoutExe.php");
} else {
    $_SESSION['LAST_ACTIVITY'] = time();

/****************************************************************/

$index = 0;



while($index < count($_SESSION['shoppingCart'])) {
    $assetName = $_SESSION['shoppingCart'][$index];
    $order = $_SESSION['shoppingCart'][$index+1];
    $queryUpdateStock = "UPDATE Assets
                     SET Stock = Stock - $order
                     WHERE AssetName = $assetName;";

    mysqli_query($conn, $queryUpdateStock);

    $_SESSION['feedbackString'] = "Stock updated.";
    $index += 2;

 }
}
?>
