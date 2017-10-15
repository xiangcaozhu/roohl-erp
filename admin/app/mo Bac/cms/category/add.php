<?php

$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );

if ( $_POST )
{
	$pid = (int)$_GET['id'];

	$data = array();
	$data['pid'] = $pid;
	$data['name'] = NoHtml( $_POST['name'] );
	$data['sort_name'] = NoHtml( $_POST['sort_name'] );
	$data['add_time'] = time();
	$data['update_time'] = time();
	$data['product_num'] = 0;
	$data['order_id'] = $CmsCategoryModel->GetMinOrderId( $pid ) - 1;
	$data['hidden'] = intval( $_POST['hidden'] );

	if ( Nothing( $data['name'] ) )
		Alert( '分类名称不能为空' );

	$categoryId = $CmsCategoryModel->Add( $data );

	/******** 扩展信息 ********/
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

	$blockConfigList = $CmsCategoryModel->GetBlockConfigList();

	if ( $_POST['block_list'] )
	{
		foreach ( $_POST['block_list'] as $blockIndex => $blockMainList )
		{
			$patternId = $blockConfigList[$blockIndex]['pattern_id'];
			$blockChildList = $_POST['block_child_list'][$blockIndex];

			$blockContent = $CmsBlockExtra->GetSaveContent( $blockMainList, $blockChildList, $patternId );

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
}

?>