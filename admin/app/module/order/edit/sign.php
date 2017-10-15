<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );



/*
$orderId = (int)$_GET['id'];

$orderInfo = $CenterOrderModel->Get( $orderId );

if ( !$orderInfo )
	Alert( '没有找到指定的订单' );

if ( !$_GET['date'] )
	Alert( '请选择时间' );

$time = strtotime( $_GET['date'] );

if ( !$time || $time < 0 )
	Alert( '时间格式错误' );


$CenterOrderModel->Model->DB->Begin();


$CenterOrderModel->Update( $orderId, array( 'sign_status' => 1, 'sign_time' => strtotime( $_GET['date'] ) ) );



$CenterOrderModel->Model->DB->Commit();

*/







if ( $_POST['logistics_company'] )
{
	foreach ( $_POST['logistics_company'] as $orderId => $val )
	{
		$data = array();
		$data['logistics_company'] = NoHtml( $val );
		$data['logistics_sn'] = NoHtml( $_POST['logistics_sn'][$orderId] );
		$data['delivery_time'] = strtotime( $_POST['delivery_time'][$orderId] ) + 8 * 3600;
		$data['sign_time'] = strtotime( $_POST['sign_time'][$orderId] ) + 8 * 3600;
		$data['sign_status'] = strtotime( $_POST['sign_time'][$orderId] ) ? 1 : 0;

		if ( $data['logistics_company'] )
			$data['delivery_ready_status'] = 1;

		$CenterOrderModel->Update( $orderId, $data );
	}
}








Common::Loading();

?>