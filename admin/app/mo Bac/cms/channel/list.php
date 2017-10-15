<?php

$CmsSiteModel = Core::ImportModel( 'CmsSite' );
$CmsChannelModel = Core::ImportModel( 'CmsChannel' );
$CmsBlockModel = Core::ImportModel( 'CmsBlock' );

include( Core::Block( 'cms.site' ) );

$CmsChannelModel->SetSiteId( $siteId );

$channelId = (int)$_GET['id'];


if ( $channelId )
{
	$channelInfo	= $CmsChannelModel->Get( $channelId );
	$extraInfo		= $CmsChannelModel->GetExtra( $channelId );

	//$blockDataList = $CmsChannelModel->GetBlockList( $categoryId );
	//$blockDataList = ArrayIndex( $blockDataList, 'config_id' );

}

$tpl['info'] = $channelInfo;
$tpl['extra'] = $extraInfo;
$tpl['info_name'] = $channelInfo['name'];
$tpl['info_id'] = $channelInfo['id'];


/********  Block  ********/

/*
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

*/

if ( $_GET['add'] )
{
	unset( $tpl['info'] );
	unset( $tpl['extra'] );
}

Common::PageOut( 'cms/channel/list.html', $tpl );

?>