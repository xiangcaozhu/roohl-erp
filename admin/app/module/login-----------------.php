<?php
/*
@@acc_free
@@acc_title="登陆"

*/

if ( !$_POST )
{
	Common::PageOut( 'login.html', $tpl, false, false );
}
else
{
	$AdminModel = Core::ImportModel( 'Admin' );

	if ( !$_POST['name'] || !$_POST['password'] )
		Common::Alert( '用户名,密码为必填项' );

	$userInfo = $AdminModel->GetAdministratorByName( $_POST['name'] );

	if ( $userInfo['user_password'] != md5( $_POST['password'] ) )
		Common::Alert( '密码错误' );

	$ClientAuth = & Core::ImportBaseClass( 'ClientAuth' );
	$ClientAuth->SetAuthData( array(
		'user_id' =>$userInfo['user_id'],
		'user_name' => $userInfo['user_name'], 
		'user_real_name' => $userInfo['user_real_name'], 
		'user_group' => $userInfo['user_group']
	) );

	$data = array();
	$data['user_login_time'] = time();
	$data['user_login_ip'] = ip2long( GetUserIp() );

	$AdminModel->UpdateAdministrator( $userInfo['user_id'], $data );

	Redirect( '?' );
}

exit();


?>