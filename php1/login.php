<html>
<meta charset="UTF-8">
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
<?php 
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 30)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
session_start();
$feedbackString = "";
?>

<<<<<<< HEAD
<div data-include="Header"></div>


<form action ="AccountSearch.php" method="POST">
=======
<form action ="LoginCheck.php" method="POST">

 	<input type="radio" id="employee_login" name="loginInput" value="employee_login">
  	<label for="male">Login as employee </label><br>
  	<input type="radio" id="customer" name="loginInput" value="customer_login">
  	<label for="customer">Login as customer</label><br>
  	
  
>>>>>>> df7b9300ee2bec85d6f153b9f80d75be3ae017c7
		<p>
		<label>Email: </label>

		<input type ="text" id="userName" name="emailInput" required>		

		<input type ="text" id="email" name="email" required>		

		</p>
		
		<p>
		<label>Password:</label>
		<input type="password" id="password" name="password" required>
		<p>
		<input type="submit"  id="login"  value="Login">
		</p>
 </form>

<?php
$feedbackString = $_SESSION['feedbackString'];
echo $feedbackString;
?>


</body>
</html>