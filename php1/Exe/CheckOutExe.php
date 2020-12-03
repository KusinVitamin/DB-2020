
<?php
session_start();
require_once '../misc/db_connection.php';

if(!isset($_SESSION['shoppingCart'])){
  $_SESSION['shoppingCart'] = array();
}
require_once '../misc/db_connection.php';
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: ../Exe/LogoutExe.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();
/****************************************************************/
}



$FnameInput =           $_POST['FnameInput'];
$LnameInput =       "'" . $_POST['LnameInput'] . "'";
$PhoneInput =       "'" . $_POST['PhoneInput'] . "'";
$EmailInput =         $_POST['EmailInput'];
$AddressInput=      "'" . $_POST['AddressInput'] . "'";
$PostalInput = "'" . $_POST['PostalInput'] . "'";
$TotPriceInput = $_SESSION['price'];



echo $FnameInput;

//Not logged in
if(!isset($_SESSION['email']) and (isset($_POST['buyButton']))){
    
    //Check if returning customer
    $returnQuerry = "SELECT ContactInfo.ContactInfoID, Orders.ContactInfoID FROM ContactInfo INNER JOIN Orders ON (Orders.ContactInfoID = ContactInfo.ContactInfoID) WHERE ContactInfo.Email='$EmailInput'";
    $returnExists = mysqli_query($conn, $returnQuerry);
        
    $queryEmailExists = "SELECT Con.Email
                     FROM ContactInfo AS Con
                     INNER JOIN Customers AS Cus
                     ON Con.CustomerID = Cus.CustomerID
                     WHERE Con.Email = '$EmailInput'
                     UNION
                     SELECT Emp.Email
                     FROM Employees AS Emp
                     WHERE Emp.Email = '$EmailInput'";
    
    $resEmailExists = mysqli_query($conn, $queryEmailExists);
    if(mysqli_num_rows($resEmailExists) === 1 and mysqli_num_rows($returnExists) >= 1 ){
        echo "du kom 1";
        $_SESSION['feedbackString'] = "Du er en tbx-kund.";
        header('Location: ../Pages/CheckOut.php');
       
    }elseif(mysqli_num_rows($resEmailExists) === 1 and mysqli_num_rows($returnExists) ==0){
        echo "du kom 2";
        $_SESSION['feedbackString'] = "Email finns redan.";
        header('Location: ../Pages/CheckOut.php');
    }

    else{
     
        echo "du kom 3";
        //Query to insert contactinfo
        $contactQuerry ="INSERT INTO ContactInfo
        (ContactInfoID,CustomerID,Fname,Lname,Pnumber,Email,Address,PostalCode)
        Values (ContactInfoID,Null,'$FnameInput',$LnameInput,$PhoneInput,'$EmailInput',$AddressInput,$PostalInput)";
        

        mysqli_query($conn,$contactQuerry);

         //Query to insert Orders
        $orderQuerry= "INSERT INTO `Orders` (`OrderID`, `ContactInfoID`, `TimePlaced`, `Status`, `TotalPrice`) VALUES (NULL,(SELECT ContactInfoID FROM `ContactInfo` WHERE `Email` LIKE '$EmailInput'), NOW(), 'Pending', '$TotPriceInput')";
         
         
        if($res_query = mysqli_query($conn,$orderQuerry)){
              
            $_SESSION['feedbackString'] = "Tack för din order," . $FnameInput ;
            $_SESSION['price']=0;
            $_SESSION['shoppingCart']=array();
            header('Location: ../Pages/AssetListings.php');
            
        
         
         }
        }
        
  
    
    
  
        

}
//Logged in

else {
    $orderQuerry= "INSERT INTO `Orders` (`OrderID`, `ContactInfoID`, `TimePlaced`, `Status`, `TotalPrice`) VALUES (NULL,(SELECT ContactInfoID FROM `ContactInfo` WHERE `Email` LIKE '$EmailInput'), NOW(), 'Pending', '$TotPriceInput')";
    
    
    if($res_query = mysqli_query($conn,$orderQuerry)){
        
        $_SESSION['feedbackString'] = "Tack Din lilla zigenare som e tillbaka :) din order," . $FnameInput ;
        $_SESSION['price']=0;
        $_SESSION['shoppingCart']=array();
        header('Location: ../Pages/AssetListings.php');
        
    }else{
        echo "Det las inte till";
    }
}


















?>