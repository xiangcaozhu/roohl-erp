<?php

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$productId = (int)$_GET['pid'];
$productInfo = $CenterProductModel->Get( $productId );

Core::LoadDom( 'CenterProduct' );
$CenterProductDom = new CenterProductDom( $productInfo );

$buyAttributeList = $CenterProductDom->GetAttributeList();

if ( $_GET['type'] == 'get_product' )
{
	if ( $buyAttributeList )
	{
		$tpl['buy_attribute_list'] = $buyAttributeList;
		$attributeHtml = Common::PageCode( 'product/attribute/buy/preview.html', $tpl, false, false );
	}

	$sku = $CenterProductDom->GetBaseSku();

	Core::LoadDom( 'CenterSku' );
	$CenterSkuDom = new CenterSkuDom( $sku );
	$skuInfo = $CenterSkuDom->InitProduct();

	echo PHP2JSON( array(
		'product' => $productInfo,
		'have_attribute' => $buyAttributeList ? 1 : 0,
		'attribute_html' => $attributeHtml,
		'sku' => $sku,
		'sku_info' => $skuInfo,
	) );
	
	exit();
}
elseif ( $_GET['type'] == 'get_product_all' )
{
	if ( $buyAttributeList )
	{
		$tpl['buy_attribute_list'] = $buyAttributeList;
		$attributeHtml = Common::PageCode( 'product/attribute/buy/preview_all.html', $tpl, false, false );
	}

	$sku = $CenterProductDom->GetBaseSku();

	Core::LoadDom( 'CenterSku' );
	$CenterSkuDom = new CenterSkuDom( $sku );
	$skuInfo = $CenterSkuDom->InitProduct();

	echo PHP2JSON( array(
		'product' => $productInfo,
		'have_attribute' => $buyAttributeList ? 1 : 0,
		'attribute_html' => $attributeHtml,
		'sku' => $sku,
		'sku_info' => $skuInfo,
	) );
	
	exit();
}
elseif ( $_GET['type'] == 'check_sku' )
{
	$sku = trim( $_GET['sku'] );

	Core::LoadDom( 'CenterSku' );
	$CenterSkuDom = new CenterSkuDom( $sku );
	$skuInfo = $CenterSkuDom->InitProduct();

	echo PHP2JSON( array(
		'product' => $skuInfo['product'],
		'have_attribute' => 0,
		'sku' => $sku,
		'sku_info' => $skuInfo,
	) );
	
	exit();
}
elseif ( $_GET['type'] == 'get_sku' )
{
	$sku = $CenterProductDom->GetSku( $_POST );

	Core::LoadDom( 'CenterSku' );
	$CenterSkuDom = new CenterSkuDom( $sku );
	$skuInfo = $CenterSkuDom->InitProduct();

	echo PHP2JSON( array(
		'product' => $productInfo,
		'sku' => $sku,
		'sku_info' => $skuInfo,
	) );

	exit();
}

?>