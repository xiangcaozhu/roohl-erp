<?php

$AdminModel = Core::ImportModel( 'Admin' );

$id= (int)$_GET['id'];

$groupInfo = $AdminModel->GetAdministratorGroup( $id );

if ( !$groupInfo )
	Common::Alert( '没有找到相关数据' );

if ( !$_POST )
{
	Core::LoadClass( 'ModuleControl' );
	Core::LoadClass( 'AccessControl' );

	$ModuleControl = new ModuleControl( Core::GetConfig( 'config_path' ) . 'module.xml', Core::GetConfig( 'config_path' ) . 'module.php', array() );

	// rewrite XML
	$ModuleControl->BuileFolder( Core::GetConfig( 'app_module_path' ) );

	$ModuleControl->Load();

	$AccessControl = new AccessControl();
	$AccessControl->SetAllow( array() );
	$AccessControl->SetModule( $ModuleControl->GetModule() );

	$tpl['tree_script'] = $ModuleControl->GetMenuScript();

	$tpl['group'] = $groupInfo;

	Common::PageOut( 'system/administrator/group/edit.html', $tpl );
}
else
{
	$allow = array();
	foreach ( $_POST as $key => $val )
	{
		if ( substr( $key, 0, 7 ) == 'module_' )
		{
			$allow[] = $val;
		}
	}

	$time = time();

	$data = array();
	$data['name'] = htmlspecialchars( $_POST['name'] );
	$data['update_time'] = $time;
	$data['allow'] = @implode( ',', $allow );

	$AdminModel->UpdateAdministratorGroup( $id, $data );

	Redirect( "?mod=system.administrator.group.list" );
}

?>