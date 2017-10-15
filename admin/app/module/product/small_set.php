<?php
/*
@@acc_free
*/

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );


$collateId = $_GET['collate_id'];
$productId = $_GET['product_id'];

if ( $productId )
{

	Core::LoadDom( 'CenterProduct' );
	$CenterProductDom = new CenterProductDom( $productId );
	$sku = $CenterProductDom->GetBaseSku();

	$ProductCollateModel->Update( $collateId, array( 'sku_id' => $CenterProductExtra->Sku2Id( $sku ) ) );
}
else
{
	$ProductCollateModel->Update( $collateId, array( 'sku_id' => '0' ) );
}
echo 200;
?>