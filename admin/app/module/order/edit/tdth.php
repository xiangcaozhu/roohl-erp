<?php



$orderId = (int)$_GET['order_id'];

//$orderInfo = $CenterOrderModel->Get( $orderId );

//if ( !$orderInfo )
//	Alert( '没有找到指定的订单' );




//$CenterOrderModel->Model->DB->Begin();

/*
$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );
if ( $_GET['do'] == 'purchase' )
{
	$action = "order_check_purchase";
	$data['purchase_check'] = $_GET['type'];
	$data['purchase_check_time'] = time();
	
	
	
	$productList = $CenterOrderModel->GetProductList( $orderId );
	foreach ( $productList as $val )
	{
		$pid = $val['product_id'];
		$productInfo = $CenterProductModel->Get( $pid );
		$data_a = array();
		$data_a['supplier_id'] = intval( $productInfo['supplier_now'] );
		$CenterOrderModel->UpdateProduct( $val['id'], $data_a );
	}


}
elseif ( $_GET['do'] == 'service' )
{
	$action = "order_check_service";
	$data['service_check'] = $_GET['type'];
	$data['service_check_time'] = time();

	if ( $_GET['type'] == 2 )
	{
		if ( $orderInfo['lock_status'] > 0 )
			exit( '订单已经配货,请取消配货后再操作' );
	}
}
//else
//{
//	Alert( '未定义操作' );
//}

$CenterOrderModel->Update( $orderId, $data );
*/
$ActionLogModel = Core::ImportModel( 'ActionLog' );
$data = array();
$data['user_id'] = $__UserAuth['user_id'];
$data['user_name'] = $__UserAuth['user_name'];
$data['comment'] = $_GET['comment'];
$data['action'] = 'order_tdth';
$data['type'] = 2;
$data['add_time'] = time();
$data['target_id'] = $orderId;
$ActionLogModel->Add( $data );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$datas = array();
$datas['status'] = 2;
$CenterOrderModel->Update( $orderId, $datas );

//$CenterOrderModel->Model->DB->Commit();


echo 200;
//Redirect( '?mod=order.check.service&service_check=0' );




//Common::Loading();

?>