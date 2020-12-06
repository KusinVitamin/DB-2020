<html>

<head>
    <link rel="stylesheet" href="../CSS/Details.css">
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

/****************************************************************/

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
            $_SESSION['feedbackString'] = "Items added to cart.";
          } else{
            $_SESSION['feedbackString'] = "Item added to cart.";
          }
    } else{
        $_SESSION['feedbackString'] = "Asset stock exceeded. Added maximum quantity to cart.";
        $_SESSION['shoppingCart'][$index] = $currentStock;
    }
}

if(isset($_GET['AssetName'])){
    $assetName = "'" . $_GET['AssetName'] . "'";
}
if(isset($_POST['AssetName'])){
    $assetName = "'" . $_POST['AssetName'] . "'";
}

// Add items to cart
if (isset($_POST['Quantity'])) {
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

if(isset($_POST['Grade']) && isset($_POST['Comment'])){
    $CommentInput = "'" . $_POST['Comment'] . "'";
    $GradeInput = $_POST['Grade'];
    $email = $_SESSION['email'];

    $queryCheckReview = "SELECT * 
                         FROM Reviews AS R
                         INNER JOIN ContactInfo AS C
                         ON R.CustomerID = C.CustomerID
                         WHERE C.Email = $email;";

    $resultCheckReview = mysqli_query($conn, $queryCheckReview);

    if(mysqli_num_rows($resultCheckReview) == 0){
        $queryInsertReview = "INSERT INTO Reviews (CustomerID, AssetName, CommentBody, Grade)
                              SELECT CustomerID, $assetName, $CommentInput, $GradeInput
                              FROM ContactInfo 
                              WHERE Email = $email;";

        mysqli_query($conn, $queryInsertReview);

        $queryCheckGrade = "SELECT GradingInt, Grading
                            FROM Assets 
                            WHERE AssetName = $assetName;";

        $resultCheckGrade = mysqli_query($conn, $queryCheckGrade);
        $row = mysqli_fetch_array($resultCheckGrade);

        if(is_null($row['Grading'])){ 
            $NewGrade = $GradeInput;
        } else{
            $NewGrade = ($row['GradingInt'] * $row['Grading'] + $GradeInput) / ($row['GradingInt'] + 1);
        }

        $NewGradeInt = $row['GradingInt'] + 1;

        $queryUpdateGrade = "UPDATE Assets 
                             SET GradingInt = $NewGradeInt, Grading = $NewGrade
                             WHERE AssetName = $assetName;";

        mysqli_query($conn, $queryUpdateGrade);

        $_SESSION['feedbackString'] = "Your review has been posted.";
    } else{
        $_SESSION['feedbackString'] = "You have already posted a review for this item.";
    }
}

$query = "SELECT * 
          FROM Assets 
          WHERE AssetName = $assetName;";

$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

?>
<div data-include="../CSS/Notification"></div>

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
        <th>Grade (1-5)</th>
    </tr>
</table>
<table id= "Write_Asset">
    <tr>
        <td><?php  echo $row['AssetName'];?></td>
        <td><?php  echo $row['SupplierName'];?></td>
        <td><?php  echo $row['Stock'];?></td>
        <td>$<?php  echo $row['AssetPrice'];?></td>
        <td><?php  echo "<img id='assetimg' src='{$row['AssetImage']}'"?> width:100px Height:100px </td>
        <?php
        if(isset($_SESSION['email'])){
            if(isset($isCustomer)){
                ?>
                <td>
                <form method="post" action="../Pages/AssetDetails.php">
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
            <form method="post" action="../Pages/AssetDetails.php">
                    <input type="number" id="Quantity" name="Quantity" min="1" value="1">
                    <input type="hidden" name="AssetName" value="<?php echo $row['AssetName']; ?>"><br><br>
                    <input type="hidden" name="AssetPrice" value="<?php echo $row['AssetPrice']; ?>"><br><br>
                    <input type="submit" name="add_to_cart" value="Add to cart">
            </form>
            </td>
            <?php
        }

        ?>
        <td><?php if(!is_null($row['Grading'])){ echo $row['Grading'];}?></td>
    </tr>
</table>

<?php

$queryGetReviews = "SELECT *
                    FROM Reviews
                    WHERE AssetName = $assetName;";

$result = mysqli_query($conn, $queryGetReviews);

?>

<table id= "Reviews">
    <tr>
        <th>Name</th>
        <th>Comment</th>
        <th>Grade (1-5)</th>
    </tr>
</table>

<table id= "Reviews">
<?php
while($row2 = mysqli_fetch_array($result)){
    $id = $row2['CustomerID'];
    $Fname = "SELECT Fname
              FROM ContactInfo 
              WHERE CustomerID = $id;";

    $result2 = mysqli_query($conn, $Fname);
    $Fname = mysqli_fetch_array($result2)
    ?>
    <tr>
        <td><?php  echo $Fname['Fname'];?></td>
        <td><?php  echo $row2['CommentBody'];?></td>
        <td><?php  echo $row2['Grade'];?></td>
    </tr>
<?php
}
?>
</table>

<?php 
if(isset($_SESSION['email'])){
    $emailString = $_SESSION['email'];
        
    $queryCheckEmployee = "SELECT Email
                           FROM Employees
                           WHERE Email = $emailString";

    $resCheckEmployee = mysqli_query($conn, $queryCheckEmployee);

    if(mysqli_num_rows($resCheckEmployee) === 0){
        ?>
        <form class="Credentials" method="POST" action="../Pages/AssetDetails.php">
            <input type="hidden" name="AssetName" value="<?php echo $row['AssetName'];?>">
            <div class="slidecontainer">
                <p>Grade:</p>
                <input type="range" min="1" max="5" value="3" class="slider" id="Grade" name="Grade"><br>
                <p>Value: <span id="Value"></span></p>
            </div>
            Comment: <input type="text" name ="Comment" required> <br>

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
    <?php
    }
}
}
?>
</body>
</html>