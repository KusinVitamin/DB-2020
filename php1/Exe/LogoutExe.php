<?php
session_start();
require_once '../misc/db_connection.php';

$email = $_SESSION['email'];

for($x = 0; $x < count($_SESSION['shoppingCart']); $x = $x + 1){
    $assetName = $_SESSION['shoppingCart'][$x];
    $x = $x + 1;
    $quantity = $_SESSION['shoppingCart'][$x];
    
    $ShoppingcartQuery = "INSERT INTO ShoppingCartDetails (AssetName, CustomerID, Quantity)
                          SELECT $assetName, CustomerID, $quantity
                          FROM ContactInfo
                          WHERE Email = $email;";

    mysqli_query($conn,$ShoppingcartQuery);
}

session_unset(); 
session_destroy();
session_start();
$_SESSION['feedbackString'] = "You were logged out.";
header("Location: ../Pages/AssetListings.php");
?>