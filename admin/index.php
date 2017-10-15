<?php
error_reporting( E_ALL ^ E_NOTICE );
function microtime_float()
{
	list( $usec, $sec ) = explode( " ", microtime() );
	return ( (float)$usec + (float)$sec );
}

$debugBeginTime = microtime_float();


/******** Config ********/
$__Config = array();
include( './site.php' );
include( '../config/config.php' );
include( './config/config.php' );
include( './config/menu.config.php' );


/******** Core File ********/
include( $__Config['core_path'] . "Core.class.php" );
include( $__Config['core_path'] . "Controller.class.php" );
include( $__Config['core_path'] . "BaseCommon.class.php" );

/******** Common file ********/
include( $__Config['app_path'] . "Common.class.php" );


/******** ���뺯��� ********/
Core::LoadFunction( 'function.inc.php' );


/******** ǰ�� ********/
include( $__Config['app_path'] . 'Front.inc.php' );


/******** ȥ������ ********/
if ( function_exists( 'get_magic_quotes_gpc' ) && get_magic_quotes_gpc() )
{
	$_GET = RemoveQuotes( $_GET );
	$_POST = RemoveQuotes( $_POST );
	$_COOKIE = RemoveQuotes( $_COOKIE );
	$_REQUEST = RemoveQuotes( $_REQUEST );
}

Core::LoadClass( 'AccessControl' );
Core::LoadClass( 'ModuleControl' );

$ModuleControl = new ModuleControl( Core::GetConfig( 'config_path' ) . 'module.xml', Core::GetConfig( 'config_path' ) . 'module.php', array() );
$ModuleControl->Load();

$AccessControl = new AccessControl();
$AccessControl->SetAllow( array() );
$AccessControl->SetModule( $ModuleControl->GetModule() );

/******** ********/

$__UserAuth = Common::GetSession();

$AdminModel = Core::ImportModel( 'Admin' );
$adminInfo = $AdminModel->GetAdministrator( $__UserAuth['user_id'] );
$__UserAuth['user_group'] = $adminInfo['user_group'];
$__UserAuth['user_call'] = $adminInfo['user_call'];

$quoteData = array();
$quoteData['__UserAuth'] = $__UserAuth;
$quoteData['__Session'] = $__UserAuth;
$quoteData['AccessControl'] = $AccessControl;
$quoteData['tpl']['SITE_URL'] = SITE_URL;
$quoteData['tpl']['session'] = Common::GetSession();

/******** Run ********/
$Controller = new FrontController( Core::GetConfig( 'app_module_path' ) );
$Controller->Run( $quoteData );

$debugEndTime = microtime_float();

$time = $debugEndTime - $debugBeginTime;
?>