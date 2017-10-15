<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$WarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

$orderId = (int)$_GET['id'];

$orderInfo = $CenterOrderModel->Get( $orderId );

if ( !$orderInfo )
	Alert( '没有找到指定的订单' );


$CenterOrderModel->Model->DB->Begin();


$CenterOrderModel->Update( $orderId, array( 'collate_status' => 1 ) );



$CenterOrderModel->Model->DB->Commit();

Common::Loading();

?>