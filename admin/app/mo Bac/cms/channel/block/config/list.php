<?php

/*
@@acc_title="块设置列表"

*/

$CmsBlockModel = Core::ImportModel( 'CmsBlock' );
$CmsChannelModel = Core::ImportModel( 'CmsChannel' );


$list = $CmsChannelModel->GetBlockConfigList();

$patternList = $CmsBlockModel->GetPatternList();
$patternList = ArrayIndex( $patternList, 'id' );

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['update_time'] = DateFormat( $val['update_time'] );
	$list[$key]['pattern'] = $patternList[$val['pattern_id']];
}


$tpl['list'] = $list;

Common::PageOut( 'cms/channel/block/config/list.html', $tpl );

?>