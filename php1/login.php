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
<div data-include="Header"></div>
<?php 
session_start();

?>

<form action ="LoginCheck.php" method="POST">

 	<input type="radio" id="employee_login" name="loginInput" value="employee_login">
  	<label for="male">Login as employee </label><br>
  	<input type="radio" id="customer" name="loginInput" value="customer_login">
  	<label for="customer">Login as customer</label><br>
  	
  
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














</body>















</html>