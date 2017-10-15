<?php

class CmsContentPublish
{
	function CmsContentPublish()
	{
		/********  *******/
		Core::LoadClass( 'TemplateBlock' );
		Core::LoadClass( 'TemplateCms' );
		Core::LoadClass( 'TemplateCmsContent' );
		$this->Template = Core::ImportBaseClass( "Template" );
		$this->Template->Plugin( new TemplateBlock() );
		$this->Template->Plugin( new TemplateCms() );
		$this->Template->Plugin( new TemplateCmsContent() );
	}

	function PublishChannel( $channelId )
	{
		// 频道数据
		$channelInfo = $this->GetChannel( $channelId );

		if ( !$channelInfo )
			return '404';

		// 站点数据
		$siteInfo = $this->GetSite( $channelInfo['site_id'] );

		// 发布参数
		$publishPath = $channelInfo['publish_path'];
		$publishName = $channelInfo['index_name'];
		$publishTemplate = $channelInfo['index_template'];

		//$publishSaveDirectory = $siteInfo['publish_path'] . $publishPath;
		$publishSavePath = $siteInfo['publish_path'] . $publishPath . $publishName;
		$publishSaveDirectory = pathinfo( $publishSavePath, PATHINFO_DIRNAME );

		if ( !FileExists( $publishSaveDirectory ) )
			MakeDirTree( $publishSaveDirectory );

		//echo $publishSavePath;

		$templateRoot = Core::GetConfig( 'cms_publish_tempalte_path' );

		// Template 处理
		$tpl['channel'] = $channelInfo;

		$this->Template->ST( $templateRoot . $publishTemplate );
		$this->Template->SV( $tpl );

		$result = $this->Template->RS();

		file_put_contents( $publishSavePath, $result );

		return true;
	}

	function PublishList()
	{

	}

	function PublishDetail( $contentId )
	{
		$tpl = array();

		$CmsContentIndexModel = Core::ImportModel( 'CmsContentIndex' );

		// 基础内容
		$contentInfo = $CmsContentIndexModel->Get( $contentId );

		if ( !$contentInfo )
			return '404';

		// 拿到模型存储的内容
		$CmsContentExtra = Core::ImportExtra( "CmsContent" . ucfirst( strtolower( $contentInfo['pattern'] ) ) );
		$contentInfo = $CmsContentExtra->Get( $contentId, $contentInfo );

		// 频道数据
		$channelInfo = $this->GetChannel( $contentInfo['cid'] );

		// 站点数据
		$siteInfo = $this->GetSite( $channelInfo['site_id'] );

		// 发布参数
		$publishPath = $contentInfo['publish_path'] ? $contentInfo['publish_path'] : $channelInfo['publish_path'];
		$publishName = $contentInfo['publish_name'];
		$publishTemplate = $contentInfo['publish_template'] ? $contentInfo['publish_template'] : $channelInfo['detail_template'];

		if ( $publishPath && $publishName )
			$publishSavePath = $siteInfo['publish_path'] . $publishPath . $publishName;
		else
			$publishSavePath = $siteInfo['publish_path'] . "detail/{$contentInfo['id']}.html";

		$publishSaveDirectory = pathinfo( $publishSavePath, PATHINFO_DIRNAME );

		if ( !FileExists( $publishSaveDirectory ) )
			MakeDirTree( $publishSaveDirectory );

		//echo $publishSavePath;

		$templateRoot = Core::GetConfig( 'cms_publish_tempalte_path' );

		// Template 处理
		$CmsContentIndexExtra = Core::ImportExtra( 'CmsContentIndex' );
		$tpl['content'] = $CmsContentIndexExtra->ExplainOne( $contentInfo );

		$this->Template->ST( $templateRoot . $publishTemplate );
		$this->Template->SV( $tpl );

		$result = $this->Template->RS();

		file_put_contents( $publishSavePath, $result );

		$data = array();
		$data['publish'] = 1;
		$data['publish_time'] = time();
		$CmsContentIndexModel->Update( $contentId, $data );

		return true;
	}

	function GetChannel( $id )
	{
		if ( $this->channel[$id] )
			return $this->channel[$id];

		$CmsChannelModel = Core::ImportModel( 'CmsChannel' );

		$this->channel[$id] = $CmsChannelModel->Get( $id );

		return $this->channel[$id];
	}

	function GetSite( $id )
	{
		if ( $this->site[$id] )
			return $this->site[$id];

		$CmsSiteModel = Core::ImportModel( 'CmsSite' );

		$this->site[$id] = $CmsSiteModel->Get( $id );

		return $this->site[$id];
	}
}


?>