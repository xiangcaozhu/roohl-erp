<?php
/*
@@acc_title="导入物流单号物流费 import"
*/
Core::LoadFunction( 'ImportOrderInfo.inc.php' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

function ArrayIndexA( $list, $key )
{
	if ( !is_array( $list ) )
		return array();
	
	$new = array();
	foreach ( $list as $val )
	{
		$new[$val[$key]] = $val;
	}

	return $new;
}


if ( !$_POST )
{
	$tpl['check'] = true;
	Common::PageOut( 'delivery/import.html', $tpl );
}
else
{
	if ( !$_FILES['file']['tmp_name'] )
		return false;

	$savePath = Core::GetConfig( 'file_upload_tmp_path' );
	$fileName = md5( GetRand( 32 ) );
	$saveFile = $savePath . $fileName  . ".tmp";

	if ( !@move_uploaded_file( $_FILES['file']['tmp_name'], $saveFile ) )
	{
		Alert( '上传文件失败' );
	}

	$list = ImportlogisticsSn( $saveFile );



	$temp = array();
	foreach ( $list as $keys => $val )
	{
		$temp[$val['order_id']] = $val['order_id'];
	}
	$IDS = implode(",",$temp);
	
	if((int)$val['xiaofw']==901){
		$orderList = $CenterOrderModel->Get0919B( $IDS );
		$orderList = ArrayIndexA($orderList,"target_id");
			
	}else{
		$orderList = $CenterOrderModel->Get0919A( $IDS );
		$orderList = ArrayIndexA($orderList,"id");
	}
	


	
	
//$CenterOrderModel->Model->DB->Begin();

	foreach ( $list as $key => $val )
	{
		if((int)$val['xiaofw']==1){
			$CenterOrderModel->Update( $val['order_id'], array( 'warehouse_id' => 5 ) );
		}
		
		/*
		if((int)$val['xiaofw']==901){
			$order = $CenterOrderModel->Get0919( $val['order_id'] );
			$val['order_id'] = $order['id'];
			$list[$key]['order_id'] = $order['id'];
			
		}else{
			$order = $CenterOrderModel->Get09191( $val['order_id'] );
		}
		*/
		//print_r($orders);
		$order = $orderList[$val['order_id']];
		if((int)$val['xiaofw']==901){
			$val['order_id'] = $order['id'];
			$list[$key]['order_id'] = $order['id'];
			
		}
		
		

		$list[$key]['error'] = false;
		if ( !$order )
			{
			$list[$key]['notexist'] = true;
			$list[$key]['error'] = true;
		    $list[$key]['ThisLogistics'] = "订单不存在";
		    $list[$key]['ThisSN'] = "订单不存在";
		    $list[$key]['ThisCost'] = "订单不存在";
			}
		elseif( $order['delivery_status']<2 && $order['warehouse_id']>5 )
		{
			$list[$key]['notexist'] = true;
			$list[$key]['error'] = true;
		    $list[$key]['ThisLogistics'] = "订单产品尚未出库";
		    $list[$key]['ThisSN'] = "订单产品尚未出库";
		    $list[$key]['ThisCost'] = "订单产品尚未出库";
		}
		else
		{
		if ( ($order['warehouse_id']>5) && ($list[$key]['logistics_company'] != $order['logistics_company']) )
			{
			$list[$key]['error'] = true;
			$list[$key]['company_error'] = "快递公司不对应";
			}

		if ( $order['logistics_sn'] )
			{
			//$list[$key]['error'] = true;
			//$list[$key]['sn_error'] = "此订单已有物流单号";
			}
			
		
		   $list[$key]['ThisLogistics'] = $order['logistics_company'];
		   $list[$key]['ThisSN'] = $order['logistics_sn'];

		}
		
	}
//$CenterOrderModel->Model->DB->Commit();

	$tpl['list'] = $list;
	$tpl['file_name'] = $fileName;
	Common::PageOut( 'delivery/import/check.html', $tpl );
}

?>