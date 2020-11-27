<?php
session_start();
if(!isset($_SESSION['shoppingCart'])){
    $_SESSION['shoppingCart'] = array();
}
require_once '../misc/db_connection.php';
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 3600)) {
    header("Location: ../Exe/LogoutExe.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();

/****************************************************************/

$email = $_SESSION['email'];

$changeStock = $_POST['ChangeStock'];
$changeName = $_POST['ChangeName'];
$changePrice = $_POST['ChangePrice'];
$changeImage = $_POST['ChangeImage'];
$delete = $_POST['Delete'];

$assetName = "'" . $_POST['AssetName'] . "'";

if($changeStock && ($_POST['Offset'] != "")){
    $offset = $_POST['Offset'];


    $queryChangeStock = "UPDATE Assets
                         SET Stock = GREATEST(Stock + $offset, 0)
                         WHERE AssetName = $assetName;";

    mysqli_query($conn, $queryChangeStock);

    $_SESSION['feedbackString'] = "Stock updated.";
}

if($changeName && ("'" . $_POST['NewName'] . "'" != $assetName)){
    if($_POST['NewName'] == ""){
        $_SESSION['feedbackString'] = "Name cannot be empty.";
    } else{
        $newName = "'" . $_POST['NewName'] . "'";

        $queryAssetExists = "SELECT AssetName
                            FROM Assets
                            WHERE AssetName = $newName;";

        $resAssetExists = mysqli_query($conn, $queryAssetExists);
        

        if(mysqli_num_rows($resAssetExists) === 1){
            $_SESSION['feedbackString'] = "Asset name already taken.";
            
        } else{
            $queryChangeName = "UPDATE Assets
                                SET AssetName = $newName
                                WHERE AssetName = $assetName;";

            mysqli_query($conn, $queryChangeName);

            $_SESSION['feedbackString'] = "Name updated.";
        }
    }
}

if($changePrice){
    $newPrice = $_POST['NewPrice'];

    $queryChangePrice = "UPDATE Assets
                         SET AssetPrice = $newPrice
                         WHERE AssetName = $assetName;";

    mysqli_query($conn, $queryChangePrice);

    $_SESSION['feedbackString'] = "Price updated.";
}

if($changeImage){
    $newImage = "'" . $_POST['NewImage'] . "'";

    $queryChangeImage = "UPDATE Assets
                         SET AssetImage = $newImage
                         WHERE AssetName = $assetName;";

    mysqli_query($conn, $queryChangeImage);

    $_SESSION['feedbackString'] = "Image updated.";
}

if($delete){
    $queryDeleteAsset = "DELETE FROM Assets
                         WHERE AssetName = $assetName;";

    $resDeleteAsset = mysqli_query($conn, $queryDeleteAsset);

    $_SESSION['feedbackString'] = "Asset deleted.";
}
header("Location: ../Pages/ManageAssets.php");
}
?>