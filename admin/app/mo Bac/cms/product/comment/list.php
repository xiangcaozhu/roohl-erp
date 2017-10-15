<?php

$CmsProductModel = Core::ImportModel( 'CmsProduct' );
$ProductCommentModel = Core::ImportModel( 'ProductComment' );

$ProductExtra = Core::ImportExtra( 'Product' );

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$commentList	= $ProductCommentModel->GetList( $_GET['pid'], $offset, $onePage );
$total		= $ProductCommentModel->GetTotal( $_GET['pid'] );

foreach ( $commentList as $key => $val )
{
	$commentList[$key]['add_time'] = DateFormat( $val['add_time'] );
	$commentList[$key]['content'] = CutStr( $val['content'], 40 );
	$commentList[$key]['product'] = $ProductExtra->ExplainOne( $CmsProductModel->Get( $val['pid'] ) );
}

$tpl['list'] = $commentList;
$tpl['total'] = $total;

$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );
$tpl['page'] = $page;
$tpl['page_num'] = ceil( $total / $onePage );

Common::PageOut( 'cms/product/comment/list.html', $tpl );

?>