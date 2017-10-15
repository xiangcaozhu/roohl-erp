<?php
/*
@@acc_free
@@acc_title="整理出库订单 pack"
*/

$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
$ActionLogModel = Core::ImportModel( 'ActionLog' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$channelList = $CenterChannelModel->GetList();
$tpl['channelList'] = $channelList;


include( Core::Block( 'warehouse' ) );

$deliveryTypeList = Core::GetConfig( 'order_delivery_type' );
$printStatusList = Core::GetConfig( 'order_print_status' );

$channel_id = $_GET['channel_id'];



ob_end_flush();
set_time_limit(0); 
	$offset = 0;
	$onePage = 500;



$search = array(
	'id' => $_GET['id'],
	'warehouse_id' => $warehouseId,
	'channel_id' => $channel_id,
	'lock_status' => 2,
	'delivery_type' => 1,
	'purchase_check' => 1,
	'service_check' => 1,
	'wait_delivery' => 1,
	'print_status' => 0,
	'product_name' => $_GET['product_name'],
	//'logistics_company' => $_GET['logistics_company'],
	//'logistics_sn' => $_GET['logistics_sn'],
);




//$list = $CenterOrderModel->GetList( $search );
//$total = $CenterOrderModel->GetTotal( $search );

$list = $CenterOrderModel->GetList( $search, $offset, $onePage );
$total = $CenterOrderModel->GetTotal( $search );

echo $total."<br><br><br><br>";


	foreach ( $list as $key => $val )
	{
		$data = array();
		$data['logistics_company'] = "EMS";
		$data['delivery_ready_status'] = 1;
		$CenterOrderModel->Update( $val['id'], $data );
echo  $val['id']."<br>";
flush(); 

	}


?>