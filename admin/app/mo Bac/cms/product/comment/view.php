<?php

$CmsProductModel = Core::ImportModel( 'CmsProduct' );
$ProductCommentModel = Core::ImportModel( 'ProductComment' );

$commentId = (int)$_GET['id'];
$commentInfo = $ProductCommentModel->Get( $commentId );
$replyList = $ProductCommentModel->GetReplyList( $commentId );

if ( !$commentInfo )
	Alert( '没有找到相关数据' );

$commentInfo['add_time'] = DateFormat( $referInfo['add_time'] );

foreach ( $replyList as $key => $val )
{
	$replyList[$key]['add_time'] = DateFormat( $val['add_time'] );
	$replyList[$key]['content'] = nl2br( $val['content'] );
}

$tpl['info'] = $commentInfo;
$tpl['list'] = $replyList;

Common::PageOut( 'cms/product/comment/view.html', $tpl );


?>