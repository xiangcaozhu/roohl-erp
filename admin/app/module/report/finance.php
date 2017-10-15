<?php
/*
@@acc_title="财务到账报表 finance"
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$ChannelModel = Core::ImportModel( 'CenterChannel' );

if ( !$_POST )
{
	Common::PageOut( 'report/finance.html', $tpl );
}
else
{
	$beginTime = $_POST['begin_date'] ? strtotime( $_POST['begin_date'] . ' 00:00:00' ) : false;
	$endTime = $_POST['end_date'] ? strtotime( $_POST['end_date'] . ' 23:59:59' ) : false;
	
	if ( $beginTime <= 0 || $endTime <= 0 )
		Alert( '查询时间格式错误' );
	
	$list = $CenterOrderModel->GetFinanceReport( $beginTime, $endTime );

	$statList = array();
	
	foreach ( $list as $key => $val )
	{
		$list[$key]['profit'] = $val['total_price'] - $val['total_stock_price'] - $val['total_payout'] ;

		$statList[$val['channel_id']]['money'] += ( $val['price'] * $val['quantity'] );
		$statList[$val['channel_id']]['payout'] += ( $val['price'] * $val['payout_rate'] * $val['quantity'] );
		$statList[$val['channel_id']]['stock_cost'] += ( $val['stock_price'] * $val['quantity'] );
		$statList[$val['channel_id']]['profit'] += ( $val['price'] - $val['stock_price'] -  ( $val['price'] * $val['payout_rate'] ) ) * $val['quantity'];

		if ( $val['product_board'] == 1 )
		{
			$statList[$val['channel_id']]['3c_stock_cost'] += ( $val['stock_price'] * $val['quantity'] );
		}
		else
		{
			$statList[$val['channel_id']]['no3c_stock_cost'] += ( $val['stock_price'] * $val['quantity'] );
		}
	}

	foreach ( $statList as $key => $val )
	{
		$info = $ChannelModel->Get( $key );
		$statList[$key]['channel'] = $info['name'];
		$statList[$key]['channel_id'] = $info['id'];
	}

	if ( !$_POST['excel'] )
	{

		$tpl['list'] = $statList;

		Common::PageOut( 'report/finance/detail.html', $tpl );
	}
	else
	{
		$excelList = array();
		
		foreach ( $statList as $val )
		{
			$excelList[] = array(
				'channel' => $val['channel'],
				'channel_id' => $val['channel_id'],
				'money' => FormatMoney( $val['money'] ),
				'payout' => FormatMoney( $val['payout'] ),
				'money' => FormatMoney( $val['money'] ),
				'profit' => FormatMoney( $val['profit'] ),
				'stock_cost' => FormatMoney( $val['3c_stock_cost'] ),
				'total_stock_cost' => FormatMoney( $val['3c_stock_cost'] + $val['no3c_stock_cost'] ),
				'type' => '3C',
			);

			$excelList[] = array(
				'channel' => $val['channel'],
				'channel_id' => $val['channel_id'],
				'money' => FormatMoney( $val['money'] ),
				'payout' => FormatMoney( $val['payout'] ),
				'money' => FormatMoney( $val['money'] ),
				'profit' => FormatMoney( $val['profit'] ),
				'stock_cost' => FormatMoney( $val['no3c_stock_cost'] ),
				'total_stock_cost' => FormatMoney( $val['3c_stock_cost'] + $val['no3c_stock_cost'] ),
				'type' => '非3C',
			);
		}

		$header = array(
			'业务分类' => 'channel',
			'到账金额' => 'money',
			'手续费' => 'payout',
			'销售合计' => 'money',
			'产品类别' => 'type',
			'成本' => 'stock_cost',
			'成本合计' => 'total_stock_cost',
			'毛利' => 'profit',
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
		echo ExcelXml( $header, $excelList, 'channel_id', array( 'channel', 'money', 'payout', 'money', 'total_stock_cost', 'profit', 'total_money' ) );
		exit;
	}
}

?>