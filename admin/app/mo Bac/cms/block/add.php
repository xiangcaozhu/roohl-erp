<?php


$CmsBlockCategoryModel = Core::ImportModel( 'CmsBlockCategory' );
$CmsBlockModel = Core::ImportModel( 'CmsBlock' );

if ( !$_POST )
{
	$CmsBlockCategoryModel->BuildTree();
	$categoryList = $CmsBlockCategoryModel->GetSelectTree();

	$patternList = $CmsBlockModel->GetPatternList();

	$tpl['category_list'] = $categoryList;
	$tpl['pattern_list'] = $patternList;
	$tpl['cid'] = $_GET['cid'];

	Common::PageOut( 'cms/block/add.html', $tpl );
}
else
{
	if ( Nothing( $_POST['name'] ) )
		Alert( '名称不能为空' );
	if ( Nothing( $_POST['en_name'] ) )
		Alert( '英文名称不能为空' );
	if ( !intval( $_POST['pattern_id'] ) )
		Alert( '请选择一个块模型' );
	
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['en_name'] = NoHtml( $_POST['en_name'] );
	$data['cid'] = intval( $_POST['cid'] );
	$data['pattern_id'] = intval( $_POST['pattern_id'] );
	$data['add_time'] = time();
	$data['update_time'] = time();

	if ( $CmsBlockModel->GetByEnName( $data['en_name'] ) )
		Alert( '英文名不允许重复,已经有相同的英文名被使用' );

	$CmsBlockModel->Add( $data );

	Common::Loading( '?mod=cms.block.list' );
}

?>