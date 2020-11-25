<html>
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
<div data-include="Header"></div>
<form method="get" action="/~erisal-8/php1/Start.php">
    <button type="submit">Start Page</button>
</form>

 </body>

<?php


// Extract account info from form.
$FnameInput = "'" . $_POST['FnameInput'] . "'";
$LnameInput = "'" . $_POST['LnameInput'] . "'";
$SexInput = "'" . $_POST['SexInput'] . "'";
$DoBInput = "'" . $_POST['DoBInput'] . "'";
$PasswordInput = "'" . $_POST['PasswordInput'] . "'";
if(empty($_POST['PnumberInput'])){
    $PnumberInput = "NULL";
} else{
    $PnumberInput = "'" . $_POST['PnumberInput'] . "'";
}
if(empty($_POST['EmailInput'])){
    $EmailInput = "NULL";
} else{
    $EmailInput = "'" . $_POST['EmailInput'] . "'";
}
if(empty($_POST['AdressInput'])){
    $AdressInput = "NULL";
} else{
    $AdressInput = "'" . $_POST['AdressInput'] . "'";
}
if(empty($_POST['PostalCodeInput'])){
    $PostalCodeInput = "NULL";
} else{
    $PostalCodeInput = "'" . $_POST['PostalCodeInput'] . "'";
}


// Insert account info as new tuple in the Customer table.
$sql_State = "INSERT INTO Customer (`Fname`, `Lname`, `Pnumber`, `Email`, `Adress`, `PostalCode`, `Sex`, `DoB`, `Password`) 
              VALUES ($FnameInput, $LnameInput, $PnumberInput, $EmailInput, $AdressInput, $PostalCodeInput, $SexInput, $DoBInput, $PasswordInput);";


if(mysqli_query($conn, $sql_State)){
    echo "Account created successfully.<br><br>";
    
}else{
    echo "Account not created. Check your inputs.<br><br>" . $sql_State . "<br>" . mysqli_error($conn) . "<br><br>";
}






?>



</html>