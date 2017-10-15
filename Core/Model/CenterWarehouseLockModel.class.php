<?php

class CenterWarehouseLockModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_warehouse_lock', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_lock';
		$cfg['condition'] = array( 'id' => $id );
		
		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data, $dataExt = '' )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_warehouse_lock',
			'data' => $data,
			'dataExt' => $dataExt,
			'condition' => array( 'id' => $id )
		) );
	}

	function GetList( $search, $offset = 0, $limit = 0 )
	{
		$condition = array();
		$conditionExt = array();

		foreach ( $search as $key => $val )
		{
			switch($key)
			{
				case 'type':
				case 'warehouse_id':
					$condition[$key] = $val;
				break;
			}
		}

		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_lock';
		$cfg['order'] = "id ASC";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function GetListByOrder( $orderId )
	{
		$condition = array();
		$condition['order_id'] = $orderId;

		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_lock';
		$cfg['order'] = "id ASC";
		$cfg['condition'] = $condition;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function GetListByOrderProduct( $orderProductId )
	{
		$condition = array();
		$condition['order_product_id'] = $orderProductId;

		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_lock';
		$cfg['order'] = "id ASC";
		$cfg['condition'] = $condition;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_lock';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function GetUnique( $warehouseId, $placeId, $skuId, $orderProductId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_lock';
		$cfg['condition'] = array( 'warehouse_id' => $warehouseId, 'place_id' => $placeId, 'sku_id' => $skuId, 'order_product_id' => $orderProductId );

		return $this->Model->Get( $cfg );
	}

	function GetOrderDeliveryTypeList( $orderId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_lock';
		$cfg['group'] = 'warehouse_id';
		$cfg['condition'] = array( 'order_id' => $orderId );

		return $this->Model->GetList( $cfg );
	}
}

?>