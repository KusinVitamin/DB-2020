<?php 
session_start();

//Employee variables

$E_company =$_POST['CompanyInput'];
$E_email =$_POST['EmailInput'];
$E_password =$_POST['P_passwordInput'];
$E_cPassword =$_POST['C_passwordInput'];
$E_fName =$_POST['Fname'];
$E_lName =$_POST['Lname'];


//Customer variables



$C_fName =$_POST['Fname'];
$C_lName =$_POST['Lname'];
$C_phone =$_POST['PnumberInput'];
$C_email =$_POST['EmailInput'];
$C_adress =$_POST['AdressInput'];
$C_postalcode =$_POST['PostalCodeInput'];
$C_password =$_POST['Password'];




require_once 'db_connection.php';

$accountType = $_POST['account'];
echo $accountType;


// e == employee else other statement Fึr att bestไmma location efter hไndelse =

if($accountType == "e"){
    
  

    
    
}
else{
    echo "Nu kollar den eftter customer CCCCCCCCCCC query";

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
		//Bรถrja session.
		$feedbackString = "Login success!";
	} else {
        $feedbackString = "Incorrect password.";
    }	
} else{
    $feedbackString = "Email not registered.";

}
}

?>