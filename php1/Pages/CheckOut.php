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
    <a class="pagetext">Checkout</a>
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

//Detta �r bara ett test f�r att se output
$list = $_SESSION['shoppingCart'];
for($x =0; $x <sizeof($list) ;$x=$x+1){
    $name = $list[$x];
    $x=$x+1;
    $antal =$list[$x];
    

    
    
    //get Suppliername
    $suppliQuery = "SELECT SupplierName FROM `Assets` WHERE `AssetName`= $name";
    
    $supres = mysqli_query($conn,$suppliQuery);
    
    $row = mysqli_fetch_row($supres);
    
     echo $row[0];
    
    $OrderDetQuerry = "INSERT into 'OrderDetails' ('OrderID','AssettName', 'SupplierName', 'Quantity') 
                                Values ('36','$name', '$row[0]', '$antal')";
}


//Writing out the shopping cart
?>


<div data-include="../CSS/Notification"></div>

<table id= "Write_Asset">
<tr>
<th>Product name</th>
<th>Seller</th>
<th>Price</th>
<th>Image</th>
<th>Quantity</th>

</tr>
</table>
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
    <td><?php  echo $row['AssetPrice'];?>$</td>
    <td><?php  echo  "<img id='assetimg' src='{$row['AssetImage']}'";?> width:100px Height:100px </td>
    <td>
    <?php echo $_SESSION['shoppingCart'][$index+1];?><br><br>
    
    </td>

    </tr>
    </table>
    
    <?php
    $index += 2;
}
?>
<h1> Total price: $<?php echo $totalPrice?></h1>
<?php

if(!isset($_SESSION['email'])) {
  ?>

  <form class="Credentials" method="POST" action="../Exe/CheckOutExe.php">
  <input type="hidden" name="TotalPrice" value=<?php echo $totalPrice; ?>>
  First name:			<input class="goat" type="text" name ="FnameInput" required> <br>
  Last name:      	<input class="goat" type="text" name ="LnameInput" required> <br>
  Phone number:	    <input class="goat" type="text" name ="PhoneInput" required> <br>
  Email:	            <input class="goat" type="text" name ="EmailInput" required> <br>
  Address:	            <input type="text" name ="AddressInput" required> <br>
  Postal code:	      <input type="text" name ="PostalInput" required> <br>
  <button type ="submit">Place order</button>
  </form>

<?php 
}
else{ 
  $email = $_SESSION['email'];
  $query = "SELECT * 
            FROM ContactInfo 
            WHERE Email = $email";
  
  $result = mysqli_query($conn,$query);
  $row = mysqli_fetch_array($result)

  ?>
  
  <form class="Credentials" method="POST" action="../Exe/CheckOutExe.php">
  <input type="hidden" name="TotalPrice" value=<?php echo $totalPrice; ?>>
  First name:			<input type="text" name ="FnameInput" value="<?php echo $row['Fname']; ?>"  required> <br>
  Last name:      	<input type="text" name ="LnameInput" value="<?php echo $row['Lname']; ?>" required> <br>
  Phone number:	    <input type="text" name ="PhoneInput" value="<?php echo $row['Pnumber']; ?>" required> <br>
  Email:	            <input type="text" name ="EmailInput" value="<?php echo $row['Email']; ?>" required> <br>
  Address:	        <input type="text" name ="AddressInput" value="<?php echo $row['Address']; ?>" required> <br>
  Postal code:	    <input type="text" name ="PostalInput" value="<?php echo $row['PostalCode']; ?>" required> <br>
  <button type ="submit">Place order</button>
  </form>
  
<?php
}
}
?>

</body>
</html>