<html>
<meta charset="UTF-8">
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
    <a class="pagetext">Shopping Cart</a>
</div>
<?php
session_start();
if(!isset($_SESSION['shoppingCart'])){
  $_SESSION['shoppingCart'] = array();
}
require_once '../misc/db_connection.php';
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: ../Exe/LogoutExe.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();

/*************************************************************** */
  
// Remove from cart.
function remove(){
    $assetName = "'" . $_POST['AssetName'] . "'";

    $index = 0;
    while($index < count($_SESSION['shoppingCart'])){
        if($_SESSION['shoppingCart'][$index] == $assetName){
            
            while($index < (count($_SESSION['shoppingCart']) - 2)){
                $_SESSION['shoppingCart'][$index] = $_SESSION['shoppingCart'][$index+2];
                $_SESSION['shoppingCart'][$index+1] = $_SESSION['shoppingCart'][$index+3];
                $index += 2;
            }
            array_pop($_SESSION['shoppingCart']);
            array_pop($_SESSION['shoppingCart']);
            break;
        }
        $index += 2;
    }
    $_SESSION['feedbackString'] = "Asset removed from cart.";
}

// Update quantity.
if(isset($_POST['ChangeQuantity'])){
    if($_POST['NewQuantity'] == 0){
        remove();
    } else{
        $newQuantity = $_POST['NewQuantity'];
        $assetName = "'" . $_POST['AssetName'] . "'";
        
        $index = 0;
        while($index < count($_SESSION['shoppingCart'])){
            if($_SESSION['shoppingCart'][$index] == $assetName){
                $_SESSION['shoppingCart'][$index+1] = $newQuantity;
                $_SESSION['feedbackString'] = "Quantity updated.";
                break;
            }
            $index += 2;
        }
    }
}

if(isset($_POST['Remove'])){
    remove();
}

?>
<div data-include="../CSS/Notification"></div>

<table id= "Write_Asset">
<tr>
<th>Product name</th>
<th>Seller</th>
<th>Price</th>
<th>Image</th>
<th>Quantity</th>
<th>Remove</th>
</tr>
<?php

$totalPrice = 0;
$index = 0;
while($index < count($_SESSION['shoppingCart'])){
    $assetName = $_SESSION['shoppingCart'][$index];

    $query = "SELECT * 
              FROM Assets 
              WHERE AssetName = $assetName;";

    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
    $totalPrice += $row['AssetPrice'] * $_SESSION['shoppingCart'][$index+1];
    ?>
    <table id= "Write_Asset">
    <tr>
    <td><?php  echo $row['AssetName'];?></td>
    <td><?php  echo $row['SupplierName'];?></td>
    <td>$<?php  echo $row['AssetPrice']* $_SESSION['shoppingCart'][$index+1] . "";?></td>
    <td><?php  echo  "<img id='assetimg' src='{$row['AssetImage']}'";?> width:100px Height:100px </td>
    <td>
    <?php echo $_SESSION['shoppingCart'][$index+1];?><br><br>
    <form method="post" action="../Pages/Shoppingcart.php">
        <input type="number" name="NewQuantity" min="0" max="<?php echo $row['Stock']; ?>" value="<?php echo $_SESSION['shoppingCart'][$index+1]; ?>"><br><br>
        <input type="submit" name="ChangeQuantity" value="Update">
        <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
        <input type="hidden" name="AssetPrice" value="<?php echo $row['AssetPrice']; ?>">
        <input type="hidden" name="Assetqt" value="<?php echo $_SESSION['shoppingCart'][$index+1]; ?> ">
 
    </form>
    </td>
    <td>
    <form method="post" action="../Pages/Shoppingcart.php">
        <input type="submit" name="Remove" value="Remove">
        <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
        <input type="hidden" name="AssetPrice" value="<?php echo $row['AssetPrice']; ?>">
        <input type="hidden" name="Assetqt" value="<?php echo $_SESSION['shoppingCart'][$index+1]; ?> ">
    </form>
    </td>
    </tr>
    </table>
    
    <?php
    $index += 2;
}

if (count($_SESSION['shoppingCart']) == 0){
        ?>
        <h1>Your shoppingcart is empty.</h1>
    <?php 
}
else{
    ?>
    <form action="../Pages/CheckOut.php">
    <input type="submit" id="olle"  value="Checkout" />
    </form>
    <h1> Total price: $<?php echo $totalPrice?></h1>
<?php 

}
}
?>
</body>
</html>