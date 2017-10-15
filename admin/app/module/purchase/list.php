<?php
/*
@@acc_title="常规库房采购单列表 list"
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

$supplierList = $CenterSupplierModel->GetList();
$warehouseList = $CenterWarehouseModel->GetList(0,0,1);
$purchaseTypeList = Core::GetConfig( 'purchase_type' );
$purchaseStatusList = Core::GetConfig( 'purchase_status' );
$purchaseReceiveStatusList = Core::GetConfig( 'purchase_receive_status' );
$purchaseProductTypeList = Core::GetConfig( 'purchase_product_type' );
$purchasePaymentTypeList = Core::GetConfig( 'purchase_payment_type' );

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

if ( $_GET['excel'] )
{
	$offset = 0;
	$onePage = 0;
}


/*
$search = array(
	'warehouse_id' => $_GET['warehouse_id'],
	'id' => $_GET['id'],
	'supplier_id' => $_GET['supplier_id'],
);
*/
global $__UserAuth;

$search = array(
	'status' =>5,
	$search['warehouse_id'] = 0,
	//'pay_status' => 1,
);

if($_GET['warehouse_id'])
     $search['warehouse_id']=$_GET['warehouse_id'];

if($_GET['id'])
     $search['id']=$_GET['id'];

if($_GET['supplier_id'])
     $search['supplier_id']=$_GET['supplier_id'];

if($_GET['type'])
     $search['type']=$_GET['type'];


if($_GET['begin_date'])
     $search['begin_time']=$_GET['begin_date'] ? strtotime( $_GET['begin_date'] . ' 00:00:00' ) : false;

if($_GET['end_date'])
     $search['end_time']=$_GET['end_date'] ? strtotime( $_GET['end_date'] . ' 23:59:59' ) : false;





switch ( $__UserAuth['user_group'] )
		{
			case 12:
			   $search['user_id']=$__UserAuth['user_id'];
			break;
			case 13:
			    $search['sign_top_jl']=$__UserAuth['user_id'];
			break;
			case 14:
			   $search['sign_top_zj']=$__UserAuth['user_id'];
			break;
			case 15:
			break;
			case 38:
			break;
			default:
			    $search['user_id']=-1;
			break;
}



$list = $CenterPurchaseModel->GetList(  $search, $offset, $onePage );
$total = $CenterPurchaseModel->GetTotal( $search );






//$list = $CenterPurchaseModel->GetList( array( 'id' => $_GET['id'], 'supplier_id' => $_GET['supplier_id'] ) );

Core::LoadClass( 'WorkFlow' );
$WorkFlow = new WorkFlow( 'Purchase' );

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['supplier_name'] = $supplierList[$val['supplier_id']]['name'];
	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];
	$list[$key]['type_name'] = $purchaseTypeList[$val['type']];
	$list[$key]['status_name'] = $purchaseStatusList[$val['status']];
	$list[$key]['receive_status_name'] = $purchaseReceiveStatusList[$val['receive_status']];
	$list[$key]['product_type_name'] = $purchaseProductTypeList[$val['product_type']];
	$list[$key]['payment_type_name'] = $purchasePaymentTypeList[$val['payment_type']];
	
	
	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $val['user_id'] );
	$list[$key]['user_name_zh'] = $AdminArray['user_real_name'] ;
	

	$WorkFlow->SetInfo( $val );
	$list[$key]['workflow_status_name'] = $WorkFlow->GetStatus();
	$list[$key]['workflow_allow_do'] = $WorkFlow->AllowDo();
}

if ( $_GET['excel'] )
{
	$excelList = array();

	foreach ( $list as $val )
	{
		$purchaseProductList = $CenterPurchaseModel->GetProductList( $val['id'] );
		$purchaseProductList = $CenterPurchaseExtra->ExplainProduct( $purchaseProductList );

		foreach ( $purchaseProductList as $v )
		{
			$excelList[] = array(
				'id' => $val['id'],	
				'add_time' => $val['add_time'],	
				'supplier_name' => $val['supplier_name'],	
				'type_name' => $val['type_name'],	
				'status_name' => $val['status_name'],	
				'product_type_name' => $val['product_type_name'],	
				'payment_type_name' => $val['payment_type_name'],	
				'comment' => $val['comment'],	
				'product_name' => $v['sku_info']['product']['name'],	
				'attribute' => $v['sku_info']['attribute'],	
				'quantity' => $v['quantity'],	
				'price' => $v['price'],	
				'history_price' => $v['history_price'],	
				'row_comment' => $v['comment'],	
			);
		}
	}

	$header = array(
		'采购单号' => 'id',
		'采购时间' => 'add_time',
		'供应商' => 'supplier_name',
		'采购类型' => 'type_name',
		'状态' => 'status_name',
		'产品类型' => 'product_type_name',
		'支付类型' => 'payment_type_name',
		'备注' => 'comment',
		'产品名称' => 'product_name',
		'属性' => 'attribute',
		'采购数量' => 'quantity',
		'采购价格' => 'price',
		'历史采购价' => 'history_price',
		'备注' => 'row_comment',
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

$tpl['warehouse_list'] = $warehouseList;
//$tpl['supplier_list'] = $supplierList;

$tpl['list'] = $list;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );


Common::PageOut( 'purchase/list.html', $tpl );

?>