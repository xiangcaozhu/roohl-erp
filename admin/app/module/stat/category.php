<?php

$CategoryModel = Core::ImportModel( 'Category' );
$StatModel = Core::ImportModel( 'Stat' );

$categoryTree = $CategoryModel->BuildTree();

$categoryList = array();
$topCategoryList = array();
foreach ( $categoryTree as $key => $val )
{
	$categoryList[$val['pid']][] = $val;

	if ( !$val['pid'] )
		$topCategoryList[] = $val;
}

$tpl['category_list_js'] = PHP2JSON( $categoryList );
$tpl['top_category_list'] = $topCategoryList;

if ( $_POST )
{
	$beginTime = strtotime( $_POST['begin_date'] );
	$endTime = strtotime( $_POST['end_date'] );

	if ( !$beginTime || !$endTime )
		Common::Alert( '请输入统计时间段' );

	$list = array();
	$time = $beginTime;
	while ( true )
	{
		$list[date( 'Ymd', $time )] = array();

		$time += 3600 * 24;

		if ( $time > $endTime )
			break;
	}

	$ipList = $StatModel->GetTopCategoryStatByIp( $_POST['cid'], $_POST['begin_date'], $_POST['end_date'] );
	$viewList = $StatModel->GetTopCategoryStatByView( $_POST['cid'], $_POST['begin_date'], $_POST['end_date'] );

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

Common::PageOut( 'stat/category.html', $tpl );

?>