<?php
/*
@@acc_title="渠道销售汇总报表 channelone"
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
//$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
//$CenterChannelParentModel = Core::ImportModel( 'CenterChannelParent' );

//$channelList = $CenterChannelModel->GetList();
//$channelParentList = $CenterChannelParentModel->GetList();

//	$tpl['channel_list'] = $channelList;
//	$tpl['channel_parent_list'] = $channelParentList;

if ( !$_POST )
{

	Common::PageOut( 'report/channelone.html', $tpl );
}
else
{
	$beginTime = $_POST['begin_date'] ? strtotime( $_POST['begin_date'] . ' 00:00:00' ) : false;
	$endTime = $_POST['end_date'] ? strtotime( $_POST['end_date'] . ' 23:59:59' ) : false;
	
	if ( $beginTime <= 0 || $endTime <= 0 )
		Alert( '查询时间格式错误' );
		
	ob_end_flush();
	set_time_limit(0); 
		
		
	$cclist = $CenterOrderModel->xiaofw1009();
	$html = '<td width="100" align="center" bgcolor="#FFFFFF"></td><td width="80" align="center" bgcolor="#FFFFFF"><div align="center">合计</div></td>';
	foreach ( $cclist as $key => $val ){
	$html .= '<td width="100" align="center" bgcolor="#FFFFFF"><div align="center">'.str_replace("→","<br />",trim($val['channel_name'])).'</div></td>';
	}
	$html .= '<td bgcolor="#FFFFFF"></td>';
	

echo "<script>parent.flush('".$html."');</script>";
flush();
sleep(0);




		$money_A = 0;
		for( $i=$beginTime; $i<$endTime ; $i=$i+86400 ){
        $html1 = "";
		$ii = $i+86399;
		$nowday = date('Y-m-d',$i);
		$ggglist = $CenterOrderModel -> Get_my_total_price1009($i,$ii);
        

	      $allMoney = 0;
		  foreach ( $cclist as $key => $val ){
		      $oneMoney = (int)$ggglist[$val['channel_id']]['total_price'];
		      $html1 .= '<td align="center"><div align="center">'.$oneMoney.'</div></td>';
			  $allMoney = $allMoney+$oneMoney;
			  $cclist[$key]['cMoney'] = (int)$cclist[$key]['cMoney']+$oneMoney;
		  }
		  $html1 .= '<td align="center"></td></tr>';
	
		$html1 = '<tr><td align="center"><a href="?mod=report.dataone&datanow='.$nowday.'" target="_blank">'.$nowday.'</a></td><td align="center"><font color="#336600">'.$allMoney.'</font></td>'.$html1;
	
echo "<script>parent.flush1('".$html1."');</script>";
flush();
sleep(0);

         $money_A = $money_A+$allMoney;

		}

		  $html2 .= '<tr><td align="center">合计</td><td align="center"><font color="#990066">'.FormatMoney($money_A).'</font></td>';


		  foreach ( $cclist as $key => $val ){
		      $html2 .= '<td align="center"><div align="center"><font color="#990000">'.(int)$val['cMoney'].'</font></div></td>';
		  }
		  $html2 .= '<td align="center"></td></tr>';


echo "<script>parent.flush1('".$html2."');</script>";
flush();
sleep(0);

echo "<script>parent.flush2('".FormatMoney($money_A)."');</script>";
flush();
sleep(0);
			






	
	//$list = $CenterOrderModel->GetChannelSalesReport( $beginTime, $endTime, $_POST['channel_id'] );


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
		
		
		
		
		
		
	//	$tpl['list'] = $list;

	//	Common::PageOut( 'report/channelone.html', $tpl );
}
?>