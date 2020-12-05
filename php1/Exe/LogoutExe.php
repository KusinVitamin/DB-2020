<?php
session_start();
require_once '../misc/db_connection.php';

// Fixa här så att shopping cart arrayen sparas i shopping cart tabellen.

$cart = $_SESSION['shoppingCart'];
$email = $_SESSION['email'];


$list = $_SESSION['shoppingCart'];
for($x =0; $x <sizeof($list) ;$x=$x+1){
    $name = $list[$x];
    
    $x=$x+1;
    $antal =$list[$x];
    
    //get Suppliername
    $suppliQuery = "SELECT SupplierName FROM `Assets` WHERE `AssetName`= $name";
    
    $supres = mysqli_query($conn,$suppliQuery);
    
    $row = mysqli_fetch_row($supres);
    
    //Check if product in shoppingcartdetatils
    $checkShopping = "SELECT AssetName FROM `ShoppingCartDetails`
                       INNER JOIN ContactInfo ON ContactInfo.CustomerID =ShoppingCartDetails.CustomerID
                        WHERE ContactInfo.Email=$email AND AssetName=$name";
    $shopping = mysqli_query($conn,$checkShopping);
    
    //it already exists
    if($saft =mysqli_num_rows($shopping) === 1 ){
        
        //Update the product to right amount
        $updateQuery ="UPDATE `ShoppingCartDetails` SET `Quantity`='$antal' WHERE (AssetName=$name and
                        CustomerID=(SELECT CustomerID FROM `ContactInfo` WHERE `Email` LIKE $email))";
        $update = mysqli_query($conn,$updateQuery);
        
        
    }//It does not exist inside shoppingcart history
    else{
        
        //Insert into shoppingcartdetails
        $ShoppingcartQuery = "INSERT INTO `ShoppingCartDetails` (`AssetName`, `CustomerID`, `Quantity`) VALUES ($name
            ,(SELECT CustomerID FROM `ContactInfo` WHERE `Email` LIKE $email), '$antal')";
        $resultCheckStock = mysqli_query($conn,$ShoppingcartQuery);
        
    }
}

session_unset(); 
session_destroy();
session_start();
$_SESSION['feedbackString'] = "You were logged out.";
header("Location: ../Pages/AssetListings.php");

?>