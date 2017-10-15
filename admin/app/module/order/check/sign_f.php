<?php
/*
@@acc_title="订单批量签收 sign_f"
*/
Core::LoadFunction( 'ImportOrderInfo.inc.php' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

if ( !$_POST )
{
	$tpl['check'] = true;
	Common::PageOut( 'order/check/import/upload.html', $tpl );
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

	$list = ImportSignTime( $saveFile );

	foreach ( $list as $key => $val )
	{
		$order = $CenterOrderModel->Get( $val['order_id'] );

		if ( !$order )
			$list[$key]['notexist'] = true;

		if ( $order['sign_status'] == 1 )
			$list[$key]['error'] = DateFormat( $order['sign_time'] + 8 * 3600 );
	}

	$tpl['list'] = $list;
	$tpl['file_name'] = $fileName;
	Common::PageOut( 'order/check/import/check.html', $tpl );
}

?>