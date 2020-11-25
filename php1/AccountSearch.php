<?php 
session_start();

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

?>