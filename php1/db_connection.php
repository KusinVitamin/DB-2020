<?php
$servername   = "127.0.0.1";
$database = "db970801";
$dbusername = "970801";
$dbpassword = "monkagiga123";
$conn = new mysqli($servername, $dbusername, $dbpassword, $database);
if ($conn->connect_error) {
    die("Connection failed.<br><br>" . $conn->connect_error);
}
?>