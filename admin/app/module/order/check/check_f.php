<?php
/*
@@acc_title="财务批量确认 check_f"
*/
Core::LoadFunction( 'ImportOrderInfo.inc.php' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelParentModel = Core::ImportModel( 'CenterChannelParent' );

$tpl['channel_parent_list'] = $CenterChannelParentModel->GetList();

if ( !$_POST )
{
	$tpl['check'] = true;
	Common::PageOut( 'order/check/import/upload_f.html', $tpl );
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

	$list = ImportFinanceRecieveTime( $saveFile );

	foreach ( $list as $key => $val )
	{
		$order = $CenterOrderModel->GetUniqueByChannelParent( $_POST['channel_parent_id'], $val['target_id'] );

		$list[$key]['order_id'] = $order['order_id'];
		$list[$key]['channel_name'] = $order['name'];

		if ( !$order )
			$list[$key]['notexist'] = true;

		if ( $order['finance_recieve'] == 1 )
			$list[$key]['error'] = DateFormat( $order['finance_recieve_time'] );
	}

	$tpl['list'] = $list;
	$tpl['file_name'] = $fileName;

	Common::PageOut( 'order/check/import/check_f.html', $tpl );
}

?>