<?php

/**
* MySQL数据库操作类
* Created / Modify : 2004-02-20 / 2005-4-10
* @name  NEATDataBaseMySQL
* @version  1.0.4
* @author  walkerlee / gouki / hihiyou
* @copyright  Powered by NEATSTUDIO 2002 - 2005 <neatstudio@qq.com>
* @link http://www.neatstudio.com NeatStudio
* @package NEATFramework
* @subpackage NEATDataBase
*/

class NEATMySQL
{

	/**
	* 查询操作总次数
	* @var integer $selectQueries
	*/
	var $selectQueries		= 0;

	/**
	* 更新操作总次数
	* @var integer $updateQueries
	*/
	var $updateQueries		= 0;

	/**
	* 时间修正值
	* @var integer $timeOffset
	*/
	var $timeOffset		= 8;

	var $SQL;

	/**
	* 构造函数
	* @param string $server MySQL数据库访问地址
	* @param string $user MySQL用户名
	* @param string $password MySQL登陆密码
	* @param string $database MySQL数据库
	* @param integer $pConnect 是否使用pConnect ( 持续连接 )
	* @param integer $autoRun 是否自动连接
	* @return NEATMySQL
	* @access private
	*/
	function NEATMySQL( $server,  $user,  $password,  $database,  $pConnect = 0, $autoRun = 1 )
	{
		$this->pConnect = $pConnect;

		if  ( $autoRun == 1 )
			$this->Connect( $server,  $user,  $password,  $database );
	}

	/**
	* 连接数据库
	* @param string $server MySQL数据库访问地址
	* @param string $user MySQL用户名
	* @param string $password MySQL登陆密码
	* @param string $database MySQL数据库
	* @return boolean
	* @access publics
	*/
	function Connect( $server,  $user,  $password,  $database )
	{
		$connectType = ( $this->pConnect ) ?  'mysql_pconnect' : 'mysql_connect';
		$this->conn = @$connectType( $server,  $user,  $password );

		if  ( !$this->conn )
		{
			$this->Error( 'Fail to connect to MySQL server' );
			return false;
		}

		if ( $database )
		{
			if ( !mysql_select_db( $database, $this->conn ) )
			{
				$this->Error( 'Cannot use database : ' . $database );
				return false;
			}
		}
	}

	/**
	* 断开数据库连接
	* @return boolean
	* @access publics
	*/
	 function Disconnect()
	{
		return mysql_close( $this->conn );
	}

	/**
	* 获取查询操作总次数
	* @return integer
	* @access publics
	*/
	function GetSelectQueries()
	{
		return $this->SelectQueries;

	}

	/**
	* 获取更新操作总次数
	* @return integer
	* @access publics
	*/
	function GetUpdateQueries()
	{
		return $this->updateQueries;
	}

	/**
	* 发送查询操作语句 ( for select )
	* @param string $queryString 查询操作SQL语句
	* @param integer $beginRow 开始行数
	* @param integer $limit 数量范围
	* @return object
	* @access publics
	*/
	function Query( $queryString,  $beginRow = 0,  $limit = 0 )
	{
		if ( $limit )
			$queryString .= " LIMIT " . $beginRow." , " . $limit;

		$queryid = mysql_query( $queryString,  $this->conn );

		$this->selectQueries++;

		$this->SQL[] = $queryString;

		if ( !$queryid )
			$this->Error( "Invalid SQL : ".$queryString );
		
		return (new NEATMySQLResult( $queryid ) );
	}

	/**
	* 发送更新操作语句 ( for insert, update, delete )
	* @param string $queryString 更新操作SQL语句
	* @return void
	* @access publics
	*/
	function Update( $queryString )
	{
		$queryid = mysql_query( $queryString,  $this->conn );

		$this->updateQueries++;

		$this->SQL[] = $queryString;

		if ( !$queryid )
			$this->Error( "Invalid SQL : " . $queryString );

		return $queryid;
	}

	/**
	* 返回最后操作影响的ID
	* @return integer
	* @access publics
	*/
	function LastID()
	{
		return mysql_insert_id( $this->conn );
	}

	/**
	* 显示MySQL错误信息
	* @param string $msg 具体的错误信息
	* @return void
	* @access publics
	*/
	function Error( $msg )
	{
		$errorTime = gmdate( "Y-n-j g:i a",  time() + ( $this->timeOffset * 3600 ) );

		$mysql_error = @mysql_error( $this->conn );
		$mysql_errno = @mysql_errno ($this->conn );

		printf( "<div style=\"font-family: 'Verdana', 'Arial', 'Helvetica', 'sans-serif'; font-size: 12px\">MySQL error message :</div><textarea rows=\"10\" cols=\"100\" style=\"font-family: 'Verdana', 'Arial', 'Helvetica', 'sans-serif'; font-size: 8pt\">\ntime : %s\n--------------------------------\n%s\n--------------------------------\nmysql error : %s\nmysql error no. : %s</textarea>",  $errorTime,  $msg,  $mysql_error,  $mysql_errno );

		exit;
	}

	function Begin()
	{
		mysql_query( "BEGIN",  $this->conn );
	}

	function Commit()
	{
		mysql_query( "COMMIT",  $this->conn );
	}

	function RollBack()
	{
		mysql_query( "ROLLBACK",  $this->conn );
	}

}

/**
* MySQL查询结果数据集
* @package NEATFramework
* @subpackage NEATDataBase
*/
Class NEATMySQLResult
{

	/**
	* MySQL进程ID
	* @var integer $resultID
	*/
	var $resultID	= 0;

	/**
	* 结果集行数
	* @var integer $rows
	*/
	var $rows	= 0;

	/**
	* 单行数据集
	* @var array $record
	*/
	var $record	= array();

	/**
	* 构造函数
	* @param integer $resultID 通过发送查询操作得到的MySQL进程标识
	* @return NEATMySQLResult
	* @access private
	*/
	function NEATMySQLResult( $resultID )
	{
		$this->resultID = $resultID;
	}

	/**
	* 移动数据集指针
	* @return boolean
	* @access public
	*/
	function NextRecord()
	{
		$this->record = mysql_fetch_array( $this->resultID,  MYSQL_ASSOC );
		
		$this->rows++;

		$status = is_array( $this->record );
		return $status;
	}

	/**
	* 获取数据字段值
	* @param string $name 字段名
	* @return mixed
	* @access public
	*/
	function Get( $name )
	{
		return $this->record[$name];
	}

	/**
	* 获取当前指针所指向的数据数组
	* @return array
	* @access public
	*/
	function GetArray()
	{
		return $this->record;
	}

	/**
	* 获取当前数据集的行数
	* @return integer
	* @access public
	*/
	function Rows()
	{
		return mysql_num_rows( $this->resultID );
	}

	/**
	* 释放MySQL查询进程
	* @return viod
	* @access public
	*/
	function Free() 
	{
		mysql_free_result( $this->resultID );
		$this->resultID = 0;
	}

}

?>