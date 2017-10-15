<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

if ( !is_array( $_POST['order_id'] ) )
	Alert( '请选择至少一个订单' );

if ( !$_POST['finance_date'] )
	Alert( '请选择到账时间' );

$financeTime = strtotime( $_POST['finance_date'] );

if ( !$financeTime || $financeTime < 0 )
	Alert( '到账时间格式错误' );

$financeRecieve = $_POST['finance_recieve'];

foreach ( $_POST['order_id'] as $orderId )
{
	$data = array();
	$data['finance_recieve'] = $financeRecieve;
	$data['finance_recieve_time'] = $financeTime;

	$CenterOrderModel->Update( $orderId, $data );
}

Common::Loading();

?>