<html>
<head>
</head>
<body>

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