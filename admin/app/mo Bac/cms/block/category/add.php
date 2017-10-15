<?php


$CmsBlockCategoryModel = Core::ImportModel( 'CmsBlockCategory' );

if ( !$_POST )
{
	$CmsBlockCategoryModel->BuildTree();
	$list = $CmsBlockCategoryModel->GetSelectTree();

	$tpl['category_list'] = $list;
	$tpl['pid'] = $_GET['pid'];

	Common::PageOut( 'cms/block/category/add.html', $tpl );
}
else
{
	if ( Nothing( $_POST['name'] ) )
		Alert( '名称不能为空' );
	
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['pid'] = intval( $_POST['pid'] );
	$data['add_time'] = time();
	$data['update_time'] = time();

	$CmsBlockCategoryModel->Add( $data );

	Common::Loading( '?mod=cms.block.list' );
}

?>