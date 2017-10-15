<?php
/*
@@acc_title="售后处理 service"
echo strtotime( '2014-08-20 09:35:58' );
*/



include( Core::BLock( 'order.list_3' ) );

if ( $_GET['excel'] )
{
	Core::LoadDom( 'CenterSku' );

	$excelList = array();
	foreach ( $list as $val )
	{
		$productList = $CenterOrderModel->GetProductList( $val['id'] );

		foreach ( $productList as $v )
		{
			$tmp = $val;
			$tmp['service_check_name'] = strip_tags( $tmp['service_check_name'] ); 
			$tmp['finance_recieve_name'] = strip_tags( $tmp['finance_recieve_name'] ); 

			$CenterSkuDom = new CenterSkuDom( $v['sku'] );
			$skuInfo = $CenterSkuDom->InitProduct();

			$tmp['product_name'] = $skuInfo['product']['name'];
			$tmp['product_id'] = $skuInfo['product']['id'];
			$tmp['product_sku'] = $v['sku'];
			$tmp['product_sku_id'] = $v['sku_id'];
			$tmp['product_quantity'] = $v['quantity'];
			$tmp['product_attribute'] = $skuInfo['attribute'];
			$tmp['product_price'] = $v['price'];
			$tmp['product_target_id'] = $v['target_id'];
			$tmp['product_payout_rate'] = $v['payout_rate'];
			$tmp['product_payout'] = FormatMoney( $v['price'] * $v['payout_rate'] );
			$tmp['product_pay'] = FormatMoney( $v['price'] - ( $v['price'] * $v['payout_rate'] ) );
			$tmp['product_stock_price'] = FormatMoney( $v['stock_price'] );
			$tmp['product_supplier_id'] =  $v['supplier_id'] ;
			
			$supplier_Infos = $CenterSupplierModel->Get( $v['supplier_id'] );
			$tmp['product_supplier_name'] =  $supplier_Infos['name'] ;

			$excelList[] = $tmp;
		}
	}
	
	$header = array(
		'订单号' => 'id',
		'渠道订单号' => 'target_id',
		'渠道' => 'channel_name',
		'下单时间' => 'order_time',
		'商务最后操作时间' => 'purchase_check_time',
		'客服最后操作时间' => 'service_check_time',
		'客服最后操作状态' => 'service_check_name',
		'客服最后操作备注' => 'service_last_check',
		'客服操作记录' => 'service_check_string',
		'客服呼叫记录' => 'service_call_string',
		'下单时间' => 'order_time',
		'到款状态' => 'finance_recieve_name',
		'总数' => 'total_quantity',
		'总品种数' => 'total_breed',
		'总金额' => 'total_money',
		'发票抬头' => 'order_invoice_header',
		'出库状态' => 'delivery_status_name',
		'出库类型' => 'delivery_type_name',
		'配货状态' => 'lock_status_name',
		'客户名称' => 'order_customer_name',
		'收货人' => 'order_shipping_name',
		'收货地址' => 'order_shipping_address',
		'收货邮编' => 'order_shipping_zip',
		'电话1' => 'order_shipping_phone',
		'电话2' => 'order_shipping_mobile',
		'备注' => 'order_comment',
		'分期数' => 'order_instalment_times',
		'客户卡号' => 'order_customer_card',
		'备注' => 'order_comment',
		'产品SKU' => 'product_sku',
		'渠道产品编号' => 'product_target_id',
		'产品名称' => 'product_name',
		'产品属性' => 'product_attribute',
		'价格' => 'product_price',
		'费率' => 'product_payout_rate',
		'手续费' => 'product_payout',
		'结算金额' => 'product_pay',
		'数量' => 'product_quantity',
		'状态' => 'status',
		'供货商' => 'product_supplier_id',
		'供货商' => 'product_supplier_name',
	);

	if ( in_array( $__UserAuth['user_group'], array( 12, 21 ) ) )
		$header['出库成本'] = 'product_stock_price';


	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=\"" . DateFormat(time(), 'Y-m-d_H-i-s') . ".xls\"");
	header("Content-Transfer-Encoding:binary");
	echo ExcelXml( $header, $excelList);
	exit;
}



$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

foreach ( $list as $key => $val )
{
	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $val['order_add_name_id'] );
	$list[$key]['order_add_name_zh'] = $AdminArray['user_real_name'] ;
	
	$list[$key]['order_Purchase'] = $CenterPurchaseModel->GetOrderListByPurchase( $val['id'] );
	
	
}



$tpl['list'] = $list;
$tpl['channel_list'] = $channelList;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );
$tpl['page_bar_a'] = Common::PageBar_a( $total, $onePage, $page );
$tpl['page_bar_b'] = Common::PageBar_b( $total, $onePage, $page );
$tpl['onePage'] = $onePage;
Common::PageOut( 'order/service.html', $tpl );

?>