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
$orderInvoice = (int)$_GET['order_invoice'];
$order_invoice_header = $_GET['order_invoice_header'];
$order_invoice_type = $_GET['order_invoice_type'];
$order_invoice_product = $_GET['order_invoice_product'];

$orderInfo = $CenterOrderModel->Get( $orderId );

if ( !$orderInfo )
	exit( '没有找到指定的订单' );


$CenterOrderModel->Model->DB->Begin();

			$data = array();
			$data['order_invoice'] = $orderInvoice;
			$data['order_invoice_header'] = $order_invoice_header;
			$data['order_invoice_type'] = $order_invoice_type;
			$data['order_invoice_product'] = $order_invoice_product;
			$data['lock_call_time'] = time();

$CenterOrderModel->Update( $orderId, $data );
$CenterOrderModel->Model->DB->Commit();

	echo 200;

?>