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

//Employee variables

$E_company =$_POST['CompanyInput'];
$E_email =$_POST['EmailInput'];
$E_password =$_POST['P_passwordInput'];
$E_cPassword =$_POST['C_passwordInput'];
$E_fName =$_POST['Fname'];
$E_lName =$_POST['Lname'];


//Customer variables


$C_fName =$_POST['Fname'];
$C_lName =$_POST['Lname'];
$C_phone =$_POST['PnumberInput'];
$C_email =$_POST['EmailInput'];
$C_adress =$_POST['AdressInput'];
$C_postalcode =$_POST['PostalCodeInput'];
$C_password =$_POST['Password'];




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