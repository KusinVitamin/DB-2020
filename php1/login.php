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
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 5)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
	session_destroy();   // destroy session data in storage
	session_start();
    $_SESSION['feedbackString'] = "You were logged out.";
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
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
if($_SESSION['feedbackString']){
	$feedbackString = $_SESSION['feedbackString'];
	echo $feedbackString;
	$_SESSION['feedbackString'] = "";
}
?>


</body>
</html>