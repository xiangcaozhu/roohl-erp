<?php

$AdminModel = Core::ImportModel( 'Admin' );

$id= (int)$_GET['id'];

$groupInfo = $AdminModel->GetAdministratorGroup( $id );

if ( !$groupInfo )
	Common::Alert( 'û���ҵ��������' );

$AdminModel->DelAdministratorGroup( $id );

Redirect( "?mod=system.administrator.group.list" );

?>