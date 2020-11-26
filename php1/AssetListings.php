<html>
<meta charset="UTF-8">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function(){
            var includes = $('[data-include]');
            jQuery.each(includes, function(){
                var file = '/~kemhua-6/php1/' + $(this).data('include') + '.php';
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

        ?>
            <div class="assetTable">
            <table id= "Write_Asset">
    <tr>
        <th>Product name</th>
        <th>Seller</th>
        <th>Stock</th>
        <th>Price</th>
        <th>Picture</th>
        <th>Buy</th>
        <th>Grading</th>
    </tr>
<?php
    while($row = mysqli_fetch_array($result)){
        ?>
        <table id= "Write_Asset">



        <tr>


            <td><?php  echo $row['AssetName'];?></td>
            <td><?php  echo $row['SupplierName'];?>&nbsp;</td>
            <td><?php  echo $row['Stock'];?>&nbsp;</td>
            <td><?php  echo $row['AssetPrice'];?>&nbsp;</td>
            <td><?php  echo  "<img src='{$row['AssetImage']}'"?> width:100px Height:100px </td>





      <!--  Quantity form -->
        <td>
        <form method="post" action="Grading.php">
  		<label for="quantity">Quantity (between 1 and 100):</label>
  		<input type="number" id="quantity" name="quantity" min="1" max="100">
  		<input type="submit" name="add_to_cart">
		</form>
		</td>

	<!--  Grading form -->
		<td>
		<form method="post" action="/action_page.php">
 		<label for="Grading">Grade product (between 1 and 5):</label>
  		<input type="range" id="grading" name="grading" min="0" max="5" oninput="this.nextElementSibling.value = this.value">
		<output>3</output>
  		<input type="submit">
		</form>
		</td>

            </tr>

 </table>
 </div>
           <?php





      }
}
}
?>

<style>

    #Write_Asset {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        border: #4CAF50;
        width: 100%;
        table-layout: fixed;
    }

    img{
        height: 100px;
        width: 100px;

    }

    #Write_Asset tr:nth-child(even){background-color: #f2f2f2;}

    #Write_Asset tr:hover {background-color: #ddd;}

    #Write_Asset th {
        text-align: center;
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: center;
        background-color: #4CAF50;
        color: white;
        border: 5px solid black;
        width: 14%;
        height: 10%;
    }
    #Write_Asset td{

        border: 5px solid black;
        width: 14%;
        height: 10%;
        text-align: center;
    }
</style>
</body>
</html>