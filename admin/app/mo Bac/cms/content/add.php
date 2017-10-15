<?php

include( Core::Block( 'cms.site' ) );

$CmsChannelModel = Core::ImportModel( 'CmsChannel' );
$CmsContentIndexModel = Core::ImportModel( 'CmsContentIndex' );

$channelId =  (int)$_GET['cid'];
$channelInfo = $CmsChannelModel->Get( $channelId );

if ( !$channelInfo )
	Alert( '频道不存在' );

$tpl['channel_info'] = $channelInfo;

Core::LoadConfig( 'cmsContentPattern' );
$patternConfigList = Core::GetConfig( 'cms_content_pattern_config' );

if ( !$_POST )
{
	if ( !$_GET['pattern'] )
	{
		$tpl['config_list'] = $patternConfigList;

		Common::PageOut( 'cms/content/add_select_pattern.html', $tpl );
	}
	else
	{
		$pattern = $_GET['pattern'];
		$patternConfig = $patternConfigList[$pattern];

		if ( !$patternConfig )
			Alert( '所选的内容模型不存在' );

		$tpl['edit'] = false;
		$tpl['pattern_config'] = $patternConfig;

		$tpl['publish_template_path'] = Core::GetConfig( 'cms_publish_template_path' );

		$tpl['pattern_form'] = Common::PageCode( 'cms/content/form/' . $pattern . '.html', $tpl );

		Common::PageOut( 'cms/content/form.html', $tpl, $parentTpl );
	}
}
else
{
	if ( Nothing( $_POST['title'] ) )
		Alert( '标题不能为空' );

	$pattern = $_GET['pattern'];
	$patternConfig = $patternConfigList[$pattern];

	if ( !$patternConfig )
		Alert( '所选的内容模型不存在' );

	/******** Index ********/
	$data = array();
	$data['title'] = NoHtml( $_POST['title'] );
	$data['sort_title'] = NoHtml( $_POST['sort_title'] );
	$data['summary'] = NoHtml( $_POST['summary'] );
	$data['keyword'] = NoHtml( $_POST['keyword'] );
	$data['site_id'] = $siteId;
	$data['cid'] = $channelId;
	$data['add_time'] = time();
	$data['update_time'] = time();
	$data['pattern'] = $_GET['pattern'];
	$data['publish_path'] = $_POST['publish_path'];
	$data['publish_name'] = $_POST['publish_name'];
	$data['publish_template'] = $_POST['publish_template'];
	$data['user_id'] = $__Session['user_id'];
	$data['view_num'] = 0;

	$contentId = $CmsContentIndexModel->Add( $data );

	$CmsContentExtra = Core::ImportExtra( "CmsContent" . ucfirst( strtolower( $pattern ) ) );
	$CmsContentExtra->Add( $contentId, $_POST );

	Common::Loading( "?mod=cms.content.list&cid={$channelId}" );
}

?>