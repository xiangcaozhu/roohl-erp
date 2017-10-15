<?php

$CmsChannelModel = Core::ImportModel( 'CmsChannel' );

include( Core::Block( 'cms.site' ) );

if ( $_POST )
{
	$pid = (int)$_GET['id'];

	$data = array();
	$data['pid'] = $pid;
	$data['site_id'] = $siteId;
	$data['name'] = NoHtml( $_POST['name'] );
	$data['sort_name'] = NoHtml( $_POST['sort_name'] );
	$data['add_time'] = time();
	$data['update_time'] = time();
	$data['order_id'] = $CmsChannelModel->GetMinOrderId( $pid ) - 1;
	$data['hidden'] = intval( $_POST['hidden'] );
	$data['publish_path'] = NoHtml( $_POST['publish_path'] );
	$data['index_name'] = NoHtml( $_POST['index_name'] );
	$data['index_template'] = NoHtml( $_POST['index_template'] );
	$data['list_name'] = NoHtml( $_POST['list_name'] );
	$data['list_template'] = NoHtml( $_POST['list_template'] );
	$data['detail_name'] = NoHtml( $_POST['detail_name'] );
	$data['detail_template'] = NoHtml( $_POST['detail_template'] );

	if ( Nothing( $data['name'] ) )
		Alert( '分类名称不能为空' );

	$categoryId = $CmsChannelModel->Add( $data );

	/******** 扩展信息 ********/

	/*
	Core::LoadLib( 'GD.class.php' );
	$Gd = new GD();

	if ( is_array( $_POST['extra'] ) )
	{
		foreach ( $_POST['extra'] as $name => $value )
		{
			$CmsChannelModel->AddExtra( $categoryId, $name, $value );
		}
	}
	
	*/

	/******** Block ********/

	/*
	Core::LoadExtra( 'CmsBlock' );
	$CmsBlockExtra = new CmsBlockExtra();

	$blockConfigList = $CmsChannelModel->GetBlockConfigList();

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
	*/

	$CmsChannelModel->BuildTree();
	$CmsChannelModel->UpdateParentIdList();

	Common::Loading( "?mod=cms.channel.list&&site={$siteId}&id={$categoryId}" );
}

?>