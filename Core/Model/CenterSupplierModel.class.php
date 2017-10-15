<?php

class CenterSupplierModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_supplier';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function GetByName( $name )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_supplier';
		$cfg['condition'] = array( 'name' => $name );

		return $this->Model->Get( $cfg );
	}

	function GetByNameNoId( $name, $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_supplier';
		$cfg['condition'] = array( 'name' => $name );
		$cfg['conditionExt'] = ' id<> '.$id.'';

		return $this->Model->Get( $cfg );
	}


	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_supplier', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_supplier', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function GetMyJl( $id )
	{ 
		$cfg = array();
		$cfg['table'] = 'sys_administrator';
		$cfg['select'] = "user_product_1";
		$cfg['condition'] = array('user_id' => $id);
		$cfg['key'] = 'user_product_1';

		return $this->Model->Get( $cfg );
	}


	function GetCondition( $search )
	{
		$condition = array();
		$conditionExt = array();

		foreach ( $search as $key => $val )
		{
			switch($key)
			{
				case 'manage_zj':
					$conditionExt[] = "(manage_id IN( SELECT user_id FROM sys_administrator WHERE user_product ={$val} ))";
				break;
				case 'manage_zl':
					$conditionExt[] = "(manage_id IN( SELECT user_product_1 FROM sys_administrator WHERE user_id ={$val} ))";
				break;
				case 'manage_OK':
					$conditionExt[] = "manage_id>0";
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
		$cfg['table'] = 'shopcenter_supplier';
		$cfg['order'] = "is_good DESC,id";
		$cfg['key'] = "id";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		return $this->Model->GetList( $cfg );
	}

	function GetTotal($search = array())
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );

		$cfg = array();
		$cfg['table'] = 'shopcenter_supplier';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_supplier';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function Search( $keyWord )
	{
		if ( !$keyWord )
			return array();

		//$conditionExt = array();

		//if ( is_numeric( $keyWord ) )
			//$conditionExt[] = "id LIKE '{$keyWord}%'";

		//$conditionExt[] = "(name LIKE '%{$keyWord}%' or scope LIKE '%{$keyWord}%')";
		//$conditionExt[] = "scope LIKE '%{$keyWord}%'";

		$cfg = array();
		//$cfg['table'] = 'shopcenter_supplier';
		//$cfg['condition'] = $condition;
		//$cfg['condition'] = array( 'manage_id' => 1 );
		//$cfg['conditionExt'] = implode( ' OR ', $conditionExt );





		$sql  = "SELECT * FROM shopcenter_supplier ";
		$sql .= "WHERE (name LIKE '%{$keyWord}%' or scope LIKE '%{$keyWord}%') ";

global $__UserAuth;
if( $__UserAuth['user_group']==38 || $__UserAuth['user_group']==15 )
{
$sql .= "AND id>0 ";
}
elseif($__UserAuth['user_group']==14)
{
$sql .= "AND (manage_id IN( SELECT user_id FROM sys_administrator WHERE user_product ={$__UserAuth['user_id']} )) ";
}
else
{
$sql .= "AND manage_id={$__UserAuth['user_id']}  ";
}

		$cfg['sql'] = $sql;
		$T_data = $this->Model->GetList( $cfg );

		return $T_data;
	}



	function GetInvoiceTotal( $supplier_id )
	{
		$cfg = array();
		$sql  = "SELECT SUM(price) AS totalMoney FROM shopcenter_invoice WHERE supplier_id = {$supplier_id} GROUP BY supplier_id ";
		$cfg['sql'] = $sql;
		$cfg['key'] = 'totalMoney';

		return $this->Model->Get( $cfg );
	}
	
	
	function GetInvoiceList( $supplier_id )
	{
		$cfg = array();
		$sql  = "SELECT * FROM shopcenter_invoice WHERE supplier_id = {$supplier_id} ";
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}
	
	function GetInvoice( $sn )
	{
		$cfg = array();
		$sql  = "SELECT id FROM shopcenter_invoice WHERE sn = {$sn} ";
		$cfg['sql'] = $sql;

		return $this->Model->Get( $cfg );
	}


	function AddInvoice( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_invoice', 'data' => $data ) );
		//return $this->Model->DB->LastID();
	}





}

?>