<?php
/*
@@acc_title="编辑订单 edit"
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

Core::LoadDom( 'CenterSku' );
$orderDeliveryTypeList = Core::GetConfig( 'order_delivery_type' );
$orderDeliveryStatusList = Core::GetConfig( 'order_delivery_status' );
$orderLockStatusList = Core::GetConfig( 'order_lock_status' );
$orderInfo['delivery_type_name'] = $orderDeliveryTypeList[$orderInfo['delivery_type']];
$orderInfo['delivery_status_name'] = $orderDeliveryStatusList[$orderInfo['delivery_status']];
$orderInfo['lock_status_name'] = $orderLockStatusList[$orderInfo['lock_status']];

$productList = $CenterOrderModel->GetProductList( $orderId );
*/

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$orderId = (int)$_GET['id'];

$orderInfo = $CenterOrderModel->Get( $orderId );

if ( !$orderInfo )
	exit( '没有找到指定的订单' );


$ActionLogModel = Core::ImportModel( 'ActionLog' );

$comment ='原始信息：';
$comment .= $orderInfo['order_shipping_name'].'/';
$comment .= $orderInfo['order_shipping_phone'].'/';
$comment .= $orderInfo['order_shipping_mobile'].'/';
$comment .= $orderInfo['order_shipping_address'].'/';
$comment .= $orderInfo['order_shipping_zip'];



$data = array();
$data['user_id'] = $__UserAuth['user_id'];
$data['user_name'] = $__UserAuth['user_name'];
$data['comment'] = $comment;
$data['action'] = 'order_edit_user' ;
$data['type'] = 0;
$data['add_time'] = time();
$data['target_id'] = $orderId;

$ActionLogModel->Add( $data );



$order_shipping_name = $_GET['order_shipping_name'];
$order_shipping_phone = $_GET['order_shipping_phone'];
$order_shipping_mobile = $_GET['order_shipping_mobile'];
$order_shipping_address = $_GET['order_shipping_address'];
$order_shipping_zip = $_GET['order_shipping_zip'];

$CenterOrderModel->Model->DB->Begin();
			$data_new = array();
			$data_new['order_shipping_name'] = $order_shipping_name;
			$data_new['order_shipping_phone'] = $order_shipping_phone;
			$data_new['order_shipping_mobile'] = $order_shipping_mobile;
			$data_new['order_shipping_address'] = $order_shipping_address;
			$data_new['order_shipping_zip'] = $order_shipping_zip;
			$data_new['lock_call_time'] = time();
$CenterOrderModel->Update( $orderId, $data_new );
$CenterOrderModel->Model->DB->Commit();


	echo 200;

?>