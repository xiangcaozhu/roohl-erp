<?php
/*
@@acc_title="渠道销售产品明细 channelproduct"
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterChannelParentModel = Core::ImportModel( 'CenterChannelParent' );

$channelList = $CenterChannelModel->GetList();
$channelParentList = $CenterChannelParentModel->GetList();

	$tpl['channel_list'] = $channelList;
	$tpl['channel_parent_list'] = $channelParentList;

if ( !$_POST )
{

	Common::PageOut( 'report/channelproduct.html', $tpl );
}
else
{
	//$beginTime = $_POST['begin_date'] ? strtotime( $_POST['begin_date'] . ' 00:00:00' ) : false;
	//$endTime = $_POST['end_date'] ? strtotime( $_POST['end_date'] . ' 23:59:59' ) : false;

	$beginTime =strtotime( $_POST['begin_date'] . ' 00:00:00' );
	$endTime = strtotime( $_POST['end_date'] . ' 23:59:59' );
	
	if ( $beginTime <= 0 || $endTime <= 0 )
		Alert( '查询时间格式错误' );

	$channelID = $_POST['channel_id'];
	if ( $channelID <= 0 )
		Alert( '请选择渠道' );
	
	//$list = $CenterOrderModel->GetChannelSalesReport( $beginTime, $endTime, $_POST['channel_id'] );
	$list = $CenterOrderModel->GetChannelProduct( $beginTime,$endTime,$channelID );


		//if ( $_POST['channel_id'] )
		//{
			//$channel = $CenterChannelModel->Get( $_POST['channel_id'] );
			//$tpl['channel_name'] = $channel['name'];
		//}

		
		
		//foreach ( $list as $key => $val )
		//{
		//echo $val;
		//echo "========1===================<br>";
		//$orderlist = $CenterOrderModel->GetProductSalesReportOrder( $beginTime, $endTime, $_POST['channel_id'], $_POST['channel_parent_id'],$val['product_id'] );
		//$list[ $key ][ 'order_list' ] = $orderlist;
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

	//	}
		
		//$orderlist = $CenterOrderModel->GetProductSalesReportOrder( $beginTime, $endTime, $_POST['channel_id'], $_POST['channel_parent_id'],$product_id );
		
		
		
		
		
$tpl['list'] = $list;

if ( $_POST['excel']==1 )
{
$product_m = $list['info'][0]['product_data'];

$d=0;
foreach ( $product_m as $p_key => $p_val ) 
{
    $d++;
	
	if( (int)$p_val['get_price']>0)
	{
	$T_price= FormatMoney($p_val['get_price']);
	$T_total_price= FormatMoney($p_val['total_price']);
	$target_id = $p_val['target_id'];
	}
	else
	{
	$T_price= '赠品';
	$T_total_price= '赠品';
	$target_id = '赠品';
	}
	
	
	$excelList_one = array(
        'list_id' => $d,	
        'target_id' => $target_id,	
        'p_name' => $p_val['p_name'],
		 'total_quantity' => $p_val['total_quantity'],
		 'get_price' =>$T_price,
		 'total_price' => $T_total_price,
		 'pro3c' => $p_val['pro3c'],
    );
    $excelList[] = $excelList_one ;
}




	$header = array(
		'序号' => 'list_id',
		'编号' => 'target_id',
		'名称' => 'p_name',
		'数量' => 'total_quantity',
		'单价' => 'get_price',
		'总价' => 'total_price',
		'3C/非3C(1=3c)' => 'pro3c',
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
	echo ExcelXml( $header, $excelList);
	exit;
}
		Common::PageOut( 'report/channelproduct.html', $tpl );
}
?>