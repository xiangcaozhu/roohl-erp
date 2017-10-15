<?php

include( Core::Block( 'cms.site' ) );

$CmsChannelModel = Core::ImportModel( 'CmsChannel' );
$CmsContentIndexModel = Core::ImportModel( 'CmsContentIndex' );

$contentId = (int)$_GET['content_id'];
$contentInfo = $CmsContentIndexModel->Get( $contentId );

$channelInfo = $CmsChannelModel->Get( $contentInfo['cid'] );

if ( !$contentInfo )
	Alert( '内容不存在' );

if ( !$_GET['cid'] )
{
	$tpl['content'] = $contentInfo;
	$tpl['channel'] = $channelInfo;

	Common::PageOut( 'cms/content/move.html', $tpl, $parentTpl );
}
else
{
	/******** category ********/
	$channelId = $_GET['cid'];
	$channelInfo = $CmsChannelModel->Get( $channelId );

	if ( $contentInfo['cid'] == $channelId )
		Alert( '新的分类不能为当前分类' );

	if ( !$channelInfo )
		Alert( '选择的频道不存在' );

	/******** Update ********/
	$data = array();
	$data['cid'] = $channelId;

	$CmsContentIndexModel->Update( $contentId, $data );

	Common::Loading( '?mod=cms.content.list&cid=' . $_GET['fcid'] . "&site=" . $_GET['site'] );
}

?>