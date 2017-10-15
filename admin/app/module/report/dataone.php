<?php
/*
@@acc_title="每日渠道销售明细 dataone"
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterChannelParentModel = Core::ImportModel( 'CenterChannelParent' );

$channelList = $CenterChannelModel->GetList();
$channelParentList = $CenterChannelParentModel->GetList();
////////////////////////////////////////////////////////////////////////////////////


//$datatime = $_GET['datanow'];
//if($datatime==)



$beginTime = $_GET['datanow'] ? strtotime( $_GET['datanow'] . ' 00:00:00' ) : false;
$endTime = $_GET['datanow'] ? strtotime( $_GET['datanow'] . ' 23:59:59' ) : false;

	
if ( $beginTime <= 0 || $endTime <= 0 )
{
$beginTime = mktime(0,0,0,date("m"),date("d"),date("Y"));
$endTime   = mktime(23,59,59,date("m"),date("d"),date("Y"));
}

if ( $beginTime <= 0 || $endTime <= 0 )
{
         Alert( '查询时间格式错误' );
}

	
$beginTime_s = date('Y-m-d G:i:s',$beginTime);
$endTime_s = date('Y-m-d G:i:s',$endTime);

$list = array();
$list = $CenterOrderModel->GetProductOrderReport( $beginTime,$endTime );

		$day_total_price=0;
		foreach ( $list as $key => $val )
		{
		$day_total_price = $day_total_price + $val['total_price'];
		}
				
		
		
$tpl['beginTime_s'] = date('Y-m-d G:i:s',$beginTime);
$tpl['endTime_s'] = date('Y-m-d G:i:s',$endTime);
$tpl['list'] = $list;
$tpl['day_total_price'] = $day_total_price;
////////////////////////////////////////////////////////////////////////////////










Common::PageOut( 'report/dataone.html', $tpl );
?>