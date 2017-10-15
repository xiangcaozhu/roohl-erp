<?php


$CmsBlockCategoryModel = Core::ImportModel( 'CmsBlockCategory' );

$id = (int)$_GET['id'];

$info = $CmsBlockCategoryModel->Get( $id );

if ( !$info )
	Alert( '没有找到相关数据' );

if ( !$_POST )
{
	$CmsBlockCategoryModel->BuildTree();
	$list = $CmsBlockCategoryModel->GetSelectTree();

	$tpl['category_list'] = $list;
	$tpl['pid'] = $info['pid'];
	$tpl['info'] = $info;
	$tpl['edit'] = true;

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

	$CmsBlockCategoryModel->Update( $id, $data );

	Common::Loading( '?mod=cms.block.list' );
}

?>