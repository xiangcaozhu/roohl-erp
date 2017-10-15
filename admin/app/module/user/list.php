<?php

include( Core::Block( 'user' ) );

$UserModel = Core::ImportModel( 'User' );

$page = (int)$_GET['page'];
$page = $page >=1 ? $page : 1;

$onePage = 20;
if ( $_GET['opnum'] )
	$onePage = $_GET['opnum'];

$offset = ( $page - 1 ) * $onePage;


if ( $_GET['user_type'] == 1 )
	$conditionExt = "user_is_vip <> 1 OR user_is_vip is  null";
elseif ( $_GET['user_type'] == 2 )
	$conditionExt = "user_is_vip = 1";

if ( $_GET['csv'] )
{
	$list = $UserModel->GetUserInfoList( 0, 0, array(), $conditionExt );
	ExportUser( $list );
	exit();
}


$userList = $UserModel->GetUserInfoList( $offset, $onePage, array(), $conditionExt );

foreach ( $userList as $key => $val )
{
	$userList[$key]['user_login_time'] = DateFormat( $val['user_login_time'] );
	$userList[$key]['user_reg_ip'] = long2ip( $val['user_reg_ip'] );
	$userList[$key]['user_login_ip'] = long2ip( $val['user_login_ip'] );
}

$total = $UserModel->GetUserBaseTotal();
$tpl['user_list'] = $userList;
$tpl['total'] = $total;
$tpl['page'] = $page;
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );


parse_str( $_SERVER['QUERY_STRING'], $q );
unset( $q['opnum'] );
$tpl['base_uri'] = http_build_query( $q );

Common::PageOut( 'user/list.html', $tpl );
?>