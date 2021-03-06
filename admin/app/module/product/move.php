<?php
/*
@@acc_free
*/
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterBrandModel = Core::ImportModel( 'CenterBrand' );
$CenrterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );


/******** product ********/
$productId = (int)$_GET['id'];
$productInfo = $CenterProductModel->Get( $productId );

if ( !$productInfo )
	Alert( '错误的产品编号' );

/******** Category ********/
$categoryInfo = $CenterCategoryModel->Get( $productInfo['cid'] );


if ( !$_GET['cid'] )
{
	$tpl['product'] = $productInfo;
	$tpl['category'] = $categoryInfo;

	Common::PageOut( 'product/move.html', $tpl, $parentTpl );
}
else
{
	/******** category ********/
	$categoryId = $_GET['cid'];
	$categoryInfo = $CenterCategoryModel->Get( $categoryId );

	if ( $productInfo['cid'] == $categoryId )
		Alert( '新的分类不能为当前分类' );

	if ( !$categoryInfo )
		Alert( '选择的分类不存在' );

	
	$data = array();
	$data['cid'] = $categoryId;
	
	/******** Update ********/
	$CenterProductModel->Update( $productId, $data );

	Common::Loading( '?mod=product.list&cid=' . $_GET['fcid'] );
}

?>