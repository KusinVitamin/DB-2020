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
<div class="page">
    <a class="pagetext">Login</a>
</div>
<?php 
session_start();
if(!isset($_SESSION['shoppingCart'])){
    $_SESSION['shoppingCart'] = array();
}
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600020)) {
    header("Location: Logout.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();

?>
<div data-include="Notification"></div>
<?php
/****************************************************************/
?>
<form action ="AccountSearch.php" method="POST">
	<p>
	<label>Email: </label>	
	<input type ="text" id="email" name="email" required>		
	</p>
	<p>
	<label>Password: </label>
	<input type="password" id="password" name="password" required>
	<p>
	<input type="submit"  id="login"  value="Login">
	</p>
</form>
<?php
}
?>
</body>
</html>