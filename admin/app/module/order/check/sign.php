<?php
/*
@@acc_title="订单签收确认 sign"
*/


//$ppp=GetExpress( '汇通','210259725266' );
//echo $ppp;


$staticSearch = array();
$staticSearch['delivery_status'] = 2;

include( Core::BLock( 'order.list' ) );



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

			$CenterSkuDom = new CenterSkuDom( $v['sku'] );
			$skuInfo = $CenterSkuDom->InitProduct();

			$tmp['product_name'] = $skuInfo['product']['name'];
			$tmp['product_id'] = $skuInfo['product']['id'];
			$tmp['product_sku'] = $v['sku'];
			$tmp['product_sku_id'] = $v['sku_id'];
			$tmp['product_quantity'] = $v['quantity'];
			$tmp['product_attribute'] = $skuInfo['attribute'];
			$tmp['product_price'] = $v['price'];
			
			$excelList[] = $tmp;
		}
	}
	
	$header = array(
		'订单号' => 'id',
		'渠道订单号' => 'target_id',
		'渠道' => 'channel_name',
		'下单时间' => 'order_time',
		'总数' => 'total_quantity',
		'总金额' => 'total_money',
		'出库状态' => 'delivery_status_name',
		'出库时间' => 'delivery_time',
		'客户名称' => 'order_customer_name',
		'客户证件号' => 'order_customer_card',
		'收货人' => 'order_shipping_name',
		'收货地址' => 'order_shipping_address',
		'收货邮编' => 'order_shipping_zip',
		'电话1' => 'order_shipping_phone',
		'电话2' => 'order_shipping_mobile',
		'物流公司' => 'logistics_company',
		'物流单号' => 'logistics_sn',
		'物流备注' => 'delivery_comment',
		'渠道产品编号' => 'target_id',
		'产品名称' => 'product_name',
		'产品属性' => 'product_attribute',
		'价格' => 'product_price',
		'数量' => 'product_quantity',
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
	echo ExcelXml( $header, $excelList, 'id', array( 'id', 'target_id', 'channel_name', 'order_time', 'total_quantity', 'total_breed', 'total_money', 'delivery_status_name', 'delivery_time', 'delivery_type_name', 'lock_status_name', 'order_customer_name', 'order_shipping_name', 'order_shipping_address', 'order_shipping_zip', 'order_shipping_phone', 'order_shipping_mobile', 'order_comment', 'logistics_company', 'logistics_sn', 'delivery_comment' ) );
	exit;
}



//$tpl['list'] = $list;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

$tpl['list'] = $list;

Common::PageOut( 'order/check/sign.html', $tpl );

?>