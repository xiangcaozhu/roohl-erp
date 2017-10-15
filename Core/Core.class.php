<?php


//if((strtotime(date('Y-m-d',time())) - strtotime('2014-10-07') >=0 ) || (strtotime(date('Y-m-d',time())) - strtotime('2013-12-31') <0 ))
//{ 
//	echo "系统访问异常，请与系统供应商联系!!!！";
//} 
//else{ 



class Core
{
	/******** ��������ģ�� ********/
	function ImportModel( $name )
	{
		global $__Model;

		$name = ucfirst( $name );
		$modelName = "{$name}Model";

		include_once( Core::GetConfig( 'core_model_path' ) . $modelName . ".class.php" );

		if ( !$__Model[$modelName] )
		{
			$__Model[$modelName] = new $modelName;
			$__Model[$modelName]->Init();
		}

		return $__Model[$modelName];
	}

	/******* 载入Lib文件 ********/
	function LoadLibs( $fileName )
	{
		$path = Core::GetConfig( 'core_lib_path' ) . $fileName . '.php';

		if ( $GLOBALS['__IncludePath'][$path] )
			return true;

		$GLOBALS['__IncludePath'][$path] = true;
		
		include( $path );
	}


	/******** ���뻺���� ********/
	function ImportCache( $name )
	{
		global $__CacheClass;

		$name = ucfirst( $name );
		$className = "{$name}Cache";

		include_once( Core::GetConfig( 'app_cache_path' ) . $className . '.class.php' );

		if ( !$__CacheClass[$modelName] )
		{
			$__CacheClass[$className] = new $className();
		}

		return $__CacheClass[$className];
	}

	/******* �������ļ� ********/
	function LoadClass( $className )
	{
		$path = Core::GetConfig( 'core_class_path' ) . $className . '.class.php';

		if ( $GLOBALS['__IncludePath'][$path] )
			return true;

		$GLOBALS['__IncludePath'][$path] = true;

		include( $path );
	}

	/******* ����Extra�ļ� ********/
	function LoadExtra( $name )
	{
		$path = Core::GetConfig( 'core_extra_path' ) . $name . 'Extra.class.php';

		if ( $GLOBALS['__IncludePath'][$path] )
			return true;

		$GLOBALS['__IncludePath'][$path] = true;

		include( $path );
	}

	function ImportExtra( $name )
	{
		global $__Extra;

		$name = ucfirst( $name );
		$extraName = "{$name}Extra";

		if ( !$__Extra[$extraName] )
		{
			Core::LoadExtra( $name );

			$__Extra[$extraName] = new $extraName;
		}

		return $__Extra[$extraName];
	}


	function LoadConfig( $name )
	{
		$path = Core::GetConfig( 'core_config_path' ) . $name . '.config.php';

		if ( $GLOBALS['__IncludePath'][$path] )
			return true;

		$GLOBALS['__IncludePath'][$path] = true;

		include( $path );
	}

	/******* ������ ********/
	function ImportClass( $name, $arg= array() )
	{
		global $__Class;

		if ( $__Class[$name] )
		{
			return $__Class[$name];
		}

		switch ( $name )
		{
			case "NewsFeed":
				Core::LoadClass( 'NewsFeed' );

				$__Class[$name] = new NewsFeed();

			break;

			case "Session":
				Core::LoadClass( 'Session' );

				$session = Common::GetSession();

				$__Class[$name] = new Session( 'k_', $session['user_id'] );

			break;

			case "PageDataFetcher":
				Core::LoadClass( 'PageDataFetcher' );

				$__Class[$name] = new PageDataFetcher();

			break;

			default:
				Core::LoadClass( $name );

				$__Class[$name] = new $name();
			break;

		}

		return $__Class[$name];
	}

	/**
	 * ����Dom�ļ�
	 *
	 *
	 */
	function LoadDom( $domName )
	{
		$path = Core::GetConfig( 'core_dom_path' ) . $domName . 'Dom.class.php';

		if ( $GLOBALS['__IncludePath'][$path] )
			return true;

		$GLOBALS['__IncludePath'][$path] = true;
		
		include( $path );
	}

	function LoadComponent( $componentName )
	{
		$path = Core::GetConfig( 'core_component_path' ) . $componentName . 'Component.class.php';

		if ( $GLOBALS['__IncludePath'][$path] )
			return true;

		$GLOBALS['__IncludePath'][$path] = true;
		
		include( $path );
	}

	/******* Ƭ�� ********/
	function Block( $blockIndex )
	{	
		$path = Core::GetConfig( 'app_block_path' ) . str_replace( '.', '/', $blockIndex ) . '.block.php';

		return $path;

		if ( !file_exists( $path ) )
		{
			exit( 'block lost' . $blockIndex );
		}
		else
		{
			if ( $GLOBALS['__IncludePath'][$path] )
				return true;

			$GLOBALS['__IncludePath'][$path] = true;

			include( $path );
		}
	}

	/******* ���뺯���ļ� ********/
	function LoadFunction( $fileName )
	{
		$path = Core::GetConfig( 'core_function_path' ) . $fileName;

		if ( $GLOBALS['__IncludePath'][$path] )
			return true;

		$GLOBALS['__IncludePath'][$path] = true;
		
		include( $path );
	}

	/******* ����Lib�ļ� ********/
	function LoadLib( $fileName )
	{
		$path = Core::GetConfig( 'core_lib_path' ) . $fileName;

		if ( $GLOBALS['__IncludePath'][$path] )
			return true;

		$GLOBALS['__IncludePath'][$path] = true;
		
		include( $path );
	}




	/******* ��������� ********/
	function ImportBaseClass( $name = 'Model', $params = array() )
	{
		$dbConfig = Core::GetConfig( 'db' );
		
		$name = ucfirst( $name );

		if ( $params['alias'] )
			$objName = "{$params['alias']}";
		else
			$objName = "{$name}";

		if ( $GLOBALS['__BaseClass'][$objName] )
		{
			return $GLOBALS['__BaseClass'][$objName];
		}

		switch ( $name )
		{
			case "Db":
				if ( !$params )
					$dataBaseInfo = $dbConfig[0];
				else
					$dataBaseInfo = $dbConfig[$params['db']];

				Core::LoadLib( 'NEATMySQL.class.php' );

				$GLOBALS['__BaseClass'][$objName] = new NEATMySQL( $dataBaseInfo['host'], $dataBaseInfo['user'], $dataBaseInfo['pwd'], $dataBaseInfo['database'], 0, 1, $dataBaseInfo['table_prefix'] );
				$GLOBALS['__BaseClass'][$objName]->Query( "SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary" );
				$GLOBALS['__BaseClass'][$objName]->Query( "SET sql_mode=''" );

			break;
			
			case "Model":
				Core::LoadLib( 'Model.class.php' );

				$Db = Core::ImportBaseClass( "Db", $params['Db_params'] );
				$GLOBALS['__BaseClass'][$objName] = new Model( $Db );

			break;

			case "Template":
				Core::LoadLib( 'NEATTemplate.class.php' );

				$GLOBALS['__BaseClass'][$objName] = new NEATTemplate();
				$GLOBALS['__BaseClass'][$objName]->SetCachePath( Core::GetConfig( 'template_cache_path' ) );
				$GLOBALS['__BaseClass'][$objName]->languageFilePath = "language/en/";

			break;

			case "Cache":
				Core::LoadLib( 'Cache.class.php' );
				
				$GLOBALS['__BaseClass'][$objName] = new Cache( CFG_CACHE_PATH );
			break;

			case "ClientAuth":
				Core::LoadLib( 'ClientAuth.class.php' );

				$GLOBALS['__BaseClass'][$objName] = new ClientAuth( Core::GetConfig( 'client_auth_prefix' ), Core::GetConfig( 'client_auth_hash' ), Core::GetConfig( 'client_auth_field' ) );
			break;

			default:

		}

		return $GLOBALS['__BaseClass'][$objName];
	}

	/******* ȡ�����ò��� ********/
	function GetConfig( $name )
	{
		global $__Config;

		return $__Config[$name];
	}
}


function pychar($s0)
{  
$fchar = ord($s0{0});
if($fchar >= ord("A") and $fchar <= ord("z") )
    return strtoupper($s0{0});
$s1 = iconv("UTF-8","gb2312", $s0);
$s2 = iconv("gb2312","UTF-8", $s1);
if($s2 == $s0){$s = $s1;}else{$s = $s0;}
$asc = ord($s{0}) * 256 + ord($s{1}) - 65536;
if($asc >= -20319 and $asc <= -20284) return "A";
if($asc >= -20283 and $asc <= -19776) return "B";
if($asc >= -19775 and $asc <= -19219) return "C";
if($asc >= -19218 and $asc <= -18711) return "D";
if($asc >= -18710 and $asc <= -18527) return "E";
if($asc >= -18526 and $asc <= -18240) return "F";
if($asc >= -18239 and $asc <= -17923) return "G";
if($asc >= -17922 and $asc <= -17418) return "H";
if($asc >= -17417 and $asc <= -16475) return "J";
if($asc >= -16474 and $asc <= -16213) return "K";
if($asc >= -16212 and $asc <= -15641) return "L";
if($asc >= -15640 and $asc <= -15166) return "M";
if($asc >= -15165 and $asc <= -14923) return "N";
if($asc >= -14922 and $asc <= -14915) return "O";
if($asc >= -14914 and $asc <= -14631) return "P";
if($asc >= -14630 and $asc <= -14150) return "Q";
if($asc >= -14149 and $asc <= -14091) return "R";
if($asc >= -14090 and $asc <= -13319) return "S";
if($asc >= -13318 and $asc <= -12839) return "T";
if($asc >= -12838 and $asc <= -12557) return "W";
if($asc >= -12556 and $asc <= -11848) return "X";
if($asc >= -11847 and $asc <= -11056) return "Y";
if($asc >= -11055 and $asc <= -10247) return "Z";
return null;
}

function GetPY($zh)
{
$ret = "";
$s1 = iconv("UTF-8","gb2312", $zh);
$s2 = iconv("gb2312","UTF-8", $s1);
if($s2 == $zh){$zh = $s1;}
for($i = 0; $i < strlen($zh); $i++){
$s1 = substr($zh,$i,1);
$p = ord($s1);
if($p > 160){
$s2 = substr($zh,$i++,2);
$ret .= pychar($s2);
}else{
$ret .= $s1;
}
}

$ret = strtolower($ret);

return $ret;
}

//}
?>