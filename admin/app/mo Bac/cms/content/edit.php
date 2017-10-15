<?php

include( Core::Block( 'cms.site' ) );

$CmsChannelModel = Core::ImportModel( 'CmsChannel' );
$CmsContentIndexModel = Core::ImportModel( 'CmsContentIndex' );

$contentId = (int)$_GET['content_id'];
$contentInfo = $CmsContentIndexModel->Get( $contentId );

if ( !$contentInfo )
	Alert( '内容不存在' );

$channelId = $contentInfo['cid'];
$channelInfo = $CmsChannelModel->Get( $channelId );

if ( !$channelInfo )
	Alert( '频道不存在' );

$tpl['channel_info'] = $channelInfo;

$CmsContentExtra = Core::ImportExtra( "CmsContent" . ucfirst( strtolower( $contentInfo['pattern'] ) ) );
$contentInfo = $CmsContentExtra->Get( $contentId, $contentInfo );

Core::LoadConfig( 'cmsContentPattern' );
$patternConfigList = Core::GetConfig( 'cms_content_pattern_config' );

if ( !$_POST )
{
	$pattern = $contentInfo['pattern'];
	$patternConfig = $patternConfigList[$pattern];

	if ( !$patternConfig )
		Alert( '内容模型不存在' );

	$tpl['edit'] = true;
	$tpl['pattern_config'] = $patternConfig;
	$tpl['content'] = $contentInfo;

	$tpl['publish_template_path'] = Core::GetConfig( 'cms_publish_template_path' );

	$tpl['pattern_form'] = Common::PageCode( 'cms/content/form/' . $pattern . '.html', $tpl );

	Common::PageOut( 'cms/content/form.html', $tpl, $parentTpl );
	
}
else
{
	if ( Nothing( $_POST['title'] ) )
		Alert( '标题不能为空' );

	/******** Index ********/
	$data = array();
	$data['title'] = NoHtml( $_POST['title'] );
	$data['sort_title'] = NoHtml( $_POST['sort_title'] );
	$data['summary'] = NoHtml( $_POST['summary'] );
	$data['keyword'] = NoHtml( $_POST['keyword'] );
	$data['update_time'] = time();
	$data['publish_path'] = $_POST['publish_path'];
	$data['publish_name'] = $_POST['publish_name'];
	$data['publish_template'] = $_POST['publish_template'];

	$CmsContentIndexModel->Update( $contentId, $data );

	$CmsContentExtra->Update( $contentId, $_POST );

	Common::Loading( "?mod=cms.content.list&cid={$channelId}" );
}

?>