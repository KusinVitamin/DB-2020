<?php

$queryAssetExists = "SELECT AssetName
                    FROM Assets
                    WHERE AssetName = $inputAssetName;";

$resAssetExists = mysqliquery($conn, $queryAssetExists);

if(mysqli_num_rows($resAssetExists) === 1){
    
}
?>