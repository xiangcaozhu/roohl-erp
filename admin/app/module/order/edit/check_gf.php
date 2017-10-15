<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );


//$orderlist = $CenterOrderModel->KK0913();

//print_r($orderlist);

//?mod=order.edit.check_f&id='+orderId+'&do=purchase&comment='+comment+'&type=1&rand=' + Math.random()
if ( $_GET['do'] == 'P' ){
	$orderlist = $CenterOrderModel->xx0913();
	foreach ( $orderlist as $val )
	{


//$CenterOrderModel->Model->DB->Begin();

	$orderId = (int)$val['id'];
	$orderInfo = $CenterOrderModel->Get( $orderId );
	$data = array();


	$action = "order_check_purchase";
	$data['purchase_check'] = 1;
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



	$CenterOrderModel->Update( $orderId, $data );
	
	$ActionLogModel = Core::ImportModel( 'ActionLog' );
	
	$data = array();
	$data['user_id'] = $__UserAuth['user_id'];
	$data['user_name'] = $__UserAuth['user_name'];
	$data['user_real_name'] = $__UserAuth['user_real_name'];
	$data['comment'] = "直接确认";
	$data['action'] = $action;
	$data['type'] = 1;
	$data['add_time'] = time();
	$data['target_id'] = $orderId;
	
	$ActionLogModel->Add( $data );
	}
	//$CenterOrderModel->Model->DB->Commit();


}


function THH($str){
echo "<br><br><br<br><br><br<br><br><br<br><br><br>";
echo "<br><br>数据查询<br>";
echo '<pre>';
print_r($str);
echo '</pre>';
echo "<br>数据查询<br><br>";
}





if ( $_GET['do'] == 'S' ){
	$orderlist = $CenterOrderModel->xsx0913();

	$action = "order_check_service";
	$data['service_check'] = 1;
	$data['service_check_time'] = time();
	$data['service_real_name'] = $__UserAuth['user_real_name'];

	$ActionLogModel = Core::ImportModel( 'ActionLog' );
	Core::LoadDom( 'CenterWarehousePlace' );
	$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );

	$mkl=array();
	foreach ( $orderlist as $vs )
	{
		$orderId = (int)$vs['id'];
		$orderInfo = $CenterOrderModel->Get( $orderId );
		
		$productList = $CenterOrderModel->GetProductList( $orderId );
		foreach( $productList as $k => $v )
		{
			$productInfo = $CenterProductModel->Get( $v['product_id'] );
			$productList[$k]['productInfo'] = $productInfo;
		}
		$goodGood = $CenterOrderExtra->ExplainProduct( $productList );
		
		$yes = 0;
		foreach( $goodGood as $k => $v )
		{
		//THH($v);
			if($v['sku_info']['attribute']!=""){
				$yes = 1;
			}
		}
		

		
		
		if($yes == 0){
			$CenterOrderModel->Update( $orderId, $data );
			
			
			$datas = array();
			$datas['user_id'] = $__UserAuth['user_id'];
			$datas['user_name'] = $__UserAuth['user_name'];
			$datas['user_real_name'] = $__UserAuth['user_real_name'];
			$datas['comment'] = "直接确认";
			$datas['action'] = $action;
			$datas['type'] = 1;
			$datas['add_time'] = time();
			$datas['target_id'] = $orderId;
			
			$ActionLogModel->Add( $datas );
	
			// 配货
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
		
			$data_new = array();
			$data_new['lock_call_time'] = time();
			$CenterOrderModel->Update( $orderId, $data_new );
		}
		
		
	}


}
?>