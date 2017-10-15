<?php

class CenterProductModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}



	function Update1011( $id, $val )
	{
		$data['ERP_SKU'] = $val;
		return $this->Model->Update( array( 'table' => 'shopcenter_product_sku', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}



	function Update1114( $id, $val )
	{
		$cfg = array();
		$cfg['select'] = 'id';
		$cfg['key'] = 'id';
		$cfg['table'] = 'shopcenter_product_collate';
		$cfg['condition'] = array( 'target_id' => $id,'channel_id' => 92 );
		$CID =  $this->Model->Get( $cfg );
		
		$dataA = array();
		$dataA['price'] = $val;
		$this->Model->Update( array( 'table' => 'shopcenter_product_collate_price', 'data' => $dataA, 'condition' => array( 'collate_id' => $CID ) ) );
		//$list = ArrayVals($list,"id");
		//TestArray($CID);
		/*
		*/
		
		$data = array();
		$data['total_money'] = $val;
		$data['total_pay_money'] = $val;
		$this->Model->Update( array( 'table' => 'shopcenter_order', 'data' => $data, 'condition' => array( 'channel_id' => 92,'target_id' => $id, ) ) );
		
		$datas = array();
		$datas['price'] = $val;
		$datas['sale_price'] = $val;
		$datas['total_pay_money_one'] = $val;
		
		$this->Model->Update( array( 'table' => 'shopcenter_order_product', 'data' => $datas, 'condition' => array( 'price' => 1,'target_id' => $id, ) ) );



		//$data = array();
		//$data['ERP_SKU'] = $val;
		//return $this->Model->Update( array( 'table' => 'shopcenter_product_sku', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}


	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function GetByName( $name )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product';
		$cfg['condition'] = array( 'name' => $name );

		return $this->Model->Get( $cfg );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_product', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Update0229()
	{
		
		$data = array();
		$data['supplier_now'] = 308;
		$this->Model->Update( array( 'table' => 'shopcenter_product', 'data' => $data, 'condition' => array( 'supplier_now' => 192 ) ) );
		//$aaa = $this->Model->GetList( array( 'table' => 'shopcenter_product', 'data' => $data, 'condition' => array( 'supplier_now' => 192 ) ) );
		//echo count($aaa);
		//print_r($aaa);
		
	}


	function Update( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_product', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function GetList( $search, $offset = 0, $limit = 0 )
	{
		
		$condition = array();
		$ext = array();

		if ( $search['category_id'] )
			$ext[] = "cid IN (" . $search['category_id'] . ")";

		if ( $search['product_id'] )
			$ext[] = "id LIKE '%" . (int)$search['product_id'] . "%'";

		if ( $search['begin_time'] )
			$ext[] = "add_time >= " . intval( $search['begin_time'] + 8 * 3600 );

		if ( $search['end_time'] )
			$ext[] = "add_time <= " . intval( $search['end_time'] + 8 * 3600 );

		if ( $search['word'] )
			$ext[] = "name LIKE '%" . addslashes( $search['word'] ) . "%'";

		if ( strlen( $search['warehouse'] ) )
			$ext[] = "warehouse LIKE '%" . addslashes( $search['warehouse'] ) . "%'";



		if ( $search['manager_user_id'] )
			$ext[] = "manager_user_id IN (" . $search['manager_user_id'] . ")";

		if ( $search['supplier_now']>0)
			$ext[] = "supplier_now =" . (int)$search['supplier_now'] ;



		$ext = array_filter( $ext );

		$cfg = array();
		$cfg['table'] = 'shopcenter_product';
		$cfg['order'] = "id DESC";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = $ext ? implode( ' AND ', $ext ) : false;
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		if ( $search['order'] && $search['by'] )
			$cfg['order'] = "{$search['by']} {$search['order']}";

		return $this->Model->GetList( $cfg );
	}

	function GetTotal( $search )
	{
		$condition = array();
		$ext = array();

		if ( $search['category_id'] )
			$ext[] = "cid IN (" . $search['category_id'] . ")";

		if ( $search['product_id'] )
			$ext[] = "id LIKE '%" . (int)$search['product_id'] . "%'";

		if ( $search['begin_time'] )
			$ext[] = "add_time >= " . intval( $search['begin_time'] + 8 * 3600 );

		if ( $search['end_time'] )
			$ext[] = "add_time <= " . intval( $search['end_time'] + 8 * 3600 );

		if ( $search['word'] )
			$ext[] = "name LIKE '%" . addslashes( $search['word'] ) . "%'";

		if ( strlen( $search['warehouse'] ) )
			$ext[] = "warehouse LIKE '%" . addslashes( $search['warehouse'] ) . "%'";


		if ( $search['manager_user_id'] )
			$ext[] = "manager_user_id IN (" . $search['manager_user_id'] . ")";

		if ( $search['supplier_now']>0)
			$ext[] = "supplier_now =" . (int)$search['supplier_now'] ;

		$ext = array_filter( $ext );

		$cfg = array();
		$cfg['table'] = 'shopcenter_product';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['key'] = 'total';
		$cfg['conditionExt'] = $ext ? implode( ' AND ', $ext ) : false;
		$cfg['condition'] = $condition;

		return $this->Model->Get( $cfg );
	}

	function GetListById( $ids )
	{
		if ( is_array( $ids ) )
			$ids = implode( ',', $ids );
		if ( !$ids )
			return array();

		$condition = array();

		$cfg = array();
		$cfg['table'] = 'shopcenter_product';
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = "id IN ({$ids})";
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function Search( $keyWord,$supplier_id )
	{
		if ( !$keyWord )
			return array();

		//$conditionExt = array();

		//if ( is_numeric( $keyWord ) )
			//$conditionExt[] = "id LIKE '{$keyWord}%'";

		//$conditionExt[] = "name LIKE '%{$keyWord}%'";

		$cfg = array();

		$sql  = "SELECT * FROM shopcenter_product ";
		if( (int)$supplier_id>0 )
		{
		$sql .= "WHERE (name LIKE '%{$keyWord}%' or scope LIKE '%{$keyWord}%' or id LIKE '%{$keyWord}%') AND (supplier_now ={$supplier_id} ) ";
		}
		else
		{
		$sql .= "WHERE name LIKE '%{$keyWord}%' or scope LIKE '%{$keyWord}%' or id LIKE '%{$keyWord}%' ";
		}

		//$cfg['table'] = 'shopcenter_product';
		//$cfg['condition'] = $condition;
		//$cfg['conditionExt'] = implode( ' OR ', $conditionExt );
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}

	function GetSkuByHash( $hash )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_sku';
		$cfg['condition'] = array( 'hash_key' => $hash );

		return $this->Model->Get( $cfg );
	}

	function GetSku( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_sku';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function GetBaseSku( $productId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_sku';
		$cfg['condition'] = array( 'pid' => $productId, 'is_base' => 1 );

		return $this->Model->Get( $cfg );
	}

	function GetSaleSku( $productId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_sku';
		$cfg['condition'] = array( 'pid' => $productId, 'is_base' => 0 );
		//$cfg['condition'] = array( 'pid' => $productId );

		return $this->Model->GetList( $cfg );
	}

	function GetSaleAll( $productId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_buy_attribute_value';
		$cfg['condition'] = array( 'pid' => $productId, 'service' => 0 );
		//$cfg['condition'] = array( 'pid' => $productId );

		return $this->Model->GetList( $cfg );
	}

	
	function DelSkuByProduct( $productId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_sku';
		$cfg['condition'] = array( 'pid' => $productId );

		return $this->Model->Del( $cfg );
	}

	function AddSku( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_product_sku', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function GetUnique( $name )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product';
		$cfg['condition'] = array( 'name' => $name );

		return $this->Model->Get( $cfg );
	}
}

?>