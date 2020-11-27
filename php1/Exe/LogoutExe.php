<?php
session_start();
// Fixa här så att shopping cart arrayen sparas i shopping cart tabellen.
session_unset(); 
session_destroy();
session_start();
$_SESSION['feedbackString'] = "You were logged out.";
header("Location: ../Pages/AssetListings.php");
?>