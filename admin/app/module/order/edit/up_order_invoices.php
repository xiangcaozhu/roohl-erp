<?php
/*
@@acc_title="编辑订单 edit"
*/

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$orderId = (int)$_GET['id'];
$orderInfo = $CenterOrderModel->Get( $orderId );

if ( !$orderInfo )
	exit( '没有找到指定的订单' );

	$data = array();
	$data['order_invoice_status'] = 1;
	$CenterOrderModel->Update( $orderId, $data );

	echo 200;

?>