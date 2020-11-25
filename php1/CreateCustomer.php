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
	$queryInsertCustomer = "INSERT INTO Customers (Password)
        VALUES ($passwordInput);";
	
	mysqliquery($conn, $queryInsertCustomer);
	
	$queryContactInfo = "INSERT INTO ContactInfo (CustomerID, Fname, Lname, Pnumber, Email, Address, PostalCode)
			SELECT CustomerID, $Fname, $Lname, $Pnumber, $Email, $Address, $PostalCode
			FROM Customers 
			WHERE Password = $inputPassword;

	mysqliquery($conn, $queryContactInfo);

	$feedbackString = "Account created.";
}
?>