<?php

include( Core::Block( 'cms.site' ) );

$CmsContentIndexModel = Core::ImportModel( 'CmsContentIndex' );
$CmsChannelModel = Core::ImportModel( 'CmsChannel' );

$channelId =  (int)$_GET['cid'];
$channelInfo = $CmsChannelModel->Get( $channelId );

$tpl['channel_info'] = $channelInfo;

$search = array();
$search['cid'] = $channelId;
$search['site_id'] = $siteId;
$search['begin_time'] = $_GET['begin_date'] ? strtotime( $_GET['begin_date'] . " 00:00:00" ) : '';
$search['end_time'] = $_GET['end_date'] ? strtotime( $_GET['end_date'] . " 24:00:00" ) : '';
$search['word'] = trim( $_GET['word'] );

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$contentList = $CmsContentIndexModel->GetList( $search, $offset, $onePage );
$total = $CmsContentIndexModel->GetTotal( $search );

$CmsContentIndexExtra = Core::ImportExtra( 'CmsContentIndex' );

foreach ( $contentList as $key => $val )
{
	$contentList[$key] = $CmsContentIndexExtra->ExplainOne( $val );

	$contentList[$key]['add_time'] = DateFormat( $val['add_time'] );
	$contentList[$key]['update_time'] = DateFormat( $val['update_time'] );
}

$tpl['content_list'] = $contentList;
$tpl['total'] = $total;

$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

$tpl['page'] = $page;
$tpl['page_num'] = ceil( $total / $onePage );


parse_str( $_SERVER['QUERY_STRING'], $q );
unset( $q['order'] );
unset( $q['by'] );
$tpl['order_uri'] = http_build_query( $q );


Common::PageOut( 'cms/content/list.html', $tpl );

?>