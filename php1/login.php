<html>

<head>


<title> Login page</title>





</head>


<body>
<<<<<<< HEAD

<form method="get" action="/~erisal-8/php1/Start.php">
=======
<?php 
session_start();

?>
<form method="get" action="Start.php">
>>>>>>> c9217d71d2f8db19beeb733fee77ae4812dfa5ac
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