<?php

class ProductCollateModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_product_collate', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_collate';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}
function GetSupplie_id( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product';
		$cfg['condition'] = array( 'id' => $id );
		$cfg['key'] = 'supplier_now';

		return $this->Model->Get( $cfg );
	}


function GetProduct10010( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product';
		$cfg['condition'] = array( 'id' => $id );
		$cfg['key'] = 'supplier_now';

		return $this->Model->Get( $cfg );
	}
	
	
function GetSupplie( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_supplier';
		$cfg['condition'] = array( 'id' => $id );
		$cfg['key'] = 'name';

		return $this->Model->Get( $cfg );
	}

	function GetUnique( $targetId='',$channelID=0 )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_collate';
		$cfg['condition'] = array( 'target_id' => $targetId , 'channel_id' => $channelID);
		$collateInfo = $this->Model->Get( $cfg );
		return $collateInfo;
	}




	function GetAAAAAA()
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_collate';
		$cfg['condition'] = array( 'channel_id' => 70);
		$collateInfo = $this->Model->GetList( $cfg );
		
		$AAA = StrVals($collateInfo,"id");
		
		return $AAA;
	}
	
	function UpAAAAAA($IDS){
		$cfg = array();
		$cfg['table'] = "shopcenter_product_collate_price";
		$cfg['data'] = array( 'payout_rate' => 0.005,'xiaofw'=>1 );
	    $ext = array();
		$ext[] = "collate_id in ({$IDS}) ";
		$ext = array_filter( $ext );
		$cfg['conditionExt'] = $ext ? implode( ' AND ', $ext ) : false;
		$this->Model->Update( $cfg );
	}	
	
	
	function GetUniqueBySku( $skuId, $channelId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_collate';
		$cfg['condition'] = array( 
			'sku_id' => $skuId,
			'channel_id' => $channelId
		);

		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_product_collate',
			'data' => $data,
			'condition' => array( 'id' => $id )
		) );
	}

	function UpdateByProduct( $id, $data )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_product_collate',
			'data' => $data,
			'condition' => array( 'product_id' => $id )
		) );
	}

	function Search( $keyWord, $channelId )
	{
		if ( !$keyWord )
			return array();

		$conditionExt = array();

		if ( is_numeric( $keyWord ) )
			$conditionExt[] = "shopcenter_product.id LIKE '{$keyWord}%'";

		$conditionExt[] = "shopcenter_product.name LIKE '%{$keyWord}%'";
		$conditionExt[] = "shopcenter_product_collate.target_id LIKE '%{$keyWord}%'";

		$sql  = "SELECT shopcenter_product.*,shopcenter_product_collate.target_id FROM shopcenter_product_collate LEFT JOIN shopcenter_product ON shopcenter_product.id = shopcenter_product_collate.product_id ";
		$sql .= "WHERE shopcenter_product_collate.channel_id = {$channelId} ";

		if ( $conditionExt )
			$sql .= "AND ( " . implode( ' OR ', $conditionExt ) . ") ";

		$sql .= "GROUP BY shopcenter_product.id ";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
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
		$cfg['table'] = 'shopcenter_product_collate';
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
		$cfg['table'] = 'shopcenter_product_collate';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_collate';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function AddPrice( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_product_collate_price', 'data' => $data ) );
	}

	function GetPriceList( $collateId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_collate_price';
		$cfg['order'] = "id ASC";
		$cfg['condition'] = array( 'collate_id' => $collateId );

		return $this->Model->GetList( $cfg );
	}


	function GetPriceOne( $collateId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_collate_price';
		//$cfg['order'] = "id ASC";
		$cfg['condition'] = array(
			'collate_id' => $collateId,
			'instalment_times' => 1,
		);
		$cfg['key'] = 'price';

		return $this->Model->Get( $cfg );
	}

	function UpdatePrice( $id, $data )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_product_collate_price',
			'data' => $data,
			'condition' => array( 'id' => $id )
		) );
	}


	function UpAllPrice( $collate_id, $data )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_product_collate_price',
			'data' => $data,
			'condition' => array( 'collate_id' => $collate_id )
		) );
	}
	
	
	
	function GetPrice( $collateId, $instalmentTimes = false )
	{
		$condition = array();
		$condition['collate_id'] = $collateId;

		if ( $instalmentTimes )
			$condition['instalment_times'] = $instalmentTimes;

		return $this->Model->Get( array(
			'table' => 'shopcenter_product_collate_price',
			'condition' => $condition,
		) );
	}

	function GetPriceByPrice( $collateId, $price )
	{
		$condition = array();
		$condition['collate_id'] = $collateId;
		$condition['price'] = $price;

		return $this->Model->Get( array(
			'table' => 'shopcenter_product_collate_price',
			'condition' => $condition,
		) );
	}

	function DelPrice( $collateId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_collate_price';
		$cfg['condition'] = array( 'collate_id' => $collateId );

		return $this->Model->Del( $cfg );
	}
}

?>