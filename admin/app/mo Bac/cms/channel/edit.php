<?php

$CmsChannelModel = Core::ImportModel( 'CmsChannel' );

include( Core::Block( 'cms.site' ) );

$channelId = (int)$_GET['id'];

$channelInfo = $CmsChannelModel->Get( $channelId );

if ( !$channelInfo )
	Common::Error( '没有找到分类信息' );

if ( $_POST )
{
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['sort_name'] = NoHtml( $_POST['sort_name'] );
	$data['hidden'] = intval( $_POST['hidden'] );
	$data['update_time'] = time();
	$data['publish_path'] = NoHtml( $_POST['publish_path'] );
	$data['index_name'] = NoHtml( $_POST['index_name'] );
	$data['index_template'] = NoHtml( $_POST['index_template'] );
	$data['list_name'] = NoHtml( $_POST['list_name'] );
	$data['list_template'] = NoHtml( $_POST['list_template'] );
	$data['detail_name'] = NoHtml( $_POST['detail_name'] );
	$data['detail_template'] = NoHtml( $_POST['detail_template'] );

	if ( Nothing( $data['name'] ) )
		Alert( '分类名称不能为空' );

	$CmsChannelModel->Update( $channelId, $data );

	/******** Extra ********/

	/*
	Core::LoadLib( 'GD.class.php' );
	$Gd = new GD();

	if ( is_array( $_POST['extra'] ) )
	{
		foreach ( $_POST['extra'] as $name => $value )
		{
			$CmsChannelModel->AddExtra( $channelId, $name, $value );
		}
	}
	*/

	/******** Block ********/

	/*
	Core::LoadExtra( 'CmsBlock' );
	$CmsBlockExtra = new CmsBlockExtra();

	$blockDataList = $CmsChannelModel->GetBlockList( $channelId );
	$blockDataList = ArrayIndex( $blockDataList, 'config_id' );

	$blockConfigList = $CmsChannelModel->GetBlockConfigList();

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
			$data['cid'] = $channelId;
			$data['pattern_id'] = $patternId;
			$data['config_id'] = $blockConfigList[$blockIndex]['id'];
			$data['content'] = $CmsBlockExtra->PackContent( $blockContent );

			$CmsChannelModel->ReplaceBlock( $data );
		}
	}

	*/

	$CmsChannelModel->BuildTree();
	$CmsChannelModel->UpdateParentIdList();

	Common::Loading( "?mod=cms.channel.list&site={$siteId}&id={$channelId}" );
	exit();
}

?>