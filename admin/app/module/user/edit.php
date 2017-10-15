<?php

$UserModel = Core::ImportModel( 'User' );

$id= (int)$_GET['id'];

$userInfo = $UserModel->GetUserInfo( $id );

if ( !$userInfo )
	Common::Alert( '没有找到相关数据' );

if ( !$_POST )
{
	$tpl['user'] = $userInfo;

	Common::PageOut( 'user/edit.html', $tpl );
}
else
{
	$time = time();

	$data = array();
	$data['user_email'] = htmlspecialchars( $_POST['user_email'] );
	$data['user_point'] = intval( $_POST['user_point'] );
	$data['user_is_vip'] = intval( $_POST['user_is_vip'] );

	if( !IsEmail( $_POST['user_email'] ) )
		Common::Alert( '邮箱格式错误' );

	if ( !$data['user_email'] )
		Common::Alert( '请填写邮箱' );

	if ( $data['user_email'] != $userInfo['user_email'] )
	{
		if ( $UserModel->GetUserInfoByEmail( trim( $data['user_email'] ) ) )
			Common::Alert( "您填写的Email已经被占用了" );
	}

	$UserModel->UpdateUserInfo( $id, $data );

	if ( $data['user_point'] != $userInfo['user_point'] )
	{
		$logData = array();
		$logData['user_id'] = $userInfo['user_id'];
		$logData['add_time'] = $time;

		if ( $data['user_point'] >$userInfo['user_point']  )
		{
			$logData['type'] = 3;
			$logData['point'] = $data['user_point'] - $userInfo['user_point'];
		}
		else
		{
			$logData['type'] = 4;
			$logData['point'] = $userInfo['user_point'] - $data['user_point'];
		}

		$logData['object_id'] = 0;
		$logData['title'] = '';

		$UserModel->AddPointLog( $logData );
	}

	if ( $_POST['user_password'] )
	{
		$data = array();

		if ( $_POST['user_password'] != $_POST['user_password_confirm'] )
			Common::Alert( '两次输入的密码不一致' );

		$data['user_password'] = md5( $_POST['user_password'] );

		$UserModel->UpdateUserBase( $id, $data );
	}

	Redirect( "?mod=user.list" );
}

?>