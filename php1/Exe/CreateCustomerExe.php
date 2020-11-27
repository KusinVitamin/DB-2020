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

$fnameInput = "'" . $_POST['Fname'] . "'";
$lnameInput = "'" . $_POST['Lname'] . "'";
$pnumberInput = "'" . $_POST['PnumberInput'] . "'";
$emailInput = "'" . $_POST['EmailInput'] . "'";
$addressInput = "'" . $_POST['AdressInput'] . "'";
$postalCodeInput = "'" . $_POST['PostalCodeInput'] . "'";
$passwordInput = "'" . $_POST['Password'] . "'";

$queryEmailExists = "SELECT Con.Email
					 FROM ContactInfo AS Con 
					 INNER JOIN Customers AS Cus 
					 ON Con.CustomerID = Cus.CustomerID
					 WHERE Con.Email = $emailInput
					 UNION
					 SELECT Emp.Email
					 FROM Employees AS Emp
					 WHERE Emp.Email = $emailInput";

$resEmailExists = mysqli_query($conn, $queryEmailExists);

if(mysqli_num_rows($resEmailExists) === 1){
	$_SESSION['feedbackString'] = "Email already in use.";
	header("Location: ../Pages/CreateAccount.php");
} else{
	$queryInsertCustomer = "INSERT INTO Customers (Password)
        					VALUES ($passwordInput);";

	mysqli_query($conn, $queryInsertCustomer);
	
	$queryInsertContactInfo = "INSERT INTO ContactInfo (CustomerID, Fname, Lname, Pnumber, Email, Address, PostalCode)
							   SELECT CustomerID, $fnameInput, $lnameInput, $pnumberInput, $emailInput, $addressInput, $postalCodeInput
							   FROM Customers 
							   WHERE Password = $passwordInput";

	mysqli_query($conn, $queryInsertContactInfo);
	$_SESSION['feedbackString'] = "Customer account created.";
	header("Location: ../Pages/AssetListings.php");
}
}
?>