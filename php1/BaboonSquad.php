<html>
    <div id="header">
        <a id="title" href="start.php">ERIKS HORHÅLA</a>
        <form id="textForm" action="/action_page.php"> 
            <input id="textbox" type="text" name="fname" placeholder="Search..."><input id="textbutton" type="submit" value="Japp, GO">
        </form>
        <a id="logIn" href="logIn.php">
            <p>Log In</p>
        </a>
        <a id="cartIcon" href="shopping.php">
            <img src="cart.png" width="70" height="70">
        </a>

    </div>
    <style>
        * { 
            margin: 0; 
            padding : 0; 
        }
        #header{
            background-color: #131921;
            width: 100%;
            height: 70px;
        }
        /*----------------------------------------------*/
        #title{
            display: inline-block;
            margin-top: 15px;
            margin-left: 30px;
            font-size: 30px;
            color: white;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            text-decoration: none;
            border-radius: 10px;

        }
        #title:hover {
            cursor: pointer; 
            -webkit-filter: brightness(70%);
            -webkit-transition: all 0.2s ease;
        }
        /*----------------------------------------------*/
        #textForm{
            margin-left: 5%;
            margin-right: 5%;
            margin-top: 15px;
            display: inline-block;
            width: 65%;
            border: none;;
            border-radius: 5px;
            vertical-align: top;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            
        }
        #textbox{
            width: 90%;
            height: 40px;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            font-size: 20px;

            
        }
        #textbutton{
            border: none;
            background-color:coral;
            text-align: center;
            text-decoration: none;
            display: inline-block ;
            height: 40px;
            width: 9%;
            font-weight: 1000;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            vertical-align: top;

        }
        #textbutton:hover{
            cursor: pointer; 
            -webkit-filter: brightness(70%);
            -webkit-transition: all 0.2s ease;
        }
        /*----------------------------------------------*/
        #logIn{
            display: inline-block;
            width: 70px;
            height: 40px;
            background-color: coral;
            border-radius: 5px;
            color: black;
            margin-top: 15px;
            vertical-align: top;
            text-decoration: none;
            text-align: center;
            font-weight: 1000;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            line-height: 25px;
        }
        #logIn p {
            margin-top: 5px;
            vertical-align: top;
        }
        #logIn:hover{
            cursor: pointer; 
            -webkit-filter: brightness(70%);
            -webkit-transition: all 0.2s ease;
        }
        /*----------------------------------------------*/
        #cartIcon{
            float: right;
            display: inline-block;
            margin-right: 30px;
        }
        #cartIcon:hover{
            cursor: pointer; 
            -webkit-filter: brightness(70%);
            -webkit-transition: all 0.2s ease;
        }
        body{
            background-color:#EAEDED;
        }
    </style>
    <body>
    session_start();


require_once 'db_connection.php';





//Checks if asset is added to chart


if (!isset($_SESSION['username_login'])):
?>
 <form method="get" action="CreateAccount.php">
    <button type="submit">Create account</button>
</form>

<form method="get" action="login.php">
    <button type="submit">Log in</button>
</form>
<?php else: ?>
<span class="menu-item">Welcome <?php echo $_SESSION['username_login']; ?> Login Success <br> <form method="get" action="Logut.php">
    <button type="submit">Log out</button>
</form></span>
<?php endif; ?>

<?php 


//Assets written out
$query =("SELECT * FROM Assets Order by AssetName ASC");


$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result)> 0)
    {
        while($row = mysqli_fetch_array($result)){
            ?>
            <table style="width: 3px;" border="3" cellpadding="4">
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
           <?php 
      
        
        }
      
        
    }
    
   
   
?>

    


    
        Lägg in PHP HÄRRRRRRRRRRRRRRRRRRRRRRR!!!!!!!!!! :)))))))))))))))))))))))))))))) 8======D~~~~~~
    </body>
</html>
