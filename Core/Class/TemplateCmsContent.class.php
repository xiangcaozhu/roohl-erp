<?php

class TemplateCmsContent
{
	function TemplateCmsContent()
	{

	}

	function Parse( $content, $compiler )
	{
		$content = $this->ProcessPattern( $content, $compiler );

		return $content;
	}

	function ProcessPattern( $content, $compiler )
	{
		$patternList = array(
			array(
				'find' => '/<!--(?:\s+)CmsChildChannelList(?:\s*)\((.+?)\)(?:\s+)AS(?:\s+)([a-zA-Z_0-9]+)(?:\s+)-->/',
				'replace' => 'SetChildChannelList',
			),
			array(
				'find' => '/<!--(?:\s+)CmsChannelNav(?:\s*)\((.+?)\)(?:\s+)AS(?:\s+)([a-zA-Z_0-9]+)(?:\s+)-->/',
				'replace' => 'SetChannelNav',
			),
			array(
				'find' => '/<!--(?:\s+)CmsChannelConentList(?:\s*)\((.+?)\)(?:\s+)AS(?:\s+)([a-zA-Z_0-9]+)(?:\s+)-->/',
				'replace' => 'SetChannelContentList',
			),
		);

		foreach ( $patternList as $pattern )
		{
			if ( preg_match_all( $pattern['find'], $content, $rs ) )
			{
				foreach ( $rs[1] as $key => $val )
				{
					$argList = explode( ',', $val );

					foreach ( $argList as $k => $arg )
					{
						$arg = trim( $arg );
						if ( $arg[0] == "'" || $arg[0] == '"' || is_numeric( $arg ) )
						{
							$argList[$k] = $arg;
						}
						else
						{
							$argList[$k] = $compiler->ProccessVARS( $arg );
						}
					}

					$var = $compiler->ProccessVARS( $rs[2][$key] );

					$phpCode = "<?p" . "hp {$var} = TemplateCmsContent::" . $pattern['replace'] . "( ". implode( $argList, ',' ) ." );?" . ">";

					$content = str_replace( $rs[0][$key], $phpCode, $content );
				}
			}
		}

		return $content;
	}

	function SetChildChannelList( $channelId, $type = 1 )
	{
		$CmsChannelModel = Core::ImportModel( 'CmsChannel' );
		$CmsChannelExtra = Core::ImportExtra( 'CmsChannel' );

		return $CmsChannelExtra->Explain( $CmsChannelModel->GetOneChildList( $channelId ) );
	}

	function SetChannelNav( $channelId, $stopChannelId = 0 )
	{
		$CmsChannelModel = Core::ImportModel( 'CmsChannel' );
		$CmsChannelExtra = Core::ImportExtra( 'CmsChannel' );

		$channelInfo = $CmsChannelModel->Get( $channelId );

		if ( !$channelInfo )
			return array();

		$CmsChannelModel->SetSiteId( $channelInfo['site_id'] );

		if ( !$CmsChannelModel->TreeExists() )
			$CmsChannelModel->BuildTree();
		
		$list = $CmsChannelModel->GetParentList( $channelId );

		$list[] = $channelInfo;

		return $CmsChannelExtra->Explain( $list );
	}

	function SetChannelContentList( $channelId, $offset = 0, $limit = 0 )
	{
		$CmsContentIndexModel = Core::ImportModel( 'CmsContentIndex' );
		$list = $CmsContentIndexModel->GetList( array( 'cid' => $channelId ), $offset, $limit );

		$CmsContentIndexExtra = Core::ImportExtra( 'CmsContentIndex' );

		$list = $CmsContentIndexExtra->Explain( $list );

		return $list;
	}
}

?>