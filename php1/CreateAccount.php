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
<style>
form.CredentialsForm {
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

<?php 
$accountChoice = $_GET['create_account'];

if($accountChoice == "employee"){
?>
	
<form class="CredentialsForm" method="POST" action="AccountSearch.php">
<input type = "hidden" name ="account" value="e">
Company name:      <input type="text" name ="CompanyInput" required> <br>
Email:	           <input type="text" name ="EmailInput" required> <br>
Personal password: <input type ="password" name ="P_passwordInput" required> <br>
First name         <input type="text" name ="Fname" > <br>
Last name          <input type="text" name ="Lname" > <br>
<button type ="submit">Create account</button>
</form>
    
<?php 
echo "Du valde att göra en employee.";
} else{
?>

<form class="CredentialsForm" method="POST" action="AccountSearch.php">
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
}
?>

</body>
</html>