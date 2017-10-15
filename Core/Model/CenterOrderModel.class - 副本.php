<?php

class CenterOrderModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array(
			'table' => 'shopcenter_order',
			'data' => $data
		) );

		return $this->Model->DB->LastID();
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_order',
			'data' => $data,
			'condition' => array( 'id' => $id )
		) );
	}

	function GetUnique( $channelId, $targetId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		$cfg['condition'] = array( 'target_id' => $targetId, 'channel_id' => $channelId );

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
				case 'locked':
					$conditionExt[] = 'lock_status > 0';
				break;

				case 'wait_service':
					$conditionExt[] = 'purchase_check > 0';
				break;

				case 'wait_delivery':
					$conditionExt[] = 'delivery_status < 2';
				break;

				case 'phone':
					if ( strlen( $val ) )
						$conditionExt[] = "(order_shipping_phone LIKE '%{$val}%' OR order_shipping_mobile LIKE '%{$val}%')";
				break;

				case 'product_name':
					if ( strlen( $val ) )
						$conditionExt[] = "(id IN( SELECT shopcenter_order_product.order_id FROM shopcenter_order_product LEFT JOIN shopcenter_product ON shopcenter_product.id = shopcenter_order_product.product_id WHERE shopcenter_product.name LIKE '%{$val}%'))";
				break;

				case 'order_customer_name':
					if ( strlen( $val ) )
						$conditionExt[] = "order_customer_name LIKE '%{$val}%'";
				break;

				case 'order_shipping_name':
					if ( strlen( $val ) )
						$conditionExt[] = "order_shipping_name LIKE '%{$val}%'";
				break;

				case 'channel_name':
					if ( strlen( $val ) )
						$conditionExt[] = "channel_id IN ( SELECT id FROM shopcenter_channel where name LIKE '%{$val}%' )";
				break;

				case 'begin_time':
					if ( $val )
						$conditionExt[] = 'add_time >= ' . ( $val + 8 * 3600 );
				break;
				case 'end_time':
					if ( $val )
						$conditionExt[] = 'add_time <= ' . ( $val + 8 * 3600 );
				break;

				case 'begin_delivery_time':
					if ( $val )
						$conditionExt[] = 'delivery_time >= ' . ( $val + 8 * 3600 );
				break;
				case 'end_delivery_time':
					if ( $val )
						$conditionExt[] = 'delivery_time <= ' . ( $val + 8 * 3600 );
				break;

				case 'begin_sign_time':
					if ( $val )
						$conditionExt[] = 'sign_time >= ' . ( $val + 8 * 3600 );
				break;
				case 'end_sign_time':
					if ( $val )
						$conditionExt[] = 'sign_time <= ' . ( $val + 8 * 3600 );
				break;

				case 'begin_purchase_check_time':
					if ( $val )
						$conditionExt[] = 'purchase_check_time >= ' . ( $val + 8 * 3600 );
				break;
				case 'end_purchase_check_time':
					if ( $val )
						$conditionExt[] = 'purchase_check_time <= ' . ( $val + 8 * 3600 );
				break;

				case 'begin_service_check_time':
					if ( $val )
						$conditionExt[] = 'service_check_time >= ' . ( $val + 8 * 3600 );
				break;
				case 'end_service_check_time':
					if ( $val )
						$conditionExt[] = 'service_check_time <= ' . ( $val + 8 * 3600 );
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
		$cfg['table'] = 'shopcenter_order';
		$cfg['order'] = "id ASC";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function StatTotal( $id ){

		$info = $this->Model->Get( array(
			'table' => 'shopcenter_order_product',
			'select' => 'COUNT(*) AS total_breed, SUM(quantity * price) AS total_money, SUM(quantity) AS total_quantity',
			'condition' => array( 'order_id' => $id )
		) );

		$this->Update( $id, $info );
	}

	function GetTotal( $search = array() )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );

		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function AddProduct( $data )
	{
		$this->Model->Add( array(
			'table' => 'shopcenter_order_product',
			'data' => $data
		) );
		
		return $this->Model->DB->LastID();
	}

	function GetProduct( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order_product';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function UpdateProduct( $id, $data, $dataExt = '' )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_order_product',
			'data' => $data,
			'dataExt' => $dataExt,
			'condition' => array( 'id' => $id )
		) );
	}

	function GetProductList( $orderId = 0, $offset = 0, $limit = 0 )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order_product';
		$cfg['order'] = "id ASC";
		$cfg['condition'] = array( 'order_id' => $orderId );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function DelProduct( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order_product';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}

	function GetNeedList( $skuId = false, $offset = 0, $limit = 0 )
	{
		$sql  = "SELECT p.*, SUM(p.quantity) AS total_quantity, SUM(p.purchase_quantity) AS total_purchase_quantity,COUNT(*) AS total_num ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE p.quantity > p.purchase_quantity + p.lock_quantity ";

		if ( $skuId && is_array( $skuId ) )
			$sql .= "AND p.sku_id IN ( " . implode( ',', $skuId ) . " ) ";
		elseif ( $skuId )
			$sql .= "AND sku_id = '{$skuId}' ";

		$sql .= "AND o.purchase_check = 1 ";
		$sql .= "AND o.service_check = 1 ";

		$sql .= "GROUP BY sku_id ";
		$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}

	function GetNeedProductList( $skuId = false, $offset = 0, $limit = 0 )
	{
		$sql  = "SELECT p.* ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE p.quantity > p.purchase_quantity + p.lock_quantity ";

		if ( $skuId && is_array( $skuId ) )
			$sql .= "AND p.sku_id IN ( " . implode( ',', $skuId ) . " ) ";
		elseif ( $skuId )
			$sql .= "AND sku_id = '{$skuId}' ";

		$sql .= "AND o.purchase_check = 1 ";
		$sql .= "AND o.service_check = 1 ";

		$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}

	/*
	function GetNeedProductList( $skuId, $offset = 0, $limit = 0 )
	{
		$conditionExt = array();
		$conditionExt[] = "quantity > purchase_quantity";

		$cfg = array();
		$cfg['table'] = 'shopcenter_order_product';
		$cfg['order'] = "order_id ASC";
		$cfg['condition'] = array( 'sku_id' => $skuId, 'purchase_check' => 1, 'service_check' => 1 );
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}
	*/

	function GetProductStat( $orderId )
	{
		return $this->Model->Get( array(
			'table' => 'shopcenter_order_product',
			'select' => 'COUNT(*) AS total_breed, SUM(quantity) AS total_quantity, SUM(lock_quantity) AS total_lock_quantity, SUM(delivery_quantity) AS total_delivery_quantity, SUM(purchase_quantity) AS total_purchase_quantity',
			'condition' => array( 'order_id' => $orderId )
		) );
	}

	function GetProductFlowBySkuId( $skuId, $orderProductId = false )
	{
		$sql  = "SELECT p.* ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE p.quantity > p.purchase_quantity + p.lock_quantity ";
		$sql .= "AND sku_id = '{$skuId}' ";
		$sql .= "AND o.purchase_check = 1 ";

		if ( $orderProductId )
			$sql .= "AND p.id = {$orderProductId} ";
		else
			$sql .= "AND o.service_check = 1 ";

		$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;
		
		
		/*
		$conditionExt = array();
		$conditionExt[] = "quantity > lock_quantity";

		$cfg = array();
		$cfg['table'] = 'shopcenter_order_product';
		$cfg['order'] = "order_id ASC";
		$cfg['condition'] = array( 'sku_id' => $skuId );
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		*/

		return $this->Model->Get( $cfg );
	}

	function GetBusinessReport( $beginTime, $endTime )
	{
		$sql  = "SELECT p.*, SUM(p.stock_price*quantity) AS total_stock_price, SUM(p.price*quantity) AS total_price, SUM(p.price*p.quantity*p.payout_rate) AS total_payout ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE o.status = 1 AND o.purchase_check = 1 AND o.service_check = 1 AND o.finance_recieve = 1 ";
		$sql .= "AND o.finance_recieve_time >= {$beginTime} ";
		$sql .= "AND o.finance_recieve_time <= {$endTime} ";
		$sql .= "GROUP BY p.manager_user_id ";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}

	function GetBusinessOrderReport( $beginTime, $endTime )
	{
		$sql  = "SELECT p.*, SUM(p.stock_price*quantity) AS total_stock_price, SUM(p.price*quantity) AS total_price, SUM(p.price*p.quantity*p.payout_rate) AS total_payout ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE o.status = 1 AND o.purchase_check = 1 AND o.service_check = 1 ";
		$sql .= "AND o.add_time >= {$beginTime} ";
		$sql .= "AND o.add_time <= {$endTime} ";
		$sql .= "GROUP BY p.manager_user_id ";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}

	function GetFinanceReport( $beginTime, $endTime )
	{
		$sql  = "SELECT p.*,pp.board AS product_board, o.channel_id ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id LEFT JOIN shopcenter_product pp ON pp.id = p.product_id ";
		$sql .= "WHERE o.status = 1 AND o.finance_recieve = 1 AND o.service_check = 1 ";
		$sql .= "AND o.finance_recieve_time >= {$beginTime} ";
		$sql .= "AND o.finance_recieve_time <= {$endTime} ";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}

	function GetProductSales( $beginTime, $endTime )
	{
		$sql  = "SELECT p.*,pp.name AS product_name, o.channel_id ";
		$sql .= "FROM shopcenter_order_product AS op LEFT JOIN shopcenter_order AS o ON o.id = op.order_id LEFT JOIN shopcenter_product p ON p.id = op.product_id ";
		$sql .= "WHERE o.status = 1 AND o.finance_recieve = 1 AND o.service_check = 1 ";
		$sql .= "AND o.add_time >= {$beginTime} ";
		$sql .= "AND o.add_time <= {$endTime} ";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}
}

?>