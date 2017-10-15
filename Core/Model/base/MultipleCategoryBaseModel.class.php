<?php

include_once( Core::GetConfig( 'core_lib_path' ) . 'NEATCategory.class.php' );

class MultipleCategoryBaseModel
{
	var $categoryList;
	var $categoryTree;

	var $extTree;
	var $extTreeTempArray;

	var $checkbox = false;
	var $checkedList = array();

	var $siteId;

	var $table;
	var $extraTable;
	var $blockTable;
	var $blockConfigTable;

	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
		$this->NC = new NEATCategory;

		$field = array();
		$field['id'] = 'id';
		$field['pid'] = 'pid';
		$field['orderid'] = 'order_id';
		$field['hidden'] = 'hidden';

		$this->NC->SetTable( $this->table);

		$this->NC->SetField( $field );
		$this->NC->SetNDB( $this->Model->DB );
	}

	function SetSiteId( $siteId )
	{
		$this->siteId = $siteId;
	}

	function SetTree( $tree )
	{
		$this->categoryTree = $tree;
	}

	function TreeExists()
	{
		return $this->categoryTree ? true : false;
	}

	function BuildTree( $noHidden = 0 )
	{
		unset( $this->NC->tmpgetArray );

		$this->NC->hide = $noHidden;

		$categoryList = $this->GetSiteCategory();
		$categoryTree = $this->NC->GetTree( $categoryList, 0, 0, 'category' );

		if ( !is_array( $categoryTree ) )
		{
			$categoryTree = array();
		}

		$this->categoryTree = $categoryTree;

		return $this->categoryTree;
	}

	function GetSiteCategory()
	{
		if ( $this->categoryList )
			return $this->categoryList;

		$this->categoryList = $this->Model->GetList( array(
			'table' => $this->table,
			'condition' => array( 'site_id' => intval( $this->siteId ) ),
			'order' => 'order_id DESC'
		) );

		if ( $this->hasExtra )
		{
			$extraList = $this->GetExtraList();

			if ( $this->categoryList )
			{
				foreach ( $this->categoryList as $k => $val )
				{
					$this->categoryList[$k]['extra'] = $extraList[$val['id']];
				}
			}
		}

		return $this->categoryList;
	}

	function GetExtTree( $checkbox = false, $checkedList = array() )
	{
		$categoryList = $this->GetSiteCategory();

		$this->checkbox = $checkbox;
		$this->checkedList = $checkedList;

		$this->tmpgetArray = array();
		$this->BuildExtTree( $categoryList, 0, $this->tmpgetArray );

		$this->checkbox = false;
		$this->checkedList = array();

		return $this->tmpgetArray;
	}

	function BuildExtTree( $array, $pid = 0, &$cache )
	{
		if ( is_array( $array ) && !empty( $array ) )
		{
			foreach( $array as $key => $val )
			{
				if ( $val['pid'] == $pid )
				{
					$count = count( $cache );
					$cache[$count] = $val;
					$cache[$count]['children'] = array();
					$cache[$count]['text'] = $val['name'] . "(ID:{$val['id']})";
					$cache[$count]['cls'] = 'cls_hide_' . $val['hidden'];
					$cache[$count]['expanded'] = $this->HasChildren( $val['id'] ) ? false : true;
					if ( $this->checkbox )
					{
						if ( @in_array( $val['id'], $this->checkedList ) )
							$cache[$count]['checked'] = true;
						else
							$cache[$count]['checked'] = false;
					}

					$this->BuildExtTree( $array, $val['id'], $cache[$count]['children'] );
				}
			}
		}
	}

	function HasChildren( $id )
	{
		$categoryList = $this->GetSiteCategory();

		foreach( $categoryList as $key => $val )
		{
			if ( $val['pid'] == $id )
			{
				return true;
			}
		}

		return false;
	}

	function GetSelectTree( $id = 0 )
	{
		$i = 0;
		foreach ( $this->categoryTree as $val )
		{
			$arr[$i]['id'] = $val['id'];
			$arr[$i]['name'] = str_repeat( '&nbsp;&nbsp;&nbsp;', $val['deep'] ) . $val['name'];

			if ( $val['id'] == $id )
				$arr[$i]['selected'] = 'selected';

			$i++;
		}

		return $arr;
	}

	function GetTree()
	{
		return $this->categoryTree;
	}

	function GetFromTree( $id )
	{
		return $this->categoryTree[$id];
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = $this->table;
		$cfg['condition'] = array( 'id' => $id );

		$info = $this->Model->Get( $cfg );

		if ( $this->hasExtra )
		{
			$info['extra'] = $this->GetExtra( $id );
		}

		return $info;
	}

	function GetMinOrderId( $pid = 0 )
	{
		$cfg = array();
		$cfg['table'] = $this->table;
		$cfg['select'] = 'min(order_id) AS min_order_id';
		$cfg['key'] = 'min_order_id';
		$cfg['condition'] = array( 'pid' => $pid, 'site_id' => $this->siteId );

		return $this->Model->Get( $cfg );
	}

	function GetByName( $name )
	{
		$cfg = array();
		$cfg['table'] = $this->table;
		$cfg['condition'] = array( 'name' => $name );

		return $this->Model->Get( $cfg );
	}

	function Add( $data )
	{
		$maxOrderID = $this->NC->GetNodeMaxOrderID( $data['pid'] );

		$data['order_id'] = $maxOrderID;

		$cfg = array();
		$cfg['table'] = $this->table;
		$cfg['data'] = $data;

		$this->Model->Add( $cfg );
		return $this->Model->DB->LastID();
	}

	function Update( $id, $data )
	{
		$cfg = array();
		$cfg['table'] = $this->table;
		$cfg['condition'] = array( 'id' => $id );
		$cfg['data'] = $data;

		return $this->Model->Update( $cfg );
	}

	function UpdateOrderId( $pid = 0, $orderId = 0 )
	{
		$cfg = array();
		$cfg['table'] = $this->table;
		$cfg['condition'] = array( 'pid' => $pid, 'site_id' => $this->siteId );
		$cfg['conditionExt'] = "order_id <= {$orderId}";
		$cfg['dataExt'] = "order_id = order_id - 1";

		return $this->Model->Update( $cfg );
	}

	function GetParentID( $id )
	{
		// 倒转数组,从下往上寻找
		$list = @array_reverse( $this->categoryTree, true );

		$array = array();
		$deep = -1;

		foreach ( $list as $val )
		{
			if ( $val['id'] == $id )
				$deep = $val['deep'] - 1;

			if ( $deep != -1 && $deep == $val['deep'] )
			{
				$array[] = $val['id'];

				$deep--;
			}
		}

		return array_reverse( $array );
	}

	function UpdateParentIdList()
	{
		foreach ( $this->categoryTree as $val )
		{
			$pidList = $this->GetParentID( $val['id'] );

			$data = array();
			$data['parent_id_list'] = implode( ',', $pidList );

			$this->Update( $val['id'], $data );
		}
	}

	function GetParentList( $id )
	{
		// 倒转数组,从下往上寻找
		$list = array_reverse( $this->categoryTree, true );

		$array = array();
		$deep = -1;

		foreach ( $list as $val )
		{
			if ( $val['id'] == $id )
				$deep = $val['deep'] - 1;

			if ( $deep != -1 && $deep == $val['deep'] )
			{
				$array[$val['id']] = $val;

				$deep--;
			}
		}

		return array_reverse( $array, true );
	}

	function GetOneLevelList( $id )
	{
		$info = $this->GetFromTree( $id );
		$pid = $info['pid'];
		$array = array();

		foreach ( $this->categoryTree as $val )
		{
			if ( $val['pid'] == $pid )
			{
				$array[$val['id']] = $val;
			}
		}

		return $array;
	}

	function GetChildID( $id )
	{
		$array = array();

		if ( $id )
		{
			$array = $this->NC->GetUnderside( $this->categoryTree, $id, 1 );
			@array_shift( $array );
		}

		return $array;
	}

	function GetOneChildList( $id, $noHidden = 0 )
	{
		$condition = array();
		$condition['pid'] = $id;

		if ( $noHidden )
			$condition['hidden'] = 0;
		
		$list = $this->Model->GetList( array(
			'table' => $this->table,
			'condition' => $condition,
			'key' => 'id',
			'order' => 'order_id DESC',
		) );

		if ( $this->hasExtra && $list )
		{
			$extraList = $this->GetExtraList( array_keys( $list ) );

			if ( $this->categoryList )
			{
				foreach ( $list as $k => $val )
				{
					$list[$k]['extra'] = $extraList[$val['id']];
				}
			}
		}

		return $list;
		
		//$array = $this->NC->GetUnderside( $this->categoryTree, $id, 4 );
		//return $array ? $array : array();
	}

	function GetNav( $id )
	{
		$array = $this->NC->GetNav( $this->categoryTree, $id );

		if ( !$array )
			return;

		$i = 0;
		foreach( $array as $val )
		{
			$arrNav[$i]['id'] = $val['id'];
			$arrNav[$i]['name'] = $val['name'];
			$arrNav[$i]['path'] = $val['path'];

			$i++;
		}

		return $arrNav;
	}

	function Del( $id )
	{
		return $this->Model->Del( array(
			'table' => $this->table,
			'condition' => array( 'id' => $id )
		) );
	}

	function PositionMove( $pid, $cid, $nid, $newParent = false )
	{
		if ( $nid > 0 )
		{
			$nextChannelInfo = $this->Get( $nid );
			$orderId = $nextChannelInfo['order_id'];
			$this->UpdateOrderId( $pid, $orderId );
		}
		else
		{
			$orderId = $this->GetMinOrderId( $pid ) - 1;
		}

		$data = array();
		$data['order_id'] = $orderId;

		// 移动到新的分类
		if ( $newParent )
			$data['pid'] = $pid;

		$this->Update( $cid, $data );
	}

	/******** Extra ********/

	function GetExtra( $id )
	{
		$cfg = array();
		$cfg['table'] = $this->extraTable;
		$cfg['condition'] = array( 'cid' => $id );
		$list = $this->Model->GetList( $cfg );

		$array = array();
		foreach ( $list as $val )
		{
			$array[$val['name']] = $val['value'];
		}

		return $array;
	}

	function GetExtraList( $ids = array() )
	{
		if ( is_array( $ids ) )
			$ids = implode( ',', $ids );

		$cfg = array();
		$cfg['table'] = $this->extraTable;
		$cfg['conditionExt'] = $ids ? "cid IN ({$ids})" : "";

		$array = array();
		$list = $this->Model->GetList( $cfg );

		foreach ( $list as $val )
		{
			$array[$val['cid']][$val['name']] = $val['value'];
		}

		return $array;
	}

	function AddExtra( $cid, $name, $value )
	{
		$name = addslashes( $name );
		$value = addslashes( $value );

		$sql = "REPLACE INTO " . $this->extraTable . " SET cid = '{$cid}', name = '{$name}', value = '{$value}'";

		return $this->Model->Update( array( 'sql' => $sql ) );
	}

	function DelExtra( $id )
	{
		$cfg = array();
		$cfg['table'] = $this->extraTable;
		$cfg['condition'] = array( 'cid' => $id );
		return $this->Model->Del( $cfg );
	}

	function UpdateExtra( $id, $data )
	{
		$cfg = array();
		$cfg['table'] = $this->extraTable;
		$cfg['condition'] = array( 'cid' => $id );
		$cfg['data'] = $data;
		return $this->Model->Update( $cfg );
	}

	/******** Block ********/
	function ReplaceBlock( $data )
	{
		return $this->Model->Replace( array( 
			'table' => $this->blockTable,
			'data' => $data
		) );
	}

	function GetBlock( $cid, $configId )
	{
		return $this->Model->Get( array( 
			'table' => $this->blockTable,
			'condition' => array(
				'cid' => $cid,
				'config_id' => $configId,
			)
		) );
	}

	function GetBlockListByConfig( $configId )
	{
		return $this->Model->GetList( array( 
			'table' => $this->blockTable,
			'condition' => array(
				'config_id' => $configId
			)
		) );
	}

	function GetBlockList( $cid )
	{
		return $this->Model->GetList( array( 
			'table' => $this->blockTable,
			'condition' => array(
				'cid' => $cid
			)
		) );
	}

	function UpdateBlock( $cid, $configId, $data )
	{
		return $this->Model->Update( array( 
			'table' => $this->blockTable,
			'condition' => array(
				'cid' => $cid,
				'config_id' => $configId,
			),
			'data' => $data
		) );
	}

	function DelBlock( $cid, $configId )
	{
		return $this->Model->Del( array( 
			'table' => $this->blockTable,
			'condition' => array(
				'cid' => $cid,
				'config_id' => $configId,
			)
		) );
	}

	function DelBlockByCategory( $cid )
	{
		return $this->Model->Del( array( 
			'table' => $this->blockTable,
			'condition' => array(
				'cid' => $cid,
			)
		) );
	}

	function GetBlockByName( $cid, $name )
	{
		$name = addslashes( $name );
		$sql = "
			SELECT 
				" . $this->blockTable . ".* 
			FROM 
				" . $this->blockTable . " 
			LEFT JOIN 
				" . $this->blockConfigTable . " 
			ON 
				" . $this->blockConfigTable . ".id = " . $this->blockTable . ".config_id
			WHERE 
				" . $this->blockConfigTable . ".en_name = '{$name}' 
				AND 
				" . $this->blockTable . ".cid = '{$cid}'
		";

		return $this->Model->Get( array( 
			'sql' => $sql,
		) );
	}

	/******** Block Config ********/
	function AddBlockConfig( $data )
	{
		return $this->Model->Add( array( 
			'table' => $this->blockConfigTable,
			'data' => $data
		) );
	}

	function GetBlockConfig( $id, $enName = '' )
	{
		$condition = array();
		$id		? $condition['id'] = $id : null;
		$enName	? $condition['en_name'] = $enName : null;

		return $this->Model->Get( array( 
			'table' => $this->blockConfigTable,
			'condition' => $condition,
		) );
	}

	function GetBlockConfigList()
	{
		return $this->Model->GetList( array( 
			'table' => $this->blockConfigTable,
			'key' => 'id'
		) );
	}

	function UpdateBlockConfig( $id, $data )
	{
		return $this->Model->Update( array( 
			'table' => $this->blockConfigTable,
			'condition' => array(
				'id' => $id
			),
			'data' => $data
		) );
	}

	function DelBlockConfig( $id )
	{
		return $this->Model->Del( array( 
			'table' => $this->blockConfigTable,
			'condition' => array(
				'id' => $id
			)
		) );
	}
}

?>