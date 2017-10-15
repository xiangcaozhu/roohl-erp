<?php
	$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );
	$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );


$importTypeList = Core::GetConfig( 'order_import_type' );
$paymentTypeList = Core::GetConfig( 'order_payment_type' );
$orderDeliveryTypeList = Core::GetConfig( 'order_delivery_type' );
$orderDeliveryStatusList = Core::GetConfig( 'order_delivery_status' );
$orderLockStatusList = Core::GetConfig( 'order_lock_status' );
$orderPurchaseCheckList = Core::GetConfig( 'order_purchase_check' );
$orderServiceCheckList = Core::GetConfig( 'order_service_check' );
$orderSignStatusList = Core::GetConfig( 'order_sign_status' );
$orderFinanceRecieveList = Core::GetConfig( 'finance_recieve' );
$orderOrderStatusList = Core::GetConfig( 'order_status' );

$tpl['lock_status_list'] = $orderLockStatusList;
$tpl['delivery_status_list'] = $orderDeliveryStatusList;
$tpl['finance_recieve_status_list'] = $orderFinanceRecieveList;
$tpl['sign_status_list'] = $orderSignStatusList;
$tpl['order_status_list'] = $orderOrderStatusList;





//$onePage=1;
//list( $page, $offset, $onePage ) = Common::PageArg( $onePage );
//$list = $CenterOrderModel->GetCall( $search, $offset, $onePage );




$orderInfo = $CenterOrderModel->GetCall( $search );


//foreach ( $list as $key => $val )
//{
	$orderInfo['channel_name'] = $channelList[$orderInfo['channel_id']]['name'];
	$orderInfo['import_type_name'] = $importTypeList[$orderInfo['import_type']];
	$orderInfo['payment_type_name'] = $paymentTypeList[$orderInfo['payment_type']];
	$orderInfo['status_name'] = $orderOrderStatusList[$orderInfo['status']]['name'];
	$orderInfo['delivery_type_name'] = $orderDeliveryTypeList[$orderInfo['delivery_type']];
	$orderInfo['delivery_status_name'] = $orderDeliveryStatusList[$orderInfo['delivery_status']];
	$orderInfo['lock_status_name'] = $orderLockStatusList[$orderInfo['lock_status']];
	$orderInfo['purchase_check_name'] = $orderPurchaseCheckList[$orderInfo['purchase_check']];
	$orderInfo['service_check_name'] = $orderServiceCheckList[$orderInfo['service_check']];
	$orderInfo['finance_recieve_name'] = $orderFinanceRecieveList[$orderInfo['finance_recieve']];
	$orderInfo['sign_status_name'] = $orderSignStatusList[$orderInfo['sign_status']];
	$orderInfo['sign_time'] = DateFormat( $orderInfo['sign_time'] );
	$orderInfo['delivery_time'] = $orderInfo['delivery_time'] ? DateFormat( $orderInfo['delivery_time'] ) : '';
	$orderInfo['purchase_check_time'] = $orderInfo['purchase_check_time'] ? DateFormat( $orderInfo['purchase_check_time'] ) : '';
	$orderInfo['service_check_time'] = $orderInfo['service_check_time'] ? DateFormat( $orderInfo['service_check_time'] ) : '';
	$orderInfo['warehouse_name'] = $warehouseList[$orderInfo['warehouse_id']]['name'];
	$orderInfo['add_time'] = DateFormat( $orderInfo['add_time'] );
	$orderInfo['order_time'] = DateFormat( $orderInfo['order_time'] );
	$orderInfo['finance_recieve_time'] = DateFormat( $orderInfo['finance_recieve_time'] );

	$purchaseCheckList = $ActionLogModel->GetList( $orderInfo['id'], 'order_check_purchase' );
	$serviceCheckList = $ActionLogModel->GetList( $orderInfo['id'], 'order_check_service' );
	$serviceCallList = $ActionLogModel->GetList_1( $orderInfo['id'], 'order_call_service' );
	$serviceEditUserList = $ActionLogModel->GetList( $orderInfo['id'], 'order_edit_user' );
	
	foreach ( $serviceCallList as $k =>$v )
	{
		$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	    $serviceCallList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;
	}
	
	foreach ( $serviceEditUserList as $k =>$v )
	{
		$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	    $serviceEditUserList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;
	}
	

	foreach ( $purchaseCheckList as $k =>$v )
	{
		$purchaseCheckList[$k]['type_name'] = $orderPurchaseCheckList[$v['type']];
		$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	    $purchaseCheckList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;
	}

	$tmp = array();
	foreach ( $serviceCheckList as $k =>$v )
	{
		$serviceCheckList[$k]['type_name'] = $orderServiceCheckList[$v['type']];
		$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	    $serviceCheckList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;

		$tmp[] = DateFormat( $v['add_time'] ) . ' 操作:' . strip_tags( $orderServiceCheckList[$v['type']] ) . ' 说明:' . $v['comment'];
	}

	if ( $serviceCheckList )
	{
		reset( $serviceCheckList );
		$current = current( $serviceCheckList );
		$orderInfo['service_last_check'] = $current['comment'];
	}

	$orderInfo['purchase_check_list'] = $purchaseCheckList;
	$orderInfo['service_check_list'] = $serviceCheckList;
	$orderInfo['service_call_list'] = $serviceCallList;
	$orderInfo['serviceEditUserList'] = $serviceEditUserList;

	$orderInfo['service_check_string'] = implode( '|', $tmp );

	$tmp = array();
	foreach ( $serviceCallList as $k =>$v )
	{
		//$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	    //$serviceCallList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;
		$tmp[] = DateFormat( $v['add_time'] ) . ' 说明:' . $v['comment'];
		//echo $serviceCallList[$k]['user_name_zh'] . '<br>';
	}

	$orderInfo['service_call_string'] = implode( '|', $tmp );


	$productList = $CenterOrderModel->GetProductList( $orderInfo['id'] );

	$p=0;
	foreach( $productList as $k => $v )
	{
		
		$liveQuantity = $CenterWarehouseStockModel->GetLiveQuantityBySkuId( $v['sku_id'] );
		$productList[$k]['warehouse_live_quantity'] = (int)$liveQuantity['live_quantity'];
		
		$productInfo = $CenterProductModel->Get( $v['product_id'] );
		$supplier_List=explode(',',$productInfo['supplier_id']);
		
			$supplier_tmp = array();
			foreach( $supplier_List as $xa => $ya )
			{
			$supplier_Info = $CenterSupplierModel->Get( $ya );
			$supplier_tmp[] = $supplier_Info;
			}
		
		
		$productList[$k]['total_price'] = FormatMoney($v['quantity']*$v['price']);
		
		if($orderInfo['order_invoice_type']==1)
		   $productList[$k]['out_name'] = '办公用品';
		
		if($orderInfo['order_invoice_type']==2)
		   $productList[$k]['out_name'] = '礼品';
		
		if($orderInfo['order_invoice_type']==3)
		   $productList[$k]['out_name'] = $orderInfo['order_invoice_product'];
		
		$productList[$k]['productInfo'] = $productInfo;
		$productList[$k]['supplierInfo'] = $supplier_tmp;
		$supplier_Now_Info = $CenterSupplierModel->Get( $productInfo['supplier_now'] );
		$productList[$k]['supplierNow'] = $supplier_Now_Info;

		if($p==0)
		$orderInfo['order_invoice_product_m'] = $productList[$k]['productInfo']['name'];

      $p++;
	}

	$orderInfo['product_list'] = $CenterOrderExtra->ExplainProduct( $productList );
//}

?>