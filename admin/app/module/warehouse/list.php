<?php
/*
@@acc_title="库房管理 list"
*/
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$list = $CenterWarehouseModel->GetList( $offset, $onePage );
$total = $CenterWarehouseModel->GetTotal();

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

Common::PageOut( 'warehouse/list.html', $tpl );

?>