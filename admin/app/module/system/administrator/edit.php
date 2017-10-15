<?php

$AdminModel = Core::ImportModel( 'Admin' );

$id= (int)$_GET['id'];

$userInfo = $AdminModel->GetAdministrator( $id );

if ( !$userInfo )
	Common::Alert( '没有找到相关数据' );

if ( !$_POST )
{
	$userGroupList = GetExplode( ',', $userInfo['user_group'] );
	
	$groupList = $AdminModel->GetAdministratorGroupList();

	foreach ( $groupList as $key => $val )
	{
		if ( in_array( $val['id'], $userGroupList ) )
			$groupList[$key]['selected'] = "selected";
	}



	
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
		if ( $val['user_id'] == $userInfo['user_product_1'] )
			$jl_list[$key]['selected'] = "selected";
		
		$user_real_name_1 = $AdminModel->GetAdministrator( $val['user_product'] );
		$jl_list[$key]['user_real_name_1'] = $user_real_name_1['user_real_name'];
	}
	$tpl['jl_list'] = $jl_list;

	
	
	$tpl['group_list'] = $groupList;
	$tpl['user'] = $userInfo;

	Common::PageOut( 'system/administrator/edit.html', $tpl );
}
else
{
	$time = time();

	$data = array();
	$data['user_real_name'] = htmlspecialchars( $_POST['user_real_name'] );
	$data['user_group'] = @implode( ',', $_POST['user_group'] );
	$data['user_update_time'] = $time;
	$data['user_product'] = $_POST['user_product'] ;
	$data['user_product_1'] = $_POST['user_product_1'] ;

	if ( !$data['user_real_name'] )
		Common::Alert( '请完整的填写资料' );

	if ( $_POST['user_password'] )
	{
		if ( $_POST['user_password'] != $_POST['user_password_confirm'] )
			Common::Alert( '两次输入的密码不一致' );

		$data['user_password'] = md5( $_POST['user_password'] );
	}


	$AdminModel->UpdateAdministrator( $id, $data );

	Redirect( "?mod=system.administrator" );
}

?>