<html>
<meta charset="UTF-8">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function(){
            var includes = $('[data-include]');
            jQuery.each(includes, function(){
                var file = '/~ollelv-8/php1/' + $(this).data('include') + '.php';
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
<?php
session_start();
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 120)) {
    header("Location: Logout.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();
$feedbackString = "";
require_once 'db_connection.php';
?>

<div data-include="Header"></div>


    <form class="CredentialsForm" method="POST" action="CreateAsset.php">
        <input type = "hidden" name ="account" value="e">
        Asset Name:      <input type="text" name ="AssetName" required> <br>
        Stock:	           <input type="text" name ="Stock" required> <br>
        Asset Price: <input type ="text" name ="Price" required> <br>
        Asset Image         <input type="text" name ="Image" > <br>
        <button type ="submit">Submit Asset</button>
    </form>


<?php
}
?>
</body>
</html>
