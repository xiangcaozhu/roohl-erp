<?php

$userId = intval( $_GET['user_id'] );

$GiftModel = Core::ImportModel( 'Gift' );
$UserModel = Core::ImportModel( 'User' );

$userInfo = $UserModel->GetUserInfo( $userId );

$tpl['user'] = $userInfo;

if ( !$userInfo )
	Common::Alert( '没有找到相关数据' );

$logList = $UserModel->GetPointLogList( $userId );

foreach( $logList as $key => $val )
{
	$logList[$key]['add_time'] = DateFormat( $val['add_time'] );
}

$tpl['log_list'] = $logList;
$tpl['total'] = count( $logList );

Common::PageOut( 'user/point.html', $tpl );

?>