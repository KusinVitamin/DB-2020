<?php 
session_start();
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 5)) {
    header("Location: Logout.php");
}
$_SESSION['LAST_ACTIVITY'] = time();
$feedbackString = "";
require_once 'db_connection.php';

$inputEmail = "'" . $_POST['email'] . "'";
$inputPassword = "'" . $_POST['password'] . "'";



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
        $feedbackString = "Login success!";
        header("Location: AssetListings.php");
	} else {
        $feedbackString = "Incorrect password.";
        header('Location: Login.php');
    }	
} else{
    $feedbackString = "Email not registered.";
    header('Location: Login.php');
}
$_SESSION['feedbackString'] = $feedbackString;
?>