<?php

class CenterStoreModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array(
			'table' => 'shopcenter_store',
			'data' => $data
		) );

		return $this->Model->DB->LastID();
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_store';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_store',
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
				case 'begin_time':
					if ( $val )
						$conditionExt[] = 'add_time >= ' . ( $val );
				break;
				case 'end_time':
					if ( $val )
						$conditionExt[] = 'add_time <= ' . ( $val );
				break;

				default:
					if ( strlen( $val ) > 0 )
						$condition[$key] = $val;
				break;
			}
		}

		$cfg = array();
		$cfg['table'] = 'shopcenter_store';
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

				default:
					if ( strlen( $val ) > 0 )
						$condition[$key] = $val;
				break;
			}
		}

		$cfg = array();
		$cfg['table'] = 'shopcenter_store';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function StatTotal( $id )
	{
		$info = $this->Model->Get( array(
			'table' => 'shopcenter_warehouse_log',
			'select' => 'SUM(quantity) AS total_quantity, COUNT(*) AS total_breed',
			'condition' => array( 'target_id' => $id, 'type' => 1 )
		) );

		$this->Update( $id, $info );
	}
}

?>