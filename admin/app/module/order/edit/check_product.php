<?php
/*
@@acc_free
@@acc_title="整理出库订单 pack"
*/


$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );

ob_end_flush();
//set_time_limit(0); 

$productID = (int)$_GET['productID'];
$channelID = (int)$_GET['channel_id'];

$orderList = $CenterOrderModel->GetList1203($productID ,$channelID);

$total = count($orderList);
echo $total."<br><br><br><br>";

foreach ( $orderList as $vs )
{

$orderID = $vs['orderID'];



	$data = array();
	$data['purchase_check'] = 1;
	$data['purchase_check_time'] = time();
	$data['purchase_real_name'] = $__UserAuth['user_name']."_批量确认";
	$data['lock_call_time'] = time();
    $CenterOrderModel->Update( $orderID, $data );
	
	
	$productList = $CenterOrderModel->GetProductList( $orderID );
	foreach ( $productList as $val )
	{
		$pid = $val['product_id'];
		$productInfo = $CenterProductModel->Get( $pid );
		$data_a = array();
		$data_a['supplier_id'] = intval( $productInfo['supplier_now'] );
		//$CenterOrderModel->UpdateProduct( $val['id'], $data_a );
	}


echo $orderID."<br>";
flush(); 
//sleep(1); 

}

?>