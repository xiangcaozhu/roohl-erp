<?php
/*
@@acc_title="广发银行月报（孙江琳） gf_2"
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
//$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
//$CenterChannelParentModel = Core::ImportModel( 'CenterChannelParent' );

//$channelList = $CenterChannelModel->GetList();
//$channelParentList = $CenterChannelParentModel->GetList();

//$tpl['channel_list'] = $channelList;
//$tpl['channel_parent_list'] = $channelParentList;


$weekarray=array("日","一","二","三","四","五","六");
//"星期".$weekarray[date("w","2011-11-11")];


if ( !$_POST )
{

	Common::PageOut( 'download/gf_2.html', $tpl );
}
else
{
	$beginTime = $_POST['begin_date'] ? strtotime( $_POST['begin_date'] . ' 00:00:00' ) : false;
	$endTime = $_POST['end_date'] ? strtotime( $_POST['end_date'] . ' 23:59:59' ) : false;
	
	if ( $beginTime <= 0 || $endTime <= 0 )
		Alert( '查询时间格式错误' );



		$channelData = array();
		$p=0;
		for( $i=$beginTime; $i<$endTime ; $i=$i+86400 )
		{
		$ii = $i+86399;
		$channelData[$p]['nowday'] = date('Y-m-d',$i);
		$channelData[$p]['nowdayWeek'] = '星期'.$weekarray[date("w",$i)];
		$channelData[$p][ 'list' ] = $p+1;
				
				//全部订单列表
				$orderList = $CenterOrderModel->GetDownload_gf_01( $i, $ii,62 );
				$channelData[$p]['orderList'] = $orderList;
				
				
				$outOrderID='';
				$outOrderBank='';
				foreach ( $orderList as $keys => $vals )
				{
				$outOrder=$outOrder.$vals['orderID'].'　';
				$outOrderBank=$outOrderBank.$vals['orderTargetID'].'　';
				}
				$channelData[$p][ 'outOrderID' ]  = $outOrder;
				$channelData[$p][ 'outOrderBank' ]  = $outOrderBank;

				//全部
				$tempData = $CenterOrderModel->GetDownload_gf_0( $i, $ii,62 );
				$channelData[$p]['totalNums'] =  (int)$tempData['totalQuantity'];
				$channelData[$p]['totalMoneys'] = FormatMoney($tempData['totalMoney']);

				//有效
				$tempData = $CenterOrderModel->GetDownload_gf_1( $i, $ii,62 );
				$channelData[$p]['totalNum'] =  (int)$tempData['totalQuantity'];
				$channelData[$p]['totalMoney'] = FormatMoney($tempData['totalMoney']);

				//外呼取消
				$tempData_del = $CenterOrderModel->GetDownload_gf_4( $i, $ii,62 );
				$channelData[$p]['totalNum_del'] =  (int)$tempData_del['totalQuantity'];
				$channelData[$p]['totalMoney_del'] = FormatMoney($tempData_del['totalMoney']);

				//售后退货中
				$tempData_re = $CenterOrderModel->GetDownload_gf_2( $i, $ii,62 );
				$channelData[$p]['totalNum_re'] =  (int)$tempData_re['totalQuantity'];
				$channelData[$p]['totalMoney_re'] = FormatMoney($tempData_re['totalMoney']);

				//售后退货完毕
				$tempData_reover = $CenterOrderModel->GetDownload_gf_3( $i, $ii,62 );
				$channelData[$p]['totalNum_reover'] =  (int)$tempData_reover['totalQuantity'];
				$channelData[$p]['totalMoney_reover'] = FormatMoney($tempData_reover['totalMoney']);

		$p++;
		}






	


		//if ( $_POST['channel_id'] )
		//{
			//$channel = $CenterChannelModel->Get( $_POST['channel_id'] );
			//$tpl['channel_name'] = $channel['name'];
		//}

		
/*
		
		$k=0;
		foreach ( $list as $key => $val )
		{
		
		
		
		//($beginTime,$endTime,$channelID,$productID,$productMoney,$targetID,$orderStatus,$orderService)
		$orderList = array();
		if($val['targetID'])
		$orderList  = $CenterOrderModel->GetDownload_jh_1_1( $beginTime, $endTime,62,$val['productID'],$val['productMoney'],$val['targetID'],$val['orderStatus'],$val['orderService'] );
		
		$list[ $key ][ 'orderList' ]  = $orderList;
		$list[ $key ][ 'orderListCount' ]  = count($orderList);
		
		
				$outOrderID='';
				$outOrderBank='';
				foreach ( $orderList as $keys => $vals )
				{
				$outOrder=$outOrder.$vals['orderID'].'　';
				$outOrderBank=$outOrderBank.$vals['orderTargetID'].'　';
				}
		$list[ $key ][ 'outOrderID' ]  = $outOrder;
		$list[ $key ][ 'outOrderBank' ]  = $outOrderBank;
		
		
		$k++;
		$list[ $key ][ 'list' ] = $k;
		if( !$val['bankName'])
		$list[ $key ][ 'bankName' ] = $list[ $key ][ 'productName' ];
		
		
		if($val['orderService']==1)
		{
		$list[ $key ][ 'statusInfo' ] = '正常';
		   if($val['orderStatus']==2)
		   {
		   $list[ $key ][ 'statusInfo' ] = '退单办理中';
		   }
		   if($val['orderStatus']==3)
		   {
		   $list[ $key ][ 'statusInfo' ] = '已退单';
		   }
		}
		
		if($val['orderService']==0)
		{
		$list[ $key ][ 'statusInfo' ] = '未操作';
		}

		if($val['orderService']==2)
		{
		$list[ $key ][ 'statusInfo' ] = '已取消';
		}
		

		}
		
*/	


///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ( $_POST['excel']>0 )
{
	$header = array(
		'日期' => 'nowday',
		'有效成功数量' => 'totalNum',
		'有效成功金额' => 'totalMoney',
		'外呼取消数量' => 'totalNum_del',
		'外呼取消金额' => 'totalMoney_del',
		'售后退货中数量' => 'totalNum_re',
		'售后退货中金额' => 'totalMoney_re',
		'售后退货完毕数量' => 'totalNum_reover',
		'售后退货完毕金额' => 'totalMoney_reover',
		'全部订单号' => 'outOrderID',
		'全部银行单号' => 'outOrderBank',

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
	echo ExcelXml( $header, $channelData );
	exit;
}
/////////////////////////////////////////////////////////////////////////////
		
		
		
$tpl['list'] = $channelData;

Common::PageOut( 'download/gf_2.html', $tpl );
}
?>