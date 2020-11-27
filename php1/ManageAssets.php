<html>
<meta charset="UTF-8">
<head>
<link rel="stylesheet" href="ListingStyle.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(function(){
    var includes = $('[data-include]');
    jQuery.each(includes, function(){
      var file = '/~erisal-8/php1/' + $(this).data('include') + '.php';
      $(this).load(file);
    });
  });
  
</script>
</head>
<body>
<div data-include="Header"></div>
<div class="page">
    <a class="pagetext">Manage assets</a>
</div>
<?php
session_start();
if(!isset($_SESSION['shoppingCart'])){
    $_SESSION['shoppingCart'] = array();
}
require_once 'db_connection.php';
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: Logout.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();

?>
<div data-include="Notification"></div>
<?php
/****************************************************************/

$email = $_SESSION['email'];

$queryListAssets = "SELECT *
                    FROM Employees AS E 
                    INNER JOIN Assets AS A 
                    ON E.Company = A.SupplierName
                    WHERE E.Email = $email;";


$resListAssets = mysqli_query($conn,$queryListAssets);

if(mysqli_num_rows($resListAssets)> 0){
  ?>
  <table id= "Write_Asset">
  <tr>
  <th>Product name</th>
  <th>Stock</th>
  <th>Price</th>
  <th>Image</th>
  <th>Change stock (+-)</th>
  <th>Change name</th>
  <th>Change price</th>
  <th>Change image-url</th>
  <th>Delete</th>
  </tr>
  <?php
  while($row = mysqli_fetch_array($resListAssets)){
      ?>
      <tr>
      <td><?php  echo $row['AssetName'];?></td>
      <td><?php  echo $row['Stock'];?></td>
      <td><?php  echo $row['AssetPrice'];?></td>
      <td><?php  echo "<img id='assetimg' src='{$row['AssetImage']}'"?></td>
      <td>
        <form method="post" action="EditAsset.php">
        <input type="number" name="Offset" min="-10000" max="10000"><br><br>
        <input type="submit" name="ChangeStock" value="Update">
        <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
        </form>
      </td>
      <td>
        <form method="post" action="EditAsset.php">
        <input type="text" name="NewName" value="<?php echo $row['AssetName']; ?>"><br><br>
        <input type="submit" name="ChangeName" value="Update">
        <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
        </form> 
      </td>
      <td>
        <form method="post" action="EditAsset.php">
        <input type="number" name="NewPrice" min="1" max="10000"  value="<?php echo $row['AssetPrice']; ?>"><br><br>
        <input type="submit" name="ChangePrice" value="Update">
        <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
        </form> 
      </td>
      <td>
        <form method="post" action="EditAsset.php">
        <input type="text" name="NewImage" value="<?php echo $row['AssetImage']; ?>"><br><br>
        <input type="submit" name="ChangeImage" value="Update">
        <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
        </form> 
      </td>
      <td>
        <form method="post" action="EditAsset.php">
        <input type="submit" name="Delete" value="Delete">
        <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
        </form> 
      </td>
      </tr>
  <?php
  }
  ?>
  </table>
  <?php 
    
}
}
?>
</body>
</html>