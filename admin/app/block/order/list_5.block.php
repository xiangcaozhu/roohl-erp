<?php
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$channelList = $CenterChannelModel->GetList();


$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$supplierList = $CenterSupplierModel->GetList();

$ActionLogModel = Core::ImportModel( 'ActionLog' );
$AdminiModel = Core::ImportModel( 'Admin' );


/*
$LogList = $ActionLogModel->GetListAll();

	foreach ( $LogList as $km =>$vm )
	{
		$AdminArray =  $AdminiModel -> GetAdministrator( $vm['user_id'] );
	    $user_real_name = $AdminArray['user_real_name'] ;
		
		$data = array();
		$data['user_real_name'] = $user_real_name;
		$ActionLogModel->Update( $vm['id'], $data );
	}

*/






$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
//$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

$CenterProductModel = Core::ImportModel( 'CenterProduct' );

//$warehouseList = $CenterWarehouseModel->GetList();

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

$order_status = $_GET['order_status'];


if($order_status==1)
{
$search['status']=$order_status;
$search['service_check']=1;
}

if($order_status==2 || $order_status==3)
{
$search['status']=$order_status;
}

if($order_status==4)
{
$search['service_check']=2;
}

if($order_status==5)
{
$search['service_check']='0';
$search['status']=1;
}



if ( $staticSearch )
	$search = array_merge( $search, $staticSearch );

$list = $CenterOrderModel->GetList( $search, $offset, $onePage );
$total = $CenterOrderModel->GetTotal( $search );





//$importTypeList = Core::GetConfig( 'order_import_type' );
//$paymentTypeList = Core::GetConfig( 'order_payment_type' );
//$orderDeliveryTypeList = Core::GetConfig( 'order_delivery_type' );
$orderDeliveryStatusList = Core::GetConfig( 'order_delivery_status' );
$orderLockStatusList = Core::GetConfig( 'order_lock_status' );//配货
$orderPurchaseCheckList = Core::GetConfig( 'order_purchase_check' );//产品确认
$orderServiceCheckList = Core::GetConfig( 'order_service_check' );//客服确认
$orderSignStatusList = Core::GetConfig( 'order_sign_status' );//签收
$orderFinanceRecieveList = Core::GetConfig( 'finance_recieve' );//到款状态
$orderOrderStatusList = Core::GetConfig( 'order_status' );//订单状态
$orderOrderDeliveryType = Core::GetConfig( 'order_delivery_type' );//发货方式

$orderOrderInvoice = Core::GetConfig( 'order_invoice' );//票据方式
$orderOrderInvoiceStatus = Core::GetConfig( 'order_invoice_status' );//票据状态

$tpl['lock_status_list'] = $orderLockStatusList;
$tpl['delivery_status_list'] = $orderDeliveryStatusList;
$tpl['finance_recieve_status_list'] = $orderFinanceRecieveList;
$tpl['sign_status_list'] = $orderSignStatusList;
//$tpl['order_status_list'] = $orderOrderStatusList;











foreach ( $list as $key => $val )
{
/////////////////////////////////////////////////////////////	

//if($val['purchase_check_name'])
//{
//echo 	$val['purchase_check_name'].'===<br>';
//$ActionLogModel->GetList( $val['id'], 'order_check_purchase' );

//}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
////////////////////////////////////////////////////////

$list[$key]['delivery_time'] = DateFormat( $val['delivery_time'] ,'m-d H:i') ;//发货时间
$list[$key]['status_name'] = $orderOrderStatusList[$val['status']];//订单状态
$list[$key]['delivery_type'] = $orderOrderDeliveryType[$val['warehouse_id']];//发货方式
$list[$key]['add_time'] = DateFormat( $val['add_time'] );//导入时间
$list[$key]['order_time'] = DateFormat( $val['order_time'] );//下单时间
$list[$key]['purchase_check_time'] =  DateFormat( $val['purchase_check_time'] ,'m-d H:i') ;//产品确认时间
$list[$key]['service_check_time'] = DateFormat( $val['service_check_time'] ,'m-d H:i') ; //客服确认时间
$list[$key]['delivery_status_name'] = $orderDeliveryStatusList[$val['delivery_status']];//发货状态
$list[$key]['lock_status_name'] = $orderLockStatusList[$val['lock_status']];//配货状态
$list[$key]['purchase_check_name'] = $orderPurchaseCheckList[$val['purchase_check']];//产品确认
$list[$key]['service_check_name'] = $orderServiceCheckList[$val['service_check']];//客服确认
$list[$key]['channel_name'] = $channelList[$val['channel_id']]['name'];//销售渠道

$list[$key]['sign_status_name'] = $orderSignStatusList[$val['sign_status']];//签收状态
$list[$key]['sign_time'] = DateFormat( $val['sign_time'],(Ymd) );//签收时间

$list[$key]['purchase_id'] = $CenterOrderModel->GetPurchaseByOrder( $val['id'] );//采购单
$list[$key]['finance_recieve_name'] = $orderFinanceRecieveList[$val['finance_recieve']];//到款状态


$list[$key]['order_invoice_name'] = $orderOrderInvoice[$val['order_invoice']];//票据方式
$list[$key]['order_invoice_status_name'] = $orderOrderInvoiceStatus[$val['order_invoice_status']];//票据状态

$list[$key]['lost_info'] = $ActionLogModel->GetList_11( $val['id'], 'order_tdth',2 );//售后退单说明


//$list[$key]['supplier_name'] = $supplierList[$val['channel_id']]['name'];//供货商

$purchaseCheckInfo = $ActionLogModel->GetOne( $val['id'], 'order_check_purchase' );//产品确认
$list[$key]['purchase_check_info'] = $purchaseCheckInfo['comment'];
$serviceCheckInfo = $ActionLogModel->GetOne( $val['id'], 'order_check_service' );//客服确认
$list[$key]['service_check_info'] = $serviceCheckInfo['comment'];

if(!$val['purchase_real_name'] || !$val['service_real_name'])
{
	$data = array();
	$data['purchase_real_name'] = $purchaseCheckInfo['user_real_name'];
	$data['service_real_name'] = $serviceCheckInfo['user_real_name'];
	$CenterOrderModel->Update( $val['id'], $data );
	$list[$key]['purchase_real_name'] = $purchaseCheckInfo['user_real_name'];
	$list[$key]['service_real_name'] = $serviceCheckInfo['user_real_name'];
}



	
	
	
	
	if ( $_GET['excel'] )
	{
		$list[$key]['delivery_type_name'] = strip_tags( $orderDeliveryTypeList[$val['delivery_type']] );
		$list[$key]['delivery_status_name'] = strip_tags( $orderDeliveryStatusList[$val['delivery_status']] );
		$list[$key]['lock_status_name'] = strip_tags( $orderLockStatusList[$val['lock_status']] );
	}
	
	
	//$list[$key]['import_type_name'] = $importTypeList[$val['import_type']];
	//$list[$key]['payment_type_name'] = $paymentTypeList[$val['payment_type']];

	

	//$list[$key]['delivery_type_name'] = $orderDeliveryTypeList[$val['delivery_type']];
	
	//

	
	

	

	//$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];


	//$list[$key]['finance_recieve_time'] = DateFormat( $val['finance_recieve_time'] );

	
	
	
	
	
	
	
	$serviceCallList = $ActionLogModel->GetList_1( $val['id'], 'order_call_service' );
	$serviceEditUserList = $ActionLogModel->GetList( $val['id'], 'order_edit_user' );
	
	$serviceList = $ActionLogModel->GetList_2( $val['id'], 'order_call_service' );
	
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
	

	//foreach ( $purchaseCheckList as $k =>$v )
	//{
	//	$purchaseCheckList[$k]['type_name'] = $orderPurchaseCheckList[$v['type']];
	//	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	 //   $purchaseCheckList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;
	//}

	//$tmp = array();
	//foreach ( $serviceCheckList as $k =>$v )
	//{
	//	$serviceCheckList[$k]['type_name'] = $orderServiceCheckList[$v['type']];
	//	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	//    $serviceCheckList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;

	//	$tmp[] = DateFormat( $v['add_time'] ) . ' 操作:' . strip_tags( $orderServiceCheckList[$v['type']] ) . ' 说明:' . $v['comment'];
	//}

	//if ( $serviceCheckList )
	//{
	//	reset( $serviceCheckList );
	//	$current = current( $serviceCheckList );
	//	$list[$key]['service_last_check'] = $current['comment'];
	//}

	
	$list[$key]['service_call_list'] = $serviceCallList;
	$list[$key]['serviceEditUserList'] = $serviceEditUserList;



	//foreach ( $serviceList as $k =>$v )
	//{
	//	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	 //   $serviceList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;
	//}
	//$list[$key]['service_list'] = $serviceList;






	//$list[$key]['service_check_string'] = implode( '|', $tmp );

	//$tmp = array();
	//foreach ( $serviceCallList as $k =>$v )
	//{
		//$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	    //$serviceCallList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;
		//$tmp[] = DateFormat( $v['add_time'] ) . ' 说明:' . $v['comment'];
		//echo $serviceCallList[$k]['user_name_zh'] . '<br>';
	//}

	//$list[$key]['service_call_string'] = implode( '|', $tmp );

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
		
		$list[$key]['supplier_name'] = $supplierList[$v['supplier_id']]['mini_name'];//供货商
		
		
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