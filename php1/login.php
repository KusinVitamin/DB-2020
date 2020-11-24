<html>

<head>


<title> Login page</title>





</head>


<body>
<?php 
session_start();

?>
<form method="get" action="Start.php">
    <button type="submit">Start Page</button>
</form>

<form action ="AccountSearch.php" method="POST">
		<p>
		<label>Email: </label>
		<input type ="text" id="userName" name="userName" required>		
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