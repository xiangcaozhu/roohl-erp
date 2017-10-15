<?php

set_time_limit( 0 );

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );


/*
$productList = $CenterProductModel->GetList( array() );

foreach ( $productList as $key => $val )
{
	Core::LoadDom( 'CenterProduct' );
	$CenterProductDom = new CenterProductDom( $val );
	$sku = $CenterProductDom->GetBaseSku();

	//echo $sku;
}
*/


$list = $ProductCollateModel->GetList( array() );

foreach ( $list as $key => $val )
{
	$sku = $CenterProductExtra->Id2Sku( $val['sku_id'] );

	$data = array();
	$data['sku'] = $sku;
	$ProductCollateModel->Update( $val['id'], $data );
}


?>