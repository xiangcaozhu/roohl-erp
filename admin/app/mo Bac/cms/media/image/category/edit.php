<?php

include( Core::Block( 'cms.site' ) );

$CmsImageCategoryModel = Core::ImportModel( 'CmsImageCategory' );
$CmsImageCategoryModel->SetSiteId( $siteId );

$categoryId = (int)$_GET['id'];

$categoryInfo = $CmsImageCategoryModel->Get( $categoryId );

if ( !$categoryInfo )
	Alert( '没有指定数据' );

if ( !$_POST )
{
	$tpl['category'] = $categoryInfo;

	Common::PageOut( 'cms/media/image/category/form.html', $tpl );
}
else
{
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );

	$CmsImageCategoryModel->Update( $categoryId, $data );

	Common::Loading( '?mod=cms.media.image.list' );

}

?>