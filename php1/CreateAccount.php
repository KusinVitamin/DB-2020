<html>

<head>
<style>

form {
	background-color:yellow;
	width:400px;
	border:2px solid black;
	margin:10px;
	padding:10px;
	


}



</style>






</head>



<body>

<<<<<<< HEAD
	<form method="get" action="/~erisal-8/php1/Start.php">
		<button type="submit">Start Page</button>
	</form>

<form method="POST" action="AccountCreated.php">
=======
	<form method="get" action="Start.php">
		<button type="submit">Start Page</button>
	</form>

<form method="POST" action="AccountCreate.php">
>>>>>>> c9217d71d2f8db19beeb733fee77ae4812dfa5ac
First Name      <input type="text" name ="FnameInput" required> <br>
Last Name       <input type="text" name ="LnameInput" required> <br>
Phone number    <input type ="tel" name ="PnumberInput" > <br>
Email           <input type="text" name ="EmailInput" > <br> 
Adress          <input type="text" name ="AdressInput" > <br> 
Postal code  	<input type="text" name ="PostalCodeInput" > <br> 
Sex             <input type="radio"id="male" name ="SexInput" value="M" required>
	 			<label for="M">Male</label><br>
	  			<input type="radio"id="female" name ="SexInput" value="F" required>
	 			<label for="F">Female</label><br>  
Date of birth   <input type="date" name ="DoBInput" required> <br> 
Password  		<input type="password" name ="PasswordInput" required> <br> 

<button type ="submit">Create account</button>






</form>



</body>




</html>