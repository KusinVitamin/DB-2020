<?php
session_start();
if(isset($_SESSION['email']) && isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 5)){
    header("Location: Logout.php");
}
$_SESSION['LAST_ACTIVITY'] = time();
$feedbackString = "";
require_once 'db_connection.php';

$companyInput = "'" . $_POST['CompanyInput'] . "'";
$emailInput = "'" . $_POST['EmailInput'] . "'";
$passwordInput = "'" . $_POST['P_passwordInput'] . "'";
$companyPasswordInput = "'" . $_POST['C_passwordInput'] . "'";
$fnameInput = "'" . $_POST['Fname'] . "'";
$lnameInput = "'" . $_POST['Lname'] . "'";



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
} else{
    $querySuppliersExists = "SELECT CompanyPassword
                             FROM Suppliers
                             WHERE SupplierName = $companyInput;";

    $resSuppliersExists = mysqli_query($conn, $querySuppliersExists);

    if(mysqli_num_rows($resSuppliersExists) === 1){

        $row = mysqli_fetch_assoc($result);
        
        if($row['CompanyPassword'] === $companyPasswordInput){
            $queryInsertEmployee = "INSERT INTO Employees (Email, Company, Fname, Lname, Password)
                                    VALUES ($emailInput, $companyInput, $fnameInput, $lnameInput, $passwordInput);";
            mysqli_query($conn, $queryInsertEmployee);
            $feedbackString = "Employee account created.";
        } else{
            $feedbackString = "Incorrect company password.";
        }
    } else{
        
        $queryInsertSupplier = "INSERT INTO Suppliers (SupplierName, CompanyPassword)
                                VALUES ($companyInput, $companyPasswordInput);";

        mysqli_query($conn, $queryInsertSupplier);

        $queryInsertEmployee = "INSERT INTO Employees (Email, Company, Fname, Lname, Password)
                                VALUES ($emailInput, $companyInput, $fnameInput, $lnameInput, $passwordInput);";

        mysqli_query($conn, $queryInsertEmployee);

        $feedbackString = "Employee account created. (New supplier)";
    }
}
$_SESSION['feedbackString'] = $feedbackString;


header('Location: CreateAccount.php');

?>