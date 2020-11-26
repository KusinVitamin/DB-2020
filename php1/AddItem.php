<?php 
session_start();
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 120)) {
    header("Location: Logout.php");
} else{
    $_SESSION['LAST_ACTIVITY'] = time();
    $feedbackString = "";
}

require_once 'db_connection.php';


$assetName = $_GET['assetname'];
$quant = $_GET['quantity'];

print_r($_GET);


$first_sql = "SELECT Stock FROM `Assets` WHERE AssetName='$assetName'";


$res = mysqli_query($conn, $first_sql);
$row =mysqli_fetch_assoc($res);

if(($row['Stock'] - $quant) <0 ){
   
    echo "Too few in stock";
    
}else{
    
    $second_sql = "UPDATE `Assets` SET Stock =Stock-$quant WHERE AssetName='$assetName'";
    $result = mysqli_query($conn,$second_sql) or die(mysql_error());
    
   
   
     echo "CONGRATS";
    
    }





?>