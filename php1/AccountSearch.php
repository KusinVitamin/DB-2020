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

$inputEmail = $_POST['email'];
$inputPassword = $_POST['password'];



$queryEmailExists = "SELECT Con.Email
FROM ContactInfo AS Con 
INNER JOIN Customers AS Cus 
ON Con.CustomerID = Cus.CustomerID
WHERE Con.Email = $inputEmail
UNION
SELECT Emp.Email
FROM Employees AS Emp
WHERE Emp.Email = $inputEmail";

$resEmailExists = mysqliquery($conn, $queryEmailExists);

if(mysqli_num_rows($resEmailExists) === 1){
	$queryPasswordCheck = "SELECT Con.Email
			               FROM ContactInfo AS Con 
			               INNER JOIN Customers AS Cus 
			               ON Con.CustomerID = Cus.CustomerID
			               WHERE Con.Email = $inputEmail AND Cus.Password = $inputPassword";
	
	$resPasswordCheck = mysqliquery($conn, $queryPasswordCheck);

	if(mysqli_num_rows($resPasswordCheck) === 1){
		//Börja session.
		$feedbackString = "Login success!";
	} else {
        $feedbackString = "Incorrect password.";
    }	
} else{
    $feedbackString = "Email not registered.";
}

$_SESSION['feedbackString'] = $feedbackString;
?>