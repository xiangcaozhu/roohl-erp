<?php

$AdminModel = Core::ImportModel( 'Admin' );

$id= (int)$_GET['id'];

$groupInfo = $AdminModel->GetAdministratorGroup( $id );

if ( !$groupInfo )
	Common::Alert( '没有找到相关数据' );

$AdminModel->DelAdministratorGroup( $id );

Redirect( "?mod=system.administrator.group.list" );

?>