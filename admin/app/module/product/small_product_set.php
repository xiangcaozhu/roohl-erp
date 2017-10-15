<?php
/*
@@acc_free
*/
?>
$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );


$productId = $_GET['pid'];
$productId2 = $_GET['pid2'];

Core::LoadDom( 'CenterProduct' );
$CenterProductDom = new CenterProductDom( $productId );
$sku = $CenterProductDom->GetBaseSku();

$ProductCollateModel->UpdateByProduct( $productId2, array( 'sku_id' => $CenterProductExtra->Sku2Id( $sku ) ) );

$CenterProductModel->Del( $productId2 );
$CenterProductModel->DelSkuByProduct( $productId2 );

echo 200;
?>