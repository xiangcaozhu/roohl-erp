<?php

class CenterWarehouseStockModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function CCC1115()
	{
		$TIME = strtotime("2016-01-01");
		$sql  = "SELECT swl.*,sps.erp_sku AS erp_sku,sp.name AS product_name,ss.key_mode ";
		$sql .= "FROM shopcenter_warehouse_log AS swl ";
		$sql .= "LEFT JOIN shopcenter_product_sku AS sps ON sps.id = swl.sku_id ";
		$sql .= "LEFT JOIN shopcenter_product AS sp ON sp.id = swl.product_id ";
		$sql .= "LEFT JOIN shopcenter_supplier AS ss ON ss.id = sp.supplier_now ";
		$sql .= "where swl.type=2 and swl.warehouse_id=6 and swl.add_time>=".$TIME." ";
		$sql .= "group by swl.sku_id";
		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
		
	}



	function BBB1115()
	{
		$TIME = strtotime("2016-01-01");
		$sql  = "SELECT supplier_id ";
		$sql .= "FROM shopcenter_purchase ";
		$sql .= "where add_time>=".$TIME." ";
		$sql .= "GROUP BY supplier_id ";
		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
		
	}

	function BBB1116($ids)
	{
		$data = array();
		$data['is_good'] = 1;
		
		$this->Model->Update( array(
			'table' => 'shopcenter_supplier',
			'data' => $data,
			'conditionExt' => 'id in ('.$ids.') '
		) );
	}



	function AAA1116($ids)
	{
		$data = array();
		$data['supplier_now'] = 398;
		
		$this->Model->Update( array(
			'table' => 'shopcenter_product',
			'data' => $data,
			'conditionExt' => 'supplier_now in ('.$ids.') '
		) );
	}

	function AAA1115($id)
	{
		$data = array();
		$data['supplier_now'] = 398;
		$this->Model->Update( array(
			'table' => 'shopcenter_product',
			'data' => $data,
			'condition' => array( 'supplier_now' => $id )
		) );


		$datas = array();
		$datas['manage_name'] = "";
		$datas['manage_id'] = 0;
		$this->Model->Update( array(
			'table' => 'shopcenter_supplier',
			'data' => $datas,
			'condition' => array( 'id' => $id )
		) );


	}









	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_warehouse_stock', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function GetByPlace( $placeId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_stock';
		$cfg['condition'] = array( 'place_id' => $placeId );
		
		return $this->Model->Get( $cfg );
	}

	function GetUnique( $warehouseId, $placeId, $skuId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_stock';
		$cfg['condition'] = array( 'warehouse_id' => $warehouseId, 'place_id' => $placeId, 'sku_id' => $skuId );
		
		return $this->Model->Get( $cfg );
	}

	function UpdateUnique( $warehouseId, $placeId, $skuId, $data, $dataExt = '' )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_stock';
		$cfg['data'] = $data;
		$cfg['dataExt'] = $dataExt;
		$cfg['condition'] = array( 'warehouse_id' => $warehouseId, 'place_id' => $placeId, 'sku_id' => $skuId );
		
		return $this->Model->Update( $cfg );
	}

	function UpdateByPlace( $warehouseId, $placeId, $data, $dataExt = '' )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_stock';
		$cfg['data'] = $data;
		$cfg['dataExt'] = $dataExt;
		$cfg['condition'] = array( 'warehouse_id' => $warehouseId, 'place_id' => $placeId );
		
		return $this->Model->Update( $cfg );
	}

	function GetSumByPlace( $placeId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_stock';
		$cfg['select'] = 'SUM(quantity) AS total';
		$cfg['condition'] = array( 'place_id' => $placeId );
		$cfg['key'] = 'total';
		
		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_warehouse_stock', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function GetList( $search, $offset = 0, $limit = 0 )
	{
		$condition = array();
		$conditionExt = array();

		foreach ( $search as $key => $val )
		{
			switch($key)
			{
				case 'todo':
					// todo
				break;
				case 'view_type':
					if ( $val == 1 )
						$conditionExt[] = "quantity > 0";
					elseif ( $val == 2 )
						$conditionExt[] = "quantity = 0";
				break;

				default:
					if ( $val )
						$condition[$key] = $val;
				break;
			}
		}

		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_stock';
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		//$cfg['order'] = "op,manage_id DESC,id DESC";
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		return $this->Model->GetList( $cfg );
	}

	function GetList1115()
	{
		$sql  = "SELECT sws.*,sps.erp_sku ";
		$sql .= "FROM shopcenter_warehouse_stock AS sws ";
		$sql .= "LEFT JOIN shopcenter_product_sku AS sps ON sps.id = sws.sku_id ";
		$sql .= "WHERE sws.quantity > 0 ";
		$sql .= "AND sps.erp_sku<>'' ";
		//$sql .= "GROUP BY sku_id ";

		$cfg = array();
		$cfg['sql'] = $sql;
                           
		return $this->Model->GetList( $cfg );
	}
	
	function GetTotal()
	{
		$condition = array();

		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_stock';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_stock';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function GetLiveQuantityBySkuId( $skuId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_stock';
		$cfg['select'] = 'SUM(quantity) AS quantity, SUM(lock_quantity) AS lock_quantity, SUM(quantity - lock_quantity) AS live_quantity';
		$cfg['condition'] = array( 'sku_id' => $skuId, 'no_delivery' => 0 );
		
		return $this->Model->Get( $cfg );
	}

	function GetLiveListBySkuId( $skuId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_stock';
		$cfg['condition'] = array( 'sku_id' => $skuId, 'no_delivery' => 0 );
		$cfg['conditionExt'] = "quantity > lock_quantity";

		return $this->Model->GetList( $cfg );
	}
}

?>