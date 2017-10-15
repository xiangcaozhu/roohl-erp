<?php

/*
+---------------------------------------------------+
| Name : NEAT_CATEGORY 分类类
+---------------------------------------------------+
| C / M : 2004-11-5 / 2005-3-28
+---------------------------------------------------+
| Version : 1.0.4
+---------------------------------------------------+
| Author : walkerlee
+---------------------------------------------------+
| Powered by NEATSTUDIO 2002 - 2004
+---------------------------------------------------+
| Email : neatstudio@yahoo.com.cn
| Homepge : http://www.neatstudio.com
| BBS : http://www.neatstudio.com/bbs/
+---------------------------------------------------+
| Log :
+---------------------------------------------------+
hihiyou 修改版(用于CMS),去掉NBS和NCA [2006-5-13]
+---------------------------------------------------+
*/

class NEATCategory
{
	var $NDB;

	var $table;
	var $tableFids;

	/*
	+---------------------------------------------------+
	| Function Name : setNDB
	+---------------------------------------------------+
	| Created / Modify : 2004-10-27 / 
	+---------------------------------------------------+
	*/

	function SetNDB(&$NDB)
	{
		$this->NDB = & $NDB;
	}

	/*
	+---------------------------------------------------+
	| Function Name : setTable
	+---------------------------------------------------+
	| C / M : 2004-10-22 / 
	+---------------------------------------------------+
	*/

	function SetTable($table)
	{
		$this->table = $table;
	}

	/*
	+---------------------------------------------------+
	| Function Name : setField
	+---------------------------------------------------+
	| C / M : 2004-10-22 / 
	+---------------------------------------------------+
	*/

	function SetField($fields)
	{
		foreach($fields as $k=>$v)
		{
			$this->tableFids[$k] = $v;
		}
	}

	/*
	+---------------------------------------------------+
	| Function Name : GetTree
	+---------------------------------------------------+
	| C / M : 2004-10-22 / 2004-10-24 11:57
	+---------------------------------------------------+
	*/

	function GetTree($array, $pid, $deep = 0, $name)
	{
		$this->tmpgetArray;

		$deep++;

		if (is_array($array) && !empty($array))
		{
			foreach($array as $key => $val)
			{
				if ($val[$this->tableFids['pid']] == $pid)
				{

					$i = $val[$this->tableFids['id']];

					foreach($val as $k => $v)
					{
						$this->tmpgetArray[$name][$i][$k] = $v;
					}

					$this->tmpgetArray[$name][$i]['deep']	= $deep-1;

					$this->GetTree($array, $val[$this->tableFids['id']], $deep, $name);
				}
			}

			return $this->getarr[$name] = $this->tmpgetArray[$name];
		}
		else
		{
			return null;
		}
	}

	/*
	+---------------------------------------------------+
	| Function Name : getNav
	+---------------------------------------------------+
	| C / M : 2004-10-24 11:58 / 
	+---------------------------------------------------+
	| Log : 
	+---------------------------------------------------+
	  2004-11-30(hihiyou)
	  增加一个判断,当$getarr为空时,
	  array_reverse会出错.
	+---------------------------------------------------+
	*/

	function GetNav($array, $id)
	{
		while($array[$id][$this->tableFids['pid']] <> NULL)
		{	
			foreach($array[$id] as $k => $v)
			{
				$getarr[$id][$k] = $v;
			}

			$id = $array[$id][$this->tableFids['pid']];
		}

		if (!empty($getarr))
			return array_reverse($getarr);
		else
			return;
	}

	/*
	+---------------------------------------------------+
	| Function Name : changeOrderID 改变分类的排序
	+---------------------------------------------------+
	| C / M : 2004-10-24 11:58 / 
	+---------------------------------------------------+
	| Note : 
	+---------------------------------------------------+
	$array : get by getTree()
	$id : the category's id which want to change orderid
	$type : the change method

	type = 1 : up
	type = 2 : down
	+---------------------------------------------------+
	| Log : 
	+---------------------------------------------------+
	
	+---------------------------------------------------+
	*/

	function ChangeOrderID($array, $id, $type)
	{
		$cateArray = $this->GetChangeOrderID($array, $id);

		//get pre and next

		$type == 1 ? $targetIndexTemp = $cateArray['info']['index'] - 1 : $targetIndexTemp = $cateArray['info']['index'] + 1;

		$cateArray['list'][$targetIndexTemp] ? $targetIndex = $targetIndexTemp : $targetIndex = $cateArray['info']['index'];

		// Default

		$thisOrderID = $cateArray['list'][$targetIndex]['orderid'];
		$targetOrderID = $cateArray['info']['orderid'];
		
		// set this and target's orderid
		
		if ($cateArray['list'][$targetIndex]['orderid'] == $cateArray['info']['orderid'])
			$type == 1 ? $thisOrderID++ : $targetOrderID++;

		$thisID = $id;
		$targetID = $cateArray['list'][$targetIndex]['id'];

		$thisCoData[$this->tableFids['id']]  = $thisID;
		$thisUpData[$this->tableFids['orderid']] = $thisOrderID;

		$this->UpdateCategory($thisUpData, $thisCoData);

		$targetCoData[$this->tableFids['id']]  = $targetID;
		$targetUpData[$this->tableFids['orderid']] = $targetOrderID;

		$this->UpdateCategory($targetUpData, $targetCoData);
	}

	/*
	+---------------------------------------------------+
	| getChangeOrderID 取结点的所有数据的orderid
	+---------------------------------------------------+
	| C / M : 2004-10-25 11:58 / 2004-11-5
	+---------------------------------------------------+
	| Note : 
	+---------------------------------------------------+
	$array : get by getTree()
	$id : the node's id
	
	[返回]
	
	$cateArray['info']['index']		= key
	$cateArray['info']['id']		= 编号
	$cateArray['info']['pid']		= 上级分类编号
	$cateArray['info']['orderid']	= 排序编号

	$cateArray['list'] 从1开始增加的编好号的节点数据,包含分类编号和分类orderid
	+---------------------------------------------------+
	| Log : 
	+---------------------------------------------------+
	
	+---------------------------------------------------+
	*/

	function GetChangeOrderID($array, $id)
	{	
		foreach($array as $k => $v)
		{	
			!$i[$v[$this->tableFids['pid']]] ? $i[$v[$this->tableFids['pid']]] = 1 : $i[$v[$this->tableFids['pid']]]++;
			
			$cateArrayTemp['list'][$v[$this->tableFids['pid']]][$i[$v[$this->tableFids['pid']]]]['id'] = $v[$this->tableFids['id']];
			$cateArrayTemp['list'][$v[$this->tableFids['pid']]][$i[$v[$this->tableFids['pid']]]]['orderid'] = $v[$this->tableFids['orderid']];

			if ($v[$this->tableFids['id']] == $id)
			{
				$cateArray['info']['index'] = $i[$v[$this->tableFids['pid']]];
				$cateArray['info']['id'] = $v[$this->tableFids['id']];
				$cateArray['info']['pid'] = $v[$this->tableFids['pid']];
				$cateArray['info']['orderid'] = $v[$this->tableFids['orderid']];
			}
		}

		$cateArray['list'] = $cateArrayTemp['list'][$cateArray['info']['pid']];

		return $cateArray;
	}

	/*
	+---------------------------------------------------+
	| getCategory 取原始数据 (从数据库取列表)
	+---------------------------------------------------+
	| C / M : 2004-10-22 / 2004-11-13
	+---------------------------------------------------+
	| Note : 
	+---------------------------------------------------+
	get the list without make tree from database
	+---------------------------------------------------+
	| Log : 
	+---------------------------------------------------+
	2004-11-13 (walker)
	
	$type = '' get by id
	$type = '1' get by pid

	2004-11-8 (walker)
	if $id seted,then get the category which id is set.
	+---------------------------------------------------+
	*/
	
	function GetCategory($id = '', $type = '')
	{
		$sql  = "SELECT * ";
		$sql .= "FROM " . $this->table . " ";
		
		if (!$id) // get all
		{
			if ( $this->hide )
				$sql .= "WHERE " . $this->tableFids['hidden'] . " = 0 ";
			
			$sql .= "ORDER BY " . $this->tableFids['orderid'] . " DESC";

			$rs = $this->NDB->Query($sql);
			
			$i = 0;
			
			while($rs->NextRecord())
			{
				
				$array = $rs->GetArray();

				foreach ($array as $k => $v)
				{
					$cateArray[$i][$k] = $v;
				}

				$i++;
			}
		}
		else // get by id or pid
		{
			!$type ?	$fids = $this->tableFids['id'] : $fids = $this->tableFids['pid'];

			$sql .= "WHERE " . $fids . " = '" . $id . "'";

			$rs = $this->NDB->Query($sql);
			$rs->NextRecord();
			$cateArray = $rs->GetArray();
		}

		return $cateArray;
	}

	/*
	+---------------------------------------------------+
	| GetUnderside 取结点下的所有数据
	+---------------------------------------------------+
	| C / M : 2004-10-25 11:58 / 2004-11-5
	+---------------------------------------------------+
	| Note : 
	+---------------------------------------------------+
	$array : This is the ordered's array (get by getTree())

	$id : The node's id

	$type : the type of the return array
		
	type = 1 only get the category's id list
	type = 2 get the category's all information
	type = 1 取所有下级分类的ID(包括自己的数据)
	type = 2 取所有下级分类的数据(包括自己的数据)
	type = 3 取第一级下级分类的ID(不包括自己的数据)
	type = 4 取第一级下级分类的数据(不包括自己的数据)
	+---------------------------------------------------+
	| Log : 
	+---------------------------------------------------+
	 2004-11-5 8:47 (walker)
	 增加了注释
	+---------------------------------------------------+
	*/

	function GetUnderside($array, $id, $type = 1)
	{

		
		$pidArray[] = $id;

		//start treeNode

		if ($type == 1)
			$getarr[0] = $array[$id][$this->tableFids['id']];
		elseif ( $type == 2 )
			$getarr[0] = $array[$id];

		// end treeNode
		
		if ( $type == 1 || $type == 2 )
		{
			foreach($array as $k => $v)
			{
				if (in_array($v[$this->tableFids['pid']], $pidArray))
				{
					$i++;
					$pidArray[] = $v[$this->tableFids['id']];
					
					if ( $type == 1 )
						$getarr[$i] = $v[$this->tableFids['id']];
					elseif ( $type == 2 )
						$getarr[$i] = $v;
				}
			}
		}
		elseif( $type == 3 || $type == 4 )
		{
			foreach($array as $k => $v)
			{
				if ( $v[$this->tableFids['pid']] == $id )
				{
					$i++;

					if ( $type == 3 )
						$getarr[$i] = $v[$this->tableFids['id']];
					elseif ( $type == 4 )
						$getarr[$i] = $v;
				}
			}
		}
		
		return $getarr;
	}

	/*
	+---------------------------------------------------+
	| Function Name : AddCategory
	+---------------------------------------------------+
	| C / M : 2004-10-22 / 
	+---------------------------------------------------+
	*/
	
	function AddCategory($categoryData)
	{
		if ( !is_array( $categoryData ) )
			return false;

		$fields	= @implode( ",", array_keys( $categoryData ) );
		$values	= "'" .  @implode( "','", $categoryData ) . "'";

		$sql  = "INSERT INTO " . $this->table . " ";
		$sql .= "( {$fields} ) ";
		$sql .= "VALUES ( {$values} )";

		$this->NDB->Update( $sql );
	}

	/*
	+---------------------------------------------------+
	| Function Name : DelCategory
	+---------------------------------------------------+
	| C / M : 2004-10-22 / 
	+---------------------------------------------------+
	*/
	
	function DelCategory($array, $id)
	{
		$idArray = $this->GetUnderside($array, $id);

		$num = count($idArray);
		
		foreach ($idArray as $k => $v)
		{	
			$i++;

			$idArraySql .= $this->tableFids['id'] . " = " . $v;

			if ($i < $num)
				$idArraySql .= " OR ";
		}
		
		$sql  = "DELETE FROM " . $this->table . " ";
		$sql .= "WHERE " . $idArraySql;
		
		//$sql = $this->NBS->del($categoryData);
		
		$this->NDB->Update($sql);

		return $idArray;
	}

	/*
	+---------------------------------------------------+
	| Function Name : UpdateCategory
	+---------------------------------------------------+
	| C / M : 2004-10-22 / 
	+---------------------------------------------------+
	*/
	
	function UpdateCategory($categoryData, $categoryCondition )
	{
		$array = $this->GetCategory();
		$array = $this->GetTree($array, 0, 0, 'category');
		$array = $this->GetUnderside($array, $categoryCondition[$this->tableFids['id']], $type = 1);
		// unset($array[0]);

		if ( in_array( $categoryData[$this->tableFids['pid']], $array ) )
		{
			return false;
		}
		else
		{
			foreach ( $categoryData as $key => $val )
			{
				$dataList[] = "{$key} = '{$val}'";
			}

			$set	= @implode( ',', $dataList );

			
			
			foreach ( $categoryCondition as $k => $v )
			{
				$conditionList[] = "$k = '$v'";
			}

			$where = @implode( " AND ", $conditionList );
			
			$sql  = "UPDATE " . $this->table . " ";
			$sql .= $set ? "SET {$set} " : null;
			$sql .= $where ? "WHERE {$where} " : null;

			$this->NDB->Update($sql);

			return true;
		}
	}

	/*
	+---------------------------------------------------+
	| Function Name : getNodeMaxOrderID
	+---------------------------------------------------+
	| C / M : 2004-11-8 / 
	+---------------------------------------------------+
	| Note : 
	+---------------------------------------------------+
	 $pid : 传入一个结点
	 功能 : 取这个结点最大的orderid 并且加1.
	+---------------------------------------------------+
	| Log : 
	+---------------------------------------------------+

	+---------------------------------------------------+
	*/

	function GetNodeMaxOrderID($pid)
	{
		$sql  = "SELECT MAX(" . $this->tableFids['orderid'] . ") + 1 AS " . $this->tableFids['orderid'] . " ";
		$sql .= "FROM " . $this->table . " ";
		$sql .= "WHERE " . $this->tableFids['pid'] . " = '" . $pid . "'";
		
		$rs = $this->NDB->Query($sql);

		$rs->NextRecord();

		$rs->Get($this->tableFids['orderid']);

		return $rs->Get($this->tableFids['orderid']);
	}
}
?>