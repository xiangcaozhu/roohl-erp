<?php

$CmsProductModel = Core::ImportModel( 'CmsProduct' );
$ProductReferModel = Core::ImportModel( 'ProductRefer' );

$ProductExtra = Core::ImportExtra( 'Product' );


list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$referList	= $ProductReferModel->GetList( $_GET['pid'], $offset, $onePage );
$total	= $ProductReferModel->GetTotal( $_GET['pid'] );

foreach ( $referList as $key => $val )
{
	$referList[$key]['add_time'] = DateFormat( $val['add_time'] );
	$referList[$key]['reply_time'] = $val['reply_time'] ? DateFormat( $val['reply_time'] ) : '-';
	$referList[$key]['content'] = CutStr( $val['content'], 40 );

	$referList[$key]['product'] = $ProductExtra->ExplainOne( $CmsProductModel->Get( $val['pid'] ) );
}

$tpl['list'] = $referList;
$tpl['total'] = $total;

$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );
$tpl['page'] = $page;
$tpl['page_num'] = ceil( $total / $onePage );

Common::PageOut( 'cms/product/refer/list.html', $tpl );

?>