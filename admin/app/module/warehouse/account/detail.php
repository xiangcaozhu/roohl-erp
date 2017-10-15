<?php

include( Core::Block( 'warehouse' ) );

$WarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );

$storeTypeList = Core::GetConfig( 'store_type' );
$deliveryTypeList = Core::GetConfig( 'delivery_type' );

$placeId = (int)$_GET['place_id'];
$sku = trim( $_GET['sku'] );

Core::LoadDom( 'CenterSku' );

$list = $WarehouseLogModel->GetJournalList( array(
	'warehouse_id' => $warehouseId,
	'place_id' => $placeId,
	'category' => $_GET['category'],
	'sku' => $sku,
	'type' => $_GET['type'],
	'begin_time' => $_GET['begin_date'] ? strtotime( $_GET['begin_date'] . ' 00:00:00' ) : 0,
	'end_time' => $_GET['end_date'] ? strtotime( $_GET['end_date'] . ' 23:59:59' ) : 0,
) );

$leaveNum = 0;
foreach ( $list as $key => $val )
{
	$CenterSkuDom = new CenterSkuDom( $val['sku'] );
	$skuInfo = $CenterSkuDom->InitProduct();
	$placeInfo = $CenterWarehousePlaceModel->Get( $val['place_id'] );
		
	$list[$key]['sku_info'] = $skuInfo;
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];
	$list[$key]['place_name'] = $placeInfo['name'];
	$list[$key]['attribute'] = $skuInfo['attribute'];
	$list[$key]['product_name'] = $skuInfo['product']['name'];
	
	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $val['user_id'] );
	$list[$key]['user_name_zh'] = $AdminArray['user_real_name'] ;

	if ( $val['type'] == 1 )
	{
		$list[$key]['type2_name'] = $storeTypeList[$val['type2']];
		$leaveNum += $val['quantity'];
	}
	else
	{
		$list[$key]['type2_name'] = $deliveryTypeList[$val['type2']];
		$leaveNum -= $val['quantity'];
	}
}

if ( $_POST['excel'] )
{
	$excelList = array();

	foreach ( $list as $val )
	{
		if ( $val['type'] == 1 )
			$val['type_name'] = "入库";
		else
			$val['type_name'] = "出库";

		$excelList[] = $val;
	}

	$header = array(
		'SKU' => 'sku',
		'产品ID' => 'product_id',
		'产品名称' => 'product_name',
		'属性' => 'attribute',
		'库房名称' => 'warehouse_name',
		'货位' => 'place_name',
		'时间' => 'add_time',
		'类型' => 'type_name',
		'业务' => 'type2_name',
		'数量' => 'quantity',
		'价格' => 'price',
	);


	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=\"" . DateFormat( time(), 'Y-m-d_H-i-s' ) . ".xls\"");
	header("Content-Transfer-Encoding:binary");
	echo ExcelXml( $header, $excelList, 'id', array( 'id', 'add_time', 'supplier_name', 'type_name', 'status_name', 'product_type_name', 'payment_type_name', 'comment' ) );
	exit;
}

$tpl['list'] = $list;
$tpl['leave'] = $leaveNum;

Common::PageOut( 'warehouse/account/detail.html', $tpl );

?>