<?php

$CmsProductModel = Core::ImportModel( 'CmsProduct' );
$ProductCommentModel = Core::ImportModel( 'ProductComment' );

$commentId = (int)$_GET['id'];
$commentInfo = $ProductCommentModel->Get( $commentId );

if ( !$commentInfo )
	Alert( '没有找到相关数据' );

$ProductCommentModel->Del( $commentId );
$ProductCommentModel->DelReply( $commentId );
	
Common::Loading( $_SERVER['HTTP_REFERER'] );

?>