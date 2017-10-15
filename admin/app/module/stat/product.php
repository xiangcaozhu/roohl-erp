<?php

$ProductModel = Core::ImportModel( 'Product' );
$StatModel = Core::ImportModel( 'Stat' );


if ( $_POST )
{
	$beginTime = strtotime( $_POST['begin_date'] );
	$endTime = strtotime( $_POST['end_date'] );

	if ( !$beginTime || !$endTime )
		Common::Alert( '请输入统计时间段' );

	if ( !$_POST['pid'] )
		Common::Alert( '错误的产品ID' );

	$productInfo = $ProductModel->Get( $_POST['pid'] );

	if ( !$productInfo )
		Common::Alert( '错误的产品ID' );

	$tpl['product'] = $productInfo;

	$list = array();
	$time = $beginTime;
	while ( true )
	{
		$list[date( 'Ymd', $time )] = array();

		$time += 3600 * 24;

		if ( $time > $endTime )
			break;
	}

	$ipList = $StatModel->GetDetailStatByIp( $_POST['pid'], $_POST['begin_date'], $_POST['end_date'] );
	$viewList = $StatModel->GetDetailStatByView( $_POST['pid'], $_POST['begin_date'], $_POST['end_date'] );

	$xml = "<?xml version='1.0' encoding='UTF-8'?><chart>";

	$xmlLabel = '';
	$xmlIp = '';
	$xmlView = '';

	foreach ( $list as $date => $val )
	{
		$xmlLabel .= "<value xid='{$date}'>{$date}</value>";
		$xmlIp .= "<value xid='{$date}'>". intval( $ipList[$date]['total'] ) . "</value>";
		$xmlView .= "<value xid='{$date}'>" . intval( $viewList[$date]['total'] ) . "</value>";
	}

	$xml .= "<series>{$xmlLabel}</series>";
	$xml .= "<graphs>";
	$xml .= "<graph gid='1' title='IP'>{$xmlIp}</graph>";
	$xml .= "<graph gid='2' title='PV'>{$xmlView}</graph>";
	$xml .= "</graphs>";

	$xml .= "</chart>";

	$tpl['xml'] = $xml;
}

Common::PageOut( 'stat/product.html', $tpl );

?>