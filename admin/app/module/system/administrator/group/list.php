<?php

$AdminModel = Core::ImportModel( 'Admin' );

$list = $AdminModel->GetAdministratorGroupList();

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['update_time'] = DateFormat( $val['update_time'] );
}

$tpl['list'] = $list;

Common::PageOut( 'system/administrator/group/list.html', $tpl );

?>