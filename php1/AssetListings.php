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

<?php
require_once 'db_connection.php';
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 30)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

<?php 

session_start();
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 5)) {
    header("Location: Logout.php");
}
$_SESSION['LAST_ACTIVITY'] = time();
$feedbackString = "";



















//Assets written out

$query =("SELECT * FROM Assets Order by AssetName ASC");


$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result)> 0)
{
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
      	
      		
      		
      		<?php 
      		
      		
      		?>
      
      <!--  Quantity form -->   
         
        <form method="post" action="Grading.php">
  		<label for="quantity">Quantity (between 1 and 100):</label>
  		<input type="number" id="quantity" name="quantity" min="1" max="100">
  		<input type="submit" name="add_to_cart">
		</form>
		
		
	<!--  Grading form -->
		
		<form method="post" action="/action_page.php">
 		<label for="Grading">Grade product (between 1 and 5):</label>
  		<input type="range" id="grading" name="grading" min="0" max="5" oninput="this.nextElementSibling.value = this.value">
		<output>3</output>
  		<input type="submit">
		</form>
		
		
            </tr>
            </tbody>
 </table>
 </div>
           <?php 
      
        
        }
      
        
    }
    
   








require_once 'db_connection.php';

?>









<div data-include="Header"></div>
<?php
echo $_SESSION['feedbackString'];
$_SESSION['feedbackString'] = "";
?>
</body>

</html>