<?php
/*
@@acc_title="导入订单物流费 freight"
*/
Core::LoadFunction( 'ImportOrderInfo.inc.php' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

if ( !$_POST )
{
	$tpl['check'] = true;
	Common::PageOut( 'delivery/freight.html', $tpl );
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

	$list = ImportShippingCost( $saveFile );

	foreach ( $list as $key => $val )
	{
		$order = $CenterOrderModel->Getcost( $val['logistics_sn'] );

		if ( !$order )
			$list[$key]['notexist'] = true;

		if ( $order['order_shipping_cost'] > 0 )
			$list[$key]['error'] = true;
		
		$list[$key]['order'] = $order;
	}

	$tpl['list'] = $list;
	$tpl['file_name'] = $fileName;
	Common::PageOut( 'delivery/freight/check.html', $tpl );
}

?>