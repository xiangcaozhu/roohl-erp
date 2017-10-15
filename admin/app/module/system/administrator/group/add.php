<?php

if ( !$_POST )
{
	Core::LoadClass( 'ModuleControl' );
	Core::LoadClass( 'AccessControl' );

	$ModuleControl = new ModuleControl( Core::GetConfig( 'config_path' ) . 'module.xml', Core::GetConfig( 'config_path' ) . 'module.php', array() );
	$ModuleControl->Load();

	$AccessControl = new AccessControl();
	$AccessControl->SetAllow( array() );
	$AccessControl->SetModule( $ModuleControl->GetModule() );

	$tpl['tree_script'] = $ModuleControl->GetMenuScript();

	Common::PageOut( 'system/administrator/group/add.html', $tpl );
}
else
{
	$AdminModel = Core::ImportModel( 'Admin' );

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
	$data['add_time'] = $time;
	$data['update_time'] = $time;
	$data['allow'] = @implode( ',', $allow );

	$AdminModel->AddAdministratorGroup( $data );

	Redirect( "?mod=system.administrator.group.list" );
}

?>