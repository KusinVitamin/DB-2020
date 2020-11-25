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
</head>
<body>

<div data-include="Header"></div>

<?php 
session_start();


if (!isset($_SESSION['username_login'])):
?>
 <form method="get" action="CreateAccount.php">
    <button type="submit">Create account</button>
</form>

<form method="get" action="login.php">
    <button type="submit">Log in</button>
</form>
<?php else: ?>
<span class="menu-item">Welcome <?php echo $_SESSION['username_login']; ?> Login Success <br> <form method="get" action="Logout.php">
    <button type="submit">Log out</button>
</form></span>
<?php endif; ?>


</body>





    




</html>