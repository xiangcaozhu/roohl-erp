<?php
/*
@@acc_title="客服外呼_2 service_2"
*/

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$ActionLogModel = Core::ImportModel( 'ActionLog' );

$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );




$channelList = $CenterChannelModel->GetList();
$tpl['channel_list'] = $channelList;


$warehouseList = $CenterWarehouseModel->GetList();
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );




$startID = $CenterOrderModel->GetListStartID_service_check();
$startID = (int)$startID-1;





$searchs = array(
	'channel_id' => $_GET['channel_id'],
	'wait_service_all' => 1,
	'xiaofwID' => $startID,
);



$checkTime=time()-300;
$CenterOrderModel->ClearLockCall( $checkTime, $__UserAuth['user_id'],$startID );


if((int)$_GET['call']>0)
{

	$search = array(
		'channel_id' => $_GET['channel_id'],
		'lock_call' => 0,
		'wait_service_all' => 1,
		'xiaofwID' => $startID,
	);





	include( Core::BLock( 'order.list_213' ) );
	$dataLock = array();
    $dataLock['lock_call_time'] = time();
	$dataLock['lock_call'] = 1;
	$dataLock['lock_call_user_id'] = $__UserAuth['user_id'];
	$dataLock['lock_call_user_name'] = $__UserAuth['user_real_name'];
	
	$CenterOrderModel->Update( $orderInfo['id'], $dataLock );
	
	
	
	$orderInfo['frontChange']=0;
	$orderInfo['NoEdit']=0;
	  
	foreach ( $orderInfo['product_list'] as $key_a => $val_a )
    {
	  	  $AttributeID = $CenterBuyAttributeExtra->ParseSkuAttribute_toID( $val_a['sku_info']['content'] );
	  	  $orderInfo['product_list'][$key_a]['service'] = (int)$AttributeID;
	  	  if((int)$AttributeID>0)
	  	  	  $orderInfo['frontChange']=1;
	  
	  	  if ( $val_a['lock_quantity'] > 0 || $val_a['purchase_quantity'] > 0 || $val_a['delivery_quantity'] > 0 )
	  	  	  $orderInfo['NoEdit']=1;
      }







	$tpl['orderInfo'] = $orderInfo;
}


$lockCall = $CenterOrderModel->GetLockCall($startID);
$tpl['lock_call'] = $lockCall;

$total = $CenterOrderModel->GetTotal( $searchs );
$tpl['total'] = $total;

Common::PageOut( 'order/check/service_2.html', $tpl );

?>