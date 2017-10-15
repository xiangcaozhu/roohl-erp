<?php

class ProductSubmitModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_product_submit', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_submit';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function GetUnique( $targetId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_submit';
		$cfg['condition'] = array( 'target_id' => $targetId );

		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_product_submit',
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
						$conditionExt[] = 'add_time >= ' . ( $val + 8 * 3600 );
				break;
				case 'end_time':
					if ( $val )
						$conditionExt[] = 'add_time <= ' . ( $val + 8 * 3600 );
				break;

				default:
					if ( $val != '' )
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
		$cfg['table'] = 'shopcenter_product_submit';
		$cfg['order'] = "id DESC";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function GetTotal( $search )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );

		$cfg = array();
		$cfg['table'] = 'shopcenter_product_submit';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_submit';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}
}

?>