<?php 

session_start();

$_SESSION = array();
?>
<span class="logout">You logged out <br> <form method="get" action="Start.php">
<button type="submit">Home page</button>
</form></span>
<?php 

session_destroy();



?>