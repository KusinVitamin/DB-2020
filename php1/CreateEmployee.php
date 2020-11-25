<?php
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
	$feedbackString = "Email already in use.";
} else{
    $querySupplierExists = "SELECT CompanyPassword
    FROM Suppliers
    WHERE SupplierName = $supplierInput;";

    $resSuppliersExists = mysqliquery($conn, $querySuppliersExists);

    if(mysqli_num_rows($resSuppliersExists) === 1){
        $row = mysqli_fetch_assoc($result);
        
        if($row['CompanyPassword'] === $companyPasswordInput){
            $queryInsertEmployee = "INSERT INTO Employees (Email, Company, Fname, Lname, Password)
                        VALUES ($emailInput, $companyInput, $fnameInput, $lnameInput, $passwordInput);";
            mysqliquery($conn, $queryInsertEmployee);
            $feedbackString = "Employee account created.";
        } else{
            $feedbackString = "Incorrect company password.";
        }
    } else{
        $queryInsertSupplierAndEmployee = "INSERT INTO Suppliers (SupplierName, CompanyPassword)
                        VALUES ($companyInput, $companyPasswordInput)
                        AND
                        INSERT INTO Employees (Email, Company, Fname, Lname, Password)
                        VALUES ($emailInput, $companyInput, $fnameInput, $lnameInput, $passwordInput);";
        $feedbackString = "Employee account created. (New supplier)";
    }
}
?>