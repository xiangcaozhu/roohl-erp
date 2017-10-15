<?php
/*
@@acc_title="添加"
*/
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );


//$colist = $ProductCollateModel->GetAAAAAA();
//$ProductCollateModel->UpAAAAAA($colist);

echo $colist;


if ( !$_POST )
{
	$channelList = $CenterChannelModel->GetList();

	$tpl['channel_list'] = $channelList;

	$priceList = array();
	$priceList[1] = array();
	$priceList[3] = array();
	$priceList[6] = array();
	$priceList[12] = array();
	$priceList[15] = array();
	$priceList[18] = array();
	$priceList[24] = array();

	$tpl['price_list'] = $priceList;
	
	
	
$tpl['payout_rate_gf'] = Core::GetConfig( 'payout_rate_gf' );
$tpl['payout_rate_jh'] = Core::GetConfig( 'payout_rate_jh' );
$tpl['payout_rate_jh1'] = Core::GetConfig( 'payout_rate_jh1' );


	Common::PageOut( 'product/collate/add.html', $tpl, $parentTpl );
}
else
{
	$channelId = $_POST['channel_id'];
	if ( !$channelId )
		exit( '渠道不能为空' );
	$channelId = (int)$channelId;

	$targetId = trim( $_POST['target_id'] );
	$sku = trim( $_POST['sku'] );
	$giftSku = trim( $_POST['gift_sku'] );
	$giftSku2 = trim( $_POST['gift_sku2'] );
	$giftSku3 = trim( $_POST['gift_sku3'] );
	$giftSku4 = trim( $_POST['gift_sku4'] );
	$giftSku5 = trim( $_POST['gift_sku5'] );

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

	if ( !$targetId )
		exit( '渠道产品ID不能为空' );
	if ( !$skuId )
		exit( 'SKU错误' );
	if ( !$skuInfo['product'] )
		exit( 'SKU错误' );

	if ( $ProductCollateModel->GetUnique( $targetId,$channelId ) )
		exit( '已经存在相同的记录了' );

	$ProductCollateModel->Model->DB->Begin();
	
	$data = array();
	$data['target_id'] = $targetId;
	$data['channel_id'] = $channelId;
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
	$data['add_time'] = time();
	$data['user_id'] = $__UserAuth['id'];
	$data['comment'] = trim( $_POST['comment'] );

	$collateId = $ProductCollateModel->Add( $data );

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

	$ProductCollateModel->Model->DB->Commit();

	echo 200;
}

?>