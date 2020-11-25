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

<?php 
$set = "abc";

?>
<h1>
<form action=CreateAccount.php >
	
  <input type="radio" id="employee" name="create_account" value="employee">
  <label for="male">Create employee account</label><br>
  <input type="radio" id="customer" name="create_account" value="customer">
  <label for="customer">Create customer account</label><br>
  <input type="submit" value="Submit">
  
</form> 



</body>



</html>