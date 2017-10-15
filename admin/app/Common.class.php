<?php

class Common extends BaseCommon
{
	function PageCode( $tplPath, $tplVar = array() )
	{
		$Template = Core::ImportBaseClass( "Template" );

		$templateRoot = Core::GetConfig( 'template_path' );

		$Template->ST( $templateRoot . $tplPath );
		$Template->SV( $tplVar );

		return $Template->RS();
	}
	
	function PageOut( $tplPath, $tplVar = array(), $parentTpl = array(), $parent = 'main' )
	{
		global $AccessControl;

		$menuConfigList = Core::GetConfig( 'menu_list' );
				
		$menuConfigListCopy = $menuConfigList;

		$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
		$warehouseList = $CenterWarehouseModel->GetList();

		foreach ( $menuConfigListCopy as $key1 => $item1 )
		{
			if ( is_array( $item1['sub'] ) )
			{
				foreach ( $item1['sub'] as $key2 => $item2 )
				{
					if ( is_array( $item2['sub'] ) )
					{
						foreach ( $item2['sub'] as $key3 => $item3 )
						{
							
							if ( !is_array( $item3['sub'] ) && $item3['warehouse'] )
							{
								foreach ( $warehouseList as $warehouse )
								{
									$menuConfigList[$key1]['sub'][$key2]['sub'][$key3]['sub'][] = array(
										'name' => $warehouse['name'],
										'path' => "{$item3['path']}&warehouse_id={$warehouse['id']}",
									);
								}
							}
							
						}
					}
					else
					{
						if ( $item2['warehouse'] )  
						{
							if(($item2['path'] != 'delivery.import') && ($item2['path'] != 'delivery.freight'))
							{
							foreach ( $warehouseList as $warehouse )
							{
								$menuConfigList[$key1]['sub'][$key2]['sub'][] = array(
									'name' => $warehouse['name'],
									'path' => "{$item2['path']}&warehouse_id={$warehouse['id']}",
								);
							}
							}
							
						}
					}
				}				
			}
			else
			{
				if ( $item1['warehouse'] )
				{
					foreach ( $warehouseList as $warehouse )
					{
						$menuConfigList[$key1]['sub'][] = array(
							'name' => $warehouse['name'],
							'path' => "{$item1['path']}&warehouse_id={$warehouse['id']}",
						);
					}
				}
			}
		}

		$menuConfigListCopy = $menuConfigList;


		foreach ( $menuConfigListCopy as $key1 => $item1 )
		{
			if ( is_array( $item1['sub'] ) )
			{
				foreach ( $item1['sub'] as $key2 => $item2 )
				{
					if ( is_array( $item2['sub'] ) )
					{
						foreach ( $item2['sub'] as $key3 => $item3 )
						{
							if ( is_array( $item3['sub'] ) )
							{
								foreach ( $item3['sub'] as $key4 => $item4 )
								{
									if ( !$AccessControl->ToTest( current( explode( '&', $item4['path'] ) ), $q['act'] ) )
										unset( $menuConfigList[$key1]['sub'][$key2]['sub'][$key3]['sub'][$key4] );

									if ( count( $menuConfigList[$key1]['sub'][$key2]['sub'][$key3]['sub'] ) == 0 )
									{
										unset( $menuConfigList[$key1]['sub'][$key2]['sub'][$key3] );
									}
									else
									{
										$endKey = end( array_keys( $menuConfigList[$key1]['sub'][$key2]['sub'][$key3]['sub'] ) );
										$menuConfigList[$key1]['sub'][$key2]['sub'][$key3]['sub'][$endKey]['end'] = 1;
									}
								}
							}
							else
							{
								if ( !$AccessControl->ToTest( current( explode( '&', $item3['path'] ) ), $q['act'] ) )
									unset( $menuConfigList[$key1]['sub'][$key2]['sub'][$key3] );
							}
						}

						if ( count( $menuConfigList[$key1]['sub'][$key2]['sub'] ) == 0 )
						{
							unset( $menuConfigList[$key1]['sub'][$key2] );
						}
						else
						{
							$endKey = end( array_keys( $menuConfigList[$key1]['sub'][$key2]['sub'] ) );
							$menuConfigList[$key1]['sub'][$key2]['sub'][$endKey]['end'] = 1;
						}
					}
					else
					{
						if ( !$AccessControl->ToTest( current( explode( '&', $item2['path'] ) ), $q['act'] ) )
							unset( $menuConfigList[$key1]['sub'][$key2] );
					}
				}

				if ( count( $menuConfigList[$key1]['sub'] ) == 0 )
				{
					unset( $menuConfigList[$key1] );
				}
				else
				{
					$endKey = end( array_keys( $menuConfigList[$key1]['sub'] ) );
					$menuConfigList[$key1]['sub'][$endKey]['end'] = 1;	
				}
			}
		}

		$Template = Core::ImportBaseClass( "Template" );

		$templateRoot = Core::GetConfig( 'template_path' );

		$Template->ST( $templateRoot . $tplPath );
		$Template->SV( $tplVar );

		if ( $parent )
		{
			$loginInfo = Common::IsLogin();

			$result = $Template->RS();
			$Template->ST( $templateRoot . $parent . ".html" );
			$Template->SV( $parentTpl );
			$Template->SV( 'module', $result );
			$Template->SV( 'menu_list', $menuConfigList );
			$Template->SV( '_GET', $_GET );
			$Template->SV( 'is_login', $loginInfo ? 1 : 0 );
			$Template->SV( 'login_user_name', $loginInfo['user_name'] );
			$Template->OP();
		}
		else
		{
			$Template->OP();
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function PageOutNew( $tplPath, $tplVar = array(), $parentTpl = array(), $parent = 'xiaofw' )
	{
		global $AccessControl;

		$menuConfigList = Core::GetConfig( 'menu_list' );
				
		$menuConfigListCopy = $menuConfigList;

		$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
		$warehouseList = $CenterWarehouseModel->GetList();

		foreach ( $menuConfigListCopy as $key1 => $item1 )
		{
			if ( is_array( $item1['sub'] ) )
			{
				foreach ( $item1['sub'] as $key2 => $item2 )
				{
					if ( is_array( $item2['sub'] ) )
					{
						foreach ( $item2['sub'] as $key3 => $item3 )
						{
							
							if ( !is_array( $item3['sub'] ) && $item3['warehouse'] )
							{
								foreach ( $warehouseList as $warehouse )
								{
									$menuConfigList[$key1]['sub'][$key2]['sub'][$key3]['sub'][] = array(
										'name' => $warehouse['name'],
										'path' => "{$item3['path']}&warehouse_id={$warehouse['id']}",
									);
								}
							}
							
						}
					}
					else
					{
						if ( $item2['warehouse'] )  
						{
							if(($item2['path'] != 'delivery.import') && ($item2['path'] != 'delivery.freight'))
							{
							foreach ( $warehouseList as $warehouse )
							{
								$menuConfigList[$key1]['sub'][$key2]['sub'][] = array(
									'name' => $warehouse['name'],
									'path' => "{$item2['path']}&warehouse_id={$warehouse['id']}",
								);
							}
							}
							
						}
					}
				}				
			}
			else
			{
				if ( $item1['warehouse'] )
				{
					foreach ( $warehouseList as $warehouse )
					{
						$menuConfigList[$key1]['sub'][] = array(
							'name' => $warehouse['name'],
							'path' => "{$item1['path']}&warehouse_id={$warehouse['id']}",
						);
					}
				}
			}
		}

		$menuConfigListCopy = $menuConfigList;


		foreach ( $menuConfigListCopy as $key1 => $item1 )
		{
			if ( is_array( $item1['sub'] ) )
			{
				foreach ( $item1['sub'] as $key2 => $item2 )
				{
					if ( is_array( $item2['sub'] ) )
					{
						foreach ( $item2['sub'] as $key3 => $item3 )
						{
							if ( is_array( $item3['sub'] ) )
							{
								foreach ( $item3['sub'] as $key4 => $item4 )
								{
									if ( !$AccessControl->ToTest( current( explode( '&', $item4['path'] ) ), $q['act'] ) )
										unset( $menuConfigList[$key1]['sub'][$key2]['sub'][$key3]['sub'][$key4] );

									if ( count( $menuConfigList[$key1]['sub'][$key2]['sub'][$key3]['sub'] ) == 0 )
									{
										unset( $menuConfigList[$key1]['sub'][$key2]['sub'][$key3] );
									}
									else
									{
										$endKey = end( array_keys( $menuConfigList[$key1]['sub'][$key2]['sub'][$key3]['sub'] ) );
										$menuConfigList[$key1]['sub'][$key2]['sub'][$key3]['sub'][$endKey]['end'] = 1;
									}
								}
							}
							else
							{
								if ( !$AccessControl->ToTest( current( explode( '&', $item3['path'] ) ), $q['act'] ) )
									unset( $menuConfigList[$key1]['sub'][$key2]['sub'][$key3] );
							}
						}

						if ( count( $menuConfigList[$key1]['sub'][$key2]['sub'] ) == 0 )
						{
							unset( $menuConfigList[$key1]['sub'][$key2] );
						}
						else
						{
							$endKey = end( array_keys( $menuConfigList[$key1]['sub'][$key2]['sub'] ) );
							$menuConfigList[$key1]['sub'][$key2]['sub'][$endKey]['end'] = 1;
						}
					}
					else
					{
						if ( !$AccessControl->ToTest( current( explode( '&', $item2['path'] ) ), $q['act'] ) )
							unset( $menuConfigList[$key1]['sub'][$key2] );
					}
				}

				if ( count( $menuConfigList[$key1]['sub'] ) == 0 )
				{
					unset( $menuConfigList[$key1] );
				}
				else
				{
					$endKey = end( array_keys( $menuConfigList[$key1]['sub'] ) );
					$menuConfigList[$key1]['sub'][$endKey]['end'] = 1;	
				}
			}
		}

		$Template = Core::ImportBaseClass( "Template" );

		$templateRoot = Core::GetConfig( 'template_path' );

		$Template->ST( $templateRoot . $tplPath );
		$Template->SV( $tplVar );

		if ( $parent )
		{
			$loginInfo = Common::IsLogin();


			$result = $Template->RS();
			$Template->ST( $templateRoot . $parent . ".html" );
			$Template->SV( $parentTpl );
			$Template->SV( 'module', $result );
			$Template->SV( 'menu_list', $menuConfigList );
			$Template->SV( '_GET', $_GET );
			$Template->SV( 'is_login', $loginInfo ? 1 : 0 );
			$Template->SV( 'login_user_name', $loginInfo['user_name'] );
			$Template->OP();
		}
		else
		{
			$Template->OP();
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function GetCurrency()
	{
		global $__GlobalVar;

		if ( $__GlobalVar['currency'] )
			return $__GlobalVar['currency'];
		

		$code = Core::GetConfig( 'currency_default' );

		$ShopCurrencyModel = Core::ImportModel( 'ShopCurrency' );

		$info = $ShopCurrencyModel->Get( $code );

		$__GlobalVar['currency'] = $info;

		return $info;
	}

	function Error( $title = '', $content = '' )
	{
		Alert( $title );

		exit;
		
		$tpl['content'] = $content;
		$tpl['title'] = $title;

		Common::PageOut( 'error.html', $tpl );

		exit();
	}

	function PageNotFound()
	{
		echo "<style>*{font-size:12px;font-family:tahoma,\"Lucida Grande\",\"Lucida Sans\",sans,Hei;}</style>";
		echo "<center>模块错误<br />URL:{$_SERVER['REQUEST_URI']}</center>";
		//header("HTTP/1.0 404 Not Found");
		exit();
	}

	function Alert( $msg )
	{
		Alert( $msg );
	}

	function Loading( $url = '', $msg = '操作成功', $title = 'loading...',  $waitTimes = 1 )
	{
		$url = !$url ? $_SERVER['HTTP_REFERER'] : $url;

		$tpl['title'] = $title;
		$tpl['msg'] = $msg;

		header( "refresh:{$waitTimes};url={$url}" );

		Common::PageOut( 'loading.html', $tpl );
		exit();
	}

	function Login( $name, $password, $save = false )
	{
		$ClientAuth = Core::ImportBaseClass( 'ClientAuth' );
		$UserModel = Core::ImportModel( 'User' );

		$userInfo = $UserModel->GetByName( $name );

		if ( !$userInfo )
			return false;
		if ( $userInfo['password'] != md5( $password ) )
			return false;
		if ( $userInfo['user_name'] != $name )
			return false;

		$ClientAuth->SetAuthData( array( 'user_name' => $userInfo['user_name'], 'user_name' => $userInfo['user_name'], 'user_id' =>$userInfo['id'], 'group' => 0 ) );

		return true;
	}

	function Logout()
	{
		$ClientAuth = Core::ImportBaseClass( 'ClientAuth' );
		$UserModel = Core::ImportModel( 'User' );

		$ClientAuth->CleanAuth();

		return true;
	}

	function IsLogin()
	{
		$ClientAuth = Core::ImportBaseClass( 'ClientAuth' );

		if ( !$ClientAuth->CheckAuth() )
			return false;

		$GLOBALS['__Session'] = $ClientAuth->GetAuthData();

		return $GLOBALS['__Session'];
	}

	function GoToLogin()
	{
		if ( !Common::IsLogin() )
		{
			Redirect( '/login?redirect=' . urlencode( $_SERVER['REQUEST_URI'] ) );
			exit();
		}
	}

	function GetSession()
	{
		if ( $GLOBALS['__Session'] )
			return $GLOBALS['__Session'];
		else
			return Common::IsLogin();
	}

/******** 分页 ********/
	function PageBar( $total, $onePage, $page, $base = '', $query = '', $offset = 5 )
	{		
		if ( !$base )
		{
			$base = $_SERVER['PHP_SELF'];
			$query = $_SERVER['QUERY_STRING'];
		}
		
		$totalPage = ceil( $total / $onePage );
		$linkArray = explode( "page=", $query );
		$linkArg = $linkArray[0];

		if ( $linkArg == '' )
		{
			$url = $base . "?";
		}
		else
		{
			$linkArg	= substr( $linkArg, -1 ) == "&" ? $linkArg : $linkArg . '&';
			$url		= $base . '?' . $linkArg;
		}

		if ( !$totalPage )
			$totalPage = 1;

		if ( $page > $totalPage || !$page )
			$page = 1;

		$mid		= floor( $offset / 2 );
		$last		= $offset - 1;
		$minPage	= ( $page - $mid ) < 1 ? 1 : $page - $mid;
		$maxPage	= $minPage + $last;

		if ( $maxPage > $totalPage )
		{
			$maxPage	= $totalPage;
			$minPage	= $maxPage - $last;
			$minPage	= $minPage < 1 ? 1 : $minPage;
		}

		if ( $page != 1 )
		{
			$prePage = $page - 1;
			$prePageBar = "<a href='{$url}page={$prePage}' class='page-pre'>上一页</a> ";
			$firstPageBar = "<a href='{$url}page=1' class='page-fast'>首页</a> ";
		}

		for ( $i = $minPage; $i <= $maxPage; $i++ )
		{
			if ( $i == $page )
				$numPageBar .= "<b class='cur'>{$i}</b> ";
			else
				$numPageBar .= "<a href='{$url}page=$i'>{$i}</a> ";
		}

		if ( $page < $totalPage )
		{
			$nextPage = $page + 1;
			$nextPageBar = "<a href='{$url}page={$nextPage}' class='page-next'>下一页</a> ";
			$lastPageBar = "<a href='{$url}page={$totalPage}' class='page-lost'>尾页</a> ";
		}

		return $firstPageBar . $prePageBar . $numPageBar . $nextPageBar . $lastPageBar;
	}
/******** 分页 ********/
	function PageBar_a( $total, $onePage, $page, $base = '', $query = '', $offset = 5 )
	{		
		if ( !$base )
		{
			$base = $_SERVER['PHP_SELF'];
			$query = $_SERVER['QUERY_STRING'];
		}
		
		$totalPage = ceil( $total / $onePage );
		$linkArray = explode( "page=", $query );
		$linkArg = $linkArray[0];

		if ( $linkArg == '' )
		{
			$url = $base . "?";
		}
		else
		{
			$linkArg	= substr( $linkArg, -1 ) == "&" ? $linkArg : $linkArg . '&';
			$url		= $base . '?' . $linkArg;
		}

		if ( !$totalPage )
			$totalPage = 1;

		if ( $page > $totalPage || !$page )
			$page = 1;

		$mid		= floor( $offset / 2 );
		$last		= $offset - 1;
		$minPage	= ( $page - $mid ) < 1 ? 1 : $page - $mid;
		$maxPage	= $minPage + $last;

		if ( $maxPage > $totalPage )
		{
			$maxPage	= $totalPage;
			$minPage	= $maxPage - $last;
			$minPage	= $minPage < 1 ? 1 : $minPage;
		}

		//if ( $page != 1 )
		//{
			$prePage = $page - 1;
			$prePageBar = "<a href='{$url}page={$prePage}' class='page-pre'><<</a>　";
			$firstPageBar = "<a href='{$url}page=1' class='page-fast'>首页</a>　";
		//}

		//for ( $i = $minPage; $i <= $maxPage; $i++ )
		//{
		//	if ( $i == $page )
		//		$numPageBar .= "<b class='cur'>{$i}</b> ";
		//	else
		//		$numPageBar .= "<a href='{$url}page=$i'>{$i}</a> ";
	//	}

		//if ( $page < $totalPage )
		//{
			$nextPage = $page + 1;
			$nextPageBar = "<a href='{$url}page={$nextPage}' class='page-next'>>></a>　";
			$lastPageBar = "<a href='{$url}page={$totalPage}' class='page-lost'>尾页</a> ";
		//}

		return $firstPageBar . $prePageBar . $nextPageBar . $lastPageBar;
	}



/******** 分页 ********/
	function PageBar_b( $total, $onePage, $page, $base = '', $query = '', $offset = 5 )
	{		
		if ( !$base )
		{
			$base = $_SERVER['PHP_SELF'];
			$query = $_SERVER['QUERY_STRING'];
		}
		
		$totalPage = ceil( $total / $onePage );
		$linkArray = explode( "page=", $query );
		$linkArg = $linkArray[0];

		if ( $linkArg == '' )
		{
			$url = $base . "?";
		}
		else
		{
			$linkArg	= substr( $linkArg, -1 ) == "&" ? $linkArg : $linkArg . '&';
			$url		= $base . '?' . $linkArg;
		}

		if ( !$totalPage )
			$totalPage = 1;

		if ( $page > $totalPage || !$page )
			$page = 1;

		$mid		= floor( $offset / 2 );
		$last		= $offset - 1;
		$minPage	= ( $page - $mid ) < 1 ? 1 : $page - $mid;
		$maxPage	= $minPage + $last;

		if ( $maxPage > $totalPage )
		{
			$maxPage	= $totalPage;
			$minPage	= $maxPage - $last;
			$minPage	= $minPage < 1 ? 1 : $minPage;
		}

		//if ( $page != 1 )
		//{
			//$prePage = $page - 1;
			//$prePageBar = "<a href='{$url}page={$prePage}' class='page-pre'><<</a>　";
			$firstPageBar = "<a class='xiao_21' href='{$url}page=1'>首</a>";
		//}

		for ( $i = $minPage; $i <= $maxPage; $i++ )
		{
			if ( $i == $page )
				$numPageBar .= "<b class='xiao_3' class='cur'>{$i}</b> ";
			else
				$numPageBar .= "<a class='xiao_2' href='{$url}page=$i'>{$i}</a> ";
		}

		//if ( $page < $totalPage )
		//{
		//	$nextPage = $page + 1;
		//	$nextPageBar = "<a href='{$url}page={$nextPage}' class='page-next'>>></a>　";
			$lastPageBar = "<a class='xiao_22' href='{$url}page={$totalPage}'>尾</a>";
		//}

		return $firstPageBar . $numPageBar . $lastPageBar;
	}























}

?>