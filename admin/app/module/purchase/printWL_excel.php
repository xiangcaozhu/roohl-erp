<?php
/*
@@acc_free
*/


$ActionLogModel = Core::ImportModel( 'ActionLog' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$purchaseId = (int)$_GET['id'];
$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

Core::LoadDom( 'CenterSku' );










if ( !$purchaseInfo )
	Alert( '没有找到采购单' );



$supplierInfo = $CenterSupplierModel->Get( $purchaseInfo['supplier_id'] );
$purchaseInfo['supplier_name'] = $supplierInfo['name'];


$orderList = $CenterPurchaseModel->GetOrderListByPurchase_1( $purchaseId );

foreach ( $orderList as $key => $val )
{
	$orderList[$key]['info'] = $CenterOrderModel->Get( $val['order_id'] );
	
	$channelInfo = $CenterChannelModel->Get( $orderList[$key]['info']['channel_id'] );
	$orderList[$key]['info']['channel_name'] = $channelInfo['name'] ;

	$orderProductInfo = $CenterOrderModel->GetProductList( $val['order_id'] );
	foreach ( $orderProductInfo as $key_a => $val_a )
	{
	$CenterSkuDom = new CenterSkuDom( $val_a['sku'] );
	$skuInfo = $CenterSkuDom->InitProduct();
	$orderProductInfo[$key_a]['sku_info'] = $skuInfo;
	}
	$orderList[$key]['ProductInfo'] = $orderProductInfo;
	
	
	$orderList[$key]['serviceCheckList'] = $ActionLogModel->GetList( $val['order_id'], 'order_check_service' );
}
//$purchaseInfo['supplier_account_bank'] = $supplierInfo['accountbank'];
//$purchaseInfo['supplier_account_number'] = $supplierInfo['account_number'];



//$WorkFlow->SetInfo( $purchaseInfo );
//$purchaseInfo['workflow_status_name'] = $WorkFlow->GetStatus();
//$purchaseInfo['workflow_allow_do'] = $WorkFlow->AllowDo();


//$orderInfo = $CenterOrderModel->Get( $purchaseInfo['supplier_id'] );


/*

$AdminModel = Core::ImportModel( 'Admin' );

if ( $purchaseInfo['user_id'] )
{
	$adminInfo = $AdminModel->GetAdministrator( $purchaseInfo['user_id'] );
	$purchaseInfo['user_name'] = $adminInfo['user_real_name'];
}


$tpl['list'] = $orderList;
$tpl['info'] = $purchaseInfo;
*/


global $__Config;
     $tpl['company_name'] = $__Config['company_name'];





$d=0;
foreach ( $orderList as $key_a => $val_a )
{
	
	$orderComment = '';
	foreach ( $val_a['serviceCheckList'] as $key_b => $val_b )
	{
	$orderComment .= $val_b['comment'].' / ';
	}

	
	
	
	
	
	foreach ( $val_a['ProductInfo'] as $key => $val )
	{
	$d++;
	$excelList_one = array(
        'list_id' => $d,
		'purchaseId' => $purchaseInfo['id'],
        'orderId' => $val_a['info']['id'],
        'channelName' => $val_a['info']['channel_name'],
		'orderTime' => DateFormat($val_a['info']['order_time']),	
        'order_shipping_name' => $val_a['info']['order_shipping_name'],
        'order_shipping_dh' => $val_a['info']['order_shipping_mobile'].' / '.$val_a['info']['order_shipping_phone'],
        'order_shipping_address' => $val_a['info']['order_shipping_address'],
        'order_shipping_zip' => $val_a['info']['order_shipping_zip'],
		'product_id' => $val['product_id'],
		'product_name' => $val['sku_info']['product']['name'],
		'product_attribute' => $val['sku_info']['attribute'],
		'product_quantity' => $val['quantity'],
		'product_price' => FormatMoney($val['price']),
		'order_comment' => $orderComment,
		'order_wl' => '',
		'order_dh' => '',
    );
	$excelList[] = $excelList_one ;
	}




}

	$header = array(
		'序号' => 'list_id',
		'采购单号' => 'purchaseId',
		'订单号' => 'orderId',
		'销售渠道' => 'channelName',
		'下单日期' => 'orderTime',
		'收货人' => 'order_shipping_name',
		'电话' => 'order_shipping_dh',
		'地址' => 'order_shipping_address',
		'邮编' => 'order_shipping_zip',
		'商品ID' => 'product_id',
		'商品名称' => 'product_name',
		'销售属性' => 'product_attribute',
		'数量' => 'product_quantity',
		'零售价' => 'product_price',
		'客服备注' => 'order_comment',
		'物流公司' => 'order_wl',
		'物流单号' => 'order_dh',
	);



	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=\"" . $_GET['id']."_" .$_GET['name']."_" .DateFormat(time(), 'Y-m-d') . ".xls\"");
	header("Content-Transfer-Encoding:binary");
	echo ExcelXml( $header, $excelList, 'orderId', array( 'list_id','purchaseId','orderId', 'channelName', 'orderTime', 'order_shipping_name', 'order_shipping_dh', 'order_shipping_address', 'order_shipping_zip', 'order_comment', 'order_wl', 'order_dh') );
	//echo ExcelXml( $header, $excelList);
	exit;


?>