<?php

class CenterWarehouseModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_warehouse', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_warehouse', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function GetList( $offset = 0, $limit = 0, $search = 0)
	{

		$condition = array();
		$conditionExt = array();
		
		if($search==1)
		$conditionExt[] = "id > 5";
		
		if($search==2)
		$conditionExt[] = "id = 5 ";

        $cfg = array();
		$cfg['table'] = 'shopcenter_warehouse';
		$cfg['order'] = "id DESC";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function GetTotal()
	{
		$condition = array();

		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}
}

?>