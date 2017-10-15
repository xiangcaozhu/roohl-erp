<?php

class CenterWorkflowModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_workflow', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_workflow', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function Updatecomment( $id, $data )
	{
		$this->Model->Update( array( 'table' => 'shopcenter_workflow', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}
	
	function GetList( $userId = 0, $groupId = 0 )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_workflow';
		$cfg['conditionExt'] = "( user_id = '{$userId}' OR group_id = '{$groupId}' ) AND is_delete = 0";
		$cfg['order'] = 'id ASC';

		return $this->Model->GetList( $cfg );
	}
	
	function GetTotal( $userId = 0, $groupId = 0 )
	{
		$condition = array();

		$cfg = array();
		$cfg['table'] = 'shopcenter_workflow';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['conditionExt'] = "user_id = '{$userId}' OR group_id = '{$groupId}'";
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function SetDel( $flowName, $targetId, $flowStatus )
	{
		$condition = array();

		if ( $flowName )
			$condition['flow_name'] = $flowName;
		if ( $targetId )
			$condition['target_id'] = $targetId;
		if ( $flowStatus )
			$condition['flow_status'] = $flowStatus;
		
		$cfg = array();
		$cfg['table'] = 'shopcenter_workflow';
		$cfg['condition'] = $condition;
		$cfg['data'] = array( 'is_delete' => 1 );

		return $this->Model->Update( $cfg );
	}
}

?>