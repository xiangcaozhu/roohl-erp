<?php

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$ProductCollateModel = Core::ImportModel( 'ProductCollate' );

$sku = trim( $_GET['sku'] );
$channelId = trim( $_GET['channel_id'] );

Core::LoadDom( 'CenterSku' );
$CenterSkuDom = new CenterSkuDom( $sku );
$skuInfo = $CenterSkuDom->InitProduct();

$collateInfo = $ProductCollateModel->GetUniqueBySku( $CenterSkuDom->id, $channelId );
$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $_GET['times'] );

echo PHP2JSON( array(
	'product' => $skuInfo['product'],
	'have_attribute' => 0,
	'sku' => $sku,
	'collate' => $collateInfo ? $collateInfo : false,
	'price' => $priceInfo ? $priceInfo : false,
	'sku_info' => $skuInfo,
) );

exit();


?>