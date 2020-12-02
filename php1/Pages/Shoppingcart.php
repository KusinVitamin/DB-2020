<html>
<meta charset="UTF-8">
<head>
<style>

#olle{
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

</style>


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

error_reporting(0);
//Function for updating shopping cart price when removing asset
function delete() {
    echo gettype($_POST['AssetPrice']);
    echo gettype($_POST['Assetqt']);
    echo gettype($_SESSION['price']);
    
    if(count($_SESSION['shoppingCart'])<2)
    {
        $_SESSION['price'] =0;
    
    }else{
    
        $_SESSION['price'] -= ($_POST['AssetPrice'] * $_POST['Assetqt']) ;

        }

}

//Function for updating shopping cart price when updating
function updates() {
    $index = 0;
    if($_POST['NewQuantity'] == 0){
        $_SESSION['price'] -= $_SESSION['shoppingCart'][$index+1]* $_POST['NewQuantity'] ;
    }
    if($_POST['NewQuantity']> $_POST['Assetqt'] ){
     
        $_SESSION['price'] += $_POST['AssetPrice'] * ($_POST['NewQuantity'] - $_POST['Assetqt']);
    }else{
      
        $_SESSION['price'] += $_POST['AssetPrice'] * ($_POST['NewQuantity'] - $_POST['Assetqt']);

    }

}
    
    
    



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
            delete();
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
                updates();
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

$index = 0;
while($index < count($_SESSION['shoppingCart'])){
    $assetName = $_SESSION['shoppingCart'][$index];

    $query = "SELECT * 
              FROM Assets 
              WHERE AssetName = $assetName;";

    $result = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($result);
    
    ?>
    <table id= "Write_Asset">
    <tr>
    <td><?php  echo $row['AssetName'];?></td>
    <td><?php  echo $row['SupplierName'];?></td>
    <td><?php  echo $row['AssetPrice']* $_SESSION['shoppingCart'][$index+1] . "";?>$</td>
    <td><?php  echo  "<img id='assetimg' src='{$row['AssetImage']}'";?> width:100px Height:100px </td>
    <td>
    <?php echo $_SESSION['shoppingCart'][$index+1];?><br><br>
    <form method="post" action="../Pages/Shoppingcart.php">
        <input type="number" name="NewQuantity" min="0" max="<?php echo $row['Stock']; ?>" value="<?php echo $_SESSION['shoppingCart'][$index+1]; ?>"><br><br>
        <input type="submit" name="ChangeQuantity" value="Update">
        <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
         <input type="hidden" name="AssetPrice" value="<?php echo $row['AssetPrice']; ?>">
           <input type="hidden" name="Assetqt" value="<?php echo $_SESSION['shoppingCart'][$index+1]; ?> ">;
 
    </form>
    </td>
    <td>
    <form method="post" action="../Pages/Shoppingcart.php">
        <input type="submit" name="Remove" value="Remove">
        <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
          <input type="hidden" name="AssetPrice" value="<?php echo $row['AssetPrice']; ?>">
           <input type="hidden" name="Assetqt" value="<?php echo $_SESSION['shoppingCart'][$index+1]; ?> ">;
    </form>
    </td>
    </tr>
    </table>
    
    <?php
    $index += 2;
}

}

//Beh�ver hj�lp med css H������R!

?>


<?php if (count($_SESSION['shoppingCart']) ==0){?>

        <h1>Your shoppingcart is empty</h1>
        <?php } else{?>
        <form action="CheckOut.php">
    <input type="submit" id="olle" background-color: #4CAF50;
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer; value="Go to check out" />
</form>
        <h1> Total price for all your products = <?php echo $_SESSION['price']?> SEK</h1>
        
<?php 

}?>
</body>
</html>