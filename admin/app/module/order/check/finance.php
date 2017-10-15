<?php
/*
@@acc_title="财务到款确认 finance"
*/
$staticSearch = array();

include( Core::BLock( 'order.list' ) );


if ( $_GET['excel'] )
{
	Core::LoadDom( 'CenterSku' );

	$excelList = array();
	foreach ( $list as $val )
	{
		$productList = $CenterOrderModel->GetProductList( $val['id'] );

		$tmp = $val;
		$tmp['need_invoice'] = $val['order_invoice'] ? '是' : '否';
		$tmp['invoice_status'] = $val['order_invoice_status'] ? '已开' : '未开';
		$excelList[] = $tmp;

		/*
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
			$tmp['target_id'] = $v['target_id'];
			
			$excelList[] = $tmp;
		}
		*/
	}
	
	$header = array(
		'订单号' => 'id',
		'渠道订单号' => 'target_id',
		'渠道' => 'channel_name',
		'下单时间' => 'order_time',
		'总金额' => 'total_money',
		'出库状态' => 'delivery_status_name',
		'是否需要发票' => 'need_invoice',
		'发票状态' => 'invoice_status',
		'发票抬头' => 'order_invoice_header',
		'发票号' => 'order_invoice_number',
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
}



$tpl['list'] = $list;
$tpl['channel_list'] = $channelList;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

Common::PageOut( 'order/check/finance.html', $tpl );

?>