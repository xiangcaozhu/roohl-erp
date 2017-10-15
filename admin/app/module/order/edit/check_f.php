<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );

$orderId = (int)$_GET['id'];

$orderInfo = $CenterOrderModel->Get( $orderId );

//if ( !$orderInfo )
//	Alert( '没有找到指定的订单' );


$data = array();

$CenterOrderModel->Model->DB->Begin();

if ( $_GET['do'] == 'purchase' )
{
	$action = "order_check_purchase";
	$data['purchase_check'] = $_GET['type'];
	$data['purchase_check_time'] = time();
	$data['purchase_real_name'] = $__UserAuth['user_real_name'];
	
	
	
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
	$data['service_real_name'] = $__UserAuth['user_real_name'];

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

$ActionLogModel = Core::ImportModel( 'ActionLog' );

$data = array();
$data['user_id'] = $__UserAuth['user_id'];
$data['user_name'] = $__UserAuth['user_name'];
$data['user_real_name'] = $__UserAuth['user_real_name'];
$data['comment'] = $_GET['comment'];
$data['action'] = $action;
$data['type'] = $_GET['type'];
$data['add_time'] = time();
$data['target_id'] = $orderId;

$ActionLogModel->Add( $data );

// 配货
if ( ( $_GET['do'] == 'purchase' && $_GET['type'] == 1 ) || ( $_GET['do'] == 'service' && $_GET['type'] == 1 ) )
{
	Core::LoadDom( 'CenterWarehousePlace' );

	$productList = $CenterOrderModel->GetProductList( $orderId );

	foreach ( $productList as $val )
	{
		$skuId = $val['sku_id'];
		$stockList = $WarehouseStockModel->GetLiveListBySkuId( $skuId );

		foreach ( $stockList as $v )
		{
			$WarehousePlaceDom = new CenterWarehousePlaceDom( $v['place_id'] );
			$WarehousePlaceDom->LockFlow( $skuId, $val['id'] );
		}
		
	}
}

$CenterOrderModel->Model->DB->Commit();


if ($_GET['do'] == 'purchase')
{
echo '<script>parent.C_over('.$orderId.');</script>';
//Redirect( '?mod=order.check.purchase&purchase_check=0' );
}
else
{
$data_new = array();
$data_new['lock_call_time'] = time();
$CenterOrderModel->Update( $orderId, $data_new );

echo 200;
}
//Redirect( '?mod=order.check.service&service_check=0' );




//Common::Loading();

?>