<?php

$CmsProductModel = Core::ImportModel( 'CmsProduct' );
$ProductReferModel = Core::ImportModel( 'ProductRefer' );

$referId = (int)$_GET['id'];
$referInfo = $ProductReferModel->Get( $referId );

if ( !$referInfo )
	Alert( '没有找到相关数据' );

$ProductReferModel->Del( $referId );
	
Common::Loading( "?mod=cms.product.refer.list" );

?>