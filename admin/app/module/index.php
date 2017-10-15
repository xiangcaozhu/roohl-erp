<?php
/*
@@acc_freet
@@acc_title="系统首页"
*/




//reset query cache;

//$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
//$a = $CenterOrderModel->Del_1218_a();

//print_r($a);
/*
$CenterProductModel = Core::ImportModel( 'CenterProduct' );


$productList = $CenterProductModel->GetList( array( 'on_sell' => -1 ), 0, 10 );

foreach ( $productList as $key => $val )
{
	$productList[$key]['add_time'] = DateFormat( $val['add_time'] );
}

$tpl['plist'] = $productList;

Core::LoadClass( 'WorkFlow' );
$WorkFlow = new WorkFlow();
$flowList = $WorkFlow->GetList();

$tpl['flow_list'] = $flowList;

*/





Common::PageOut( 'index.html', $tpl );

?>