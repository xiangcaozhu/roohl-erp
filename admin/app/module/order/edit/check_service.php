<?php
/*
@@acc_free
@@acc_title="整理出库订单 pack"
*/


$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
ob_end_flush();
//set_time_limit(0); 

$productID = (int)$_GET['productID'];
$channelID = (int)$_GET['channel_id'];

$orderList = $CenterOrderModel->GetList1203_A($productID ,$channelID);

$total = count($orderList);
echo $total."<br><br><br><br>";

foreach ( $orderList as $vs )
{

$orderID = $vs['orderID'];



$data = array();
	$data['lock_call_time'] = time();
	$data['service_check'] = 1;
	$data['service_check_time'] = time();
	$data['service_real_name'] = $__UserAuth['user_name']."_批量确认";

  $CenterOrderModel->Update( $orderID, $data );

echo $orderID."<br>";
flush(); 
//sleep(1); 

}

?>