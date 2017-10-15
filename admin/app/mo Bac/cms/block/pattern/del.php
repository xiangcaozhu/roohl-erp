<?php

$BrandModel = Core::ImportModel( 'Brand' );

$id = (int)$_GET['id'];

$info = $BrandModel->Get( $id );

if ( !$info )
	Common::Error( '错误的编号' );

@unlink( Core::GetConfig( 'brand_picture_url' ) . "{$id}.jpg" );
$BrandModel->Del( $id );

//Common::Loading( '删除成功', 'index.php?mod=brand.list' );
Redirect( '?mod=brand.list' );
?>