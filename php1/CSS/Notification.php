<?php
require_once '../misc/db_connection.php';
session_start();
if(!isset($_SESSION['shoppingCart'])){
  $_SESSION['shoppingCart'] = array();
}
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: ../Exe/LogoutExe.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();
//Feedback string
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
}
?>