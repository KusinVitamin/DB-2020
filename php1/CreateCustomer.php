<?php
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 30)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
session_start();
$feedbackString = "";
require_once 'db_connection.php';
header('Location: CreateAccount.php');

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
	$feedbackString = "Email already in use.";
	header('Location: CreateAccount.php');
} else{
	$queryInsertCustomer = "INSERT INTO Customers (Password)
        VALUES ($passwordInput);";

	mysqli_query($conn, $queryInsertCustomer);
	
	$queryInsertContactInfo = "INSERT INTO ContactInfo (CustomerID, Fname, Lname, Pnumber, Email, Address, PostalCode)
			SELECT CustomerID, $fnameInput, $lnameInput, $pnumberInput, $emailInput, $addressInput, $postalCodeInput
			FROM Customers 
			WHERE Password = $passwordInput";

	mysqli_query($conn, $queryInsertContactInfo);


    $feedbackString = "Account created.";
    

    $feedbackString = "Account created";

}

$_SESSION['feedbackString'] = $feedbackString;
header("Location: CreateAccount.php");


?>