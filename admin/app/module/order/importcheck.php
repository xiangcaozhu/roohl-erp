<?php
/*
@@acc_title="导入订单 check"
*/

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterChannelParentModel = Core::ImportModel( 'CenterChannelParent' );
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );

//$aaa = $CenterOrderModel->AA0805();


Core::LoadDom( 'CenterSku' );

Core::LoadFunction( 'ImportOrder.inc.php' );

$tpl['channel_parent_list'] = $CenterChannelParentModel->GetList();

if ( !$_POST )
{
	$tpl['check'] = true;
	Common::PageOut( 'order/import.html', $tpl );
}
else
{	
	if ( !$_FILES['file']['tmp_name'] )
		return false;

	$savePath = Core::GetConfig( 'file_upload_tmp_path' );
	$fileName = md5( GetRand( 32 ) );
	$saveFile = $savePath . $fileName  . ".tmp";

	if ( !@move_uploaded_file( $_FILES['file']['tmp_name'], $saveFile ) )
	{
		Alert( '上传文件失败' );
	}

	if ( $_POST['channel_parent_id'] == 1 )
		$orderDataList = ImportZhongXin( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 2 )
		$orderDataList = ImportYinLian( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 4 )
		$orderDataList = ImportMinSheng( $saveFile );
/*
	elseif ( $_POST['channel_parent_id'] == 3 )
		$orderDataList = ImportGuangDa( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 5 )
		$orderDataList = ImportHuaXia( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 7 )
		$orderDataList = ImportYouChu( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 9 )
		$orderDataList = ImportSina( $saveFile );
*/
	elseif ( $_POST['channel_parent_id'] == 10 )
		$orderDataList = ImportJianShe( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 11 )
		$orderDataList = ImportJiaoTong( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 12 )
		$orderDataList = ImportGuangFa( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 13 )
		$orderDataList = ImportRongEGou( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 14 )
		$orderDataList = ImportTongLian( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 15 )
		$orderDataList = ImportYiLiWang( $saveFile );
    elseif ( $_POST['channel_parent_id'] == 16 )
	    $orderDataList = ImportNongShang( $saveFile );
    elseif ( $_POST['channel_parent_id'] == 17 )
	    $orderDataList = ImportLeYiTong( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 18 )
		$orderDataList = ImportPingAn( $saveFile );
    elseif ( $_POST['channel_parent_id'] == 19 )
	$orderDataList = ImportYouLe( $saveFile );
    elseif ( $_POST['channel_parent_id'] == 20 )
	$orderDataList = ImportYouChu( $saveFile ); 
	elseif ( $_POST['channel_parent_id'] == 21 )
		$orderDataList = ImportSanWeiDu( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 22 )
		$orderDataList = ImportJianSheSR( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 23 )
		$orderDataList = ImportHJY( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 24 )
		$orderDataList = ImportEzhongxin( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 25 )
		$orderDataList = ImportBJjifen( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 26 )
		$orderDataList = ImportZiHeXin( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 27 )
		$orderDataList = ImportGongHangJiCai( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 28 )
		$orderDataList = ImportNeiGouWang( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 29 )
		$orderDataList = ImportMinShengFL( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 30 )
		$orderDataList = ImportCMG( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 31 )
		$orderDataList = ImportZhaoShang( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 32 )
		$orderDataList = ImportMinShengSHQ( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 33 )
		$orderDataList = ImportGuangDaApp( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 34 )
		$orderDataList = ImportYiYuanTong( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 35 )
		$orderDataList = ImportGuangFaFL( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 36 )
		$orderDataList = ImportQiLinBLJC( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 37 )
		$orderDataList = ImportZhenPinWang( $saveFile );
	elseif ( $_POST['channel_parent_id'] == 38 )
		$orderDataList = ImportFuKaSC( $saveFile );
	else
		Alert( '没有此导入类型A' );

	$list = array();
	foreach ( $orderDataList as $key => $val )
	{
		$collateInfo = $ProductCollateModel->GetUnique( $val['product_data']['target_id'],$val['data']['ppIDS'] );
		//$collateInfo = $val['collateInfo'];

		if ( !$collateInfo )
			$orderDataList[$key]['error'] = true;
		else
			$orderDataList[$key]['error'] = false;

		$channelId = $collateInfo['channel_id'];

		if ( $collateInfo )
		{
			$CenterSkuDom = new CenterSkuDom( $collateInfo['sku'] );
			$skuInfo = $CenterSkuDom->InitProduct();

			$orderDataList[$key]['sku_info'] = $skuInfo;
		}

//echo $CenterOrderModel->GetUnique( $channelId, $val['data']['target_id'] ) . 'kkk';
//echo $val['data']['target_id'].'='.$val['product_data']['target_id'].'<br>';
		if ( $CenterOrderModel->GetUnique( $channelId, $val['data']['target_id'] ) )
		{
			$orderDataList[$key]['exists'] = true;
		}
	}

	$tpl['list'] = $orderDataList;
	$tpl['file_name'] = $fileName;

	Common::PageOut( 'order/import/check.html', $tpl );
}

?>