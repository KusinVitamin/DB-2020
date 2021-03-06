<?php
session_start();
if(!isset($_SESSION['shoppingCart'])){
    $_SESSION['shoppingCart'] = array();
}
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: ../Exe/LogoutExe.php");
} else{

$_SESSION['LAST_ACTIVITY'] = time();
require_once '../misc/db_connection.php';
/****************************************************************/
?>
<div id="header">
    <a id="title" href="../Pages/AssetListings.php">Marketplace</a>
    <form id="searchForm" method="get" action="../Pages/AssetListings.php"> 
        <input id="searchBox" type="text" name="AssetSearch" placeholder="Search for assets..."><input id="searchButton" type="submit" value="Search">
    </form>
    <?php 
    if(!isset($_SESSION['email'])){
        ?>
        <a href="../Pages/Login.php">
        <div id="login">
            Log In
        </div>
        </a>
    <?php
    } 
    if(!isset($_SESSION['email'])){
        ?>
        <a href="../Pages/CreateAccount.php">
        <div id="createAccount">
            Create Account
        </div>
        </a>
    
    <?php
    } 
    if(isset($_SESSION['email'])){
         echo $_SESSION['email'];
        ?>
        
        <a href="../Exe/LogoutExe.php">
        <div id="logout">
            Log Out
        </div>
        </a>
        <?php
        $emailString = $_SESSION['email'];
        
        $queryCheckEmployee = "SELECT Email
                               FROM Employees
                               WHERE Email = $emailString";

        $resCheckEmployee = mysqli_query($conn, $queryCheckEmployee);

        if(mysqli_num_rows($resCheckEmployee) === 1){
            ?>
            <a href="../Pages/ListAsset.php">
            <div id="listAsset">
                List Asset
            </div>
            </a>
            <a href="../Pages/ManageAssets.php">
            <div id="manageAssets">
                Manage Assets
            </div>
            </a>
            <?php
            if($emailString == "'admin'"){
                ?>
                <a href="../Pages/Orders.php">
                <div id="orders">
                    Orders
                </div>
                </a>
                <?php
            }
        } else{
            ?>
            <a href="../Pages/Orders.php">
            <div id="orders">
                Orders
            </div>
            </a>
            <a id="cartIcon" href="../Pages/Shoppingcart.php">
                <img src="../Images/cart.png" width="70" height="70">
            </a>
        <?php
        }
    } else{
        ?>
        <a id="cartIcon" href="../Pages/Shoppingcart.php">
            <img src="../Images/cart.png" width="70" height="70">
        </a>
    <?php
    }
    ?>
</div>

<?php
}
?>
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
#Notification{
    background-color: #ffff99;
    width: 100%;
    color: blue;
    text-align: center;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    padding: 10px 0;
}
/*----------------------------------------------*/
#title{
    display: inline-block;
    margin-top: 20px;
    margin-left: 1%;
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
#searchForm{
    margin-left: 1%;
    margin-right: 1%;
    margin-top: 20px;
    display: inline-block;
    width: 55%;
    border: none;
    border-radius: 5px;
    vertical-align: top;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    
}
#searchBox{
    width: 90%;
    height: 40px;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    font-size: 20px;

    
}
#searchButton{
    border: none;
    background-color:coral;
    text-align: center;
    text-decoration: none;
    display: inline-block ;
    height: 40px;
    width: 10%;
    font-weight: 1000;
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    vertical-align: top;

}
#searchButton:hover{
    cursor: pointer; 
    -webkit-filter: brightness(70%);
    -webkit-transition: all 0.2s ease;
}
/*----------------------------------------------*/
#login, #createAccount, #logout, #listAsset, #manageAssets{
    display: inline-block;
    width: 75px;
    padding: 2px 0;
    background-color: coral;
    border-radius: 5px;
    color: black;
    margin: 30px 5px;
    vertical-align: top;
    text-decoration: none;
    text-align: center;
    font-weight: 1000;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}

#orders{
    display: inline-block;
    width: 75px;
    padding: 2px 0;
    background-color: coral;
    border-radius: 5px;
    color: black;
    margin: 30px 5px;
    vertical-align: top;
    text-decoration: none;
    text-align: center;
    font-weight: 1000;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}

#createAccount, #manageAssets{
    margin: 20px 5px;
}
#login p, #createAccount p, #logout p, #listAsset p, #manageAssets p, #orders p{
    line-height: 1.5;
    display: inline-block;
    vertical-align: middle;
    
}
#login:hover, #createAccount:hover, #logout:hover, #listAsset:hover, #manageAssets:hover, #orders:hover{
    cursor: pointer; 
    -webkit-filter: brightness(70%);
    -webkit-transition: all 0.2s ease;
}
/*----------------------------------------------*/
#cartIcon{
    float: right;
    display: inline-block;
    margin: 0 30px 0 0;
}
#cartIcon:hover{
    cursor: pointer; 
    -webkit-filter: brightness(70%);
    -webkit-transition: all 0.2s ease;
}
/*----------------------------------------------*/
.page{
    background-color: #4caf66;
    width: 100%;
    height: 50px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.pagetext{
    display: inline-block;
    font-size: 30px;
    color: white;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    text-decoration: none;
    border-radius: 10px;
}
.olle{
color:green;
</style>