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

$inputEmail = "'" . $_POST['email'] . "'";
$inputPassword = "'" . $_POST['password'] . "'";

$_SESSION['shoppingCart'] = array();

$queryEmailExists = "SELECT Con.Email
                     FROM ContactInfo AS Con 
                     INNER JOIN Customers AS Cus 
                     ON Con.CustomerID = Cus.CustomerID
                     WHERE Con.Email = $inputEmail
                     UNION
                     SELECT Emp.Email
                     FROM Employees AS Emp
                     WHERE Emp.Email = $inputEmail";

$resEmailExists = mysqli_query($conn, $queryEmailExists);

if(mysqli_num_rows($resEmailExists) === 1){
	$queryPasswordCheck = "SELECT Con.Email
			               FROM ContactInfo AS Con 
			               INNER JOIN Customers AS Cus 
			               ON Con.CustomerID = Cus.CustomerID
                           WHERE Con.Email = $inputEmail AND Cus.Password = $inputPassword
                           UNION
                           SELECT Emp.Email
                           FROM Employees AS Emp
                           WHERE Emp.Email = $inputEmail AND Emp.Password = $inputPassword";
	
	$resPasswordCheck = mysqli_query($conn, $queryPasswordCheck);

	if(mysqli_num_rows($resPasswordCheck) === 1){
        $_SESSION['email'] = $inputEmail;
        
        $email = $_SESSION['email'];
            
        $checkShopping = "SELECT AssetName, Quantity FROM `ShoppingCartDetails`
                       INNER JOIN ContactInfo ON ContactInfo.CustomerID =ShoppingCartDetails.CustomerID
                        WHERE ContactInfo.Email=$email ";
         $shopping = mysqli_query($conn,$checkShopping);
            
         //Fill the shoppingarray with the history shoppingcart
         while ($row = mysqli_fetch_assoc($shopping)) 
         {
                
                
             array_push($_SESSION['shoppingCart'],"'".$row['AssetName']."'",$row['Quantity']);
                
                
         }
            
            
          
        // Delete items from shoppingcartdetails when logging in
         $deletdetails = "DELETE FROM ShoppingCartDetails
                          where CustomerID IN (SELECT CustomerID
                          FROM ContactInfo WHERE Email LIKE $email)";
         $delete =mysqli_query($conn,$deletdetails);
         
        
        
        
        
        
        
        
        // Fixa här så att shopping carten laddas från tabellen
        $_SESSION['feedbackString'] = "Login success!";
        header("Location: ../Pages/AssetListings.php");
	} else {
        $_SESSION['feedbackString'] = "Incorrect password.";
        header('Location: ../Pages/Login.php');
    }	
} else{
    $_SESSION['feedbackString'] = "Email not registered.";
    header('Location: ../Pages/Login.php');
}
}
?>