<?php

$CenterBrandModel = Core::ImportModel( 'CenterBrand' );

$id = (int)$_GET['id'];

$info = $CenterBrandModel->Get( $id );

if ( !$info )
	Common::Error( '错误的编号' );

@unlink( Core::GetConfig( 'brand_picture_url' ) . "{$id}.jpg" );
$CenterBrandModel->Del( $id );

Common::Loading( 'index.php?mod=product.brand.list' );
?>