<?php

$CmsSiteModel = Core::ImportModel( 'CmsSite' );

$siteList = $CmsSiteModel->GetList();

if ( !$siteList )
	Alert( '请先建立CMS站点' );

$siteId = (int)$siteId;

if ( $_GET['site'] )
	$siteId = (int)$_GET['site'];

if ( !$siteId || !$siteList[$siteId] )
{
	$siteInfo = current( $siteList );
	$siteId = $siteInfo['id'];
}
else
{
	$siteInfo = $siteList[$siteId];
}

$tpl['site_info'] = $siteInfo;
$tpl['site_id'] = $siteId;
$tpl['site_list'] = $siteList;


?>