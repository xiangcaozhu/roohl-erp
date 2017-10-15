<?php

$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );

$keyWord = trim( $_POST['key'] );

$list = $CenterWarehousePlaceModel->Search( $keyWord, $_GET['warehouse_id'] );

echo PHP2JSON( $list );

exit();

?>