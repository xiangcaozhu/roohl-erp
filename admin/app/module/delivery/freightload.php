<?php
/*
@@acc_freet
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

Core::LoadFunction( 'ImportOrderInfo.inc.php' );

$savePath = Core::GetConfig( 'file_upload_tmp_path' );
$fileName = $_GET['file'];
$saveFile = $savePath . $fileName  . ".tmp";

if ( !file_exists( $saveFile ) )
{
	Alert( '没有找到待导入文件' );
}

$list = ImportShippingCost( $saveFile );

$CenterOrderModel->Model->DB->Begin();

foreach ( $list as $val )
{
		$order = $CenterOrderModel->Getcost( $val['logistics_sn'] );

		$p=0;
		if ( !$order )
			{
			$list[$key]['notexist'] = true;
			$p=1;
			}

		if ( $order['order_shipping_cost'] > 0 )
			{
			$list[$key]['error'] = true;
			$p=1;
			}
		
		if ( $p==0 )
		    $CenterOrderModel->Update( $order['id'], array( 'order_shipping_cost' => $val['order_shipping_cost'] ) );
}

$CenterOrderModel->Model->DB->Commit();

Common::Loading( '?mod=delivery.freight' );

?>