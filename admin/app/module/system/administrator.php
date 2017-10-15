<?php
/*
@@acc_title="系统帐号管理 administrator"
*/
$AdminModel = Core::ImportModel( 'Admin' );

$list = $AdminModel->GetAdministratorList();
$groupList = $AdminModel->GetAdministratorGroupList();

$groupList = ArrayIndex( $groupList, 'id' );

foreach ( $list as $key => $val )
{
	$list[$key]['user_add_time'] = DateFormat( $val['user_add_time'] );
	$list[$key]['user_update_time'] = DateFormat( $val['user_update_time'] );
	$list[$key]['user_login_time'] = DateFormat( $val['user_login_time'] );
	$list[$key]['user_login_ip'] = long2ip( $val['user_login_ip'] );

	$list[$key]['user_group'] = $groupList[$val['user_group']];
}


$tpl['list'] = $list;

Common::PageOut( 'system/administrator/list.html', $tpl );

?>