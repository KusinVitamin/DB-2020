<html>
<head>
</head>
<body>

<form method="get" action="/~erisal-8/php1/Start.php">
    <button type="submit">Start Page</button>
</form>

</body>
<?php 

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




$userName =$_POST['userName'];
$password =$_POST['password'];



$query = ("SELECT * FROM `Customer` WHERE `Email` LIKE '$userName' AND `Password` LIKE '$password'");
    
$result =mysqli_query($conn, $query);

if(mysqli_num_rows($result) ===1){
    echo "Login success!";
 }
 else{
     echo "Login failed. Email or password incorrect";
 }


?>
</html>