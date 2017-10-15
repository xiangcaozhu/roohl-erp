<?php

$CmsSiteModel = Core::ImportModel( 'CmsSite' );

$list = $CmsSiteModel->GetList();

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['update_time'] = DateFormat( $val['update_time'] );
}

$tpl['list'] = $list;

Common::PageOut( 'cms/site/list.html', $tpl );

?>