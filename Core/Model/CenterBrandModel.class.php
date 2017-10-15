<?php

class CenterBrandModel
{
	function Init()
	{
		$this->Model = & Core::ImportBaseClass( 'Model' );
	}


	function GetNeedList_mast()
	{
		$sql  = "SELECT sbav.id,sbav.pid,sbav.name,sp.name as pname,ss.name as sname,ss.id as sid ";
		$sql .= "FROM shopcenter_buy_attribute_value AS sbav ";
		$sql .= "INNER JOIN shopcenter_product AS sp ON (sp.id = sbav.pid) ";
		$sql .= "INNER JOIN shopcenter_supplier AS ss ON (ss.id = sp.supplier_now) ";
		$sql .= "WHERE ss.key_mode = 1 ";
		


		$cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->GetList( $cfg );
	}


	function G1()
	{
		$sql  = "SELECT sp.id as pid,sp.name as pname,ss.name as sname,ss.id as sid ";
		$sql .= "FROM shopcenter_product AS sp ";
		$sql .= "INNER JOIN shopcenter_supplier AS ss ON (ss.id = sp.supplier_now) ";
		$sql .= "WHERE ss.key_mode = 1 ";
		


		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['offset'] = 0;
		$cfg['limit'] = 0;

		return $this->Model->GetList( $cfg );
	}

	function G2()
	{
		$sql  = "SELECT sp.id as pid,sp.name as pname ";
		$sql .= "FROM shopcenter_product AS sp ";
		//$sql .= "INNER JOIN shopcenter_supplier AS ss ON (ss.id = 0) ";
		$sql .= "WHERE sp.supplier_now = 0 ";
		


		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['offset'] = 0;
		$cfg['limit'] = 0;

		return $this->Model->GetList( $cfg );
	}
	
	function G3()
	{
		$Ltime = strtotime("2016-04-01");
		$sql  = "SELECT swl.product_id AS Pid,sp.name AS Pname,SUM(swl.quantity) AS Ptotal,swl.sku AS Psku,swl.sku_id AS Psku_id ";
		$sql .= "FROM shopcenter_warehouse_log AS swl ";
		$sql .= "INNER JOIN shopcenter_product AS sp ON (sp.id = swl.product_id) ";
		$sql .= "INNER JOIN shopcenter_supplier AS ss ON (ss.id = sp.supplier_now) ";
		$sql .= "WHERE ss.key_mode = 1 AND swl.type=2 AND swl.warehouse_id=6 AND swl.add_time>".$Ltime." ";
		$sql .= "GROUP BY swl.product_id ";
		


		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['offset'] = 0;
		$cfg['limit'] = 0;

		return $this->Model->GetList( $cfg );
	}




















	function Del1012( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_product_sku';
		$cfg['conditionExt'] = "id IN({$id})";

		return $this->Model->Del( $cfg );
	}























	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_brand';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_brand', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_brand', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function GetList( $offset = 0, $limit = 0 )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_brand';
		$cfg['order'] = "id DESC";
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		return $this->Model->GetList( $cfg );
	}

	function GetListById( $ids )
	{
		if ( !$ids )
			return false;
		
		$cfg = array();
		$cfg['table'] = 'shopcenter_brand';
		$cfg['conditionExt'] = "id IN({$ids})";

		return $this->Model->GetList( $cfg );
	}

	function GetTotal()
	{
		$condition = array();

		$cfg = array();
		$cfg['table'] = 'shopcenter_brand';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$this->Model->Del( array( 'table' => 'shopcenter_brand', 'condition' => array( 'id' => $id ) ) );
	}
}

?>