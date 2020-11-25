<html>

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(function(){
    var includes = $('[data-include]');
    jQuery.each(includes, function(){
      var file = '/~ollelv-8/php1/' + $(this).data('include') + '.php';
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


<?php 


$accountChoice = $_GET['create_account'];

if($accountChoice == "employee"){
    ?>
    <form method="POST" action="AccountSearch.php">
    <input type = "hidden" name ="account" value="e">
    Company name:      <input type="text" name ="CompanyInput" required> <br>
    Email:	           <input type="text" name ="EmailInput" required> <br>
    Personal password: <input type ="password" name ="P_passwordInput" required> <br>
    First name         <input type="text" name ="Fname" > <br>
    Last name          <input type="text" name ="Lname" > <br>
    
   
    <button type ="submit">Create account</button>

</form>
    
    <?php 
    // Account creating for Employee
    
    echo "Du valde göra en employee";
}else {
    
    ?>
    <form method="POST" action="AccountSearch.php">
    <input type = "hidden" name ="account" value="c">
    First name:     <input type="text" name ="Fname" required> <br>
    Last name:	    <input type="text" name ="Lname" required> <br>
    Phone number    <input type ="tel" name ="PnumberInput" > <br>
    Email           <input type="text" name ="EmailInput" required> <br>
    Adress          <input type="text" name ="AdressInput" required> <br>
    Postal code  	<input type="text" name ="PostalCodeInput" > <br>
    Password        <input type="password" name ="Password" required> <br>
    Email password   <input type="password" name ="emailPasswordInput" required> <br>
    <button type ="submit">Create account</button>
    
    </form>
    
    
    <?php 
    
    // Account creating for customer
   
}


?>





</body>




</html>