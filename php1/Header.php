<div id="header">
<a id="title" href="AssetListings.php">Marketplace</a>
<form id="searchForm" action="AssetListings.php"> 
    <input id="searchBox" type="text" name="fname" placeholder="Search for assets..."><input id="searchButton" type="submit" value="Search">
</form>

<div id="login" href="/~ollelv-8/php1/login.php">
	<a href="/~ollelv-8/php1/login.php">
    <p>Log In</p></a>
</div>
<div id="createAccount" href="/~ollelv-8/php1/CreateAccount.php">
    <p>Create Account</p>
    <a href="/~ollelv-8/php1/CreateAccount.php">
    <p>Create new account</p></a>
</div>
<div id="logout" href="Logout.php">
    <p>Log Out</p>
</div>

    <a href="/~erisal-8/php1/login.php">
    <div id="login">
        Log In
    </div>
    </a>
    <a href="/~erisal-8/php1/Account_Choose.php">
    <div id="createAccount">
        Create Account
    </div>
    </a>
    <a href="/~erisal-8/php1/Logout.php">
    <div id="logout">
        Log Out
    </div>
    </a>

<a id="cartIcon" href="Shoppingcart.php">
    <img src="cart.png" width="70" height="70">
</a>
</div>

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
#login, #createAccount, #logout{
    display: inline-block;
    width: 70px;
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
#login p, #createAccount p, #logout p{
    line-height: 1.5;
    display: inline-block;
    vertical-align: middle;
    
}
#login:hover, #createAccount:hover, #logout:hover{
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