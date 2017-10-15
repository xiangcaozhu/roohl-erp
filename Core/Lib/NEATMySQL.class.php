<?php

/**
* MySQL���ݿ������
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
	* ��ѯ�����ܴ���
	* @var integer $selectQueries
	*/
	var $selectQueries		= 0;

	/**
	* ���²����ܴ���
	* @var integer $updateQueries
	*/
	var $updateQueries		= 0;

	/**
	* ʱ������ֵ
	* @var integer $timeOffset
	*/
	var $timeOffset		= 8;

	var $SQL;

	/**
	* ���캯��
	* @param string $server MySQL���ݿ���ʵ�ַ
	* @param string $user MySQL�û���
	* @param string $password MySQL��½����
	* @param string $database MySQL���ݿ�
	* @param integer $pConnect �Ƿ�ʹ��pConnect ( �������� )
	* @param integer $autoRun �Ƿ��Զ�����
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
	* �������ݿ�
	* @param string $server MySQL���ݿ���ʵ�ַ
	* @param string $user MySQL�û���
	* @param string $password MySQL��½����
	* @param string $database MySQL���ݿ�
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
	* �Ͽ����ݿ�����
	* @return boolean
	* @access publics
	*/
	 function Disconnect()
	{
		return mysql_close( $this->conn );
	}

	/**
	* ��ȡ��ѯ�����ܴ���
	* @return integer
	* @access publics
	*/
	function GetSelectQueries()
	{
		return $this->SelectQueries;

	}

	/**
	* ��ȡ���²����ܴ���
	* @return integer
	* @access publics
	*/
	function GetUpdateQueries()
	{
		return $this->updateQueries;
	}

	/**
	* ���Ͳ�ѯ������� ( for select )
	* @param string $queryString ��ѯ����SQL���
	* @param integer $beginRow ��ʼ����
	* @param integer $limit ������Χ
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
	* ���͸��²������ ( for insert, update, delete )
	* @param string $queryString ���²���SQL���
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
	* ����������Ӱ���ID
	* @return integer
	* @access publics
	*/
	function LastID()
	{
		return mysql_insert_id( $this->conn );
	}

	/**
	* ��ʾMySQL������Ϣ
	* @param string $msg ����Ĵ�����Ϣ
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
* MySQL��ѯ������ݼ�
* @package NEATFramework
* @subpackage NEATDataBase
*/
Class NEATMySQLResult
{

	/**
	* MySQL����ID
	* @var integer $resultID
	*/
	var $resultID	= 0;

	/**
	* ���������
	* @var integer $rows
	*/
	var $rows	= 0;

	/**
	* �������ݼ�
	* @var array $record
	*/
	var $record	= array();

	/**
	* ���캯��
	* @param integer $resultID ͨ�����Ͳ�ѯ�����õ���MySQL���̱�ʶ
	* @return NEATMySQLResult
	* @access private
	*/
	function NEATMySQLResult( $resultID )
	{
		$this->resultID = $resultID;
	}

	/**
	* �ƶ����ݼ�ָ��
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
	* ��ȡ�����ֶ�ֵ
	* @param string $name �ֶ���
	* @return mixed
	* @access public
	*/
	function Get( $name )
	{
		return $this->record[$name];
	}

	/**
	* ��ȡ��ǰָ����ָ�����������
	* @return array
	* @access public
	*/
	function GetArray()
	{
		return $this->record;
	}

	/**
	* ��ȡ��ǰ���ݼ�������
	* @return integer
	* @access public
	*/
	function Rows()
	{
		return mysql_num_rows( $this->resultID );
	}

	/**
	* �ͷ�MySQL��ѯ����
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