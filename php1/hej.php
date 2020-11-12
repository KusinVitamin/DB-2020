<html>
<head>
</head>

<?php

$servername   = "127.0.0.1";
$database = "db970801";
$username = "970801";
$password = "monkagiga123";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed cuse du suger: " . $conn->connect_error);
}
echo "Connected successfully <br>";





//get = få All input från SKRIV in delen

$firstName = $_GET['fNameInput'];
$lastName = $_GET['lNameInput'];
$phoneNumber= $_GET['phoneInput'];
$emailInput = $_GET['emailInput'];
$postalNumber = $_GET['postalInput'];
$sex = $_GET['sexInput'];
$dateOfBirth = $_GET['dateInput'];
$password = $_GET['passwordInput'];
$adress = $_GET['adressInput'];



//QUERYN för att lägga till customer
$sql_State ="INSERT INTO `Customer` (`CustomerID`, `Fname`, `Lname`, `Pnumber`, `Email`, `Adress`, `PostalCode`, `Sex`, `DoB`, `Password`) VALUES (NULL, '$firstName', '$lastName', '$phoneNumber', '$emailInput', '$adress', '$postalNumber', '$sex', '$dateOfBirth', '$password');";


// Checkar av om queryn var okej eller inte!
if(mysqli_query($conn, $sql_State)){
    echo $firstName . " " . $lastName. " is added  till datorbasen";
    
}else{
    echo "Queryn var felaktig   ". $sql_State . "<br>". mysqli_error($conn);
}






?>
<body>


<img src="https://media.discordapp.net/attachments/644554196577681418/664783568765059082/13467729_1139679689386204_340542460_o.jpg?width=395&height=702" alt="Italian Trulli">
 </body>


</html>