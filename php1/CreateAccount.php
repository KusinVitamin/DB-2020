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
<div data-include="Header"></div>
	<form method="get" action="Start.php">
		<button type="submit">Start Page</button>
	</form>

<form method="POST" action="AccountCreate.php">
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