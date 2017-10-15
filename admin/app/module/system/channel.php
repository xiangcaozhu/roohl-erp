<?php
/*
@@acc_title="渠道管理 channel"
*/
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$list = $CenterChannelModel->GetList( $offset, $onePage );
$total = $CenterChannelModel->GetTotal();


/*
foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
}
*/

$tpl['list'] = $list;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

Common::PageOut( 'system/channel/list.html', $tpl );

?>