<?php

class CenterWarehousePlaceModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_warehouse_place', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_place';
		$cfg['condition'] = array( 'id' => $id );
		
		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_warehouse_place', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function GetByName( $warehouseId, $name )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_place';
		$cfg['condition'] = array( 'name' => $name, 'warehouse_id' => $warehouseId );

		return $this->Model->Get( $cfg );
	}

	function Search( $keyWord, $warehouseId )
	{
		if ( !$keyWord )
			return array();

		$conditionExt = array();

		$conditionExt[] = "name LIKE '%{$keyWord}%'";

		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_place';
		$cfg['condition'] = array( 'warehouse_id' => $warehouseId );
		$cfg['conditionExt'] = implode( ' OR ', $conditionExt );

		return $this->Model->GetList( $cfg );
	}

	function GetList( $warehouseId, $offset = 0, $limit = 0 )
	{
		$condition = array();
		
		if ( $warehouseId )
			$condition['warehouse_id'] = $warehouseId;
		
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_place';
		$cfg['order'] = "id DESC";
		$cfg['condition'] = $condition;
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		return $this->Model->GetList( $cfg );
	}

	function GetTotal( $warehouseId )
	{
		$condition = array();

		if ( $warehouseId )
			$condition['warehouse_id'] = $warehouseId;

		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_place';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['condition'] = $condition;
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_place';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}
}

?>