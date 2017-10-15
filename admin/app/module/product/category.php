<?php
/*
@@acc_title="分类管理 category"
*/
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );
$CenterBrandModel = Core::ImportModel( 'CenterBrand' );

$categoryList = $CenterCategoryModel->BuildTree();

$categoryId = (int)$_GET['id'];
$categoryBrandList = array();

if ( $categoryId )
{
	$categoryInfo = $CenterCategoryModel->Get( $categoryId );
	$categoryBrandList = $CenterCategoryModel->GetBrandList( $categoryId );
}

$tpl['info'] = $categoryInfo;
$tpl['info_name'] = $categoryInfo['name'];
$tpl['info_id'] = $categoryInfo['id'];


if ( $_GET['add'] )
{
	unset( $tpl['info'] );
	$categoryBrandList = array();
}

$brandList = $CenterBrandModel->GetList();
foreach ( $brandList as $key => $val )
{
	if ( $categoryBrandList[$val['id']] )
		$brandList[$key]['selected'] = 1;
}

$tpl['brand_list'] = $brandList;

Common::PageOut( 'product/category/list.html', $tpl );

?>