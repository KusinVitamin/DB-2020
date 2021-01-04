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
    <a class="pagetext">Orders</a>
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

/****************************************************************/

if(isset($_POST['Delete'])){
    $OrderID = "'" . $_POST['OrderID'] . "'";

    $queryDeleteOrder = "DELETE FROM Orders
                         WHERE OrderID = $OrderID;";

    mysqli_query($conn,$queryDeleteOrder);

    $_SESSION['feedbackString'] = "Order deleted.";
}

?>
<div data-include="../CSS/Notification"></div>
<?php

$email = $_SESSION['email'];

if($email == "'admin'"){
  $queryListOrders = "SELECT *
                      FROM Orders;";
} else{
  $queryListOrders = "SELECT *
                      FROM Orders AS O 
                      INNER JOIN ContactInfo AS C 
                      ON O.ContactInfoID = C.ContactInfoID
                      WHERE C.Email = $email;";
}

$resListOrders = mysqli_query($conn,$queryListOrders);

if(mysqli_num_rows($resListOrders)> 0){
  ?>
  <table id= "Write_Asset">
  <tr>
  <th>Order ID</th>
  <th>Time Placed</th>
  <th>Price</th>
  <?php
  if($email == "'admin'"){
    ?>
    <th>Delete</th>
  <?php
  }
  ?>
  </tr>
  <?php
  while($row = mysqli_fetch_array($resListOrders)){
      ?>
      <tr>
      <td>
      <?php  echo $row['OrderID'];?><br><br>
      <form method="GET" action="../Pages/OrderDetails.php">
      <input type="hidden" name="OrderID" value="<?php echo $row['OrderID']; ?>"><br><br>
      <input type="submit" value="View details">
      </form>
      </td>
      <td><?php  echo $row['TimePlaced'];?></td>
      <td>$<?php  echo $row['TotalPrice'];?></td>
      <?php
      if($email == "'admin'"){
        ?>
        <td>
            <form method="post" action="../Pages/Orders.php">
            <input type="submit" name="Delete" value="Delete">
            <input type="hidden" name="OrderID" value="<?php echo $row['OrderID']; ?>">
            </form> 
        </td>
      <?php
      }
      ?>
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