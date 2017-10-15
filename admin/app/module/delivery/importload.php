<?php
/*
@@acc_freet
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );


Core::LoadDom( 'CenterPurchase' );
Core::LoadDom( 'CenterOrder' );
Core::LoadDom( 'CenterReceive' );
Core::LoadDom( 'CenterWarehousePlace' );

Core::LoadFunction( 'ImportOrderInfo.inc.php' );

$CenterReceiveExtra = Core::ImportExtra( 'CenterReceive' );
$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );		

$CenterStoreModel = Core::ImportModel( 'CenterStore' );
$CenterWarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$channelList = $CenterChannelModel->GetList();
$CenterDeliveryModel = Core::ImportModel( 'CenterDelivery' );
$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );


function ArrayIndexA( $list, $key )
{
	if ( !is_array( $list ) )
		return array();
	
	$new = array();
	foreach ( $list as $val )
	{
		$new[$val[$key]] = $val;
	}

	return $new;
}




$savePath = Core::GetConfig( 'file_upload_tmp_path' );
$fileName = $_GET['file'];
$saveFile = $savePath . $fileName  . ".tmp";

if ( !file_exists( $saveFile ) )
{
	Alert( '没有找到待导入文件' );
}


$list = ImportlogisticsSn( $saveFile );

//$CenterOrderModel->Model->DB->Begin();




	$temp = array();
	foreach ( $list as $keys => $val )
	{
		$temp[$val['order_id']] = $val['order_id'];
	}
	$IDS = implode(",",$temp);
	
	if((int)$val['xiaofw']==901){
		$orderList = $CenterOrderModel->Get0919B( $IDS );
		$orderList = ArrayIndexA($orderList,"target_id");
			
	}else{
		$orderList = $CenterOrderModel->Get0919A( $IDS );
		$orderList = ArrayIndexA($orderList,"id");
	}
	


foreach ( $list as $TKey => $val )
{
/*
	if((int)$val['xiaofw']==901){
		$order = $CenterOrderModel->Get0919( $val['order_id'] );
		$val['order_id'] = $order['id'];
		$list[$TKey]['order_id'] = $order['id'];
	}else{
		$order = $CenterOrderModel->Get09191( $val['order_id'] );
	
	}
*/
		$order = $orderList[$val['order_id']];
		if((int)$val['xiaofw']==901){
			$val['order_id'] = $order['id'];
			$list[$TKey]['order_id'] = $order['id'];
			
		}
		


    $error_one = false;
		
    if ( !$order )
         $error_one = true;

    if( $order['delivery_status']<2 && $order['warehouse_id']>5 )
         $error_one = true;
		 
	if ( $order['logistics_sn'] )
	     $error_one = true;


    if( !$error_one )
    {
        $dataOrder = array();
        $dataOrder['logistics_company'] = $val['logistics_company'];
        $dataOrder['logistics_sn'] = $val['logistics_sn']; 
        $dataOrder['logistics_time'] = time(); 
        $CenterOrderModel->Update( $val['order_id'], $dataOrder );


////////////////////////////////更新代发货库收货状态        
if ($order['warehouse_id'] == 5 && $order['lock_status']<2 && $order['delivery_status']<2 )
{
    $order_ProductList = $CenterOrderModel->GetProductList( $val['order_id'] );//订单商品列表
    foreach ( $order_ProductList as $p_key => $P_val )
	{
	$purchase_ProductId = $CenterPurchaseModel->GetPpidByOpid( $P_val['id'] );
		if ( $purchase_ProductId )
		{
		$CenterPurchaseModel->UpdateProduct( $purchase_ProductId, false, "receive_quantity = receive_quantity + " . $P_val['quantity'] );
		$CenterPurchaseModel->UpdateProduct( $purchase_ProductId, false, "into_quantity = into_quantity + " . $P_val['quantity'] );
		$data_op = array(
			'into_quantity' => $P_val['quantity'],
			'lock_quantity' => $P_val['quantity'],
			'delivery_quantity' => $P_val['quantity'],
		    );
		$CenterOrderModel->UpdateProduct( $P_val['id'], $data_op );
		
		// 更新 采购关联表
		$CenterPurchaseModel->UpdateRelation_dfh( $P_val['id'], false, "into_quantity = quantity" );
		$CenterPurchaseModel->UpdateRelation_dfh( $P_val['id'], false, "lock_quantity = quantity" );

		}
	}

	//更新采购单的完成状态
    $order_PurchaseList = $CenterPurchaseModel->GetOrderListByPurchase( $val['order_id'] );//订单反查采购单号
	if ( $purchase_ProductId )
	{
		foreach ( $order_PurchaseList as $p_key => $P_val )
    	{
    	$purchaseInfo = $CenterPurchaseModel->Get( $P_val['purchase_id'] );
		$CenterPurchaseDom = new CenterPurchaseDom( $purchaseInfo );
		$CenterPurchaseDom->UpdateStatus();
		}
	}

	//更新定单的完成状态
	$OrderDom = new CenterOrderDom( $order );
	$OrderDom->UpdateStatus_dfh();		
}
////////////////////////////////更新代发货库收货状态
    }

}
		
//$CenterOrderModel->Model->DB->Commit();


Common::Loading( '?mod=delivery.import' );

?>