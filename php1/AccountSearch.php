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


// e == employee else other statement

if($accountType == "e"){
    
  
    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        
        if($row['CompanyPassword'] === $companyPasswordInput){
            $queryInsertEmployee = "INSERT INTO Employees (Email, Company, Fname, Lname, Password)
                    VALUES ($emailInput, $companyInput, $fnameInput, $lnameInput, $passwordInput);";
            mysqliquery($conn, $queryInsertEmployee);
            $feedbackString = "Employee account created.";
        } else{
            $feedbackString = "Incorrect company password.";
        }
    } else{
        $queryInsertSupplierAndEmployee = "INSERT INTO Suppliers (SupplierName, CompanyPassword)
                    VALUES ($companyInput, $companyPasswordInput)
                    AND
                    INSERT INTO Employees (Email, Company, Fname, Lname, Password)
                    VALUES ($emailInput, $companyInput, $fnameInput, $lnameInput, $passwordInput);";
    }
    
    
    
    
}
else{
    echo "Nu kollar den eftter customer CCCCCCCCCCC query";
}



?>
</html>