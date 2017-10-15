<?php

class CenterDeliveryModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array(
			'table' => 'shopcenter_delivery',
			'data' => $data
		) );

		return $this->Model->DB->LastID();
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_delivery';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_delivery',
			'data' => $data,
			'condition' => array( 'id' => $id )
		) );
	}

	function GetCondition( $search )
	{
		$condition = array();
		$conditionExt = array();

		foreach ( $search as $key => $val )
		{
			switch($key)
			{
				case 'begin_time':
					if ( $val )
						$conditionExt[] = 'add_time >= ' . ( $val );
				break;
				case 'end_time':
					if ( $val )
						$conditionExt[] = 'add_time <= ' . ( $val );
				break;
				case 'is_print':
						$conditionExt[] = 'is_print = ' . ( $val );
				break;
				case 'is_logistics':
						$conditionExt[] = 'is_logistics = ' . ( $val );
				break;

				default:
					if ( $val )
						$condition[$key] = $val;
				break;
			}
		}

		return array( $condition, $conditionExt );
	}

	function GetList( $search = array(), $offset = 0, $limit = 0 )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );

		$cfg = array();
		$cfg['table'] = 'shopcenter_delivery';
		$cfg['order'] = "id DESC";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function GetTotal( $search = array() )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );

		$cfg = array();
		$cfg['table'] = 'shopcenter_delivery';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function GetProductStatusNum( $receiveId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_delivery_product';
		$cfg['select'] = 'SUM(into_quantity) AS total_into_quantity';
		$cfg['condition'] = array( 'receive_id' => $receiveId );

		return $this->Model->Get( $cfg );
	}

	function GetByOrder( $orderId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_delivery';
		$cfg['condition'] = array( 'order_id' => $orderId );

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_delivery';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function StatTotal( $id )
	{
		$info = $this->Model->Get( array(
			'table' => 'shopcenter_warehouse_log',
			'select' => 'SUM(quantity) AS total_quantity, COUNT(*) AS total_breed',
			'condition' => array( 'target_id' => $id, 'type' => 2 )
		) );

		$this->Update( $id, $info );
	}
}

?>