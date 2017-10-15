<?php

class Controller
{
	var $moduleRootPath;
	/*
	* 构造函数
	*
	*/
	function Controller( $moduleRootPath = '' )
	{
		$this->moduleRootPath = $moduleRootPath;
		$this->module = $this->SafeModule( $_GET['mod'] );
		$this->action = trim( $_GET['act'] );
	}

	function ExplodeModule( $module )
	{
		return explode( '.', $module );
	}

	function SafeModule( $module )
	{
		$module = trim( $module );
		$module = str_replace( array( '/', '\\', '../', '..\\' ), '', $module );
		$module = preg_replace( array( '/\.{2,}/is' ), '', $module );

		return $module;
	}

	/*
	* 模块加载前的处理
	* 设计为被子类重载的方法
	*
	*/
	function BeforeRun()
	{

	}

	/*
	* 加载模块
	*
	*/
	function Run( $quoteData = array() )
	{
		$this->BeforeRun();

		$this->moduleList = $this->ExplodeModule( $this->module );

		$modulePath = $this->moduleRootPath . implode( '/', $this->moduleList ) . '.php';

		if ( !file_exists( $modulePath ) )
		{
			//exit( 'Error Module:' . $modulePath );
			Common::PageNotFound();
			exit;
			//header("HTTP/1.0 404 Not Found");
			//exit();
		}

		@extract( $quoteData );
		include( $modulePath );
	}
}

?>