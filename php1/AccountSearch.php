<html>
<head>
</head>
<body>

<form method="get" action="Start.php">
    <button type="submit">Start Page</button>
</form>

</body>
<?php 
session_start();

require_once 'db_connection.php';




$userName =$_POST['userName'];
$password =$_POST['password'];



$query = ("SELECT * FROM `Customer` WHERE `Email` LIKE '$userName' AND `Password` LIKE '$password'");
    
$result =mysqli_query($conn, $query);



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
 }


?>
</html>