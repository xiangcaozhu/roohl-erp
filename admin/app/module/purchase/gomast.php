<?php
/*
@@acc_title="调库过账 gomast"
*/
Core::LoadDom( 'CenterSku' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
Core::LoadDom( 'CenterWarehousePlace' );
global $__UserAuth;
//ob_start();
//ob_end_flush();

$needList = $CenterOrderModel->GetNeedList_mast();
$len=count($needList);

//print_r($needList);

/*
echo "<br>订单数据读取完毕【".$len."】<br>";
flush();
sleep(1);

echo "<br>订单数据读取完毕【".$len."】<br>";
flush();
sleep(1);
echo "<br>订单数据读取完毕【".$len."】<br>";
flush();
sleep(1);
echo "<br>订单数据读取完毕【".$len."】<br>";
flush();
sleep(1);
*/
if($len>0){
///////////////////////////////////////////////////
	$data = array();
	$data['add_time'] = time();
	$data['user_id'] = $__UserAuth['user_id'];
	$data['user_name'] = $__UserAuth['user_name'];
	$data['type'] = 5;
	$data['status'] = 1;
	$data['purchase_id'] = 0;
	$data['receive_id'] = 0;
	$data['warehouse_id'] = 6;
	$data['comment'] = '积分产品调拨';
	$storeId = $CenterOrderModel->Add1008( $data );
	//////////////////////////////////////////////////////////////////
	//$CenterOrderModel->Model->DB->Begin();
	
	$skuLL = array();
     $p=0;
	 foreach ( $needList as $key => $val ){
		 $p++;
		// echo "<br>代操作读取完毕".$p;
		// flush();
		// sleep(0);
		 
		 $intoNum = (int)$val['productQuantity'];
		 $productId = (int)$val['productID'];
		 $sku = $val['productSku'];
		 $skuId = $val['skuID'];
		 $price = floatval( $val['productPrice'] );
	
		//echo $intoNum.'='.$productId.'='.$sku.'='.$skuId.'='.$price.'<br>';
		 $placeId = 4;
		 $comment = '积分产品调拨';
	 


		 $stockInfo = $CenterOrderModel->GetUnique1008( 6, 4, $skuId );

		 if ( $stockInfo )
		 {
			$price = ( $stockInfo['quantity'] * $stockInfo['price'] + $intoNum * $price ) / ( $stockInfo['quantity'] + $intoNum );
			$CenterOrderModel->UpdateUnique1008(6,4,$skuId,array( 'price' => $price ),"quantity = quantity + {$intoNum}");
		 }
		 else
		 {
	 
			$data = array();
			$data['sku'] = $sku;
			$data['sku_id'] = $skuId;
			$data['product_id'] = $productId;
			$data['quantity'] = $intoNum;
			$data['lock_quantity'] = 0;
			$data['place_id'] = 4;
			$data['no_delivery'] = 0;
			$data['price'] = $price;
			$data['warehouse_id'] = 6;

			$CenterOrderModel->AddStock1008( $data );
		 }	 

		
		
		$data = array();
		$data = array('target_id' => $storeId,'target_id2' => 0,'target_id3' => 0,'type' => 1,'type2' => 5,'product_id' => $productId,'sku' => $sku,'sku_id' => $skuId,'price' => $price,'quantity' => $intoNum,'comment' => $comment);
		$data['warehouse_id'] = 6;
		$data['place_id'] = 4;
		$data['add_time'] = time();
		$data['user_id'] = $__UserAuth['user_id'];
		$data['user_name'] = $__UserAuth['user_name'];
		$CenterOrderModel->Addppp1008( $data );
	 

		$skuLL[] =  $skuId;

	}

	if(count($skuLL)>0){
		 foreach ( $skuLL as $skuID ){
			// todo 分配到订单
	$WarehousePlaceDom = new CenterWarehousePlaceDom( 4 );
	$WarehousePlaceDom->LockFlow( $skuID );
		 
		}
	}


	$CenterOrderModel->StatTotal1008( $storeId );

/////////////////////////////////////////////////////









//$CenterOrderModel->Model->DB->Commit();



}

Alert('操作完成', '?mod=delivery.pack&warehouse_id=6');
//
//Common::Loading(, "操作完成" );


//header("Location:?mod=delivery.pack&warehouse_id=6"); 
exit;
?>