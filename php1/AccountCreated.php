<html>
<head>
</head>

<body>

<form method="get" action="/~erisal-8/php1/Start.php">
    <button type="submit">Start Page</button>
</form>

 </body>

<?php

<<<<<<< HEAD
$servername   = "127.0.0.1";
$database = "db970801";
$username = "970801";
$password = "monkagiga123";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed.<br><br>" . $conn->connect_error);
}
echo "Database connection successful.<br><br>";

=======
session_start();

require_once 'db_connection.php';
>>>>>>> c9217d71d2f8db19beeb733fee77ae4812dfa5ac

// Extract account info from form.
$FnameInput = "'" . $_POST['FnameInput'] . "'";
$LnameInput = "'" . $_POST['LnameInput'] . "'";
$SexInput = "'" . $_POST['SexInput'] . "'";
$DoBInput = "'" . $_POST['DoBInput'] . "'";
$PasswordInput = "'" . $_POST['PasswordInput'] . "'";
if(empty($_POST['PnumberInput'])){
    $PnumberInput = "NULL";
} else{
    $PnumberInput = "'" . $_POST['PnumberInput'] . "'";
}
if(empty($_POST['EmailInput'])){
    $EmailInput = "NULL";
} else{
    $EmailInput = "'" . $_POST['EmailInput'] . "'";
}
if(empty($_POST['AdressInput'])){
    $AdressInput = "NULL";
} else{
    $AdressInput = "'" . $_POST['AdressInput'] . "'";
}
if(empty($_POST['PostalCodeInput'])){
    $PostalCodeInput = "NULL";
} else{
    $PostalCodeInput = "'" . $_POST['PostalCodeInput'] . "'";
}


// Insert account info as new tuple in the Customer table.
$sql_State = "INSERT INTO Customer (`Fname`, `Lname`, `Pnumber`, `Email`, `Adress`, `PostalCode`, `Sex`, `DoB`, `Password`) 
              VALUES ($FnameInput, $LnameInput, $PnumberInput, $EmailInput, $AdressInput, $PostalCodeInput, $SexInput, $DoBInput, $PasswordInput);";


if(mysqli_query($conn, $sql_State)){
    echo "Account created successfully.<br><br>";
<<<<<<< HEAD
=======
   
>>>>>>> c9217d71d2f8db19beeb733fee77ae4812dfa5ac
    
}else{
    echo "Account not created. Check your inputs.<br><br>" . $sql_State . "<br>" . mysqli_error($conn) . "<br><br>";
}






?>



</html>