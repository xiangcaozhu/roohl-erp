<?php
/*
@@acc_title="渠道回款汇总 total"
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelParentModel = Core::ImportModel( 'CenterChannelParent' );

$channelParentList = $CenterChannelParentModel->GetList();

$channelParentId = (int)$_GET['channel_parent_id'];
$endTime = $_GET['end_date'] ? strtotime( $_GET['end_date'].' 23:59:59' ) : time();
$beginTime = $_GET['begin_date'] ? strtotime( $_GET['begin_date'].' 00:00:00' ) : $endTime - 86400;

$list = $CenterOrderModel->GetFinanceRecieveTotalReport( $channelParentId, $beginTime, $endTime, $invoiceStatus );


if ( $_GET['excel'] )
{
	$excelList = array();

	foreach ( $list as $val )
	{
		$excelList[] = array(
			'channel_parent_name' => $val['channel_parent_name'],
			'finance_recieve_time' => DateFormat( $val['finance_recieve_time'], 'Y-m-d' ),
			'order_invoice_status' => $val['order_invoice_status'] ? '已开发票' : '未开发票',
			'total_sales_price' => FormatMoney( $val['total_sales_price'] ),
			'total_payout' => FormatMoney( $val['total_payout'] ),
			'total_balance' => FormatMoney( $val['total_balance'] ),
		);
	}

	$header = array(
		'父渠道' => 'channel_parent_name',
		'回款日期' => 'finance_recieve_time',
		'销售合计' => 'total_sales_price',
		'手续费' => 'total_payout',
		'结算金额' => 'total_balance',
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
$tpl['channel_parent_list'] = $channelParentList;

Common::PageOut( 'finance/recieve/total.html', $tpl );

?>