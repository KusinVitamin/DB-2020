<?php
session_start();

$emailInput =  isset($_SESSION['email']) ? $_SESSION['email'] : array();
$employee = array();

require_once 'db_connection.php';



$nameInput = "'" . $_POST['AssetName'] . "'";
$stockInput = "'" . $_POST['Stock'] . "'";
$priceInput = "'" . $_POST['Price'] . "'";
$pictureInput = "'" . $_POST['Picture'] . "'";


$employeeCompany = "SELECT Company
                   FROM Employees
                   WHERE Email = $emailInput;";

$queryInsertAsset = "INSERT INTO Assets (AssetName, SupplierName, Stock, AssetPrice, AssetImage)
          VALUES ($nameInput, $employeeCompany, $stockInput, $priceInput, $pictureInput);";
        mysqli_query($conn, $queryInsertAsset);
        echo $nameInput, $employeeCompany, $stockInput, $priceInput, $pictureInput;
        $feedbackString = "New asset created.";


?>