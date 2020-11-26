<?php
$servername   = "127.0.0.1";
$database = "db970801";
$username = "970801";
$password = "monkagiga123";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed.<br><br>" . $conn->connect_error);
}
?>