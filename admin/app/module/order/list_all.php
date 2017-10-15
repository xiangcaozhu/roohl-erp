<?php
/*
@@acc_title="所有订单信息客服部 list_all"
*/
include( Core::BLock( 'order.list_99' ) );

if ( $_GET['excel'] )
{
	Core::LoadDom( 'CenterSku' );


	foreach ( $list as $key => $val )
	{

if($val['status']>1)
{
$list[$key]['order_s_name'] ='售后退单退货';
$list[$key]['lost_info'] = $ActionLogModel->GetList_11( $val['id'], 'order_tdth',2 );
}
else
{
if($val['service_check']==2)
{
$list[$key]['order_s_name'] ='已取消';
$list[$key]['lost_info'] = $ActionLogModel->GetList_11( $val['id'], 'order_check_service',2 );
}
else
{
$list[$key]['order_s_name'] ='正常';
$list[$key]['lost_info'] = '';
}
}

}

	$excelList = array();


	foreach ( $list as $key => $val )
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
			$tmp['product_coupon_price'] = $v['coupon_price'];
			$tmp['product_payout'] = FormatMoney( $v['price'] * $v['payout_rate'] );
			$tmp['product_pay'] = FormatMoney( $v['price'] - ( $v['price'] * $v['payout_rate'] ) );
			$tmp['product_stock_price'] = FormatMoney( $v['stock_price'] );

			//$tmp['sign_time'] = DateFormat( $val['sign_time'],'Y-m-d H:i' );

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
		//'出库时间' => 'delivery_time',
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
		'优惠券' => 'product_coupon_price',
		'结算金额' => 'product_pay',
		'数量' => 'product_quantity',
		'快递公司' => 'logistics_company',
		'快递单号' => 'logistics_sn',
		'发货时间' => 'logistics_time',
		'签收时间' => 'sign_time',
		'签收人' => 'sign_name',
		'订单状态' => 'order_s_name',
		'状态备注' => 'lost_info',
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
	echo ExcelXml( $header, $excelList, 'id', array( 'id', 'target_id', 'channel_name', 'order_time', 'total_quantity', 'total_breed', 'total_money', 'order_invoice_header', 'delivery_status_name', 'delivery_type_name', 'lock_status_name', 'order_customer_name', 'order_shipping_name', 'order_shipping_address', 'order_shipping_zip', 'order_shipping_phone', 'order_shipping_mobile', 'order_comment', 'order_instalment_times', 'order_customer_card', 'purchase_check_time', 'service_check_time', 'service_check_name', 'service_last_check', 'service_check_string', 'service_call_string' ) );
	exit;
}



$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

foreach ( $list as $key => $val )
{
	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $val['order_add_name_id'] );
	$list[$key]['order_add_name_zh'] = $AdminArray['user_real_name'] ;
	
	$list[$key]['order_Purchase'] = $CenterPurchaseModel->GetOrderListByPurchase( $val['id'] );

if($val['status']>1)
{
$list[$key]['order_s_name'] ='售后退单退货';
$list[$key]['lost_info'] = $ActionLogModel->GetList_11( $val['id'], 'order_tdth',2 );
}
else
{
if($val['service_check']==2)
{
$list[$key]['order_s_name'] ='已取消';
$list[$key]['lost_info'] = $ActionLogModel->GetList_11( $val['id'], 'order_check_service',2 );
}
else
{
$list[$key]['order_s_name'] ='正常';
$list[$key]['lost_info'] = '';
}
}
	
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

Common::PageOut( 'order/list_all.html', $tpl );

?>