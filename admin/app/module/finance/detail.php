<?php
/*
@@acc_title="订单回款明细 detail"
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterChannelParentModel = Core::ImportModel( 'CenterChannelParent' );

$channelList = $CenterChannelModel->GetList();
$channelParentList = $CenterChannelParentModel->GetList();

$channelId = (int)$_GET['channel_id'];
$channelParentId = (int)$_GET['channel_parent_id'];
$endTime = $_GET['end_date'] ? strtotime( $_GET['end_date'].' 23:59:59' ) : time();
$beginTime = $_GET['begin_date'] ? strtotime( $_GET['begin_date'].' 00:00:00' ) : $endTime - 86400;
$invoiceStatus = $_GET['order_invoice_status'];

$list = $CenterOrderModel->GetFinanceRecieveReport( $channelId, $beginTime, $endTime, $invoiceStatus, $channelParentId );


if ( $_GET['excel'] )
{
	$excelList = array();

	foreach ( $list as $val )
	{
		$excelList[] = array(
			'id' => $val['id'],
			'channel_parent_name' => $val['channel_parent_name'],
			'channel_name' => $val['channel_name'],
			'finance_recieve_time' => DateFormat( $val['finance_recieve_time'], 'Y-m-d' ),
			'order_invoice_status' => $val['order_invoice_status'] ? '已开发票' : '未开发票',
			'product_name' => $val['product_name'],
			'sales_price' => FormatMoney( $val['sales_price'] ),
			'sales_quantity' => $val['sales_quantity'],
			'total_sales_price' => FormatMoney( $val['total_sales_price'] ),
			'payout' => FormatMoney( $val['payout'] ),
			'balance' => FormatMoney( $val['balance'] ),
			'stock_price' => FormatMoney( $val['stock_price'] ),
			'stock_quantity' => $val['stock_quantity'],
			'total_stock_price' => FormatMoney( $val['total_stock_price'] ),
		);
	}

	$header = array(
		'订单号' => 'id',
		'父渠道' => 'channel_parent_name',
		'渠道' => 'channel_name',
		'回款日期' => 'finance_recieve_time',
		'是否开票' => 'order_invoice_status',
		'商品名称' => 'product_name',
		'销售单价' => 'sales_price',
		'销售数量' => 'sales_quantity',
		'销售合计' => 'total_sales_price',
		'手续费' => 'payout',
		'结算金额' => 'balance',
		'成本(不含税)' => 'stock_price',
		'数量' => 'stock_quantity',
		'成本合计' => 'total_stock_price',
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
$tpl['total'] = count( $list );
$tpl['channel_list'] = $channelList;
$tpl['channel_parent_list'] = $channelParentList;

Common::PageOut( 'finance/recieve/detail.html', $tpl );

?>