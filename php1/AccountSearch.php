<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(function(){
    var includes = $('[data-include]');
    jQuery.each(includes, function(){
      var file = '/~erisal-8/php1/' + $(this).data('include') + '.php';
      $(this).load(file);
    });
  });
</script>
</head>
<body>

<form method="get" action="Start.php">
    <button type="submit">Start Page</button>
</form>

</body>
<div data-include="Header"></div>
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