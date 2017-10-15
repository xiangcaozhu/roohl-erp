<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$orderId = (int)$_GET['orderId'];
$comment = $_GET['comment'] ;
$type = (int)$_GET['type'];



$orderInfo = $CenterOrderModel->Get( $orderId );

if ( !$orderInfo )
	Alert( '没有找到指定的订单' );


if($type==2)
{
$data_order = array();
$data_order['order_service'] = 2;
$data_order['service_end'] = time();
$CenterOrderModel->Update( $orderId, $data_order );
}
else
{


$data_order = array();
$data_order['order_service'] = 1;
if($orderInfo['order_service']==0)
{
$data_order['service_begin'] = time();
}
$CenterOrderModel->Update( $orderId, $data_order );


$ActionLogModel = Core::ImportModel( 'ActionLog' );

$data = array();
$data['user_id'] = $__UserAuth['user_id'];
$data['user_name'] = $__UserAuth['user_name'];
$data['comment'] = $comment;
$data['action'] = 'order_call_service' ;
$data['type'] = 0;
$data['add_time'] = time();
$data['target_id'] = $orderId;

$ActionLogModel->AddService( $data );
}

echo '200';

?>