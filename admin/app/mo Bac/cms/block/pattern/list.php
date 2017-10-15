<?php

$CmsBlockModel = Core::ImportModel( 'CmsBlock' );


$list = $CmsBlockModel->GetPatternList( $offset, $onePage );

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['update_time'] = DateFormat( $val['update_time'] );
}

$tpl['list'] = $list;
$tpl['page'] = $page;
$tpl['total'] = $total;

Common::PageOut( 'cms/block/pattern/list.html', $tpl );

?>