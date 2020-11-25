<html>
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
</head>
<body>

<form method="get" action="Start.php">
    <button type="submit">Start Page</button>
</form>

</body>
<div data-include="Header"></div>
<?php 
session_start();

require_once 'db_connection.php';


$accountType = $_POST['account'];
echo $accountType;


// e == employee else other statement FÖr att bestämma location efter händelse =

if($accountType == "e"){
    
  

    
    
}
else{
    echo "Nu kollar den eftter customer CCCCCCCCCCC query";
}

header('Location:AssetListings.php');

?>
</html>