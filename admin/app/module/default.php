<?php
/*
@@acc_freet
@@acc_title="系统首页"

*/
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







Common::PageOutNew( 'default.html', $tpl );

?>