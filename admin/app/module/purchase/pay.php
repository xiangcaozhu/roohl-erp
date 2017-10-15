<?php
/*
@@acc_title="财务采购付款 pay"
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

$supplierList = $CenterSupplierModel->GetList();
$warehouseList = $CenterWarehouseModel->GetList();
$purchaseTypeList = Core::GetConfig( 'purchase_type' );
$purchaseStatusList = Core::GetConfig( 'purchase_status' );
$purchaseReceiveStatusList = Core::GetConfig( 'purchase_receive_status' );
$purchaseProductTypeList = Core::GetConfig( 'purchase_product_type' );
$purchasePaymentTypeList = Core::GetConfig( 'purchase_payment_type' );
$purchasePayStatusList = Core::GetConfig( 'purchase_pay_status' );

if ( $_GET['excel'] )
{
	$offset = 0;
	$onePage = 0;
}

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$search = array(
	'id' => $_GET['id'],
	'status' => 3,
	'supplier_id' => $_GET['supplier_id'],
	//'pay_status' => $_GET['pay_status'],
	'pay_status' => 0,
	'pay_invoice' => $_GET['pay_invoice'],
);


$list = $CenterPurchaseModel->GetList(  $search, $offset, $onePage );
$total = $CenterPurchaseModel->GetTotal( $search );

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = date('Y-m-d', $val['add_time'] ) . '<br>' . date('G:i:s', $val['add_time'] );
	$list[$key]['supplier_name'] = $supplierList[$val['supplier_id']]['name'];
	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];
	$list[$key]['type_name'] = $purchaseTypeList[$val['type']];
	$list[$key]['status_name'] = $purchaseStatusList[$val['status']];
	$list[$key]['receive_status_name'] = $purchaseReceiveStatusList[$val['receive_status']];
	$list[$key]['product_type_name'] = $purchaseProductTypeList[$val['product_type']];
	$list[$key]['payment_type_name'] = $purchasePaymentTypeList[$val['payment_type']];
	$list[$key]['pay_status_name'] = $purchasePayStatusList[$val['pay_status']];
	
	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $val['user_id'] );
	$list[$key]['user_name_zh'] = $AdminArray['user_real_name'] ;

}

if ( $_GET['excel'] )
{
	$excelList = $list;

	foreach ( $excelList as $key => $val )
	{
		$excelList[$key]['pay_invoice'] = $val['pay_invoice'] == 1 ? '有发票' : '无发票';
		$excelList[$key]['pay_status'] = $val['pay_status'] == 1 ? '已付款' : '未付款';
		$excelList[$key]['pay_time'] = DateFormat( $val['pay_time'] );
		$excelList[$key]['pay_invoice_time'] = DateFormat( $val['pay_invoice_time'] );
		$excelList[$key]['receive_status_name'] = strip_tags( $val['receive_status_name'] );
	}

	$header = array(
		'采购单号' => 'id',
		'采购时间' => 'add_time',
		'供应商' => 'supplier_name',
		'采购类型' => 'type_name',
		'状态' => 'status_name',
		'收货状态' => 'receive_status_name',
		'类型' => 'product_type_name',
		'是否付款' => 'pay_status',
		'付款时间' => 'pay_time',
		'发票' => 'pay_invoice',
		'发票时间' => 'pay_invoice_time',
		'总金额' => 'total_money',
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
$tpl['supplier_list'] = $supplierList;




$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );


Common::PageOut( 'purchase/pay.html', $tpl );

?>