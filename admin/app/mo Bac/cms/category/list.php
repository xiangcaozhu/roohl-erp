<?php

$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );
$CmsBlockModel = Core::ImportModel( 'CmsBlock' );

$categoryId = (int)$_GET['id'];

$categoryList = $CmsCategoryModel->BuildTree();

if ( $categoryId )
{
	$categoryInfo	= $CmsCategoryModel->Get( $categoryId );
	$extraInfo		= $CmsCategoryModel->GetExtra( $categoryId );

	$blockDataList = $CmsCategoryModel->GetBlockList( $categoryId );
	$blockDataList = ArrayIndex( $blockDataList, 'config_id' );
}

$tpl['ext_tree_script'] = PHP2JSON( $CmsCategoryModel->GetExtTree() );
$tpl['info'] = $categoryInfo;
$tpl['extra'] = $extraInfo;
$tpl['info_name'] = $categoryInfo['name'];
$tpl['info_id'] = $categoryInfo['id'];

$tpl['front_template_path'] = Core::GetConfig( 'front_template_path' );

/********  Block  ********/
Core::LoadExtra( 'CmsBlock' );
$CmsBlockExtra = new CmsBlockExtra();

$blockConfigList = $CmsCategoryModel->GetBlockConfigList();

$blockList = array();
foreach ( $blockConfigList as $key => $val )
{
	$pattern = $CmsBlockExtra->GetExtraPattern( $blockDataList[$val['id']]['content'], $val['pattern_id'] );

	if ( $pattern )
	{
		$pattern['multi_name'] = "[{$val['id']}]";
		$pattern['multi_id'] = "{$val['id']}_";

		$blockList[$key]['html'] = Common::PageCode( 'cms/block/pattern/form.html', $pattern );
		$blockList[$key]['name'] = $val['name'];
		$blockList[$key]['id'] = $val['id'];
		$blockList[$key]['type'] = $pattern['type'];
	}
}

$tpl['block_list'] = $blockList;

if ( $_GET['add'] )
{
	unset( $tpl['info'] );
	unset( $tpl['extra'] );
}

Common::PageOut( 'cms/category/list.html', $tpl );

?>