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
    <a class="pagetext">Order <?php echo $_GET['OrderID']; ?></a>
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

?>
<div data-include="../CSS/Notification"></div>
<?php
/****************************************************************/

$email = $_SESSION['email'];

$queryListOrderDetails = "SELECT *
                          FROM OrderDetails
                          WHERE OrderID = $OrderID;";

$resListOrderDetails = mysqli_query($conn,$queryListOrderDetails);

if(mysqli_num_rows($resListOrderDetails)> 0){
  ?>
  <table id= "Write_Asset">
  <tr>
  <th>Asset Name</th>
  <th>Supplier Name</th>
  <th>Quantity</th>
  </tr>
  <?php
  while($row = mysqli_fetch_array($resListOrderDetails)){
      ?>
      <tr>
      <td><?php  echo $row['AssetName'];?></td>
      <td><?php  echo $row['SupplierName'];?></td>
      <td><?php  echo $row['Quantity'];?></td>
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