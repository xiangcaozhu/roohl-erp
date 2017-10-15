<?php

$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

if ( $_POST['logistics_company'] )
{
	foreach ( $_POST['logistics_company'] as $orderId => $val )
	{
		$data = array();
		$data['logistics_company'] = NoHtml( $val );
		$data['logistics_sn'] = NoHtml( $_POST['logistics_sn'][$orderId] );
		$data['delivery_comment'] = NoHtml( $_POST['delivery_comment'][$orderId] );

		if ( $data['logistics_company'] )
			$data['delivery_ready_status'] = 1;
		else
			$data['delivery_ready_status'] = 0;

		$CenterOrderModel->Update( $orderId, $data );
	}
}

echo 200;
exit();

?>