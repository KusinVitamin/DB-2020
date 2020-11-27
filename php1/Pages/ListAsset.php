<html>
<meta charset="UTF-8">
<head>
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
    <style>

        form.CredentialsForm {
            background-color:yellow;
            width:400px;
            border:2px solid black;
            margin:10px;
            padding:10px;
        }

    </style>
</head>

<body>
<div data-include="../CSS/Header"></div>
<div class="page">
    <a class="pagetext">List Asset</a>
</div>
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

?>
<div data-include="../CSS/Notification"></div>
<?php
/****************************************************************/
?>
    <form class="CredentialsForm" method="POST" action="../Exe/ListAssetExe.php">
        Asset Name:      <input type="text" name ="AssetName" required> <br>
        Stock:	           <input type="text" name ="Stock" required> <br>
        Asset Price ($): <input type ="text" name ="Price" required><br>
        Asset Image:         <input type="text" name ="Image" > <br>
        <button type ="submit">List Asset</button>
    </form>
<?php
}
?>
</body>
</html>
