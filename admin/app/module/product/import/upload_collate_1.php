<?php
/*
@@acc_free
*/
$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
$AdminModel = Core::ImportModel( 'Admin' );

Core::LoadFunction( 'Importcollate.inc.php' );
Core::LoadDom( 'CenterSku' );


$savePath = Core::GetConfig( 'file_upload_tmp_path' );
$fileName = $_GET['file'];
$saveFile = $savePath . $fileName  . ".tmp";

if ( !file_exists( $saveFile ) )
{
	Alert( '没有找到待导入文件' );
}

$collateList = UpCollate( $saveFile );

$importCounter = 0;
$skipCounter = 0;

$ProductCollateModel->Model->DB->Begin();


// check
foreach ( $collateList as $key => $val )
{
    $ThisMy=0;
	$channelId = $val['channel_id'];
	if ( !$channelId )
		$ThisMy=1;//exit( '渠道不能为空' );
	
	$targetId = $val['target_id'];
	if ( !$targetId )
		$ThisMy=1;//exit( '渠道产品ID不能为空' );
	
	$sku = $val['sku'];
	//if ( !$sku )
		//$ThisMy=1;//exit( 'SKU错误' );
	
	$AllMoney = $val['AllMoney'];
	if ( !$AllMoney )
		$ThisMy=1;//exit( '价格错误' );

	//if ( $ProductCollateModel->GetUnique( $targetId ) )
		//$ThisMy=1;//exit( '已经存在相同的记录了' );
	
	if ( $ThisMy>0 )
	{
		$skipCounter++;
		continue;
	}

	
	 $collateOne = $ProductCollateModel->GetUnique( $val['target_id'] );
	
	/*
	$data['channel_id'] = $channelId;
	$data['target_id'] = $targetId;
	$data['sku'] = $sku;
	$data['bank_link'] = $val['bank_link'];

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

    $CenterSkuDom = new CenterSkuDom( $sku );
	$skuInfo = $CenterSkuDom->InitProduct();
	$skuId = $CenterSkuDom->id;
	$data['sku_id'] = $skuId;
	$data['product_id'] = $skuInfo['product']['id'];
	
	$data['add_time'] = time();
	$data['user_id'] = $__UserAuth['id'];
	//$data['comment'] = trim( $_POST['comment'] );
*/
	if ($collateOne)
	{
	$data = array();
	$data['bank_name'] = $val['bank_name'];
	$data['bank_link'] = $val['bank_link'];
	$ProductCollateModel->Update( $collateOne['id'], $data );
	//$data['price'] = $val['AllMoney'];
	//$ProductCollateModel->UpAllPrice( $collateOne['id'], $data );
	
	
$importCounter++;
	}

	

}

$ProductCollateModel->Model->DB->Commit();	
	
Common::Loading( '?mod=product.up_collate', "导入{$importCounter}个对照表,跳过{$skipCounter}个产品(已经存在)" );

?>