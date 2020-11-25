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
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 30)) {
  // last request was more than 30 minutes ago
  session_unset();     // unset $_SESSION variable for the run-time 
  session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
session_start();
$feedbackString = "";
?>
<div data-include="Header"></div>

<h1>
<form action=CreateAccount.php >
	
  <input type="radio" id="employee" name="create_account" value="employee">
  <label for="male">Create employee account</label><br>
  <input type="radio" id="customer" name="create_account" value="customer">
  <label for="customer">Create customer account</label><br>
  <input type="submit" value="Submit">
  
</form> 
<?php
$feedbackString = $_SESSION['feedbackString'];
echo $feedbackString;
?>


</body>



</html>