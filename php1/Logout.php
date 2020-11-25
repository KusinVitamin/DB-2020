<?php
session_unset(); 
session_destroy();
session_start();
$_SESSION['feedbackString'] = "You were logged out.";
?>