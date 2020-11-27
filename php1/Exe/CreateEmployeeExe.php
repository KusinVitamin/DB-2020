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
    $_SESSION['feedbackString'] = "Email already in use.";
    header("Location: ../Pages/CreateAccount.php");
} else{
    $querySuppliersExists = "SELECT CompanyPassword
                             FROM Suppliers
                             WHERE SupplierName = $companyInput;";

    $resSuppliersExists = mysqli_query($conn, $querySuppliersExists);

    if(mysqli_num_rows($resSuppliersExists) === 1){

        $row = mysqli_fetch_assoc($resSuppliersExists);

        if(("'" . $row['CompanyPassword'] . "'") === $companyPasswordInput){
            $queryInsertEmployee = "INSERT INTO Employees (Email, Company, Fname, Lname, Password)
                                    VALUES ($emailInput, $companyInput, $fnameInput, $lnameInput, $passwordInput);";
            mysqli_query($conn, $queryInsertEmployee);
            $_SESSION['feedbackString'] = "Employee account created.";
            header('Location: ../Pages/AssetListings.php');
        } else{
            $_SESSION['feedbackString'] = "Incorrect company password.";
            header('Location: ../Pages/CreateAccount.php');
        }
    } else{
        
        $queryInsertSupplier = "INSERT INTO Suppliers (SupplierName, CompanyPassword)
                                VALUES ($companyInput, $companyPasswordInput);";

        mysqli_query($conn, $queryInsertSupplier);

        $queryInsertEmployee = "INSERT INTO Employees (Email, Company, Fname, Lname, Password)
                                VALUES ($emailInput, $companyInput, $fnameInput, $lnameInput, $passwordInput);";

        mysqli_query($conn, $queryInsertEmployee);

        $_SESSION['feedbackString'] = "Employee account created. (New supplier)";
        header('Location: ../Pages/AssetListings.php');
    }
}
}
?>