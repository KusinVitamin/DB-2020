<?php
session_start();
if(isset($_SESSION['email']) && isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 5)){
    header("Location: Logout.php");
}
$_SESSION['LAST_ACTIVITY'] = time();
$feedbackString = "";
require_once 'db_connection.php';
?>
<div id="header">
    <a id="title" href="AssetListings.php">Marketplace</a>
    <form id="searchForm" action="AssetListings.php"> 
        <input id="searchBox" type="text" name="fname" placeholder="Search for assets..."><input id="searchButton" type="submit" value="Search">
    </form>
    <?php 
    if(!isset($_SESSION['email'])){
        ?>
        <a href="/~ollelv-8/php1/login.php">
        <div id="login">
            Log In
        </div>
        </a>
    <?php
    } 
    if(!isset($_SESSION['email'])){
        ?>
        <a href="/~ollelv-8/php1/CreateAccount.php">
        <div id="createAccount">
            Create Account
        </div>
        </a>
    <?php
    } 
    if(isset($_SESSION['email'])){
        ?>
        <a href="/~ollelv-8/php1/Logout.php">
        <div id="logout">
            Log Out
        </div>
        </a>
    <?php
    }
    if(isset($_SESSION['email'])){
        $emailString = $_SESSION['email'];
        
        $queryCheckEmployee = "SELECT Email
                               FROM Employees
                               WHERE Email = $emailString";

        $resCheckEmployee = mysqli_query($conn, $queryCheckEmployee);

        if(mysqli_num_rows($resCheckEmployee) === 1){
            ?>
            <a href="/~ollelv-8/php1/ListAsset.php">
            <div id="listAsset">
                List Asset
            </div>
            </a>
        <?php
        }
    }
    ?>
    <a id="cartIcon" href="Shoppingcart.php">
        <img src="cart.png" width="70" height="70">
    </a>
</div>

<?php
if(isset($_SESSION['feedbackString'])){
    ?>
    <div id="Notification">
        <?php
        echo $_SESSION['feedbackString'];
        unset($_SESSION['feedbackString']);
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
a{
    margin: 5px;
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
    margin-top: 15px;
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
    margin-top: 15px;
    display: inline-block;
    width: 65%;
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
#login, #createAccount, #logout, #listAsset{
    display: inline-block;
    width: 75px;
    padding: 2px 0;
    background-color: coral;
    border-radius: 5px;
    color: black;
    margin: 20px 5px;
    vertical-align: top;
    text-decoration: none;
    text-align: center;
    font-weight: 1000;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}
#createAccount{
    margin: 10px 5px;
}
#login p, #createAccount p, #logout p, #listAsset p{
    line-height: 1.5;
    display: inline-block;
    vertical-align: middle;
    
}
#login:hover, #createAccount:hover, #logout:hover, #listAsset:hover{
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
</style>