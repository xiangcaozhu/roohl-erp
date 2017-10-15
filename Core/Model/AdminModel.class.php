<?php

class AdminModel
{
	function Init()
	{
		$this->Model = & Core::ImportBaseClass( 'Model' );
	}

	function GetAdministratorTotal( $cfgExt = array() )
	{
		$cfg = array();
		$cfg['table'] = 'sys_administrator';
		$cfg['select'] = 'COUNT(*) AS total';
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function GetAdministratorByName( $userName )
	{
		$cfg = array();
		$cfg['table'] = 'sys_administrator';
		$cfg['condition'] = array( 'user_name' => $userName );
		return $this->Model->Get( $cfg );
	}

	function GetAdministratorByRealName( $userRealName )
	{
		$cfg = array();
		$cfg['table'] = 'sys_administrator';
		$cfg['condition'] = array( 'user_real_name' => $userRealName );
		return $this->Model->Get( $cfg );
	}

	function GetAdministrator( $id )
	{
		$cfg = array();
		$cfg['table'] = 'sys_administrator';
		$cfg['condition'] = array( 'user_id' => $id );
		return $this->Model->Get( $cfg );
	}

	function AddAdministrator( $data )
	{
		$this->Model->Add( array( 'table' => 'sys_administrator', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function GetAdministratorList( $offset = 0, $limit = 0, $condition = array(), $conditionExt = '' )
	{
		$cfg = array();
		$cfg['table'] = 'sys_administrator';
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = $conditionExt;
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['order'] = 'user_id DESC';
		return $this->Model->GetList( $cfg );
	}

	function GetAdministratorListcp_all( $offset = 0, $limit = 0, $condition = '', $conditionExt = '' )
	{
		$sql  = "SELECT * FROM sys_administrator WHERE user_group<16 and user_group>12 ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		return $this->Model->GetList( $cfg );
	}
	
	function GetAdministratorListcp( $offset = 0, $limit = 0, $condition = array( 'user_group' => 14 ), $conditionExt = '' )
	{
		$cfg = array();
		$cfg['table'] = 'sys_administrator';
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = $conditionExt;
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['order'] = 'user_id DESC';
		return $this->Model->GetList( $cfg );
	}

	function GetAdministratorListcp_1( $offset = 0, $limit = 0, $condition = array( 'user_group' => 13 ), $conditionExt = '' )
	{
		$cfg = array();
		$cfg['table'] = 'sys_administrator';
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = $conditionExt;
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['order'] = 'user_id DESC';
		return $this->Model->GetList( $cfg );
	}

	function GetAdministratorListcp_2( $offset = 0, $limit = 1, $condition = array( 'user_group' => 15 ), $conditionExt = '' )
	{
		$cfg = array();
		$cfg['table'] = 'sys_administrator';
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = $conditionExt;
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['order'] = 'user_id DESC';
		return $this->Model->GetList( $cfg );
	}
	
		
	function GetAdministratorListByIds( $ids )
	{
		if ( is_array( $ids ) )
			$ids = implode( ',', $ids );

		if ( !$ids )
			return array();
		
		$cfg = array();
		$cfg['table'] = 'sys_administrator';
		$cfg['conditionExt'] = "user_id IN({$ids})";
		$cfg['key'] = 'user_id';
		return $this->Model->GetList( $cfg );
	}

	function UpdateAdministrator( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'sys_administrator', 'data' => $data, 'condition' => array( 'user_id' => $id ) ) );
	}

	function DelAdministrator( $id )
	{
		$this->Model->Del( array( 'table' => 'sys_administrator', 'condition' => array( 'user_id' => $id ) ) );
	}


	/******** administrator group ********/
	function GetAdministratorGroup( $id )
	{
		$cfg = array();
		$cfg['table'] = 'sys_administrator_group';
		$cfg['condition'] = array( 'id' => $id );
		return $this->Model->Get( $cfg );
	}

	function AddAdministratorGroup( $data )
	{
		$this->Model->Add( array( 'table' => 'sys_administrator_group', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function GetAdministratorGroupList( $offset = 0, $limit = 0 )
	{
		$cfg = array();
		$cfg['table'] = 'sys_administrator_group';
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = $conditionExt;
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['order'] = 'id DESC';
		return $this->Model->GetList( $cfg );
	}

	function UpdateAdministratorGroup( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'sys_administrator_group', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function DelAdministratorGroup( $id )
	{
		$this->Model->Del( array( 'table' => 'sys_administrator_group', 'condition' => array( 'id' => $id ) ) );
	}
}

?>