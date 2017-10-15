<?php

class CenterReceiveModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array(
			'table' => 'shopcenter_receive',
			'data' => $data
		) );

		return $this->Model->DB->LastID();
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_receive';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_receive',
			'data' => $data,
			'condition' => array( 'id' => $id )
		) );
	}

	function GetList( $search = array(), $offset = 0, $limit = 0 )
	{
		$condition = array();
		$conditionExt = array();

		foreach ( $search as $key => $val )
		{
			switch($key)
			{
				case 'wait_store':
					$conditionExt[] = "into_status < 3";
				break;

				default:
					if ( $val )
						$condition[$key] = $val;
				break;
			}
		}

		$cfg = array();
		$cfg['table'] = 'shopcenter_receive';
		$cfg['order'] = "id DESC";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function GetProductStatusNum( $receiveId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_receive_product';
		$cfg['select'] = 'SUM(into_quantity) AS total_into_quantity';
		$cfg['condition'] = array( 'receive_id' => $receiveId );

		return $this->Model->Get( $cfg );
	}

	function GetTotal()
	{
		$condition = array();

		$cfg = array();
		$cfg['table'] = 'shopcenter_receive';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_receive';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function StatTotal( $id ){

		$info = $this->Model->Get( array(
			'table' => 'shopcenter_receive_product',
			'select' => 'SUM(quantity) AS total_quantity',
			'condition' => array( 'receive_id' => $id )
		) );

		$this->Update( $id, $info );
	}

	function AddProduct( $data )
	{
		$this->Model->Add( array(
			'table' => 'shopcenter_receive_product',
			'data' => $data
		) );
		
		return $this->Model->DB->LastID();
	}

	function GetProduct( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_receive_product';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function UpdateProduct( $id, $data, $dataExt = '' )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_receive_product',
			'data' => $data,
			'dataExt' => $dataExt,
			'condition' => array( 'id' => $id )
		) );
	}

	function GetProductList( $receiveId = 0, $offset = 0, $limit = 0 )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_receive_product';
		$cfg['order'] = "id ASC";
		$cfg['condition'] = array( 'receive_id' => $receiveId );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function DelProduct( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_receive_product';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}
}

?>