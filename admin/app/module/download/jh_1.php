<?php
/*
@@acc_title="建行销售报表（刘丹） jh_1"
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
//$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
//$CenterChannelParentModel = Core::ImportModel( 'CenterChannelParent' );

//$channelList = $CenterChannelModel->GetList();
//$channelParentList = $CenterChannelParentModel->GetList();

//$tpl['channel_list'] = $channelList;
//$tpl['channel_parent_list'] = $channelParentList;

if ( !$_POST )
{

	Common::PageOut( 'download/jh_1.html', $tpl );
}
else
{
	$beginTime = $_POST['begin_date'] ? strtotime( $_POST['begin_date'] . ' 00:00:00' ) : false;
	$endTime = $_POST['end_date'] ? strtotime( $_POST['end_date'] . ' 23:59:59' ) : false;
	
	if ( $beginTime <= 0 || $endTime <= 0 )
		Alert( '查询时间格式错误' );
	
	$list = $CenterOrderModel->GetDownload_jh_1( $beginTime, $endTime,60 );


		//if ( $_POST['channel_id'] )
		//{
			//$channel = $CenterChannelModel->Get( $_POST['channel_id'] );
			//$tpl['channel_name'] = $channel['name'];
		//}

		

		
		$k=0;
		foreach ( $list as $key => $val )
		{
		
		
		
		//($beginTime,$endTime,$channelID,$productID,$productMoney,$targetID,$orderStatus,$orderService)
		$orderList = array();
		if($val['targetID'])
		$orderList  = $CenterOrderModel->GetDownload_jh_1_1( $beginTime, $endTime,60,$val['productID'],$val['productMoney'],$val['targetID'],$val['orderStatus'],$val['orderService'] );
		
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
		
		
		
///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ( $_POST['excel']>0 )
{
	$header = array(
		'商品编号' => 'targetID',
		'商品名称' => 'productName',
		'销售数量' => 'totalQuantity',
		'销售单价' => 'productMoney',
		'销售状态' => 'statusInfo',
		'订单数' => 'orderListCount',
		'订单号' => 'outOrderID',
		'银行单号' => 'outOrderBank',
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
	echo ExcelXml( $header, $list );
	exit;
}
/////////////////////////////////////////////////////////////////////////////
		
		
		
$tpl['list'] = $list;

Common::PageOut( 'download/jh_1.html', $tpl );
}
?>