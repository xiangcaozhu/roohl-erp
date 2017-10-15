<?php
/*
@@acc_free
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$channelList = $CenterChannelModel->GetList();

$purchaseIdList = explode(',',$_GET['purchase_list_Id']) ;


$supplierInfo = $CenterSupplierModel->Get( $_GET['supplierId'] );
$purchaseInfo['supplier_name'] = $supplierInfo['name'];
$purchaseInfo['supplier_account_bank'] = $supplierInfo['accountbank'];
$purchaseInfo['supplier_account_number'] = $supplierInfo['account_number'];

$pp_zc = $CenterPurchaseModel->GetProductList_zc_3( implode(",",$purchaseIdList) );
//银行分期（入库）


Core::LoadDom( 'CenterSku' );

///////////////////////////////
	$excelList = array();

		foreach ( $pp_zc as $v )
		{
			$tmp['id'] = $v['id'];
			$tmp['add_time'] = DateFormat($v['add_timer'], 'Y-m-d H:i');
			$tmp['supplier_name'] = $supplierInfo['name'];
			
			$tmp['product_sku'] = $v['sku'];
			$tmp['product_name'] = $v['productName'];
			
			$CenterSkuDom = new CenterSkuDom( $v['sku'] );
			$skuInfo = $CenterSkuDom->InitProduct();


			$tmp['product_attribute'] =$skuInfo['attribute'];
			$tmp['product_quantity'] = $v['totalQuantity'];
			$tmp['product_price'] = $v['productPrice'];
			$tmp['total_price'] = $v['totalPrice'];
			$tmp['product_cost'] = $v['costPrice'];
			$tmp['product_money'] = $v['costPrice']+$v['productPrice']*$v['totalQuantity'];
			//$tmp['product_coupon_price'] = $v['coupon_price'];
			//$tmp['product_payout'] = FormatMoney( $v['price'] * $v['payout_rate'] );
			//$tmp['product_pay'] = FormatMoney( $v['price'] - ( $v['price'] * $v['payout_rate'] ) );
			//$tmp['product_stock_price'] = FormatMoney( $v['stock_price'] );

			$excelList[] = $tmp;
		}


	$header = array(
		'采购号' => 'id',
		'下单时间' => 'add_time',
		'供货商' => 'supplier_name',
		'商品SKU' => 'product_sku',
		'商品名称' => 'product_name',
		'销售属性' => 'product_attribute',
		'销售数量' => 'product_quantity',
		'采购单价' => 'product_price',
		'采购合计' => 'total_price',
		'代发货总运费' => 'product_cost',
		'合计' => 'product_money',
		//'下单时间' => 'order_time',
		//'到款状态' => 'finance_recieve_name',
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

exit();

?>