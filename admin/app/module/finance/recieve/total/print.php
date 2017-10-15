<?php

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );


$channelParentId = (int)$_GET['channel_parent_id'];
$endTime = $_GET['end_date'] ? strtotime( $_GET['end_date'].' 23:59:59' ) : time();
$beginTime = $_GET['begin_date'] ? strtotime( $_GET['begin_date'].' 00:00:00' ) : $endTime - 86400;

$list = $CenterOrderModel->GetFinanceRecieveTotalReport( $channelParentId, $beginTime, $endTime );


$tpl['list'] = $list;
$tpl['begin_date'] = $_GET['begin_date'];
$tpl['end_date'] = $_GET['end_date'];
$tpl['creator'] = $__UserAuth['user_real_name'];
$tpl['current_time'] = DateFormat( time() );

Common::PageOut( 'finance/recieve/total/print.html', $tpl, false, false );

exit();

?>