<?php


$ShopImageModel = Core::ImportModel( 'ShopImage' );
$ShopImageCategoryModel = Core::ImportModel( 'ShopImageCategory' );


$ShopImageExtra = Core::ImportExtra( 'ShopImage' );

$categoryId = (int)$_GET['id'];

$search = array();
$search['cid'] = $categoryId;

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$imageList		= $ShopImageModel->GetList( $search, $offset, $onePage );
$total		= $ShopImageModel->GetTotal( $search );


foreach ( $imageList as $key => $val )
{
	$imageList[$key] = $ShopImageExtra->ExplainOne( $val );

	$imageList[$key]['add_time'] = DateFormat( $val['add_time'] );
	$imageList[$key]['update_time'] = DateFormat( $val['update_time'] );
}

$tpl['image_list'] = $imageList;
$tpl['total'] = $total;

$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

$tpl['page'] = $page;
$tpl['page_num'] = ceil( $total / $onePage );

Common::PageOut( 'product/image/list.html', $tpl );

?>