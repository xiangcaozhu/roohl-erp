<?php
/**
* Cache
* Cache 缓存处理
* @name Cache
* @author hihiyou
* @copyright neatstudio
* @link http://www.neatstudio.com http://www.neatcn.com
*/
class Cache
{
	
	var $cachePath;
	var $cacheName;
	var $cacheType;

	var $cacheReadTimes = 0;
	var $cacheDoTimes = 0;

	var $cacheContent;

	var $loadedCache = array();

	function Cache( $path = '', $type = 'txt' )
	{
		$this->cachePath = $path;

		// 'php' or 'txt'
		$this->cacheType = $type;
	}

	function SetCachePath( $path )
	{
		$this->cachePath = $path;
	}

	function SetCacheType( $type )
	{
		$this->cacheType = $type;
	}

	function SetCacheName( $name )
	{
		$this->cacheName = $name;
	}

	function SetCacheContent( $array )
	{
		// php 或者txt 分开处理
		if ( $this->cacheType == 'php' )
		{
			$this->cacheContent  = "<?php\n\$__Cache" . $this->cacheName . "=";
			$this->cacheContent .= var_export( $array, true );
			$this->cacheContent .= "?>";
		}
		elseif ( $this->cacheType == 'txt' )
		{
			$this->cacheContent = serialize( $array );
		}
	}

	function ReadCache( $name = '', $lifeTime = 0, $cache = 1 )
	{
		if ( $name == '' )
			$name = $this->cacheName;

		$path = $this->cachePath . $name . '.' . $this->cacheType;

		if ( $lifeTime > 0 )
		{
			if ( ( time() - @filemtime( $path ) ) > $lifeTime )
				return false;
		}

		$loadedCacheKey = str_replace( array( '/', '\\', '.' , ':'), '_', $path );

		if ( $this->loadedCache[$loadedCacheKey] && $cache )
			return $this->loadedCache[$loadedCacheKey];

		$this->cacheReadTimes++;

		//echo $path. "<br>";

		if ( $this->cacheType == 'php' )
		{
			@include( $path );

			$name = "__Cache" . $name . "";

			if ( $$name )
				$this->loadedCache[$loadedCacheKey] =  $$name;
			else
				return array();
		}
		elseif ( $this->cacheType == 'txt' )
		{
			clearstatcache();

			$fp = @fopen( $path, "rb");
			@flock($fp, LOCK_SH);

			$mqrArg = get_magic_quotes_runtime();
			set_magic_quotes_runtime( 0 );

			$fileContent = @fread( $fp, @filesize( $path ) );

			@flock($fp, LOCK_UN);
			@fclose($fp);

			set_magic_quotes_runtime( $mqrArg );

			if ( !$fileContent )
			{
				return false;
			}

			$var = unserialize( $fileContent );

			if ( $var )
				$this->loadedCache[$loadedCacheKey] = $var;
			else
				return array();
		}
		else
		{
			return false;
		}

		return $this->loadedCache[$loadedCacheKey];
	}

	function GetCacheTime( $name = '' )
	{
		if ( $name == '' )
			$name = $this->cacheName;

		$path = $this->cachePath . $name . '.' . $this->cacheType;

		return @filemtime( $path );
	}

	function DoCache()
	{
		$this->cacheDoTimes++;

		$cacheFile = $this->cachePath . $this->cacheName . '.' . $this->cacheType;
		//echo $cacheFile;
		if ( !FileExists( $this->cachePath ) )
			MakeDirTree( $this->cachePath );

		$fp = @fopen( $cacheFile, "wb" );
		@flock($fp, LOCK_EX);

		$mqrArg = get_magic_quotes_runtime();
		set_magic_quotes_runtime( 0 );

		@fwrite( $fp, $this->cacheContent );

		@flock($fp, LOCK_UN);
		@fclose( $fp );

		set_magic_quotes_runtime( $mqrArg );

		clearstatcache();
	}
}
?>