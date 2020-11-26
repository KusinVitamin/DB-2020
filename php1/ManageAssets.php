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
session_start();
$feedbackString = "";
require_once 'db_connection.php';
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 120)) {
    header("Location: Logout.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();


$email = $_SESSION['email'];

$queryListAssets = "SELECT *
					FROM Employees AS E 
					INNER JOIN Assets AS A 
					ON E.Company = A.SupplierName
                    WHERE E.Email = $email;";


$resListAssets = mysqli_query($conn,$queryListAssets);

if(mysqli_num_rows($resListAssets)> 0){
    while($row = mysqli_fetch_array($resListAssets)){
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
            <form method="post" action="EditAsset.php">
  		    <label>Change stock (+-):</label>
  		    <input type="number" name="Offset" min="-10000" max="10000">
  		    <input type="submit" name="ChangeStock" value="Update">
            <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
            </td>
            <td>
            <form method="post" action="EditAsset.php">
            <label>Change name:</label>
            <input type="text" name="NewName" value="<?php echo $row['AssetName']; ?>">
  		    <input type="submit" name="ChangeName" value="Update">
            <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
		    </form> 
            </td>
            <td>
            <form method="post" action="EditAsset.php">
            <label>Change price:</label>
            <input type="number" name="NewPrice" min="1" max="10000"  value="<?php echo $row['AssetPrice']; ?>">
  		    <input type="submit" name="ChangePrice" value="Update">
            <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>">
		    </form> 
            </td>
            <td>
            <form method="post" action="EditAsset.php">
            <label>Change image url:</label>
            <input type="text" name="NewImage" value="<?php echo $row['AssetImage']; ?>">
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