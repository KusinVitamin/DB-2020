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
session_start();
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 12020)) {
    header("Location: Logout.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();
$feedbackString = "";
?>

<div data-include="Header"></div>


<form action ="AccountSearch.php" method="POST">
		<p>
		<label>Email: </label>	

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
}
?>
</body>
</html>