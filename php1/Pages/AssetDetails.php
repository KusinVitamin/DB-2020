<html>

<head>
    <link rel="stylesheet" href="../CSS/fuckmyass.css">
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
    <a class="pagetext">Product Details</a>
</div>

<?php
require_once '../misc/db_connection.php';
session_start();

if(!isset($_SESSION['shoppingCart'])){
    $_SESSION['shoppingCart'] = array();
}
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: ../Exe/LogoutExe.php");
} else {
    $_SESSION['LAST_ACTIVITY'] = time();


// Add items to cart
    if (isset($_POST['Quantity'])) {
        $assetName = "'" . $_POST['AssetName'] . "'";
        $asprice = $_POST['AssetPrice'];
        $quantity = $_POST['Quantity'];


        $index = 0;
        while ($index < count($_SESSION['shoppingCart'])) {
            if ($_SESSION['shoppingCart'][$index] == $assetName) {
                checkStockAddItems($conn, $index + 1, $assetName, $quantity);
                break;
            }
            $index += 2;
        }

        if ($index == count($_SESSION['shoppingCart'])) {
            array_push($_SESSION['shoppingCart'], $assetName, 0);
            checkStockAddItems($conn, $index + 1, $assetName, $quantity);
        }
    }


//Assets written out
    if (isset($_GET['AssetSearch'])) {
        $Search = $_GET['AssetSearch'];
    } else {
        $Search = "";
    }

    $query = "SELECT * 
         FROM Assets 
         WHERE AssetName 
         LIKE '%Clock%'
         ORDER BY AssetName ASC;";

    $result = mysqli_query($conn, $query);
}
?>

<div data-include="../CSS/Notification"></div>

<?php




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
        <th>Grading</th>
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
            <td><?php  echo $row['Grading'];?></td>
        </tr>
    </table>
    <?php
    }


    $comments = "SELECT *
    FROM Comments
    WHERE AssetName
    LIKE '%$Search%'
    ORDER BY AssetName ASC;";

    $result = mysqli_query($conn, $comments);




?>

    <table id= "Comments">
        <tr>
            <th>Buyer</th>
            <th>Review</th>

        </tr>
        <?php
        while($row = mysqli_fetch_array($result)){
            $id = $row['CustomerID'];
            $Email = "SELECT Email
             FROM ContactInfo 
             WHERE CustomerID = $id";

            $result2 = mysqli_query($conn, $Email);
            $mail = mysqli_fetch_array($result2)
            ?>
            <table id= "Comments">
                <tr>
                    <td><?php  echo $mail['Email'];?></td>
                    <td><?php  echo $row['CommentBody'];?></td>

                </tr>
            </table>
<?php
    }

?>

        <form class="Credentials" method="POST" action="">
            <input type = "hidden" name ="account" value="e">
            <div class="slidecontainer">
                <p>Grade:</p>
                <input type="range" min="1" max="5" value="3"class="slider" id="Grade"><br>
                <p>Value: <span id="Value"></span></p>
            </div>
                Comment: <input type="text" name ="EmailInput" required> <br>

                <script>
                    var slider = document.getElementById("Grade");
                    var output = document.getElementById("Value");
                    output.innerHTML = slider.value;

                    slider.oninput = function() {
                        output.innerHTML = this.value;
                    }
                </script>

            <button type ="submit">Submit Review</button>
        </form>
</body>
</html>