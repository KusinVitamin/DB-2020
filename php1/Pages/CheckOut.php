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
<a class="pagetext">Asset Listings</a>
</div>

<?php 
session_start();

require_once '../misc/db_connection.php';



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









//Checks if you not logged in and buyButton not pressed
if(!isset($_SESSION['email']) and !isset($_POST['buyButton'])) {
    
 ?>
 
 
  
    <form class="Credentials" method="POST" action="">
    <input type = "hidden" name ="account" value="e">
    First name:			<input class="goat" type="text" name ="FnameInput" required> <br>
    Last name:      	<input class="goat" type="text" name ="LnameInput" required> <br>
    Phone number:	    <input class="goat" type="text" name ="EmailInput" required> <br>
    Email:	            <input class="goat" type="text" name ="EmailInput" required> <br>
    Address:	            <input type="text" name ="EmailInput" required> <br>
	Postal code:	      <input type="text" name ="EmailInput" required> <br>
    <button type ="submit" name="buyButton">Buy products</button>
	</form>
	<?php 

}
elseif (isset($_SESSION['email']) and !isset($_POST['buyButton'])){ 
    $email = $_SESSION['email'];
    $query ="SELECT * FROM ContactInfo Where Email=$email";
    
    
    
    $result = mysqli_query($conn,$query);
    
    while($row = mysqli_fetch_array($result)){
     ?>
      
        
         
    <form class="Credentials" method="POST" action="">
    <input type = "hidden" name ="account" value="e">
    First name:			<input type="text" name ="FnameInput" value="<?php echo $row['Fname']; ?>"  required> <br>
    Last name:      	<input type="text" name ="LnameInput" value="<?php echo $row['Lname']; ?>" required> <br>
    Phone number:	    <input type="text" name ="EmailInput" value="<?php echo $row['Pnumber']; ?>" required> <br>
    Email:	            <input type="text" name ="EmailInput" value="<?php echo $row['Email']; ?>" required> <br>
    Address:	        <input type="text" name ="EmailInput" value="<?php echo $row['Address']; ?>" required> <br>
	Postal code:	    <input type="text" name ="EmailInput" value="<?php echo $row['PostalCode']; ?>" required> <br>
    <button type ="submit" name="buyButton">Buy products</button>
	</form>
       
        
        <?php 
        

}
}else{
    if(isset($_POST['buyButton'])){
        ?>
        <h1 id="showprice">Tack för din investering <?php echo $_POST['FnameInput']?>,  ditt buy gick igenom!! Total price for all your products = <?php echo $_SESSION['price']?> $</h1>
        <?php
        $_SESSION['shoppingCart']=array();
        $_SESSION['price'] =0;
       
        
    }else{
        echo "pop";
    }
}


?>

</body>
</html>