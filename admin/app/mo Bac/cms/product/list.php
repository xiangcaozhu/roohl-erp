<?php

$CmsProductModel = Core::ImportModel( 'CmsProduct' );
$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );
$CategoryModel = Core::ImportModel( 'Category' );

Core::LoadExtra( 'Product' );
$ProductExtra = new ProductExtra();

$categoryList = $CategoryModel->BuildTree();
$cmsCategoryList = $CmsCategoryModel->BuildTree();

$_GET['cid'] = (int)$_GET['cid'];

if ( $_GET['cid'] )
{
	$cidList = array();
	//$cidList = $CmsCategoryModel->GetChildID( $_GET['cid'] );
	array_unshift( $cidList, $_GET['cid'] );
}

$flag = 1;

if ( $_GET['flag'] == 1 )
	$flag = 1;
elseif ( $_GET['flag'] == -1 )
	$flag = -1;

$search = array();
$search['category_id'] = @implode( ',', @array_filter( $cidList ) );
$search['product_id'] = intval( $_GET['pid'] );
$search['cms_product_id'] = intval( $_GET['cms_product_id'] );
$search['flag'] = $flag;
$search['word'] = trim( $_GET['word'] );


list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$productList	= $CmsProductModel->GetList( $search, $offset, $onePage );
$total		= $CmsProductModel->GetTotal( $search );

$productList = $ProductExtra->Explain( $productList );


foreach ( $productList as $key => $val )
{
	$productList[$key]['add_time'] = DateFormat( $val['add_time'] );
	$productList[$key]['update_time'] = DateFormat( $val['update_time'] );

	//$productList[$key]['attribute'] = $ProductExtra->GetAttributeDescription( $val['id'] );
	$productList[$key]['category'] = $categoryList[$val['cid']]['name'];
	$productList[$key]['cms_category'] = $cmsCategoryList[$val['cms_cid']]['name'];
}

$tpl['product_list'] = $productList;
$tpl['total'] = $total;

$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

$tpl['flag'] = $_GET['flag'];

$tpl['page'] = $page;
$tpl['page_num'] = ceil( $total / $onePage );


parse_str( $_SERVER['QUERY_STRING'], $q );
unset( $q['order'] );
unset( $q['by'] );
$tpl['order_uri'] = http_build_query( $q );


Common::PageOut( 'cms/product/list.html', $tpl );

?>