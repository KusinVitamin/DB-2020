<html>

<head>
    <link rel="stylesheet" href="../CSS/ListingStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function(){
            var includes = $('[data-include]');
            jQuery.each(includes, function(){
                var file = $(this).data('include') + '.php';
                $(this).load(file);
            });
        });
    </script>


</head>

<body>

<div data-include="../CSS/Header"></div>
<div class="page">
    <a class="pagetext">Check out</a>
</div>

<?php
session_start();
if(!isset($_SESSION['shoppingCart'])){
    $_SESSION['shoppingCart'] = array();
}
require_once '../misc/db_connection.php';
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: ../Exe/LogoutExe.php");
} else {
    $_SESSION['LAST_ACTIVITY'] = time();

/****************************************************************/

$index = 0;



while($index < count($_SESSION['shoppingCart'])) {
    $assetName = $_SESSION['shoppingCart'][$index];
    $order = $_SESSION['shoppingCart'][$index+1];
    $queryUpdateStock = "UPDATE Assets
                     SET Stock = Stock - $order
                     WHERE AssetName = $assetName;";

    mysqli_query($conn, $queryUpdateStock);

    $_SESSION['feedbackString'] = "Stock updated.";
    $index += 2;

 }
    ?>
    <h1 id="Receipt">Tack för din investering <?php echo $_POST['FnameInput']?>,  ditt buy gick igenom!! Total price for all your products = <?php echo $_SESSION['price']?> $</h1>
    <?php
    $_SESSION['shoppingCart']=array();
    $_SESSION['price'] =0;

}
?>
