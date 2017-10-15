<?php

$CmsProductModel = Core::ImportModel( 'CmsProduct' );
$ProductCommentModel = Core::ImportModel( 'ProductComment' );

$referId = (int)$_GET['id'];
$referInfo = $ProductCommentModel->Get( $referId );

if ( !$referInfo )
	Alert( '没有找到相关数据' );


if ( !$_POST )
{
	$referInfo['add_time'] = DateFormat( $referInfo['add_time'] );
	$referInfo['reply_time'] = $referInfo['reply_time'] ? DateFormat( $referInfo['reply_time'] ) : '';

	$tpl['info'] = $referInfo;

	Common::PageOut( 'cms/product/comment/edit.html', $tpl );
}
else
{
	$data = array();
	$data['content'] = NoHtml( $_POST['content'] );
	$data['reply_content'] = NoHtml( $_POST['reply_content'] );
	$data['reply_time'] = !Nothing( $_POST['reply_content'] ) ? time() : 0;
	$data['replied'] = !Nothing( $_POST['reply_content'] ) ? 1 : 0;

	$ProductCommentModel->Update( $referId, $data );

	Common::Loading( "?mod=cms.product.comment.list" );
	exit();
}

?>