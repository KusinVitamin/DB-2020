<?php
session_start();
$feedbackString = "";
require_once 'db_connection.php';
if ((isset($_SESSION['email'])) && ($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 120)) {
    header("Location: Logout.php");
} else{
$_SESSION['LAST_ACTIVITY'] = time();


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

    $feedbackString = "Stock updated.";
    $_SESSION['feedbackString'] = $feedbackString;
}

if($changeName && ("'" . $_POST['NewName'] . "'" != $assetName)){
    if($_POST['NewName'] == ""){
        $feedbackString = "Name cannot be empty.";
        $_SESSION['feedbackString'] = $feedbackString;
    } else{
        $newName = "'" . $_POST['NewName'] . "'";

        $queryAssetExists = "SELECT AssetName
                            FROM Assets
                            WHERE AssetName = $newName;";

        $resAssetExists = mysqli_query($conn, $queryAssetExists);
        

        if(mysqli_num_rows($resAssetExists) === 1){
            $feedbackString = "Asset name already taken.";
            $_SESSION['feedbackString'] = $feedbackString;
            
        } else{
            $queryChangeName = "UPDATE Assets
                                SET AssetName = $newName
                                WHERE AssetName = $assetName;";

            mysqli_query($conn, $queryChangeName);

            $feedbackString = "Name updated.";
            $_SESSION['feedbackString'] = $feedbackString;
        }
    }
}

if($changePrice){
    $newPrice = $_POST['NewPrice'];

    $queryChangePrice = "UPDATE Assets
                         SET AssetPrice = $newPrice
                         WHERE AssetName = $assetName;";

    mysqli_query($conn, $queryChangePrice);

    $feedbackString = "Price updated.";
    $_SESSION['feedbackString'] = $feedbackString;
}

if($changeImage){
    $newImage = "'" . $_POST['NewImage'] . "'";

    $queryChangeImage = "UPDATE Assets
                         SET AssetImage = $newImage
                         WHERE AssetName = $assetName;";

    mysqli_query($conn, $queryChangeImage);

    $feedbackString = "Image updated.";
    $_SESSION['feedbackString'] = $feedbackString;
}

if($delete){
    $queryDeleteAsset = "DELETE FROM Assets
                         WHERE AssetName = $assetName;";

    $resDeleteAsset = mysqli_query($conn, $queryDeleteAsset);

    $feedbackString = "Asset deleted.";
    $_SESSION['feedbackString'] = $feedbackString;
}
header("Location: ManageAssets.php");
}
?>