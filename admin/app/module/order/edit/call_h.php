<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$orderId = (int)$_GET['id'];
$comments = (int)$_GET['comment'];

$comment = $_GET['comment'] ;

if($comments==1)
$comment = '无人接听' ;
if($comments==2)
$comment = '客户关机' ;
if($comments==3)
$comment = '客户挂断' ;
if($comments==4)
$comment = '来电提醒' ;
if($comments==5)
$comment = '无法接通' ;


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
$data['comment'] = $comment;
$data['action'] = 'order_call_service' ;
$data['type'] = 0;
$data['add_time'] = time();
$data['target_id'] = $orderId;

$ActionLogModel->Add( $data );

echo '200';

?>