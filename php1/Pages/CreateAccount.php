<html>

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(function(){
    var includes = $('[data-include]');
    jQuery.each(includes, function(){
      var file = $(this).data('include') + '.php';
      $(this).load(file);
    });
  });
</script>
<style>
form.Credentials {
	background-color:yellow;
	width:400px;
	border:2px solid black;
	margin:10px;
	padding:10px;
}
</style>
</head>

<body>
<div data-include="../CSS/Header"></div>
<div class="page">
    <a class="pagetext">Create Account</a>
</div>
<?php 
session_start();
if(!isset($_SESSION['shoppingCart'])){
  $_SESSION['shoppingCart'] = array();
}
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: ../Exe/LogoutExe.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();

?>
<div data-include="../CSS/Notification"></div>
<?php
/****************************************************************/

if(isset($_POST['submitButton'])){
    
    $create_account= $_POST['create_account'];
    if($create_account == "employee"){
    ?>
    <form class="Credentials" method="POST" action="../Exe/CreateEmployeeExe.php">
    <input type = "hidden" name ="account" value="e">
    Company name:      <input type="text" name ="CompanyInput" required> <br>
    Email:	           <input type="text" name ="EmailInput" required> <br>
    Personal password: <input type ="password" name ="P_passwordInput" required> <br>
    Company password: <input type ="password" name ="C_passwordInput" required> <br>
    First name         <input type="text" name ="Fname" > <br>
    Last name          <input type="text" name ="Lname" > <br>
    <button type ="submit">Create account</button>
	</form>
    
	<?php 
	// Account creating for Employee

	}else {
	?>
    <form class="Credentials" method="POST" action="../Exe/CreateCustomerExe.php">
    <input type = "hidden" name ="account" value="c">
    First name:     <input type="text" name ="Fname" required> <br>
    Last name:	    <input type="text" name ="Lname" required> <br>
    Phone number    <input type ="tel" name ="PnumberInput" > <br>
    Email           <input type="text" name ="EmailInput" required> <br>
    Adress          <input type="text" name ="AdressInput" required> <br>
    Postal code  	<input type="text" name ="PostalCodeInput" > <br>
    Password        <input type="password" name ="Password" required> <br>
    <button type ="submit">Create account</button>
    </form>
	<?php 

	// Account creating for customer

	}
    

}
?>

<?php 
if(!isset($_POST['submitButton'])){
    ?>
    <form class="Credentials" action="" method="post" >
	<input type="radio" id="employee" name="create_account" value="employee" required>
	<label for="male">Create employee account</label><br>
	<input type="radio" id="customer" name="create_account" value="customer" required>
	<label for="customer">Create customer account</label><br>
	<input type="submit" name="submitButton" >
	</form> 
<?php 
}
}
?>

</body>
</html>