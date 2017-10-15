<?php
/*
@@acc_freet
*/
$id = (int)$_GET['id'];

$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$CenterWarehouseModel->Del($id);

Redirect( '?mod=warehouse.list' );

?>