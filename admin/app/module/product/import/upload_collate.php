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

$collateList = ImportCollate( $saveFile );

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
	if ( !$sku )
		$ThisMy=1;//exit( 'SKU错误' );
	
	$AllMoney = $val['AllMoney'];
	if ( !$AllMoney )
		$ThisMy=1;//exit( '价格错误' );

	if ( $ProductCollateModel->GetUnique( $targetId ) )
		$ThisMy=1;//exit( '已经存在相同的记录了' );
	
	if ( $ThisMy>0 )
	{
		$skipCounter++;
		continue;
	}

	
	$data = array();
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

	$collateId = $ProductCollateModel->Add( $data );

/*
		switch($channelId)
			{
				case 68:
					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 1;
					if($val['Type']==2)
					$data['payout_rate'] = 0.05;
					else
					$data['payout_rate'] = 0.05;
					
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 3;
					if($val['Type']==2)
					$data['payout_rate'] = 0.04;
					else
					$data['payout_rate'] = 0.03;
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 6;
					if($val['Type']==2)
					$data['payout_rate'] = 0.05;
					else
					$data['payout_rate'] = 0.04;
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 12;
					if($val['Type']==2)
					$data['payout_rate'] = 0.07;
					else
					$data['payout_rate'] = 0.05;
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 15;
					if($val['Type']==2)
					$data['payout_rate'] = 0.00;
					else
					$data['payout_rate'] = 0.00;
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 18;
					if($val['Type']==2)
					$data['payout_rate'] = 0.00;
					else
					$data['payout_rate'] = 0.00;
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 24;
					if($val['Type']==2)
					$data['payout_rate'] = 0.00;
					else
					$data['payout_rate'] = 0.00;
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );
				break;
				case 60:
					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 1;
					if($val['Type']==2)
					$data['payout_rate'] = 0.02;
					else
					$data['payout_rate'] = 0.02;
					
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 3;
					if($val['Type']==2)
					$data['payout_rate'] = 0.04;
					else
					$data['payout_rate'] = 0.03;
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 6;
					if($val['Type']==2)
					$data['payout_rate'] = 0.06;
					else
					$data['payout_rate'] = 0.04;
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 12;
					if($val['Type']==2)
					$data['payout_rate'] = 0.08;
					else
					$data['payout_rate'] = 0.05;
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 15;
					if($val['Type']==2)
					$data['payout_rate'] = 0.00;
					else
					$data['payout_rate'] = 0.00;
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 18;
					if($val['Type']==2)
					$data['payout_rate'] = 0.10;
					else
					$data['payout_rate'] = 0.08;
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 24;
					if($val['Type']==2)
					$data['payout_rate'] = 0.12;
					else
					$data['payout_rate'] = 0.11;
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );
				break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////
				case 61:
					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 1;
					
					if($val['Type']==1){
					$data['payout_rate'] = 0.20;
					}
					if($val['Type']==2){
					$data['payout_rate'] = 0.05;
					}
					if($val['Type']==3){
					$data['payout_rate'] = 0.08;
					}
					if($val['Type']==4){
					$data['payout_rate'] = 0.10;
					}
					
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );


					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 6;
					if($val['Type']==1){
					$data['payout_rate'] = 0.23;
					}
					if($val['Type']==2){
					$data['payout_rate'] = 0.08;
					}
					if($val['Type']==3){
					$data['payout_rate'] = 0.11;
					}
					if($val['Type']==4){
					$data['payout_rate'] = 0.13;
					}
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );

					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = $AllMoney;
					$data['instalment_times'] = 12;
					if($val['Type']==1){
					$data['payout_rate'] = 0.245;
					}
					if($val['Type']==2){
					$data['payout_rate'] = 0.095;
					}
					if($val['Type']==3){
					$data['payout_rate'] = 0.125;
					}
					if($val['Type']==4){
					$data['payout_rate'] = 0.145;
					}
					
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );
				break;
				
/////////////////////////////////////////////////////////////////////////////////////////////////////
				default:
				break;
			}	
*/




					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = 1;
					$data['instalment_times'] = 1;
					$data['payout_rate'] = 0;
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );


					$data = array();
					$data['collate_id'] = $collateId;
					$data['price'] = 1;
					$data['instalment_times'] = 6;
					$data['payout_rate'] = 0;
					$data['add_time'] = time();
					$ProductCollateModel->AddPrice( $data );









$importCounter++;
}

$ProductCollateModel->Model->DB->Commit();	
	
Common::Loading( '?mod=product.import_collate', "导入{$importCounter}个对照表,跳过{$skipCounter}个产品(已经存在)" );

?>