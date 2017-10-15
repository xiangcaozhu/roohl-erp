<?php
/*
@@acc_title="业务部毛利报表 business"
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

if ( !$_POST )
{
	Common::PageOut( 'report/business.html', $tpl );
}
else
{
	$beginTime = $_POST['begin_date'] ? strtotime( $_POST['begin_date'] . ' 00:00:00' ) : false;
	$endTime = $_POST['end_date'] ? strtotime( $_POST['end_date'] . ' 23:59:59' ) : false;
	
	if ( $beginTime <= 0 || $endTime <= 0 )
		Alert( '查询时间格式错误' );
	
	$list = $CenterOrderModel->GetBusinessReport( $beginTime, $endTime );

	foreach ( $list as $key => $val )
	{
		$list[$key]['profit'] = $val['total_price'] - $val['total_stock_price']  - $val['total_payout']/100 ;
		$list[$key]['total_payout_lost'] = $val['total_price'] - $val['total_payout']/100;
		$list[$key]['total_payout'] = $val['total_payout']/100;
	}

	if ( !$_POST['excel'] )
	{

		$tpl['list'] = $list;

		Common::PageOut( 'report/business/detail.html', $tpl );
	}
	else
	{
		$excelList = array();

		$totalPrice = 0;
		$totalStockPrice = 0;
		$totalPayoutPrice = 0;
		$totalProfit = 0;

		foreach ( $list as $val )
		{
			$excelList[] = array(
				'manager_user_real_name' => $val['manager_user_name'],
				'total_price' => FormatMoney( $val['total_price'] ),
				'total_stock_price' => FormatMoney( $val['total_stock_price'] ),
				'total_payout' => FormatMoney( $val['total_payout'] ),
				'profit' => FormatMoney( $val['profit'] ),
				'total_payout_lost' => FormatMoney( $val['total_payout_lost'] ),
			);

			$totalPrice += $val['total_price'];
			$totalStockPrice += $val['total_stock_price'];
			$totalPayoutPrice += $val['total_payout'];
			$totalProfit += $val['profit'];
		}

		$excelList[] = array(
			'manager_user_real_name' => '合计',
			'total_price' => FormatMoney( $totalPrice ),
			'total_stock_price' => FormatMoney( $totalStockPrice ),
			'total_payout' => FormatMoney( $totalPayoutPrice ),
			//'total_payout' => FormatMoney( $totalPayoutPrice ),
			'profit' => FormatMoney( $totalProfit ),
		);
		
		$header = array(
			'姓名' => 'manager_user_real_name',
			'销售收入' => 'total_price',
			'成本' => 'total_stock_price',
			'手续费' => 'total_payout',
			'销售收入 - 手续费' => 'total_payout_lost',
			'物流费' => '-',
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
		echo ExcelXml( $header, $excelList );
		exit;
	}
}

?>