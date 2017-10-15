<?php

$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );

$categoryId = (int)$_GET['id'];

$categoryInfo = $CmsCategoryModel->Get( $categoryId );

if ( !$categoryInfo )
	Common::Error( '没有找到分类信息' );

if ( $_POST )
{
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['sort_name'] = NoHtml( $_POST['sort_name'] );
	$data['hidden'] = intval( $_POST['hidden'] );
	$data['update_time'] = time();
	$data['attribute_list'] = @implode( ',', $_POST['attribute'] );

	if ( Nothing( $data['name'] ) )
		Alert( '分类名称不能为空' );

	$CmsCategoryModel->Update( $categoryId, $data );

	/******** Extra ********/
	Core::LoadLib( 'GD.class.php' );
	$Gd = new GD();

	if ( is_array( $_POST['extra'] ) )
	{
		foreach ( $_POST['extra'] as $name => $value )
		{
			$CmsCategoryModel->AddExtra( $categoryId, $name, $value );
		}
	}

	/******** Block ********/
	Core::LoadExtra( 'CmsBlock' );
	$CmsBlockExtra = new CmsBlockExtra();

	$blockDataList = $CmsCategoryModel->GetBlockList( $categoryId );
	$blockDataList = ArrayIndex( $blockDataList, 'config_id' );

	$blockConfigList = $CmsCategoryModel->GetBlockConfigList();

	if ( $_POST['block_list'] )
	{
		foreach ( $_POST['block_list'] as $blockIndex => $blockMainList )
		{
			$patternId = $blockConfigList[$blockIndex]['pattern_id'];
			$blockChildList = $_POST['block_child_list'][$blockIndex];

			$blockContent = $CmsBlockExtra->GetSaveContent( $blockMainList, $blockChildList, $patternId );

			$blockContentOld = $CmsBlockExtra->UnPackContent( $blockDataList[$blockIndex]['content'] );

			$CmsBlockExtra->Clean( $blockContentOld, $blockContent, $patternId );

			$data = array();
			$data['cid'] = $categoryId;
			$data['pattern_id'] = $patternId;
			$data['config_id'] = $blockConfigList[$blockIndex]['id'];
			$data['content'] = $CmsBlockExtra->PackContent( $blockContent );

			$CmsCategoryModel->ReplaceBlock( $data );
		}
	}

	$CmsCategoryModel->BuildTree();
	$CmsCategoryModel->UpdateParentIdList();

	Common::Loading( "?mod=cms.category.list&id={$categoryId}" );
	exit();
}

?>