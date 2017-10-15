<?php

class BaseCommon
{
	/******** 产品列表图片 Url ********/
	function GetProductPictureUrl( $id, $type = false )
	{
		$rootUrl = Core::GetConfig( 'product_picture_url' );

		return $rootUrl . Common::GetProductPictureShortPath( $id, $type );
	}

	/******** 产品列表图片 Path ********/
	function GetProductPicturePath( $id, $type = false )
	{
		$rootPath = Core::GetConfig( 'product_picture_path' );

		return $rootPath . Common::GetProductPictureShortPath( $id, $type );
	}

	/******** 产品列表图片 ShortPath ********/
	function GetProductPictureShortPath( $id, $type )
	{
		$path = substr( sprintf( '%02d', $id ), -2, 1 ) . '/' . substr( $id, -1, 1 ) . '/';

		if ( $type )
			return "{$path}{$id}_{$type}.jpg";
		else
			return $path;
	}

	/******** 分类图片 Url ********/
	/*
	function GetCategoryImageUrl( $cid, $name, $type, $enable = 1 )
	{
		if ( !$enable )
			return SITE_URL . Core::GetConfig( 'avatar_default_url_' . $type );

		$root = Core::GetConfig( 'category_image_url' );

		return $root . "{$cid}_{$name}_{$type}.jpg";
	}
	*/

	/******** 分类图片 Path ********/
	/*
	function GetCategoryImagePath( $cid, $name, $type )
	{
		$root = Core::GetConfig( 'category_image_path' );

		return $root . "{$cid}_{$name}_{$type}.jpg";
	}


	/******** 产品详细页图片 Url ********/
	function GetPictureUrl( $savePath, $saveName = '', $saveExt = '', $type = false )
	{
		return Core::GetConfig( 'detail_picture_url' ) . Common::GetPictureShortPath( $savePath, $saveName, $saveExt, $type );
	}

	/******** 产品详细页图片 Path ********/
	function GetPicturePath( $savePath, $saveName = '', $saveExt = '', $type = false )
	{
		return Core::GetConfig( 'detail_picture_path' ) . Common::GetPictureShortPath( $savePath, $saveName, $saveExt, $type );
	}

	/******** 产品详细页图片 Short Path ********/
	function GetPictureShortPath( $savePath, $saveName, $saveExt, $type )
	{
		if ( $type )
		{
			$dir= array();
			$dir[1] = '_f';
			$dir[2] = '_m';
			$dir[3] = '_n';
			$dir[4] = '_s';

			return $savePath . $saveName . $dir[$type] . '.' . $saveExt;
		}
		else
		{
			return $savePath;
		}
	}

	/******** 产品详细页图片 File Name ********/
	function GetPictureSaveName( $time, $seed = array() )
	{
		do
		{
			$name = $time . '_' . GetRand( 10 );
		}
		while( in_array( $name, $seed ) );

		return $name;
	}

	/******** 购买属性图片 Url ********/
	function GetAttributeImageUrl( $id, $type = false )
	{
		$rootUrl = Core::GetConfig( 'attribute_image_url' );

		return $rootUrl . Common::GetAttributeImageShortPath( $id, $type );
	}

	/******** 购买属性图片 Path ********/
	function GetAttributeImagePath( $id, $type = false )
	{
		$rootPath = Core::GetConfig( 'attribute_image_path' );

		return $rootPath . Common::GetAttributeImageShortPath( $id, $type );
	}

	/******** 购买属性图片 Short Path ********/
	function GetAttributeImageShortPath( $id, $type )
	{
		$path = substr( sprintf( '%02d', $id ), -2, 1 ) . '/' . substr( $id, -1, 1 ) . '/';

		if ( $type )
		{
			$ext = array();
			$ext[1] = '_list.jpg';
			$ext[2] = '_detail.jpg';

			return $path . $id . $ext[$type];
		}
		else
		{
			return $path;
		}
	}

	/******** 分页 ********/
	function PageBars( $total, $onePage, $page, $base = '', $query = '', $offset = 5 )
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
			$prePageBar = "<a href='{$url}page={$prePage}'>Previous</a> ";
			$firstPageBar = "<a href='{$url}page=1'>First</a> ";
		}

		for ( $i = $minPage; $i <= $maxPage; $i++ )
		{
			if ( $i == $page )
				$numPageBar .= "<span>{$i}</span> ";
			else
				$numPageBar .= "<a href='{$url}page=$i'>{$i}</a> ";
		}

		if ( $page < $totalPage )
		{
			$nextPage = $page + 1;
			$nextPageBar = " <a href='{$url}page={$nextPage}'>Next</a>";
			$lastPageBar = " <a href='{$url}page={$totalPage}'>Last</a>";
		}

		return $firstPageBar . $prePageBar . $numPageBar . $nextPageBar . $lastPageBar;
	}

	/******** 分页参数 ********/
	function PageArg( $onePage = 30, $page = false )
	{
		if ( $page === false )
			$page = (int)$_GET['page'];

		if ( $page <= 0 )
			$page = 1;

		$offset = $onePage* ( $page - 1 );

		return array( $page, $offset, $onePage );
	}

	/******** Mail ********/
	function MailTo( $to, $subject, $content, $type = 'Notice' )
	{
		$mailConfig = Core::GetConfig( 'mail_config' );
		$mailConfig = $mailConfig[$type];
		
		Core::LoadLib( 'class.phpmailer.php' );

		if ( !$GLOBALS['PHPMailer'] )
			$GLOBALS['PHPMailer'] = new PHPMailer();

		$Mail = $GLOBALS['PHPMailer'];

		$Mail->IsSMTP(); 
		$Mail->SMTPAuth = true;
		$Mail->SMTPSecure = 'ssl';
		$Mail->Host = 'smtp.gmail.com';
		$Mail->Port = 465;
		$Mail->CharSet = 'utf-8';
		$Mail->Username   = $mailConfig['account'];
		$Mail->Password   = $mailConfig['password'];

		$Mail->From = $mailConfig['from'];
		$Mail->FromName = $mailConfig['from_name'];

		$Mail->Subject = $subject;
		$Mail->WordWrap = 50;
		$Mail->MsgHTML( $content );

		if ( is_array( $to ) )
		{
			foreach ( $to as $m )
			{
				$Mail->AddAddress( $m );
			}
		
		}
		else
		{
			$Mail->AddAddress( $to );
		}

		$Mail->IsHTML( true );

		return $Mail->Send();
	}

	/******** Cookie ********/
	function AddCookie( $name, $value, $time = 0 )
	{
		setcookie( $prefix . $name, $value, ( $time ? time() + $time : 0  ), '/', '' );
	}

	/******** Cookie ********/
	function GetCookie( $name )
	{
		return $_COOKIE[$prefix . $name];
	}

	/******** Cookie ********/
	function DelCookie( $name )
	{
		setcookie( $prefix . $name, '', time() - 3600, '/', '' );
	}
}


?>