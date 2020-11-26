<html>
<meta charset="UTF-8">
<head>
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
<?php
require_once 'db_connection.php';
session_start();
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 120)) {
    header("Location: Logout.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();
$feedbackString = "";

//Assets written out

$query = ("SELECT * 
           FROM Assets 
           ORDER BY AssetName ASC");


$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result)> 0){
    while($row = mysqli_fetch_array($result)){
        ?>
       		<div class="assetTable">
            <table id= "Write_Asset" style="width: 3px;" border="3" cellpadding="4" background-color:333;>
            <tbody>
            <tr>
            <td><?php  echo "Product name ".$row['AssetName'];?>"</td>
            <td><?php  echo "Seller". $row['SupplierName'] . "\r\n";?>&nbsp;</td>
            <td><?php  echo "Stock: ". $row['Stock'] . "\r\n";?>&nbsp;</td>
            <td><?php  echo "Price: " .$row['AssetPrice'] . "$ \r\n";?>&nbsp;</td>
            <td><?php  echo  "<img src='{$row['AssetImage']}'"?> </td>
            <td>       
            <form method="post" action="EditCart.php">
  		      <label for="Quantity">Quantity:</label>
  		      <input type="number" id="Quantity" name="Quantity" min="1" value="1">
            <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
  		      <input type="submit" name="add_to_cart">
		        </form>
            </td>
            </tr>
            </tbody>
            </table>
          </div>
           <?php 
      }
}
}
?>
</body>
</html>