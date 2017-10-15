<?php

$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );
$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
//$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
//$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$ActionLogModel = Core::ImportModel( 'ActionLog' );

$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );

$channelList = $CenterChannelModel->GetList();
//$warehouseList = $CenterWarehouseModel->GetList();
//$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );

$startID=0;
if((int)$_GET['service_check']<1)
{
$startID = $CenterOrderModel->GetListStartID_service_check();
$startID = (int)$startID-1;
}

//echo $startID;


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
	'xiaofwID' => $startID,
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



if((int)trim($_GET['id'])>0){
$search = array();
$search = array('id' => trim($_GET['id']));
}



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

	
	
	
	$CECE = $ActionLogModel->GetNewLogGood( $val['id'],1);
	$CECE = ArrayIndex($CECE,"action");
	$list[$key]['ceA'] = $CECE["order_check_purchase"];
	$list[$key]['ceB'] = $CECE["order_check_service"];
	
	$list[$key]['ceC'] = $CECE["order_call_service"];
	$list[$key]['ceD'] = $CECE["order_edit_user"];

	$serviceCallList=array();
	if($CECE["order_call_service"]){
	$serviceCallList = $ActionLogModel->GetList_1( $val['id'], 'order_call_service' );
	foreach ( $serviceCallList as $k =>$v )
	{
		$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	    $serviceCallList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;
	}
	}
	$list[$key]['service_call_list'] = $serviceCallList;
	

	$serviceEditUserList=array();
	if($CECE["order_edit_user"]){
	$serviceEditUserList = $ActionLogModel->GetList( $val['id'], 'order_edit_user' );
	foreach ( $serviceEditUserList as $k =>$v )
	{
		$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $v['user_id'] );
	    $serviceEditUserList[$k]['user_name_zh'] = $AdminArray['user_real_name'] ;
	}
	}
	$list[$key]['serviceEditUserList'] = $serviceEditUserList;



	$productList = $CenterOrderModel->GetProductList( $val['id'] );

	$p=0;
	foreach( $productList as $k => $v )
	{
		
		$productInfo = $CenterProductModel->Get( $v['product_id'] );
		$supplier_List=explode(',',$productInfo['supplier_id']);
		
		$productList[$k]['total_price'] = FormatMoney($v['quantity']*$v['price']);
		
		if($list[$key]['order_invoice_type']==1)
		   $productList[$k]['out_name'] = '办公用品';
		
		if($list[$key]['order_invoice_type']==2)
		   $productList[$k]['out_name'] = '礼品';
		
		if($list[$key]['order_invoice_type']==3)
		   $productList[$k]['out_name'] = $val['order_invoice_product'];
		
		
		$productList[$k]['productInfo'] = $productInfo;
		if($p==0)
		$list[$key]['order_invoice_product_m'] = $productList[$k]['productInfo']['name'];
		
	

      $p++;
	}

	$goodGood = $CenterOrderExtra->ExplainProduct( $productList );
	$list[$key]['list'] = $goodGood;
	
	

//主页面切换过来的	
	  $list[$key]['frontChange']=0;
	  $list[$key]['NoEdit']=0;
	  foreach ( $goodGood as $key_a => $val_a )
      {
	  	 if($val_a['price']>0){
		  $list[$key]['coupon_price']=$val_a['price']*$val_a['quantity'];
		  if((int)$val_a['coupon_price']>0 )
	      $list[$key]['coupon_price']=$val_a['price']*$val_a['quantity']-$val_a['coupon_price'];
		  }

	  $AttributeID = $CenterBuyAttributeExtra->ParseSkuAttribute_toID( $val_a['sku_info']['content'] );
	  $list[$key]['list'][$key_a]['service'] = (int)$AttributeID;
	  if((int)$AttributeID>0)
	      $list[$key]['frontChange']=1;
	  
	  if ( $val_a['lock_quantity'] > 0 || $val_a['purchase_quantity'] > 0 || $val_a['delivery_quantity'] > 0 )
	      $list[$key]['NoEdit']=1;
      }


//主页面切换过来的	


}

?>