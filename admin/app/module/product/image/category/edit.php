<?php

$ShopImageCategoryModel = Core::ImportModel( 'ShopImageCategory' );

$categoryId = (int)$_GET['id'];

$categoryInfo = $ShopImageCategoryModel->Get( $categoryId );

if ( !$categoryInfo )
	Alert( '没有指定数据' );

if ( !$_POST )
{
	$tpl['category'] = $categoryInfo;

	Common::PageOut( 'product/image/category/form.html', $tpl );
}
else
{
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );

	$ShopImageCategoryModel->Update( $categoryId, $data );

	Common::Loading( '?mod=product.image.list' );

}

?>