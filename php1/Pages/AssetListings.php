<html>
<meta charset="UTF-8">
<head>

<script>
function myFunction() {
  alert("Hello! I am an alert box!");
}
</script>
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
require_once '../misc/db_connection.php';
session_start();
if(!isset($_SESSION['shoppingCart'])){
  $_SESSION['shoppingCart'] = array();
}
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: ../Exe/LogoutExe.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();

/****************************************************************/




function Sum($price,$quant)
{   
    $_SESSION['price'] += $_POST['AssetPrice'] * $quant;

    echo "<br>"; 
    echo  $_SESSION['price'] . "Detta is tot after add";
    echo "<br>";
    

}

function checkStockAddItems($conn, $index, $assetName, $quantity){
    $queryCheckStock = "SELECT Stock
                        FROM Assets
                        WHERE AssetName = $assetName;";

    $resultCheckStock = mysqli_query($conn,$queryCheckStock);
    $row = mysqli_fetch_array($resultCheckStock);
    $currentStock = $row['Stock'];
    
    if($currentStock >= ($_SESSION['shoppingCart'][$index] + $quantity)){
        
        $_SESSION['shoppingCart'][$index] += $quantity;
        if($quantity > 1){
            Sum($_POST['AssetPrice'], $quantity);
            $_SESSION['feedbackString'] = "Items added to cart.";
          } else{
            
            $_SESSION['feedbackString'] = "Item added to cart.";
            Sum($_POST['AssetPrice'], $quantity);
          }
    } else{
        $_SESSION['feedbackString'] = "Asset stock exceeded.Chose legit number off assets.";
       
    }
}


// Add items to cart
if(isset($_POST['Quantity'])){
    $assetName = "'" . $_POST['AssetName'] . "'";
    $asprice = $_POST['AssetPrice'];
    $quantity = $_POST['Quantity'];
    
    
    
    $index = 0;
    while($index < count($_SESSION['shoppingCart'])){
      if($_SESSION['shoppingCart'][$index] == $assetName){
        checkStockAddItems($conn, $index+1, $assetName, $quantity);
        break;
      }
      $index += 2;
    }
    
    if($index == count($_SESSION['shoppingCart'])){
      array_push($_SESSION['shoppingCart'], $assetName, 0);
      checkStockAddItems($conn, $index+1, $assetName, $quantity);
    }
}

//Assets written out
if(isset($_GET['AssetSearch'])){
    $Search = $_GET['AssetSearch'];
} else{
    $Search = "";
}

$query ="SELECT * 
         FROM Assets 
         WHERE AssetName 
         LIKE '%$Search%'
         ORDER BY AssetName ASC;";

$result = mysqli_query($conn,$query);

if(isset($_GET['AssetSearch'])){
    if(mysqli_num_rows($result) != 1){
        $_SESSION['feedbackString'] = "Your search generated " . mysqli_num_rows($result) . " results.";
    } else{
        $_SESSION['feedbackString'] = "Your search generated 1 result.";
    }
}
?>

<div data-include="../CSS/Notification"></div>

<?php
if(mysqli_num_rows($result)> 0){
    
    ?>
    <table id= "Write_Asset">
    <tr>
    <th>Product name</th>
    <th>Seller</th>
    <th>Stock</th>
    <th>Price</th>
    <th>Image</th>
    <?php 
    if(isset($_SESSION['email'])){
        $emailString = $_SESSION['email'];
        
        $queryCheckEmployee = "SELECT Email
                               FROM Employees
                               WHERE Email = $emailString";

        $resCheckEmployee = mysqli_query($conn, $queryCheckEmployee);

        if(mysqli_num_rows($resCheckEmployee) === 0){
            $isCustomer = true;
            ?>
            <th>Purchase (Quantity)</th>
        <?php
        }
    } else {
        ?>
        <th>Purchase (Quantity)</th>
    <?php
    }
    ?>
    </tr>
    <?php
    while($row = mysqli_fetch_array($result)){
        ?>
        <table id= "Write_Asset">
        <tr>
        <td><?php  echo $row['AssetName'];?></td>
        <td><?php  echo $row['SupplierName'];?></td>
        <td><?php  echo $row['Stock'];?></td>
        <td><?php  echo $row['AssetPrice'];?>$</td>
        <td><?php  echo "<img id='assetimg' src='{$row['AssetImage']}'"?> width:100px Height:100px </td>
        <?php 
        if(isset($_SESSION['email'])){
            if(isset($isCustomer)){
                ?>
                <td>
                    <form method="post" action="../Pages/AssetListings.php">
                    <input type="number" id="Quantity" name="Quantity" min="1" value="1">
                    <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>"><br><br>
                     <input type="hidden" name="AssetPrice" value="<?php echo $row['AssetPrice']; ?>"><br><br>
                    <input type="submit" name="add_to_cart" value="Add to cart">
                    </form>
                </td>
            <?php
            }
        } else {
            ?>
            <td>
                <form method="post" action="../Pages/AssetListings.php">
                <input type="number" id="Quantity" name="Quantity" min="1" value="1">
                <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>"><br><br>
                  <input type="hidden" name="AssetPrice" value="<?php echo $row['AssetPrice']; ?>"><br><br>
                <input type="submit" name="add_to_cart" value="Add to cart">
                </form>
            </td>
        <?php
        }
        ?>
        </tr>
        </table>
        <?php
    }
}





}
?>
</body>
</html>