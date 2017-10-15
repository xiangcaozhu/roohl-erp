<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

Core::LoadFunction( 'ImportOrderInfo.inc.php' );

$savePath = Core::GetConfig( 'file_upload_tmp_path' );
$fileName = $_GET['file'];
$saveFile = $savePath . $fileName  . ".tmp";

if ( !file_exists( $saveFile ) )
{
	Alert( '没有找到待导入文件' );
}

$list = ImportFinanceRecieveTime( $saveFile );

$CenterOrderModel->Model->DB->Begin();

foreach ( $list as $val )
{
	$order = $CenterOrderModel->GetUniqueByChannelParent( $_GET['channel_parent_id'], $val['target_id'] );

	$CenterOrderModel->Update( $order['order_id'], array( 'finance_recieve' => 1, 'finance_recieve_time' => strtotime( $val['finance_recieve_time'] ) ) );
}

$CenterOrderModel->Model->DB->Commit();

Common::Loading( '?mod=order.check.finance' );

?>