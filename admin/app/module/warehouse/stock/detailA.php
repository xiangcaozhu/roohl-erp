<?php

include( Core::Block( 'warehouse' ) );

$WarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );
$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );


/*
$NID = (int)$_GET['NID'];
$CenterWarehouseStockModel->AAA1115($NID);
*/
/*

$a = $CenterWarehouseStockModel->BBB1115();
$b = StrVals($a,"supplier_id");

$CenterWarehouseStockModel->BBB1116($b);

TestArray($b);
*/
$list = $CenterWarehouseStockModel->CCC1115();
	$header = array(
		'商品ID' => 'product_id',
		'商品SKU' => 'sku',
		'商品SKU_ID' => 'sku_id',
		'ERP_SKU' => 'erp_sku',
		'商品名称' => 'product_name',
		'发货类型' => 'key_mode',
	);

//TestArray($list);
//	exit;
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=\"" . DateFormat(time(), 'Y-m-d_H-i-s') . ".xls\"");
	header("Content-Transfer-Encoding:binary");
	echo ExcelXml( $header,$list);

exit;



$placeId = (int)$_GET['place_id'];
$sku = trim( $_GET['sku'] );
Core::LoadDom( 'CenterSku' );

$list = $CenterWarehouseStockModel->GetList1115();

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
}

if ( $_POST['excel'] )
{
	$excelList = array();

	foreach ( $list as $val )
	{
		$excelList[] = $val;
	}

	$header = array(
		'SKU' => 'sku',
		'产品ID' => 'product_id',
		'产品名称' => 'product_name',
		'属性' => 'attribute',
		'库房名称' => 'warehouse_name',
		'货位' => 'place_name',
		'数量' => 'quantity',
		'锁定数量' => 'lock_quantity',
		'库存成本' => 'price',
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

Common::PageOut( 'warehouse/stock/detailA.html', $tpl );

?>