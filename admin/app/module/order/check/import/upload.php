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

$list = ImportSignTime( $saveFile );

$CenterOrderModel->Model->DB->Begin();

foreach ( $list as $val )
{
	$CenterOrderModel->Update( $val['order_id'], array( 'sign_status' => 1, 'sign_time' => strtotime( $val['sign_time'] ) ) );
}

$CenterOrderModel->Model->DB->Commit();

Common::Loading( '?mod=order.check.sign' );

?>