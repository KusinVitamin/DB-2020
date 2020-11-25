<html>
<head>
</head>
<body>

<<<<<<< HEAD
<form method="get" action="/~erisal-8/php1/Start.php">
=======
<form method="get" action="Start.php">
>>>>>>> c9217d71d2f8db19beeb733fee77ae4812dfa5ac
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




$userName =$_POST['userName'];
$password =$_POST['password'];



$query = ("SELECT * FROM `Customer` WHERE `Email` LIKE '$userName' AND `Password` LIKE '$password'");
    
$result =mysqli_query($conn, $query);

<<<<<<< HEAD
if(mysqli_num_rows($result) ===1){
    echo "Login success!<br><br>";
 }
 else{
     echo "Login failed. Email or password incorrect.<br><br>";
=======


if(mysqli_num_rows($result) ===1){
    
    $row =mysqli_fetch_assoc($result);
    

    if($row['Email'] === $userName && $row['Password'] === $password);
    {
        //Session variable ,Account from the present shopper
        $_SESSION['username_login'] = $row['Email'];
       
        header('Location:Start.php');
    }
  

 }
 else{
     echo "Login failed. Email or password incorrect";
>>>>>>> c9217d71d2f8db19beeb733fee77ae4812dfa5ac
 }


?>
</html>