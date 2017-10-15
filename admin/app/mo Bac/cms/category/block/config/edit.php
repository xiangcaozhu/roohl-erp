<?php

/*
@@acc_title="编辑块设置"

*/

$CmsBlockModel = Core::ImportModel( 'CmsBlock' );
$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );

$id = (int)$_GET['id'];

$info = $CmsCategoryModel->GetBlockConfig( $id );

if ( !$info )
	Alert( '没有找到相关数据' );

if ( !$_POST )
{
	$patternList = $CmsBlockModel->GetPatternList();

	$tpl['pattern_list'] = $patternList;
	$tpl['info'] = $info;

	Common::PageOut( 'cms/category/block/config/edit.html', $tpl );
}
else
{
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['en_name'] = NoHtml( $_POST['en_name'] );
	$data['pattern_id'] = intval( $_POST['pattern_id'] );
	$data['update_time'] = time();

	if ( Nothing( $data['name'] ) )
		Alert( '名称不能为空' );
	if ( Nothing( $data['en_name'] ) )
		Alert( '英文名不能为空' );
	if ( !$data['pattern_id'] )
		Alert( '请选择块模型' );

	if ( $data['en_name'] != $info['en_name'] )
	{
		if ( $CmsCategoryModel->GetBlockConfig( false, $data['en_name'] ) )
			Alert( '英文名已经被使用' );
	}

	$CmsCategoryModel->UpdateBlockConfig( $id, $data );

	Common::Loading( '?mod=cms.category.block.config.list' );
}

?>