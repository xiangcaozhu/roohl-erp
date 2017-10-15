<?php
/*
@@acc_title="编辑"
*/
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

$collateId = (int)$_GET['id'];
$collateInfo = $ProductCollateModel->Get( $collateId );

if ( !$collateInfo )
	Alert( '没有找到请求的信息' );

if ( !$_POST )
{
	$channelList = $CenterChannelModel->GetList();

	$existsPriceList = $ProductCollateModel->GetPriceList( $collateId );
	$existsPriceList = ArrayIndex( $existsPriceList, 'instalment_times' );

	$priceList = array();
	$priceList[1] = $existsPriceList[1];
	$priceList[3] = $existsPriceList[3];
	$priceList[6] = $existsPriceList[6];
	$priceList[12] = $existsPriceList[12];
	$priceList[15] = $existsPriceList[15];
	$priceList[18] = $existsPriceList[18];
	$priceList[24] = $existsPriceList[24];

	$tpl['channel_list'] = $channelList;
	$tpl['collate'] = $collateInfo;
	$tpl['price_list'] = $priceList;

	$tpl['edit'] = true;
	Common::PageOut( 'product/collate/add.html', $tpl, $parentTpl );
}
else
{
	$channelId = (int)$_POST['channel_id'];
	$targetId = trim( $_POST['target_id'] );
	$sku = trim( $_POST['sku'] );
	$giftSku = trim( $_POST['gift_sku'] );
	$giftSku2 = trim( $_POST['gift_sku2'] );
	$giftSku3 = trim( $_POST['gift_sku3'] );
	$giftSku4 = trim( $_POST['gift_sku4'] );
	$giftSku5 = trim( $_POST['gift_sku5'] );
	$bank_link = $_POST['bank_link'];
	$bank_name = $_POST['bank_name'];
	

	Core::LoadDom( 'CenterSku' );
	$CenterSkuDom = new CenterSkuDom( $sku );
	$skuInfo = $CenterSkuDom->InitProduct();
	$skuId = $CenterSkuDom->id;

	if ( $giftSku )
	{
		$GiftSkuDom = new CenterSkuDom( $giftSku );
		$giftSkuInfo = $GiftSkuDom->InitProduct();
		$giftSkuId = $GiftSkuDom->id;

		if ( !$giftSkuId )
			exit( '赠品SKU错误' );
	}

	if ( $giftSku2 )
	{
		$GiftSkuDom = new CenterSkuDom( $giftSku2 );
		$giftSkuInfo2 = $GiftSkuDom->InitProduct();
		$giftSkuId2 = $GiftSkuDom->id;

		if ( !$giftSkuId2 )
			exit( '赠品2 SKU错误' );
	}

	if ( $giftSku3 )
	{
		$GiftSkuDom = new CenterSkuDom( $giftSku3 );
		$giftSkuInfo3 = $GiftSkuDom->InitProduct();
		$giftSkuId3 = $GiftSkuDom->id;

		if ( !$giftSkuId3 )
			exit( '赠品3 SKU错误' );
	}

	if ( $giftSku4 )
	{
		$GiftSkuDom = new CenterSkuDom( $giftSku4 );
		$giftSkuInfo4 = $GiftSkuDom->InitProduct();
		$giftSkuId4 = $GiftSkuDom->id;

		if ( !$giftSkuId4 )
			exit( '赠品4 SKU错误' );
	}

	if ( $giftSku5 )
	{
		$GiftSkuDom = new CenterSkuDom( $giftSku5 );
		$giftSkuInfo5 = $GiftSkuDom->InitProduct();
		$giftSkuId5 = $GiftSkuDom->id;

		if ( !$giftSkuId5 )
			exit( '赠品5 SKU错误' );
	}

	if ( !$skuId )
		exit( 'SKU错误' );
	if ( !$skuInfo['product'] )
		exit( 'SKU错误' );

	if ( $channelId != $collateInfo['channel_id'] || $targetId != $collateInfo['target_id'] )
	{
		if ( $ProductCollateModel->GetUnique( $targetId,$channelId ) )
			exit( '已经存在相同的记录了' );
	}

	$data = array();
	$data['target_id'] = $targetId;
	$data['channel_id'] = $channelId;
	$data['bank_link'] = $bank_link;
	$data['bank_name'] = $bank_name;
	$data['sku'] = $sku;
	$data['sku_id'] = $skuId;

	$data['gift_sku'] = $giftSku;
	$data['gift_sku_id'] = $giftSkuId;
	$data['gift_sku2'] = $giftSku2;
	$data['gift_sku_id2'] = $giftSkuId2;
	$data['gift_sku3'] = $giftSku3;
	$data['gift_sku_id3'] = $giftSkuId3;
	$data['gift_sku4'] = $giftSku4;
	$data['gift_sku_id4'] = $giftSkuId4;
	$data['gift_sku5'] = $giftSku5;
	$data['gift_sku_id5'] = $giftSkuId5;

	$data['product_id'] = $skuInfo['product']['id'];
	$data['comment'] = trim( $_POST['comment'] );

	$ProductCollateModel->Update( $collateId, $data );

	if ( is_array( $_POST['price'] ) )
	{
		foreach ( $_POST['price'] as $key => $val )
		{
			$data = array();
			$data['collate_id'] = $collateId;
			$data['price'] = $_POST['price'][$key];
			$data['instalment_times'] = $key;
			$data['instalment_price'] = $_POST['instalment_price'][$key];
			$data['payout_rate'] = $_POST['payout_rate'][$key];
			$data['invoice'] = $_POST['invoice'][$key];
			$data['comment'] = trim( $_POST['row_comment'][$key] );
			$data['add_time'] = time();

			$existsPriceInfo = $ProductCollateModel->GetPrice( $collateId, $key );

			if ( !$existsPriceInfo )
			{
				$ProductCollateModel->AddPrice( $data );
			}
			else
			{
				$ProductCollateModel->UpdatePrice( $existsPriceInfo['id'], $data );
			}
		}
	}

	echo 200;
}

?>