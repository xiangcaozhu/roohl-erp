<?php

$ShopImageCategoryModel = Core::ImportModel( 'ShopImageCategory' );

//上级分类
$parentCategory = array();

if ( $_GET['id'] )
	$parentCategory = $ShopImageCategoryModel->Get( intval( $_GET['id'] ) );

if ( !$_POST )
{
	$tpl['parent'] = $parentCategory;

	Common::PageOut( 'product/image/category/form.html', $tpl );
}
else
{
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['pid'] = $parentCategory['id'];
	$data['order_id'] = $ShopImageCategoryModel->GetMinOrderId( intval( $parentCategory['id'] ) ) - 1;

	$ShopImageCategoryModel->Add( $data );

	Common::Loading( '?mod=product.image.list' );

}

?>