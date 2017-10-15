<?php
/*
@@acc_freet
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterChannelParentModel = Core::ImportModel( 'CenterChannelParent' );
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );

Core::LoadDom( 'CenterSku' );

Core::LoadFunction( 'ImportOrder.inc.php' );

$savePath = Core::GetConfig( 'file_upload_tmp_path' );
$fileName = $_GET['file'];
$saveFile = $savePath . $fileName  . ".tmp";

if ( !file_exists( $saveFile ) )
{
	Alert( '没有找到待导入文件' );
}

if ( $_GET['channel_parent_id'] == 1 )
	$orderDataList = ImportZhongXin( $saveFile );
elseif ( $_GET['channel_parent_id'] == 2 )
	$orderDataList = ImportYinLian( $saveFile );
elseif ( $_GET['channel_parent_id'] == 3 )
	$orderDataList = ImportGuangDa( $saveFile );
elseif ( $_GET['channel_parent_id'] == 4 )
	$orderDataList = ImportMinSheng( $saveFile );
elseif ( $_GET['channel_parent_id'] == 5 )
	$orderDataList = ImportHuaXia( $saveFile );
elseif ( $_GET['channel_parent_id'] == 7 )
	$orderDataList = ImportYouChu( $saveFile );
elseif ( $_GET['channel_parent_id'] == 9 )
	$orderDataList = ImportSina( $saveFile );
elseif ( $_GET['channel_parent_id'] == 10 )
	$orderDataList = ImportJianShe( $saveFile );
elseif ( $_GET['channel_parent_id'] == 11 )
	$orderDataList = ImportJiaoTong( $saveFile );
elseif ( $_GET['channel_parent_id'] == 12 )
	$orderDataList = ImportGuangFa( $saveFile );
elseif ( $_GET['channel_parent_id'] == 13 )
	$orderDataList = ImportRongEGou( $saveFile );
elseif ( $_GET['channel_parent_id'] == 14 )
	$orderDataList = ImportTongLian( $saveFile );
elseif ( $_GET['channel_parent_id'] == 15 )
	$orderDataList = ImportYiLiWang( $saveFile );
elseif ( $_GET['channel_parent_id'] == 16 )
	$orderDataList = ImportNongShang( $saveFile );
elseif ( $_GET['channel_parent_id'] == 17 )
	$orderDataList = ImportLeYiTong( $saveFile );
elseif ( $_GET['channel_parent_id'] == 18 )
	$orderDataList = ImportPingAn( $saveFile );
elseif ( $_GET['channel_parent_id'] == 19 )
	$orderDataList = ImportYouLe( $saveFile );
elseif ( $_GET['channel_parent_id'] == 20 )
	$orderDataList = ImportYouChu( $saveFile ); 
elseif ( $_GET['channel_parent_id'] == 21 )
		$orderDataList = ImportSanWeiDu( $saveFile );
elseif ( $_GET['channel_parent_id'] == 22 )
		$orderDataList = ImportJianSheSR( $saveFile );
elseif ( $_GET['channel_parent_id'] == 23 )
		$orderDataList = ImportHJY( $saveFile );
elseif ( $_GET['channel_parent_id'] == 24 )
		$orderDataList = ImportEzhongxin( $saveFile );
elseif ( $_GET['channel_parent_id'] == 25 )
		$orderDataList = ImportBJjifen( $saveFile );
elseif ( $_GET['channel_parent_id'] == 26 )
		$orderDataList = ImportZiHeXin( $saveFile );
elseif ( $_GET['channel_parent_id'] == 27 )
		$orderDataList = ImportGongHangJiCai( $saveFile );
elseif ( $_GET['channel_parent_id'] == 28 )
		$orderDataList = ImportNeiGouWang( $saveFile );
elseif ( $_GET['channel_parent_id'] == 29 )
		$orderDataList = ImportMinShengFL( $saveFile );
elseif ( $_GET['channel_parent_id'] == 30 )
		$orderDataList = ImportCMG( $saveFile );
elseif ( $_GET['channel_parent_id'] == 31 )
		$orderDataList = ImportZhaoShang( $saveFile );
elseif ( $_GET['channel_parent_id'] == 32 )
		$orderDataList = ImportMinShengSHQ( $saveFile );
elseif ( $_GET['channel_parent_id'] == 33 )
		$orderDataList = ImportGuangDaApp( $saveFile );
elseif ( $_GET['channel_parent_id'] == 34 )
		$orderDataList = ImportYiYuanTong( $saveFile );
elseif ( $_GET['channel_parent_id'] == 35 )
		$orderDataList = ImportGuangFaFL( $saveFile );
elseif ( $_GET['channel_parent_id'] == 36 )
		$orderDataList = ImportQiLinBLJC( $saveFile );
elseif ( $_GET['channel_parent_id'] == 37 )
		$orderDataList = ImportZhenPinWang( $saveFile );
elseif ( $_GET['channel_parent_id'] == 38 )
		$orderDataList = ImportFuKaSC( $saveFile );
else
	Alert( '没有此导入类型B' );

// check
foreach ( $orderDataList as $key => $val )
{
	//$channelId = $val['data']['channel_id'];

	if ( !$val['data']['target_id'] )
		continue;

	//$collateInfo = $ProductCollateModel->GetUnique( $val['product_data']['target_id'] );
	$collateInfo = $ProductCollateModel->GetUnique( $val['product_data']['target_id'],$val['data']['ppIDS'] );

	if ( !$collateInfo )
		continue;

	$CenterSkuDom = new CenterSkuDom( $collateInfo['sku'] );
	$skuInfo = $CenterSkuDom->InitProduct();
	$orderDataList[$key]['product_data']['sku'] = $collateInfo['sku'];
	$orderDataList[$key]['product_data']['sku_id'] = $collateInfo['sku_id'];
	$orderDataList[$key]['product_data']['product_id'] = $collateInfo['product_id'];

	if ( !$val['product_data']['price'] )
		continue;
	
	$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );
	if($priceInfo['price'] != $val['product_data']['sale_price'])
		continue;

	// 渠道编号
	$orderDataList[$key]['data']['channel_id'] = $collateInfo['channel_id'];
}

$CenterOrderModel->Model->DB->Begin();

Core::LoadDom( 'CenterOrder' );
Core::LoadDom( 'CenterSku' );

$importTimer = 0;
$skipTimer = 0;

$waitLockProductSkuList = array();

foreach ( $orderDataList as $val )
{

	if ( !$val['data']['target_id'] )
	  {
		$skipTimer++;
		continue;
	  }

	$collateInfo = $ProductCollateModel->GetUnique( $val['product_data']['target_id'],$val['data']['ppIDS'] );

	if ( !$collateInfo )
	  {
		$skipTimer++;
		continue;
	  }


	if ( !$val['product_data']['price'] )
	  {
		$skipTimer++;
		continue;
	  }

	$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );
	if($priceInfo['price'] != $val['product_data']['sale_price'])
	  {
		$skipTimer++;
		continue;
	  }




	$data = $val['data'];
	$data['add_time'] = time();
	$data['lock_call_time'] = time();
	$data['import_type'] = 1;
	$data['order_invoice'] = 0;

    if ( $CenterOrderModel->GetUnique( $data['channel_id'], $data['target_id'] ) )
	{
		$skipTimer++;
		continue;
	}

	$Product_infos = $CenterProductModel->Get( $val['product_data']['product_id'] );  
	$supplier_id = $Product_infos['supplier_now'];

	$orderId = $CenterOrderModel->Add( $data );

	$data = $val['product_data'];
	$data['order_id'] = $orderId;
	$data['add_time'] = time();
	$data['supplier_id'] = $supplier_id;

	$CenterOrderModel->AddProduct( $data );

	$waitLockOrderIdList[$orderId] = 1;

	// 增加赠品
	//$collateInfo = $ProductCollateModel->GetUnique( $val['product_data']['target_id'],$data['channel_id'] );

	for ( $i = 1; $i < 6; $i++ )
	{
		if ( $i != 1 )
			$ext = $i;
		else
			$ext = '';

		if ( $collateInfo['gift_sku_id' . $ext] )
		{
			$gifSku = $collateInfo['gift_sku' . $ext];

			$GiftSkuDom = new CenterSkuDom( $gifSku );
			$giftSkuInfo = $GiftSkuDom->InitProduct();
			$giftSkuId = $GiftSkuDom->id;
			
			if ( $giftSkuId )
			{
				$data = array();
				$data['order_id'] = $orderId;
				$data['sku'] = $gifSku;
				$data['sku_id'] = $giftSkuId;
				$data['product_id'] = $giftSkuInfo['product']['id'];
				$data['quantity'] = $val['product_data']['quantity'];
				$data['price'] = 0;
				$data['manager_user_id'] = $giftSkuInfo['product']['manager_user_id'];
				$data['manager_user_name'] = $giftSkuInfo['product']['manager_user_name'];
				$data['manager_user_real_name'] = $giftSkuInfo['product']['manager_user_real_name'];

				$CenterOrderModel->AddProduct( $data );
			}
		}
	}

	// 更新订单状态和统计
	$OrderDom = new CenterOrderDom( $orderId );
	$OrderDom->UpdateStatus();
	$CenterOrderModel->StatTotal( $orderId );

	$importTimer++;
}

$CenterOrderModel->Model->DB->Commit();


if(count($waitLockOrderIdList)>0){
// 配货
Core::LoadDom( 'CenterWarehousePlace' );

foreach ( $waitLockOrderIdList as $wlOrderId => $_val )
{
	$productList = $CenterOrderModel->GetProductList( $wlOrderId );

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

	// 采购确认
	$orderInfo = $CenterOrderModel->Get( $wlOrderId );
	
	// 全部配货的订单 自动商务确定
	if ( $orderInfo['lock_status'] == 2 )
	{
		$data = array();
		$data['purchase_check'] = 1;
		$data['purchase_check_time'] = time();

		$CenterOrderModel->Model->DB->Begin();
		$CenterOrderModel->Update( $wlOrderId, $data );
		$CenterOrderModel->Model->DB->Commit();
	}
}
}

if($__UserAuth['user_group']==17)
Common::Loading( '?mod=order.list_all', "导入{$importTimer}个订单,跳过{$skipTimer}个订单(已经存在)" );
else
Common::Loading( '?mod=order.list', "导入{$importTimer}个订单,跳过{$skipTimer}个订单(已经存在)" );
?>