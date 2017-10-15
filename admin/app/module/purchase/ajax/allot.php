<?php

$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

Core::LoadDom( 'CenterSku' );

$sku = $_GET['sku'];
$skuId = $CenterProductExtra->Sku2Id( $sku );
$num = $_GET['num'];

$list = $CenterPurchaseExtra->AllotOrderProduct( $skuId, $num );

echo PHP2JSON( $list );
exit;
?>