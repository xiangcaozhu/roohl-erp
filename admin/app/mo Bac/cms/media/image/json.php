<?php

include( Core::Block( 'cms.site' ) );

$CmsImageModel = Core::ImportModel( 'CmsImage' );

$CmsImageExtra = Core::ImportExtra( 'CmsImage' );

$categoryId = (int)$_GET['cid'];

$search = array();
$search['cid'] = $categoryId;
$search['site_id'] = $siteId;

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$imageList		= $CmsImageModel->GetList( $search, $offset, $onePage );
$total		= $CmsImageModel->GetTotal( $search );


foreach ( $imageList as $key => $val )
{
	$imageList[$key] = $CmsImageExtra->ExplainOne( $val );

	$imageList[$key]['add_time'] = DateFormat( $val['add_time'] );
	$imageList[$key]['update_time'] = DateFormat( $val['update_time'] );
}

$json = array();
$json['list'] = $imageList;
$json['total'] = $total;

echo PHP2JSON( $json );

?>