<?php

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

if((int)$onePage<1)
    $onePage=10;


list( $page, $offset, $onePage ) = Common::PageArg( $onePage );

if ( $_GET['excel'] )
{
	$offset = 0;
	$onePage = 0;
}

$search = array(
	//'collate_status' => 1,
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

$list = $CenterOrderModel->GetList( $search, $offset, $onePage );

$total = $CenterOrderModel->GetTotal( $search );

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

foreach ( $list as $key => $val )
{
	$list[$key]['supplier_name'] = $channelList[$val['channel_id']]['name'];//供货商
	
	
	
	$list[$key]['channel_name'] = $channelList[$val['channel_id']]['name'];
	$list[$key]['import_type_name'] = $importTypeList[$val['import_type']];
	$list[$key]['payment_type_name'] = $paymentTypeList[$val['payment_type']];

	$list[$key]['status_name'] = $orderOrderStatusList[$val['status']]['name'];

	$list[$key]['delivery_type_name'] = $orderDeliveryTypeList[$val['delivery_type']];
	$list[$key]['delivery_status_name'] = $orderDeliveryStatusList[$val['delivery_status']];
	$list[$key]['lock_status_name'] = $orderLockStatusList[$val['lock_status']];
	$list[$key]['purchase_check_name'] = $orderPurchaseCheckList[$val['purchase_check']];
	$list[$key]['service_check_name'] = $orderServiceCheckList[$val['service_check']];
	$list[$key]['finance_recieve_name'] = $orderFinanceRecieveList[$val['finance_recieve']];

	$list[$key]['sign_status_name'] = $orderSignStatusList[$val['sign_status']];
	$list[$key]['sign_time'] = DateFormat( $val['sign_time'],(Ymd) );

	$list[$key]['delivery_time'] = $val['delivery_time'] ? DateFormat( $val['delivery_time'] ) : '';
	$list[$key]['purchase_check_time'] = $val['purchase_check_time'] ? DateFormat( $val['purchase_check_time'] ) : '';
	$list[$key]['service_check_time'] = $val['service_check_time'] ? DateFormat( $val['service_check_time'] ) : '';

	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];

	if ( $_GET['excel'] )
	{
		$list[$key]['delivery_type_name'] = strip_tags( $orderDeliveryTypeList[$val['delivery_type']] );
		$list[$key]['delivery_status_name'] = strip_tags( $orderDeliveryStatusList[$val['delivery_status']] );
		$list[$key]['lock_status_name'] = strip_tags( $orderLockStatusList[$val['lock_status']] );
	}

	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['order_time'] = DateFormat( $val['order_time'] );
	$list[$key]['finance_recieve_time'] = DateFormat( $val['finance_recieve_time'] );

	
	
	
	
	
	
	$purchaseCheckList = $ActionLogModel->GetList( $val['id'], 'order_check_purchase' );
	$serviceCheckList = $ActionLogModel->GetList( $val['id'], 'order_check_service' );
	$serviceCallList = $ActionLogModel->GetList_1( $val['id'], 'order_call_service' );
	$serviceEditUserList = $ActionLogModel->GetList( $val['id'], 'order_edit_user' );
	
	$serviceList = $ActionLogModel->GetList_2( $val['id'], 'order_call_service' );
	
	//$serviceList = $ActionLogModel->GetList_11( $val['id'], 'order_call_service' );
	//$serviceList = $ActionLogModel->GetList_2( $val['id'], 'order_call_service' );
	
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
		$list[$key]['service_last_check'] = $current['comment'];
	}

	$list[$key]['purchase_check_list'] = $purchaseCheckList;
	$list[$key]['service_check_list'] = $serviceCheckList;
	$list[$key]['service_call_list'] = $serviceCallList;
	$list[$key]['serviceEditUserList'] = $serviceEditUserList;



	foreach ( $serviceList as $k =>$v )
	{
		$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	    $serviceList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;
	}
	$list[$key]['service_list'] = $serviceList;






	$list[$key]['service_check_string'] = implode( '|', $tmp );

	$tmp = array();
	foreach ( $serviceCallList as $k =>$v )
	{
		//$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	    //$serviceCallList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;
		$tmp[] = DateFormat( $v['add_time'] ) . ' 说明:' . $v['comment'];
		//echo $serviceCallList[$k]['user_name_zh'] . '<br>';
	}

	$list[$key]['service_call_string'] = implode( '|', $tmp );

	/*
	$d = array();
	$t = end($purchaseCheckList);
	$d['purchase_check_time'] = $t['add_time'];
	$t = end($serviceCheckList);
	$d['service_check_time'] = $t['add_time'];
	$t = end($serviceCallList);
	$d['call_time'] = $t['add_time'];

	$CenterOrderModel->Update( $val['id'], $d );
	

	$CenterDeliveryModel = Core::ImportModel( 'CenterDelivery' );
	$inf = $CenterDeliveryModel->GetByOrder( $val['id'] );
	if ( $inf )
		$CenterOrderModel->Update( $val['id'], array( 'delivery_time' => $inf['add_time'] ) );
		
	*/

	$productList = $CenterOrderModel->GetProductList( $val['id'] );

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
		
		if($list[$key]['order_invoice_type']==1)
		   $productList[$k]['out_name'] = '办公用品';
		
		if($list[$key]['order_invoice_type']==2)
		   $productList[$k]['out_name'] = '礼品';
		
		if($list[$key]['order_invoice_type']==3)
		   $productList[$k]['out_name'] = $val['order_invoice_product'];
		
		
		
		
		
		
		
		
		
		$productList[$k]['productInfo'] = $productInfo;
		$productList[$k]['supplierInfo'] = $supplier_tmp;
		$supplier_Now_Info = $CenterSupplierModel->Get( $productInfo['supplier_now'] );
		$productList[$k]['supplierNow'] = $supplier_Now_Info;
		//if($v['manager_edit_user_id']>0)
		//{
		//$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['manager_edit_user_id'] );
	   // $productList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;
		//}
		
		if($p==0)
		$list[$key]['order_invoice_product_m'] = $productList[$k]['productInfo']['name'];
		
	

      $p++;
	}

	$list[$key]['list'] = $CenterOrderExtra->ExplainProduct( $productList );
}

?>