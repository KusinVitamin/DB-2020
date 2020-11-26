<?php
session_start();
$feedbackString = "";
require_once 'db_connection.php';
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 5)) {
    header("Location: Logout.php");
}
$_SESSION['LAST_ACTIVITY'] = time();


$email = $_SESSION['email'];


$nameInput = "'" . $_POST['AssetName'] . "'";
$stockInput = "'" . $_POST['Stock'] . "'";
$priceInput = "'" . $_POST['Price'] . "'";
$pictureInput = "'" . $_POST['Picture'] . "'";


$employeeCompany = "SELECT SupplierName
                   FROM Employees
                   WHERE Email = $email;";

$queryInsertAsset = "INSERT INTO Assets (AssetName, SupplierName, Stock, AssetPrice, AssetImage)
          VALUES ($nameInput, $employeeCompany, $stockInput, $priceInput, $pictureInput);";
        mysqli_query($conn, $queryInsertAsset);
        echo $nameInput, $employeeCompany, $stockInput, $priceInput, $pictureInput;
        $feedbackString = "New asset created.";



?>