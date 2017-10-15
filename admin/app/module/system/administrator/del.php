<?php

$AdminModel = Core::ImportModel( 'Admin' );

$id= (int)$_GET['id'];

$userInfo = $AdminModel->GetAdministrator( $id );

if ( !$userInfo )
	Common::Alert( '没有找到相关数据' );

$AdminModel->DelAdministrator( $id );

Redirect( );


?>