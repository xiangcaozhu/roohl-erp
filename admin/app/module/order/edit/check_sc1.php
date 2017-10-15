<?php
/*
@@acc_free
@@acc_title="整理出库订单 pack"
*/


$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$ActionLogModel = Core::ImportModel( 'ActionLog' );

$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );

$channelList = $CenterChannelModel->GetList();
$warehouseList = $CenterWarehouseModel->GetList();
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );

ob_end_flush();
set_time_limit(0); 
	$offset = 0;
	$onePage = 0;







$search = array(
	//'product_name' => "75B*60001",
	//'purchase_check' => 0,
	//'channel_id' => 62,
	'id' => trim($_GET['id']),
	'target_id' => trim($_GET['target_id']),
	'product_name' => $_GET['product_name'],
	'phone' => $_GET['phone'],
	'status' => $_GET['order_status'],
	'lock_status' => $_GET['lock_status'],
	'delivery_status' => $_GET['delivery_status'],
	'channel_id' => $_GET['channel_id'],
	'order_invoice' => $_GET['order_invoice'],
	'order_invoice_status' => $_GET['order_invoice_status'],
	'logistics_type' => $_GET['logistics_type'],
	'delivery_first' => $_GET['delivery_first'],
	'logistics_company' => $_GET['logistics_company'],
	'sign_status' => $_GET['sign_status'],
	'purchase_check' => $_GET['purchase_check'],
	'channel_name' => $_GET['channel_name'],
	'service_check' => $_GET['service_check'],
	'channel_name' => $_GET['channel_name'],	
	'finance_recieve' => $_GET['finance_recieve'],
	'sign_status' => $_GET['sign_status'],
	'warehouse_type' => $_GET['warehouse_type'],
	'order_customer_name' => $_GET['order_customer_name'],
	'order_shipping_name' => trim($_GET['order_shipping_name']),
	'begin_time' => $_GET['begin_date'] ? strtotime( $_GET['begin_date'] . ' 00:00:00' ) : false,
	'end_time' => $_GET['end_date'] ? strtotime( $_GET['end_date'] . ' 23:59:59' ) : false,
	'begin_delivery_time' => $_GET['begin_delivery_date'] ? strtotime( $_GET['begin_delivery_date'] . ' 00:00:00' ) : false,
	'end_delivery_time' => $_GET['end_delivery_date'] ? strtotime( $_GET['end_delivery_date'] . ' 23:59:59' ) : false,
	'begin_sign_time' => $_GET['begin_sign_date'] ? strtotime( $_GET['begin_sign_date'] . ' 00:00:00' ) : false,
	'end_sign_time' => $_GET['end_sign_date'] ? strtotime( $_GET['end_sign_date'] . ' 23:59:59' ) : false,

	'begin_purchase_check_time' => $_GET['begin_purchase_check_date'] ? strtotime( $_GET['begin_purchase_check_date'] . ' 00:00:00' ) : false,
	'end_purchase_check_time' => $_GET['end_purchase_check_date'] ? strtotime( $_GET['end_purchase_check_date'] . ' 23:59:59' ) : false,

	'begin_service_check_time' => $_GET['begin_service_check_date'] ? strtotime( $_GET['begin_service_check_date'] . ' 00:00:00' ) : false,
	'end_service_check_time' => $_GET['end_service_check_date'] ? strtotime( $_GET['end_service_check_date'] . ' 23:59:59' ) : false,
);

if ( $staticSearch )
	$search = array_merge( $search, $staticSearch );



$orderList = $CenterOrderModel->GetList( $search, $offset, $onePage );
$total = $CenterOrderModel->GetTotal( $search );

echo $total;
foreach ( $orderList as $vs )
{


$orderId = $vs['id'];

$orderInfo = $CenterOrderModel->Get( $orderId );
$data = array();

$CenterOrderModel->Model->DB->Begin();

	$data['purchase_check'] = 1;
	$data['purchase_check_time'] = time();
	$data['purchase_real_name'] = "系统确认";
	$data['lock_call_time'] = time();
   $CenterOrderModel->Update( $orderId, $data );
	
	
	$productList = $CenterOrderModel->GetProductList( $orderId );
	foreach ( $productList as $val )
	{
		$pid = $val['product_id'];
		$productInfo = $CenterProductModel->Get( $pid );
		$data_a = array();
		$data_a['supplier_id'] = intval( $productInfo['supplier_now'] );
		$CenterOrderModel->UpdateProduct( $val['id'], $data_a );
	}

$CenterOrderModel->Model->DB->Commit();

echo $orderId."<br>";
flush(); 
//sleep(1); 

}


?>