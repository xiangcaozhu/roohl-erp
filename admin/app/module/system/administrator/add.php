<?php

$AdminModel = Core::ImportModel( 'Admin' );

if ( !$_POST )
{
	$groupList = $AdminModel->GetAdministratorGroupList();


	$zj_list = $AdminModel->GetAdministratorListcp();
	foreach ( $zj_list as $key => $val )
	{
		if ( $val['user_id'] == $userInfo['user_product'] )
			$zj_list[$key]['selected'] = "selected";
	}
	$tpl['zj_list'] = $zj_list;



	$jl_list = $AdminModel->GetAdministratorListcp_1();
	foreach ( $jl_list as $key => $val )
	{
		if ( $val['user_id'] == $userInfo['user_product'] )
			$jl_list[$key]['selected'] = "selected";
		
		$user_real_name_1 = $AdminModel->GetAdministrator( $val['user_product'] );
		$jl_list[$key]['user_real_name_1'] = $user_real_name_1['user_real_name'];
	}
	$tpl['jl_list'] = $jl_list;




	$tpl['group_list'] = $groupList;

	Common::PageOut( 'system/administrator/add.html', $tpl );
}
else
{
	$time = time();

	$data = array();
	$data['user_name'] = htmlspecialchars( $_POST['user_name'] );
	$data['user_real_name'] = htmlspecialchars( $_POST['user_real_name'] );
	$data['user_password'] = md5( $_POST['user_password'] );
	$data['user_group'] = @implode( ',', $_POST['user_group'] );
	$data['user_add_time'] = $time;
	$data['user_update_time'] = $time;
	$data['user_login_time'] = $time;
	$data['user_login_ip'] = 0;
	$data['user_product'] = $_POST['user_product'] ;
	$data['user_product_1'] = $_POST['user_product_1'] ;

	if ( $AdminModel->GetAdministratorByName( $data['user_name'] ) )
		Common::Alert( '用户名已经存在了' );

	if ( !$data['user_name'] || !$data['user_real_name'] || !$data['user_password'] )
		Common::Alert( '请完整的填写资料' );

	if ( $_POST['user_password'] != $_POST['user_password_confirm'] )
		Common::Alert( '两次输入的密码不一致' );

	$AdminModel->AddAdministrator( $data );

	Redirect( "?mod=system.administrator" );
}

?>