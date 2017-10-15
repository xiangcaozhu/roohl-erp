<?php
/*
@@acc_freet
@@acc_title="快速修改属性 edit"
*/
//$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
//$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
//$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

//$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

//Core::LoadDom( 'CenterSku' );

//$orderId = (int)$_GET['orderId'];
//$e_id = (int)$_GET['e_id'];
//$sku_New = trim( $_GET['e_sku'] );

//$orderInfo = $CenterOrderModel->Get( $orderId );

//if ( !$orderInfo )
//	Alert( '没有找到指定的订单' );

//$orderDeliveryTypeList = Core::GetConfig( 'order_delivery_type' );
//$orderDeliveryStatusList = Core::GetConfig( 'order_delivery_status' );
//$orderLockStatusList = Core::GetConfig( 'order_lock_status' );

//$orderInfo['delivery_type_name'] = $orderDeliveryTypeList[$orderInfo['delivery_type']];
//$orderInfo['delivery_status_name'] = $orderDeliveryStatusList[$orderInfo['delivery_status']];
//$orderInfo['lock_status_name'] = $orderLockStatusList[$orderInfo['lock_status']];

 //   $orderProductInfo = $CenterOrderModel->GetProductOne( $e_id );
	//$CenterSkuDom = new CenterSkuDom( $orderProductInfo['sku'] );
	//$skuInfo = $CenterSkuDom->InitProduct();



//foreach ( $productList as $key => $val )
//{
	//$productList[$key]['wait_quantity'] = $val['quantity'] - $val['lock_quantity'];


//	$productList[$key]['sku_info'] = $skuInfo;
//}


// check
	//if ( is_array( $_POST['e_price'] ) )
	//{
	//	foreach ( $_POST['e_price'] as $pid => $sku )
	//	{
			//$quantity = intval( $_POST['e_quantity'][$pid] );

			//$orderProductInfo = $productList[$pid];


			//if ( !NoThing( $_POST['e_sku'][$pid] ) )
			//{
			//	if ( $orderProductInfo['lock_quantity'] > 0 || $orderProductInfo['purchase_quantity'] > 0 || $orderProductInfo['delivery_quantity'] > 0 )
				//	exit( '订单产品行已经有后续操作,不能更改属性' );
		//	}
	//	}
	//}

	// check and collect
/*
	$productDataList = array();
	if ( is_array( $_POST['sku'] ) )
	{
		foreach ( $_POST['sku'] as $key => $sku )
		{
			$data = array();
			$data['sku'] = $sku;
			$data['sku_id'] = $CenterProductExtra->Sku2Id( $sku );
			$data['product_id'] = intval( $_POST['pid'][$key] );
			$data['quantity'] = intval( $_POST['quantity'][$key] );
			$data['price'] = floatval( $_POST['price'][$key] );
			$data['comment'] = trim( $_POST['row_comment'][$key] );

			if ( $data['quantity'] <= 0 )
				exit( '数量必须大于零' );
			if ( !$data['sku'] || !$data['sku_id'] )
				exit( 'SKU信息错误' );

			$productDataList[] = $data;
		}
	}
*/
	//$waitLockProductSkuList = array();

//	$CenterOrderModel->Model->DB->Begin();

	// update
//	if ( is_array( $_POST['e_price'] ) )
//	{
	//	foreach ( $_POST['e_price'] as $pid => $sku )
	//	{
		//	$data = array();
		//	$data['quantity'] = intval( $_POST['e_quantity'][$pid] );
		//	$data['price'] = floatval( $_POST['e_price'][$pid] );
		//	$data['comment'] = trim( $_POST['e_row_comment'][$pid] );

		//	if ( !NoThing( $_POST['e_sku'][$pid] ) )
		//	{
			//	$data['sku'] = $sku_New;
			//	$data['sku_id'] = $CenterProductExtra->Sku2Id( $sku_New );
		//	}

		//	$CenterOrderModel->UpdateProduct( $e_id, $data );

			//$orderProductInfo = $CenterOrderModel->GetProduct( $pid );

			//$waitLockProductSkuList[$orderProductInfo['sku_id']] = 1;
	//	}
//	}
	
	// update
	//$data = $_POST['order'];

	//$CenterOrderModel->Update( $orderId, $data );

	//$CenterOrderModel->Model->DB->Commit();

$orderId = (int)$_GET['id'];
if($orderId>0)
{
$data = array();
$data['lock_call'] = 0;
$data['lock_call_time'] = time();
$CenterOrderModel->Update( $orderId, $data );
}

	echo 200;

?>