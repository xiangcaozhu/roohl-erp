<?php

class ActionLogModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_action_log';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_action_log', 'data' => $data ) );
	}

	function AddService( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_service_log', 'data' => $data ) );
	}


	function Update( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_action_log', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function GetList( $targetId, $action )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_action_log';
		$cfg['condition'] = array( 'target_id' => $targetId, 'action' => $action );
		$cfg['order'] = "id DESC";
		$cfg['key'] = "id";
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		return $this->Model->GetList( $cfg );
	}

	function GetList_98( $targetId, $action )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_action_log';
		$cfg['condition'] = array( 'target_id' => $targetId, 'action' => $action, 'type' => 1 );
		$cfg['order'] = "id DESC";
		$cfg['key'] = "id";
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		return $this->Model->GetList( $cfg );
	}
	
	function GetList_1( $targetId, $action )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_action_log';
		$cfg['condition'] = array( 'target_id' => $targetId, 'action' => $action );
		$cfg['order'] = "id";
		$cfg['key'] = "id";
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		return $this->Model->GetList( $cfg );
	}

	function GetNewLogGood( $targetId,$DES)
	{
	/*
		$cfg = array();
		$cfg['table'] = 'shopcenter_action_log';
		$cfg['condition'] = array( 'target_id' => $targetId);
		if($DES==0){$cfg['order'] = "id";}else{$cfg['order'] = "id DESC";}
		$cfg['order'] = "id DESC";
		$cfg['group'] = "action"; ORDER BY MAX(TIME)
		return $this->Model->GetList( $cfg );
*/
        if($DES==0){
		$sql  = "select * from (SELECT sal.*,sa.user_real_name as real_name FROM shopcenter_action_log AS sal LEFT JOIN sys_administrator AS sa ON sa.user_id = sal.user_id  WHERE target_id = {$targetId} order by id) as t group by action";
		}else{
		$sql  = "select * from (SELECT sal.*,sa.user_real_name as real_name FROM shopcenter_action_log AS sal LEFT JOIN sys_administrator AS sa ON sa.user_id = sal.user_id  WHERE target_id = {$targetId} order by id desc) as t group by action";
		}
		
		
		//$sql  = "SELECT * FROM shopcenter_action_log WHERE target_id = {$targetId} GROUP BY action ORDER BY MIN(id)";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );



	}





	function GetList_11( $targetId, $action, $type )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_action_log';
		$cfg['condition'] = array( 'target_id' => $targetId, 'action' => $action, 'type' => $type );
		$cfg['order'] = "id DESC";
		$cfg['key'] = "comment";
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		return $this->Model->Get( $cfg );
	}
	
	
	function GetList_2( $targetId, $action )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_service_log';
		$cfg['condition'] = array( 'target_id' => $targetId, 'action' => $action );
		$cfg['order'] = "id";
		$cfg['key'] = "id";
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		return $this->Model->GetList( $cfg );
	}
	
	function GetListAll()
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_action_log';
		//$cfg['condition'] = array( 'target_id' => $targetId, 'action' => $action );
		$cfg['order'] = "id";
		$cfg['key'] = "id";
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		return $this->Model->GetList( $cfg );
	}
	
		
	function GetTotal()
	{
		$condition = array();

		$cfg = array();
		$cfg['table'] = 'shopcenter_action_log';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_action_log';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}





	function GetLast( $targetId, $action )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_action_log';
		$cfg['condition'] = array( 'target_id' => $targetId, 'action' => $action );
		$cfg['order'] = "id DESC";
		$cfg['key'] = "comment";
		return $this->Model->Get( $cfg );
	}

	function GetOne( $targetId, $action )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_action_log';
		$cfg['condition'] = array( 'target_id' => $targetId, 'action' => $action );
		$cfg['order'] = "id DESC";
		//$cfg['key'] = "comment";
		return $this->Model->Get( $cfg );
	}




























}

?>