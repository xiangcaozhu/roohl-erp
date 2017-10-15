<?php

class CenterWarehouseLogModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_warehouse_log', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_log';
		$cfg['condition'] = array( 'id' => $id );
		
		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_warehouse_log', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function GetList( $targetId, $type = 1 )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_log';
		$cfg['order'] = "id DESC";
		$cfg['condition'] = array( 'target_id' => $targetId, 'type' => $type );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		return $this->Model->GetList( $cfg );
	}

	function GetListGroup( $targetId, $type = 1 )
	{
		$sql  = "SELECT *, SUM(quantity) AS total_quantity,COUNT(*) AS total_num ";
		$sql .= "FROM shopcenter_warehouse_log ";
		$sql .= "WHERE target_id = {$targetId} AND type={$type} ";
		$sql .= "GROUP BY sku_id ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

/*
        $cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_log';
		$cfg['order'] = "id DESC";
		$cfg['condition'] = array( 'target_id' => $targetId, 'type' => $type );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['group'] = 'sku';
*/
		return $this->Model->GetList( $cfg );
	}
	
	
	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_log';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function GetJournalList( $search )
	{
		$condition = array();
		$conditionExt = array();

		foreach ( $search as $key => $val )
		{
			switch($key)
			{
				case 'begin_time':
					if ( $val )
						$conditionExt[] = "add_time >= " . ( $val + 8 * 3600 );
				break;
				case 'end_time':
					if ( $val )
						$conditionExt[] = "add_time <= ". ( $val + 8 * 3600 );
				break;
				case 'category':
					if ( $val )
					{
						$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );
						$CenterCategoryModel->BuildTree( 1 );

						$list = explode( ',', $val );
						$cidList = array();
						foreach ( $list as $cid )
						{
							$cid = intval( $cid );

							$cidList[$cid] = 1;
							$subCategoryIdList = $CenterCategoryModel->GetChildID( $cid );

							foreach ( $subCategoryIdList as $id )
							{
								$cidList[$id] = 1;
							}
						}

						$conditionExt[] = "product_id IN (SELECT id FROM shopcenter_product WHERE cid IN(" . implode( ',', array_keys( $cidList ) ) . "))";
					}
				break;

				default:
					if ( $val )
						$condition[$key] = $val;
				break;
			}
		}

		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_log';
		$cfg['order'] = "id ASC";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}
}

?>