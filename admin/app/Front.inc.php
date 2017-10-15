<?php

/******** 控制器 ********/
class FrontController extends Controller
{
	// 重载了 Controller 的 BeforeRun 方法
	function BeforeRun()
	{
		global $quoteData, $AccessControl, $__GroupSession;

		$firstModule = current( GetExplode( '.', $this->module ) );

		$freeModule = array( 'login', 'tool.upload', 'product.upload.image', 'product.attribute.upload' );

		if ( !$firstModule )
		{
			Redirect( '?mod=index' );
		}

		$inAccess = $AccessControl->InModule( $this->module, $this->action );

		$session = Common::GetSession();

		if ( !$session && $inAccess )
		{
			Redirect( '?mod=login' );
		}

		$AdminModel = Core::ImportModel( 'Admin' );

		$adminInfo = $AdminModel->GetAdministrator( $session['user_id'] );

		//if ( !$adminInfo && !in_array( $this->module, $freeModule ) )
		if ( !$adminInfo && $inAccess )
		{
			Redirect( '?mod=login' );
		}

		$userGroup = $adminInfo['user_group'];

		$groupInfo = $AdminModel->GetAdministratorGroup( $userGroup );

		if ( !$groupInfo && $inAccess )
			Common::ALert( '尚未加入管理组' );

		$__GroupSession = $groupInfo;

		$AccessControl->SetAllow( explode( ',', $groupInfo['allow'] ) );

		if ( !$AccessControl->ToTest( $this->module, $this->action ) )
		{
			if ( $session )
			{
				header( "Content-Type:text/html; charset=utf-8" );
				exit( '权限不足,不允许访问' );
			}
			else
			{
				Redirect( '?mod=login' );
			}
		}
	}
}

?>