<?php
/*
@@acc_title="产品销量报表 sales"
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterChannelParentModel = Core::ImportModel( 'CenterChannelParent' );

$channelList = $CenterChannelModel->GetList();
$channelParentList = $CenterChannelParentModel->GetList();


if ( !$_POST )
{
	$tpl['channel_list'] = $channelList;
	$tpl['channel_parent_list'] = $channelParentList;

	Common::PageOut( 'report/sales.html', $tpl );
}
else
{
	$beginTime = $_POST['begin_date'] ? strtotime( $_POST['begin_date'] . ' 00:00:00' ) : false;
	$endTime = $_POST['end_date'] ? strtotime( $_POST['end_date'] . ' 23:59:59' ) : false;
	
	if ( $beginTime <= 0 || $endTime <= 0 )
		Alert( '查询时间格式错误' );
	
	$list = $CenterOrderModel->GetProductSalesReport( $beginTime, $endTime, $_POST['channel_id'], $_POST['channel_parent_id'] );


	if ( !$_POST['excel'] )
	{
		if ( $_POST['channel_id'] )
		{
			$channel = $CenterChannelModel->Get( $_POST['channel_id'] );
			$tpl['channel_name'] = $channel['name'];
		}

		if ( $_POST['channel_parent_id'] )
		{
			$channelParent = $CenterChannelParentModel->Get( $_POST['channel_parent_id'] );
			$tpl['channel_parent_name'] = $channelParent['name'];
		}

		
		
		foreach ( $list as $key => $val )
		{
		//echo $val;
		//echo "========1===================<br>";
		$orderlist = $CenterOrderModel->GetProductSalesReportOrder( $beginTime, $endTime, $_POST['channel_id'], $_POST['channel_parent_id'],$val['product_id'] );
		$list[ $key ][ 'order_list' ] = $orderlist;
		//echo $list[ $key ] . " = " . $val . "<br>";
		//echo $list[$key]['product_id' ] . " <br>";
		//echo $val;
		
		//echo $orderlist;
		
		//echo $list[ $key ] . " = " . $val['product_id'];
		//echo "------------------------------<br>";
				//foreach ($orderlist as $keys => $vals )
				//{
				//echo $list[ $key ]['product_id'];
				//echo $keys . " = " . $vals . "<br>";
				//echo $vals['get_order_id'] . "<br>";
				//echo "++++<br>";
				//}
		
		
		//echo "===========2========================<br>";

		}
		
		//$orderlist = $CenterOrderModel->GetProductSalesReportOrder( $beginTime, $endTime, $_POST['channel_id'], $_POST['channel_parent_id'],$product_id );
		
		
		
		
		
		
		$tpl['list'] = $list;

		Common::PageOut( 'report/sales/detail.html', $tpl );
	}
	else
	{
		$excelList = array();
		
		foreach ( $list as $val )
		{
			$excelList[] = array(
				'product_id' => $val['product_id'],
				'product_name' => $val['name'],
				'total_quantity' => $val['total_quantity'],
				'total_price' => FormatMoney( $val['total_price'] ),
			);
		}

		$header = array(
			'商品ID' => 'product_id',
			'商品名称' => 'product_name',
			'销售数量' => 'total_quantity',
			'销售合计' => 'total_price',
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
		echo ExcelXml( $header, $excelList, 'product_id', array( 'product_id', 'product_name', 'total_quantity', 'total_price' ) );
		exit;
	}
}

?>