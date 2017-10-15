<?php

/*
@@acc_title="★代发货→采购单列表 listreceive_h"
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );



$supplierList = $CenterSupplierModel->GetList();
$warehouseList = $CenterWarehouseModel->GetList( 0, 0, 2);
$purchaseTypeList = Core::GetConfig( 'purchase_type' );
$purchaseStatusList = Core::GetConfig( 'purchase_status' );
$purchaseReceiveStatusList = Core::GetConfig( 'purchase_receive_status_a' );
$purchaseProductTypeList = Core::GetConfig( 'purchase_product_type' );
$purchasePaymentTypeList = Core::GetConfig( 'purchase_payment_type' );



if ( $_GET['excel']>0 )
{
$onePage=9999;
}
else
{
if((int)$onePage<1)
    $onePage=5;
}

list( $page, $offset, $onePage ) = Common::PageArg( $onePage );

/*
$search = array();
*/

global $__UserAuth;


$tpl['U_ID'] =$__UserAuth['user_id'];

$search = array(
	'status' => (int)$_GET['status'],
	'warehouse_id' => 5,
	//'supplier_id' => $SUID,
	'receive_status' => $_GET['receive_status'],
	'begin_time' => $_GET['begin_date'] ? strtotime( $_GET['begin_date'] . ' 00:00:00' ) : false,
	'end_time' => $_GET['end_date'] ? strtotime( $_GET['end_date'] . ' 23:59:59' ) : false,
);

$SUID = (int)$_GET['supplier_id'];
if($SUID>0){
	$search['supplier_id'] = $SUID;
}

if((int)$_GET['order_id']>0)
{
//$PurchaseIDList = $CenterPurchaseModel->GetPurchaseIDByOrder( (int)$_GET['order_id'] );
//$PurchaseIDList = implode(",",$PurchaseIDList);
$search['order_id'] = (int)$_GET['order_id'];
}
elseif((int)$_GET['id']>0)
{
$PurchaseID = $_GET['id'];
$search['id']=$PurchaseID;
}

/*
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
			case 16:
			break;
			case 38:
			break;
			default:
			    $search['user_id']=-1;
			break;
}
*/

$list = $CenterPurchaseModel->GetList(  $search, $offset, $onePage );
$total = $CenterPurchaseModel->GetTotal( $search );






//$list = $CenterPurchaseModel->GetList( array( 'id' => $_GET['id'], 'supplier_id' => $_GET['supplier_id'] ) );

Core::LoadClass( 'WorkFlow' );
$WorkFlow = new WorkFlow( 'Purchase' );

foreach ( $list as $key => $val )
{

$purchaseOrderList = $CenterPurchaseModel->GetOrderListByPurchase_2( $val['id'] );

$ReceiveOrderTotal = count($purchaseOrderList);
$list[$key]['ReceiveOrderTotal'] = $ReceiveOrderTotal;

$PurchaseOrderTotal = $CenterPurchaseModel->GetError_1( $val['id'] );
$list[$key]['PurchaseOrderTotal'] = $PurchaseOrderTotal;

$list[$key]['Error_This'] = "#FFFFFF";
if( $ReceiveOrderTotal != $PurchaseOrderTotal )
$list[$key]['Error_This'] = "#FF0000";




$purchaseProductList = $CenterPurchaseModel->GetProductList( $val['id'] );
$purchaseProductList = $CenterPurchaseExtra->ExplainProduct_1( $purchaseProductList );
$list[$key]['productList'] = $purchaseProductList;


$list[$key]['orderList'] = $purchaseOrderList;

	$list[$key]['add_time'] = DateFormat( $val['add_time'] ,'Y-m-d H:i' );
	$list[$key]['plan_arrive_time'] = DateFormat( $val['plan_arrive_time'] ,'Y-m-d' );
	
	$list[$key]['supplier_name'] = $supplierList[$val['supplier_id']]['name'];
	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];
	$list[$key]['type_name'] = $purchaseTypeList[$val['type']];
	$list[$key]['status_name'] = $purchaseStatusList[$val['status']];
	$list[$key]['receive_status_name'] = $purchaseReceiveStatusList[$val['receive_status']];
	$list[$key]['product_type_name'] = $purchaseProductTypeList[$val['product_type']];
	$list[$key]['payment_type_name'] = $purchasePaymentTypeList[$val['payment_type']];
	
	
	
	
	
	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $val['user_id'] );
	$list[$key]['user_name_zh'] = $AdminArray['user_real_name'] ;
	
	if( $val['user_id'] == $__UserAuth['user_id'])
	$list[$key]['user_name_zh'] =' <font color="red">'.$AdminArray['user_real_name'].'</font>';

	$WorkFlow->SetInfo( $val );
	$list[$key]['workflow_status_name'] = $WorkFlow->GetStatus();
	$list[$key]['workflow_allow_do'] = $WorkFlow->AllowDo();
}

$tpl['warehouse_list'] = $warehouseList;

//$tpl['id'] = $_POST['id'];
//$tpl['warehouse_id'] = $_GET['warehouse_id'];

//if($_POST['supplier_id'])
//   $tpl['supplier_name'] = $_POST['supplier_name'];
//else
   //$tpl['supplier_name'] = '请输入供应商名称进行查找...';

//$tpl['supplier_id'] = $_POST['supplier_id'];







if( $__UserAuth['user_group']==38 || $__UserAuth['user_group']==15 || $__UserAuth['user_group']==16 )
{
$search_a = array();
}
elseif($__UserAuth['user_group']==14)
{
$search_a = array('manage_zj' => $__UserAuth['user_id'],);
}
elseif($__UserAuth['user_group']==12)
{
$search_a = array('manage_zl' => $__UserAuth['user_id'],);
}
else
{
$search_a = array('manage_id' => $__UserAuth['user_id'],);
}

$search_a = array();
$search_a['manage_OK']=1;
$tpl['Supplier_list']  = $CenterSupplierModel->GetList( $search_a );




$tpl['list'] = $list;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );
$tpl['page_bar_a'] = Common::PageBar_a( $total, $onePage, $page );
$tpl['page_bar_b'] = Common::PageBar_b( $total, $onePage, $page );
$tpl['onePage'] = $onePage;

//$tpl['type_id'] =$_POST['type_id'];





if ( $_GET['excel']>0 )
{

///////////////////////////////
	$excelList = array();
	foreach ( $list as $val )
	{

		foreach ( $val['productList'] as $v )
		{

			foreach ( $v['relation_list'] as $vs )
			{
				$tmp['add_user'] = $val['user_name'];
				$tmp['id'] = $val['id'];
				$tmp['add_time'] = $val['add_time'];
				$tmp['supplier_name'] = $val['supplier_name'];
				
				//$tmp['product_sku'] = $v['sku'];
				//$tmp['product_cost'] = $v['help_cost'];
				$tmp['product_name'] = $v['sku_info']['product']['name'];
				$tmp['product_attribute'] = $v['sku_info']['attribute'];
				$tmp['product_quantity'] = $vs['total_quantity'];
				$tmp['product_price'] = $v['price'];
				$tmp['product_money'] = $v['price']*$vs['total_quantity'];
				
				$TTS = 0;
				if($vs['channel_id']==75 || $vs['channel_id']==73){
					if($vs['channel_id']==751){
						$TTS = FormatMoney($vs['bj_price']/$vs['total_quantity']);
					}else{
						$TTS = FormatMoney($vs['xs_price']);
					}
				}else{
					$TTS = FormatMoney($vs['xs_price']);
				}
	
				$tmp['sale_price'] = $TTS;
				$tmp['sale_money'] = $TTS*$vs['total_quantity'];
	
				$tmp['channel'] = $vs['channel_name'];
				$tmp['order_id'] = $vs['order_id'];
				//$tmp['product_payout'] = FormatMoney( $v['price'] * $v['payout_rate'] );
				//$tmp['product_pay'] = FormatMoney( $v['price'] - ( $v['price'] * $v['payout_rate'] ) );
				//$tmp['product_stock_price'] = FormatMoney( $v['stock_price'] );
	
				$excelList[] = $tmp;
			}
		}
	}


	$header = array(
		'制单人' => 'add_user',
		'采购号' => 'id',
		'下单时间' => 'add_time',
		'供货商' => 'supplier_name',
		//'商品SKU' => 'product_sku',
		'商品名称' => 'product_name',
		'销售属性' => 'product_attribute',
		'数量' => 'product_quantity',
		'采购单价' => 'product_price',
		'采购合计' => 'product_money',
		'销售单价' => 'sale_price',
		'销售合计' => 'sale_money',
		'项目' => 'channel',
		'订单号' => 'order_id',
		//'电话2' => 'order_shipping_mobile',
		//'签收时间' => 'sign_time',
	);



	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=\"" . DateFormat(time(), 'Y-m-d_H-i-s') . ".xls\"");
	header("Content-Transfer-Encoding:binary");
	echo ExcelXml( $header, $excelList );
	exit;




/////////////////////////////////////
}









































Common::PageOut( 'purchase/listreceive_h.html', $tpl );

?>