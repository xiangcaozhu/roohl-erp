<?php

include( Core::Block( 'cms.site' ) );

$CmsImageCategoryModel = Core::ImportModel( 'CmsImageCategory' );
$CmsImageCategoryModel->SetSiteId( $siteId );

//上级分类
$parentCategory = array();

if ( $_GET['id'] )
	$parentCategory = $CmsImageCategoryModel->Get( intval( $_GET['id'] ) );

if ( !$_POST )
{
	$tpl['parent'] = $parentCategory;

	Common::PageOut( 'cms/media/image/category/form.html', $tpl );
}
else
{
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['site_id'] = $siteId;
	$data['pid'] = $parentCategory['id'];
	$data['order_id'] = $CmsImageCategoryModel->GetMinOrderId( intval( $parentCategory['id'] ) ) - 1;

	$CmsImageCategoryModel->Add( $data );

	Common::Loading( '?mod=cms.media.image.list' );

}

?>