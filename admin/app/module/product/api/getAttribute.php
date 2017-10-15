<?php

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );

$productId = trim( $_GET['id'] );
$productInfo = $CenterProductModel->Get( $productId );

$attributeList = $CenterBuyAttributeModel->GetList( $productId );

foreach ( $attributeList as $key => $val )
{
	$attributeList[$key]['value_list'] = $CenterBuyAttributeModel->GetValueListByAid( $val['id'] );
}

echo serialize( $attributeList );
exit;

?>