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
<div data-include="Header"></div>


    <form class="CredentialsForm" method="POST" action="CreateAsset.php">
        <input type = "hidden" name ="account" value="e">
        Asset Name:      <input type="text" name ="AssetName" required> <br>
        Company Name:  <input type="text" name ="CompanyName" required> <br>
        Stock:	           <input type="text" name ="Stock" required> <br>
        Asset Price: <input type ="text" name ="Price" required> <br>
        Asset Image         <input type="text" name ="Picture" > <br>
        <button type ="submit">Create account</button>
    </form>

    <?php


?>

</body>
</html>
