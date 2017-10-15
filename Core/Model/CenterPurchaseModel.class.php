<?php

class CenterPurchaseModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array(
			'table' => 'shopcenter_purchase',
			'data' => $data
		) );

		return $this->Model->DB->LastID();
	}

	function Add_pay( $data )
	{
		$this->Model->Add( array(
			'table' => 'shopcenter_pay',
			'data' => $data
		) );

		return $this->Model->DB->LastID();
	}
	
	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_purchase',
			'data' => $data,
			'condition' => array( 'id' => $id )
		) );
	}

	function UpdatePay( $id, $data )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_pay',
			'data' => $data,
			'condition' => array( 'id' => $id )
		) );
	}


	function GetListGroup( $search = array(), $offset = 0, $limit = 0 )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );
		$cfg = array();
		$cfg['select'] = '*,SUM(all_money) AS Allmoney,COUNT(*) AS AllTotal';
		$cfg['table'] = 'shopcenter_purchase';
		$cfg['order'] = "id DESC";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['group'] = 'supplier_id';

		return $this->Model->GetList( $cfg );
	}
	
	
	
	function GetList( $search = array(), $offset = 0, $limit = 0 )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );
		/*
		$condition = array();
		$conditionExt = array();

		foreach ( $search as $key => $val )
		{
			switch($key)
			{
				case 'wait_receive':
					$conditionExt[] = "receive_status < 3";
				break;
				case 'warehouse_id':
					if ( $val == 0 )
 					   $conditionExt[] = "warehouse_id >5";
					else
					   $conditionExt[] = "warehouse_id = ".$val;
				break;
				case 'status':
					if ( $val == 0 )
 					   $conditionExt[] = "status >2";
					else
					   $conditionExt[] = "status = ".$val;
				break;
				case 'receive_status':
					if ( $val == 0 )
 					   $conditionExt[] = "receive_status >0";
					elseif ( $val == 1 )
					   $conditionExt[] = "receive_status <3 ";
					else
					   $conditionExt[] = "receive_status = ".$val;
				break;
				case 'begin_time':
					if ( $val )
						$conditionExt[] = 'add_time >= ' . ( $val );
				break;
				case 'end_time':
					if ( $val )
						$conditionExt[] = 'add_time <= ' . ( $val );
				break;
				case 'order_id':
					$conditionExt[] = "id IN ( SELECT purchase_id FROM shopcenter_purchase_relation where order_id = {$val} )";
				break;

				default:
					if ( strlen( $val ) > 0 )
						$condition[$key] = $val;
				break;
			}
		
		}
*/
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase';
		$cfg['order'] = "id DESC";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function GetPayListTotal( $search = array() )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );

		$cfg = array();
		$cfg['select'] = 'count(*) AS total';
		$cfg['table'] = 'shopcenter_pay';
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}
	

	function GetPayList( $search = array(), $offset = 0, $limit = 0 )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );

		$cfg = array();
		$cfg['table'] = 'shopcenter_pay';
		$cfg['order'] = "id DESC";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function GetList_1( $search = array(), $offset = 0, $limit = 0 )
	{
		$condition = array();
		$conditionExt = array();

		foreach ( $search as $key => $val )
		{
			switch($key)
			{
				case 'wait_receive':
					$conditionExt[] = "receive_status < 3";
				break;

				default:
					if ( strlen( $val ) > 0 )
						$condition[$key] = $val;
				break;
			}
		}

		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase';
		$cfg['order'] = "id DESC";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		
		$cfg['conditionExt'] = $cfg['conditionExt'] .' ' . ' AND (payment_type=1 or ( payment_type=2 AND pay_status=1 ) ) ';
		
		
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}


	function GetPayID($PurchaseID)
	{
		$sql  = "SELECT id,status,purchase_id ";
		$sql .= "FROM shopcenter_pay WHERE purchase_id  LIKE '%{$PurchaseID}%' ";
		$cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->Get( $cfg );
	}



// 'payment_type' => 2, 'pay_status' =>1,
 	function GetCondition( $search )
	{
		$condition = array();
		$conditionExt = array();

		foreach ( $search as $key => $val )
		{
			switch($key)
			{
				case 'wait_receive':
					$conditionExt[] = "receive_status < 3";
				break;
				case 'warehouse_id':
					if ( $val == 0 )
 					   $conditionExt[] = "warehouse_id >5";
					else
					   $conditionExt[] = "warehouse_id = ".$val;
				break;
				case 'status':
					if ( $val == 0 )
 					   $conditionExt[] = "status >2";
					else
					   $conditionExt[] = "status = ".$val;
				break;
/*
				case 'receive_status':
					if ( $val == 0 )
 					   $conditionExt[] = "receive_status >0";
					elseif ( $val == 1 )
					   $conditionExt[] = "receive_status <3 ";
					else
					   $conditionExt[] = "receive_status = ".$val;
				break;
*/
				case 'begin_time':
					if ( $val )
						$conditionExt[] = 'add_time >= ' . ( $val );
				break;
				case 'end_time':
					if ( $val )
						$conditionExt[] = 'add_time <= ' . ( $val );
				break;
				case 'order_id':
					$conditionExt[] = "id IN ( SELECT purchase_id FROM shopcenter_purchase_relation where order_id = {$val} )";
				break;

				default:
					if ( strlen( $val ) > 0 )
						$condition[$key] = $val;
				break;
			}
		}
		return array( $condition, $conditionExt );
	}
	
 
	function GetTotal($search = array())
	{
		//$condition = array();
		list( $condition, $conditionExt ) = $this->GetCondition( $search );

		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function StatTotal( $id ){

		$info = $this->Model->Get( array(
			'table' => 'shopcenter_purchase_product',
			'select' => 'COUNT(*) AS total_breed, SUM(quantity * price) AS total_money, SUM(quantity) AS total_quantity, SUM(total_cost) AS total_cost, SUM(quantity * price+total_cost) AS all_money ',
			'condition' => array( 'purchase_id' => $id )
		) );

		$this->Update( $id, $info );
	}



	function StatTotal1203( $id,$PurchaseIDS ){

		$info = $this->Model->Get( array(
			'table' => 'shopcenter_purchase',
			'select' => 'SUM(all_money) AS all_money ',
			'conditionExt' => 'id IN ('.$PurchaseIDS.')'
		) );
//print_r($info);
		//$this->Update( $id, $info );
		
		$this->Model->Update( array('table' => 'shopcenter_pay','data' => $info,'condition' => array( 'id' => $id )) );
	}
	


	function Del1203( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_product';
		$cfg['condition'] = array( 'purchase_id' => $id );

		return $this->Model->Del( $cfg );
	}




	
	function AddProduct( $data )
	{
		$this->Model->Add( array(
			'table' => 'shopcenter_purchase_product',
			'data' => $data
		) );
		
		return $this->Model->DB->LastID();
	}

	function GetProduct( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_product';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function UpdateProduct( $id, $data, $dataExt = '' )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_purchase_product',
			'data' => $data,
			'dataExt' => $dataExt,
			'condition' => array( 'id' => $id )
		) );
	}

	
	
	function GetProductList( $purchaseId = 0, $offset = 0, $limit = 0 )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_product';
		$cfg['order'] = "id ASC";
		$cfg['condition'] = array( 'purchase_id' => $purchaseId );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}



	function GetRelationListByPurchaseProduct_1( $purchaseProductId )
	{
		$sql  = "SELECT pr.*, SUM(pr.quantity) AS totalnum ";
		$sql .= "FROM shopcenter_purchase_relation AS pr ";
		$sql .= "LEFT JOIN shopcenter_order AS o ON (pr.order_id = o.id ) ";
		$sql .= "WHERE pr.purchase_product_id={$purchaseProductId} ";
		$sql .= "GROUP BY o.channel_id,pr.sale_price ";
		$sql .= "ORDER BY pr.id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;


/*
        $cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['condition'] = array( 'purchase_product_id' => $purchaseProductId );
		$cfg['order'] = 'id ASC';
*/
		return $this->Model->GetList( $cfg );
	}



	function GetZc_channel( $purchaseId = 0, $offset = 0, $limit = 0 )
	{
		$sql  = "SELECT o.channel_id AS channelID ";
		$sql .= "FROM shopcenter_purchase_relation AS r ";
		$sql .= "LEFT JOIN shopcenter_order AS o ON (r.order_id = o.id ) ";
		$sql .= "WHERE r.purchase_id={$purchaseId} ";
		$sql .= "GROUP BY o.channel_id";
		//$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;


		return $this->Model->GetList( $cfg );
	}

	function GetZc_channel_1( $purchaseIdList, $offset = 0, $limit = 0 )
	{
		$sql  = "SELECT o.channel_id AS channelID ";
		$sql .= "FROM shopcenter_purchase_relation AS r ";
		$sql .= "LEFT JOIN shopcenter_order AS o ON (r.order_id = o.id ) ";
		$sql .= "WHERE r.purchase_id IN ({$purchaseIdList}) ";
		$sql .= "GROUP BY o.channel_id";
		//$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;


		return $this->Model->GetList( $cfg );
	}
	
	function GetProductList_zc_1( $purchaseIdList, $channelId = 0 )
	{
		$sql  = "SELECT pp.product_id AS productID,p.name AS productName ";
		$sql .= ", SUM(r.quantity) AS totalQuantity, SUM(r.quantity*pp.price) AS totalPrice, SUM(r.quantity*pp.help_cost) AS costPrice ";
		$sql .= "FROM shopcenter_purchase_relation AS r ";
		$sql .= "INNER JOIN shopcenter_order AS o ON (r.order_id = o.id ) ";
		$sql .= "INNER JOIN shopcenter_purchase_product AS pp ON (r.purchase_product_id = pp.id ) ";
		$sql .= "INNER JOIN shopcenter_product AS p ON (pp.product_id = p.id ) ";
		$sql .= "WHERE r.purchase_id IN ({$purchaseIdList}) AND o.channel_id={$channelId} ";
		$sql .= "GROUP BY pp.product_id";
		//$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;


		return $this->Model->GetList( $cfg );
	}


	function GetProductList_zc_1_1( $purchaseIdList, $channelId = 0 )
	{
		$sql  = "SELECT pp.product_id AS productID,p.name AS productName,pp.price AS productPrice ";
		$sql .= ", SUM(r.quantity) AS totalQuantity, SUM(r.quantity*pp.price) AS totalPrice, SUM(r.quantity*pp.help_cost) AS costPrice ";
		$sql .= "FROM shopcenter_purchase_relation AS r ";
		$sql .= "INNER JOIN shopcenter_order AS o ON (r.order_id = o.id ) ";
		$sql .= "INNER JOIN shopcenter_purchase_product AS pp ON (r.purchase_product_id = pp.id ) ";
		$sql .= "INNER JOIN shopcenter_product AS p ON (pp.product_id = p.id ) ";
		$sql .= "WHERE r.purchase_id IN ({$purchaseIdList}) AND o.channel_id={$channelId} ";
		$sql .= "GROUP BY pp.product_id,pp.price ";
		$sql .= "ORDER BY p.name ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;


		return $this->Model->GetList( $cfg );
	}

	function GetProductList_zc_3( $purchaseIdList )
	{
		//$sql  = " ";
		//$sql .= "";
		$sql = "SELECT  pp.product_id AS productID,pu.id AS id,pu.add_time AS add_timer,pu.supplier_id AS supplier_id,pp.sku AS sku,p.name AS productName,pp.price AS productPrice, SUM(pp.quantity) AS totalQuantity, SUM(pp.quantity*pp.price) AS totalPrice, SUM(pp.quantity*pp.help_cost) AS costPrice  ";
		//$sql .= "FROM shopcenter_purchase_relation AS r ";
		$sql .= "FROM shopcenter_purchase AS pu ";
		//$sql .= "INNER JOIN shopcenter_purchase AS pu ON (r.purchase_id = pu.id ) ";
		//$sql .= "LEFT JOIN shopcenter_purchase_relation AS r ON ( pu.id=r.purchase_id ) ";
		//$sql .= "LEFT JOIN shopcenter_order AS o ON (r.order_id = o.id ) ";
		$sql .= "INNER JOIN shopcenter_purchase_product AS pp ON (pp.purchase_id = pu.id ) ";
		$sql .= "INNER JOIN shopcenter_product AS p ON (pp.product_id = p.id ) ";
		$sql .= "WHERE pu.id IN ({$purchaseIdList}) ";
		$sql .= "GROUP BY pp.sku_id,pp.price ";
		$sql .= "ORDER BY p.name ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;


		return $this->Model->GetList( $cfg );
	}

	function GetProductList_zc_2( $purchaseIdList )
	{
		$sql  = "SELECT pp.product_id AS productID,p.name AS productName,pp.price AS productPrice ";
		$sql .= ", SUM(pp.quantity) AS totalQuantity, SUM(pp.quantity*pp.price) AS totalPrice, SUM(pp.quantity*pp.help_cost) AS costPrice ";
		$sql .= "FROM shopcenter_purchase_product AS pp ";
		//$sql .= "INNER JOIN shopcenter_order AS o ON (r.order_id = o.id ) ";
		//$sql .= "INNER JOIN shopcenter_purchase_product AS pp ON (r.purchase_product_id = pp.id ) ";
		$sql .= "INNER JOIN shopcenter_product AS p ON (pp.product_id = p.id ) ";
		$sql .= "WHERE pp.purchase_id IN ({$purchaseIdList}) ";
		$sql .= "GROUP BY pp.product_id,pp.price";
		//$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;


		return $this->Model->GetList( $cfg );
	}
	
	
		
		
	function GetProductList_zc( $purchaseId = 0, $channelId = 0 )
	{
		$sql  = "SELECT pp.product_id AS productID,p.name AS productName ";
		$sql .= ", SUM(r.quantity) AS totalQuantity, SUM(r.quantity*pp.price) AS totalPrice, SUM(r.quantity*pp.help_cost) AS costPrice ";
		$sql .= "FROM shopcenter_purchase_relation AS r ";
		$sql .= "INNER JOIN shopcenter_order AS o ON (r.order_id = o.id ) ";
		$sql .= "INNER JOIN shopcenter_purchase_product AS pp ON (r.purchase_product_id = pp.id ) ";
		$sql .= "INNER JOIN shopcenter_product AS p ON (pp.product_id = p.id ) ";
		$sql .= "WHERE r.purchase_id={$purchaseId} AND o.channel_id={$channelId} ";
		$sql .= "GROUP BY pp.product_id";
		//$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;


		return $this->Model->GetList( $cfg );
	}

	
	function DelProduct( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_product';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function GetOnRoadNum( $skuId )
	{
		$sql  = "SELECT SUM(shopcenter_purchase_product.quantity - shopcenter_purchase_product.into_quantity) AS total ";
		$sql .= "FROM shopcenter_purchase_product , shopcenter_purchase ";
		$sql .= "WHERE shopcenter_purchase.id = shopcenter_purchase_product.purchase_id 
			    AND shopcenter_purchase_product.sku_id = '{$skuId}' 
			    AND shopcenter_purchase.type = 1
			    ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function GetProductHistoryPrice( $sku )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_product';
		$cfg['condition'] = array( 'sku' => $sku );
		$cfg['order'] = 'id DESC';
		$cfg['limit'] = 3;
		$cfg['offset'] = 0;

		$list = $this->Model->GetList( $cfg );

		$price = 0;
		foreach ( $list as $val )
		{
			$price += $val['price'];
		}

		if ( $price !=0 && $list )
			return FormatMoney( $price / count( $list ) );
		else
			return FormatMoney( 0 );
	}

	function GetProductStatusNum( $purchaseId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_product';
		$cfg['select'] = 'SUM(receive_quantity) AS total_receive_quantity, SUM(into_quantity) AS total_into_quantity';
		$cfg['condition'] = array( 'purchase_id' => $purchaseId );

		return $this->Model->Get( $cfg );
	}

	function AddLock( $data )
	{
		$this->Model->Add( array(
			'table' => 'shopcenter_purchase_lock',
			'data' => $data
		) );
	}

	function GetLock( $skuId,$supplierId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_lock';
		$cfg['condition'] = array( 'sku_id' => $skuId, 'supplierId' => $supplierId );

		return $this->Model->Get( $cfg );
	}

	function DelLock( $skuId,$supplierId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_lock';
		$cfg['condition'] = array( 'sku_id' => $skuId, 'supplierId' => $supplierId );

		return $this->Model->Del( $cfg );
	}

	function DelLockByUser( $userId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_lock';
		$cfg['condition'] = array( 'user_id' => $userId );

		return $this->Model->Del( $cfg );
	}

	function GetLockList( $userId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_lock';
		$cfg['condition'] = array( 'user_id' => $userId );

		return $this->Model->GetList( $cfg );
	}

	function GetLockList_1( $userId, $supplierId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_lock';
		$cfg['condition'] = array( 'user_id' => $userId,'supplierId' => $supplierId );

		return $this->Model->GetList( $cfg );
	}
	
	function GetAllLockList($supplierId)
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_lock';
		$cfg['condition'] = array( 'supplierId' => $supplierId );
		$cfg['key'] = 'sku_id';

		return $this->Model->GetList( $cfg );
	}

	function AddRelation( $data )
	{
		$this->Model->Add( array(
			'table' => 'shopcenter_purchase_relation',
			'data' => $data
		) );
	}

	function GetRelation( $skuId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['condition'] = array( 'sku_id' => $skuId );

		return $this->Model->Get( $cfg );
	}


	function GetRelationInfo( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function GetRelationUnique( $purchaseProductId, $orderProductId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['condition'] = array( 'purchase_product_id' => $purchaseProductId, 'order_product_id' => $orderProductId );

		return $this->Model->Get( $cfg );
	}

	function DelRelationUnique( $purchaseProductId, $orderProductId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['condition'] = array( 'purchase_product_id' => $purchaseProductId, 'order_product_id' => $orderProductId );

		return $this->Model->Del( $cfg );
	}

	function DelRelation( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function UpdateRelation( $id, $data, $dataExt = '' )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_purchase_relation',
			'data' => $data,
			'dataExt' => $dataExt,
			'condition' => array( 'id' => $id )
		) );
	}

	function UpdateRelation_dfh( $id, $data, $dataExt = '' )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_purchase_relation',
			'data' => $data,
			'dataExt' => $dataExt,
			'condition' => array( 'order_product_id' => $id )
		) );
	}
	
	function GetRelationListByPurchaseProduct( $purchaseProductId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['condition'] = array( 'purchase_product_id' => $purchaseProductId );
		$cfg['order'] = 'id ASC';

		return $this->Model->GetList( $cfg );
	}

	function GetOrderListByPurchase( $orderId )//订单反查采购单
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['condition'] = array( 'order_id' => $orderId );
		$cfg['order'] = 'id ASC';

		return $this->Model->GetList( $cfg );
	}


	function GetPurchaseIDByOrder( $orderId )//订单反查采购单
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['select'] = "purchase_id";
		$cfg['condition'] = array( 'order_id' => $orderId );
		$cfg['group'] = 'purchase_id';
		//$cfg['order'] = 'id ASC';
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}
	
	
	function GetPpidByOpid( $orderProductId )//订单商品反查采购单商品
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['select'] = "purchase_product_id";
		$cfg['condition'] = array( 'order_product_id' => $orderProductId );
		$cfg['key'] = 'purchase_product_id';

		return $this->Model->Get( $cfg );
	}


	function GetPurchaseListByOrder( $purchaseId )//采购单反查订单
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['condition'] = array( 'purchase_id' => $purchaseId );
		$cfg['order'] = 'id ASC';

		return $this->Model->GetList( $cfg );
	}




	function GetOrderListByPurchase_1( $purchaseId )//采购单反查订单
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['condition'] = array( 'purchase_id' => $purchaseId );
		$cfg['order'] = 'id ASC';
		$cfg['group'] = 'order_id';

		return $this->Model->GetList( $cfg );
	}


	function GetOrderListByPurchase_2( $purchaseId )//采购单反查订单
	{
		$sql  = "SELECT o.*,COUNT(*) AS orderTotal";
		$sql .= " FROM shopcenter_purchase_relation AS r ";
		$sql .= " LEFT JOIN shopcenter_order AS o ON (o.id = r.order_id ) ";
		$sql .= " WHERE r.purchase_id = {$purchaseId} ";
		$sql .= " GROUP BY r.order_id ";
		$sql .= " ORDER BY r.order_id ";
		$cfg = array();
		$cfg['sql'] = $sql;


		//$cfg = array();
		//$cfg['table'] = 'shopcenter_purchase_relation';
		//$cfg['condition'] = array( 'purchase_id' => $purchaseId );
		//$cfg['order'] = 'id ASC';
		//$cfg['group'] = 'order_id';

		return $this->Model->GetList( $cfg );
	}

	function GetOrderListByPurchase_20( $productId,$purchaseId )//采购单反查订单——限定产品
	{
		$sql  = "SELECT r.*,o.logistics_sn AS logistics_sn";
		$sql .= " FROM shopcenter_purchase_relation AS r ";
		$sql .= " LEFT JOIN shopcenter_order AS o ON (o.id = r.order_id ) ";
		$sql .= " WHERE r.purchase_id = {$purchaseId} AND r.purchase_product_id = {$productId}  ";
		$sql .= " GROUP BY r.order_id ";
		$cfg = array();
		$cfg['sql'] = $sql;


		//$cfg = array();
		//$cfg['table'] = 'shopcenter_purchase_relation';
		//$cfg['condition'] = array( 'purchase_id' => $purchaseId );
		//$cfg['order'] = 'id ASC';
		//$cfg['group'] = 'order_id';

		return $this->Model->GetList( $cfg );
	}



	function GetRelationListByPurchaseProduct_9( $purchaseProductId )
	{
		//$cfg = array();
		//$cfg['table'] = 'shopcenter_purchase_relation';
		//$cfg['condition'] = array( 'purchase_product_id' => $purchaseProductId );
		//$cfg['order'] = 'id ASC';
		//$cfg['group'] = 'order_id';
		
		
		
		
		$sql  = "SELECT op.price AS xs_price,o.total_money AS bj_price,pr.sale_price AS sale_price,o.channel_id AS channel_id,c.print_name AS channel_name ";
		$sql .= ",pr.quantity AS total_quantity,pr.order_id AS order_id  ";
		//$sql .= ",SUM(pr.quantity) AS total_quantity ";
		$sql .= "FROM shopcenter_purchase_relation AS pr ";
		$sql .= "LEFT JOIN shopcenter_order AS o ON (o.id = pr.order_id) ";
		$sql .= "LEFT JOIN shopcenter_order_product AS op ON (op.id=pr.order_product_id ) ";
		$sql .= "LEFT JOIN shopcenter_channel AS c ON (c.id = o.channel_id) ";
		$sql .= "WHERE pr.purchase_product_id = {$purchaseProductId} ";
		//$sql .= " GROUP BY channel_id,sale_price ";

		$cfg = array();
		$cfg['sql'] = $sql;


		return $this->Model->GetList( $cfg );
	}





	function GetSupplierMoneyaa( $supplierId = 3 )
	{
		//总采购金额
		$sql_total_money  = "SELECT * FROM shopcenter_purchase ";
		$sql_total_money .= "WHERE supplier_id = {$supplierId} ";
		//$sql_total_money .= "GROUP BY p.supplier_id ";
		$cfg_total_money = array();
		$cfg_total_money['sql'] = $sql_total_money;
		//$cfg_total_money['key'] = 'total_money';
		return $this->Model->GetList( $cfg_total_money );
		}






	function GetSupplierMoney( $supplierId = false )
	{
		//总采购金额
		$sql_total_money  = "SELECT SUM(p.all_money) AS all_money,SUM(p.total_money) AS total_money,SUM(p.total_cost) AS total_cost FROM shopcenter_purchase AS p ";
		$sql_total_money .= "WHERE p.supplier_id = {$supplierId} ";
		$sql_total_money .= "GROUP BY p.supplier_id ";
		$cfg_total_money = array();
		$cfg_total_money['sql'] = $sql_total_money;
		//$cfg_total_money['key'] = 'total_money';
		$total_money = $this->Model->Get( $cfg_total_money );



		//总付款金额
		$sql_ok_money  = "SELECT SUM(p.all_money) AS pay_all_money,SUM(p.total_money) AS pay_total_money,SUM(p.total_cost) AS pay_total_cost FROM shopcenter_purchase AS p ";
		$sql_ok_money .= "WHERE p.supplier_id = {$supplierId} AND pay_status=1 ";
		$sql_ok_money .= "GROUP BY p.supplier_id ";
		$cfg_ok_money = array();
		$cfg_ok_money['sql'] = $sql_ok_money;
		//$cfg_ok_money['key'] = 'ok_money';
		$pay_money = $this->Model->Get( $cfg_ok_money );

		//总已请款金额
		$sql_ready_money  = "SELECT SUM(p.all_money) AS ready_all_money,SUM(p.total_money) AS ready_total_money,SUM(p.total_cost) AS ready_total_cost FROM shopcenter_purchase AS p ";
		$sql_ready_money .= "WHERE p.supplier_id = {$supplierId} AND pay_status=-1 ";
		$sql_ready_money .= "GROUP BY p.supplier_id ";
		$cfg_ready_money = array();
		$cfg_ready_money['sql'] = $sql_ready_money;
		//$cfg_ready_money['key'] = 'ready_money';
		$ready_money = $this->Model->Get( $cfg_ready_money );

		//总未请款金额
		$sql_wqk_money  = "SELECT SUM(p.total_money) AS wqk_all_money,SUM(p.total_money) AS wqk_total_money,SUM(p.total_cost) AS wqk_total_cost FROM shopcenter_purchase AS p ";
		$sql_wqk_money .= "WHERE p.supplier_id = {$supplierId} AND pay_status=0 ";
		$sql_wqk_money .= "GROUP BY p.supplier_id ";
		$cfg_wqk_money = array();
		$cfg_wqk_money['sql'] = $sql_wqk_money;
		//$cfg_wqk_money['key'] = 'wqk_money';
		$wqk_money = $this->Model->Get( $cfg_wqk_money );

		
		$cfg_money = array();
		$cfg_money['total_money'] = $total_money;
		$cfg_money['pay_money'] = $pay_money;
		$cfg_money['ready_money'] = $ready_money;
		
		$cfg_money['yfk_money']['yfk_all_money'] = $total_money['all_money'] - $pay_money['pay_all_money'] ;
		$cfg_money['yfk_money']['yfk_total_money'] = $total_money['total_money'] - $pay_money['pay_total_money'] ;
		$cfg_money['yfk_money']['yfk_total_cost'] = $total_money['total_cost'] - $pay_money['pay_total_cost'] ;
		
		$cfg_money['wqk_money'] = $wqk_money;
		return $cfg_money;
	}








	function GetError_1( $purchaseId = 0 )
	{
/*
		$sql  = "SELECT COUNT(*) AS total FROM shopcenter_purchase_relation ";
		$sql .= "WHERE purchase_id = {$purchaseId} AND sale_price > 0 ";

		$cfg = array();
		$cfg['sql'] = $sql;
		print_r($this->Model->Get( $cfg ));
*/

		$condition = array();

		$cfg = array();
		$cfg['table'] = 'shopcenter_purchase_relation';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['condition'] = array( 'purchase_id' => $purchaseId );
		$cfg['conditionExt'] =  ' sale_price > 0 ';
		$cfg['key'] = 'total';
		return $this->Model->Get( $cfg );

	}

















}

?>