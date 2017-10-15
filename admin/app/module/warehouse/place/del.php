<?php

$id = (int)$_GET['id'];

$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
$CenterWarehousePlaceModel->Del($id);

Redirect( '?mod=warehouse.place' );

?>