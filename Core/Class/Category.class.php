<?php

include_once( LIB_PATH . 'NEATCategory.class.php' );

class CategoryModel
{
	function Category( $table, $DB )
	{
		$this->NC = new NEATCategory;

		$arrFid['id']		= 'id';
		$arrFid['pid']		= 'pid';
		$arrFid['orderid']	= 'order_id';

		$this->NC->SetTable( '****' . $table );
		$this->NC->SetField( $arrFid );
		$this->NC->SetNDB( $DB );
	}

	function SetTree( $tree )
	{
		$this->categoryTree = $tree;
	}

	function BuildTree()
	{
		unset( $this->NC->tmpgetArray );

		$categoryList	= $this->NC->GetCategory();
		$categoryTree	= $this->NC->GetTree( $categoryList, 0, 0, 'category' );

		if ( !is_array( $categoryTree ) )
		{
			$categoryTree = array();
		}

		$this->categoryTree = $categoryTree;
	}

	function BuildTreeScript()
	{
		$channelList = $this->NC->GetCategory();

		if ( $channelList )
		{
			foreach ( $channelList as $val )
			{
				$item[] = "tree.nodes['{$val['pid']}_{$val['id']}'] = 'text:{$val['name']};'";
			}

			return @implode( "\r\n", $item );
		}
	}

	function GetTree()
	{
		return $this->categoryTree;
	}

	function Get( $id )
	{
		return $this->NC->GetCategory( $id );
	}

	function Add( $data )
	{
		$maxOrderID = $this->NC->GetNodeMaxOrderID( $data['pid'] );

		$data['order_id'] = $maxOrderID;

		$this->NC->AddCategory( $data );
	}

	function Update( $id, $data )
	{
		$condition['id'] = $id;

		return $this->NC->UpdateCategory( $data, $condition );
	}

	function GetSelectTree( $id = 0 )
	{
		foreach ( $this->categoryTree as $val )
		{
			$arr[$val['id']]['id'] = $val['id'];
			$arr[$val['id']]['name'] = str_repeat( '&nbsp;&nbsp;&nbsp;', $val['deep'] ) . $val['name'];
			$arr[$val['id']]['indent'] = str_repeat( '&nbsp;&nbsp;&nbsp;', $val['deep'] );

			if ( $val['id'] == $id )
				$arr[$val['id']]['selected'] = 'selected';
		}

		return $arr;
	}

	function GetParentID( $id )
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
				$array[] = $val['id'];

				$deep--;
			}
		}

		return $array;
	}

	function GetChildID( $id )
	{
		$array = $this->NC->GetUnderside( $this->categoryTree, $id, 1 );

		array_shift( $array );

		return $array;
	}

	function Order( $id, $postion )
	{
		if ( $postion =='up' )
			$type = 1;
		elseif ( $postion =='down' )
			$type = 2;
		else
			$type = 1;

		$this->NC->ChangeOrderID( $this->categoryTree, $id, $type );
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
}

?>