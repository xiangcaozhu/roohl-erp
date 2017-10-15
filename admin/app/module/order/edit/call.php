<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$orderId = (int)$_GET['id'];

$orderInfo = $CenterOrderModel->Get( $orderId );

if ( !$orderInfo )
	Alert( '没有找到指定的订单' );


$data = array();
$data['call_status'] = 1;
$data['call_timer'] = $orderInfo['call_timer'] + 1;

$CenterOrderModel->Update( $orderId, $data );

$ActionLogModel = Core::ImportModel( 'ActionLog' );

$data = array();
$data['user_id'] = $__UserAuth['user_id'];
$data['user_name'] = $__UserAuth['user_name'];
$data['comment'] = $_POST['comment'];
$data['action'] = 'order_call_service' ;
$data['type'] = 0;
$data['add_time'] = time();
$data['target_id'] = $orderId;

$ActionLogModel->Add( $data );

Common::Loading();

?>