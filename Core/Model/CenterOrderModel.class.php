<?php

class CenterOrderModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function AA0805()
	{
	$data = array();
	$data['payout_rate'] = 0.065;
		return $this->Model->Update( array(
			'table' => 'shopcenter_order_product',
			'data' => $data,
			'condition' => array( 'payout_rate' => '0.65' )
		) );
	}

	function xx0913()
	{
		$sql = "SELECT id FROM shopcenter_order WHERE channel_id=92 ";
		$cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->GetList( $cfg );
	}

	function KK0913()
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		$cfg['condition'] = array( 'channel_id' => 92 );
		$cfg['conditionExt'] = 'total_quantity>100';

		return $this->Model->Del( $cfg );
	}
	
	function xsx0913()
	{
		$sql = "SELECT id FROM shopcenter_order WHERE channel_id=92 AND service_check=0 ";
		$cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->GetList( $cfg );
	}


	function Del_1218()
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		//$cfg['condition'] = array( 'id' => $id );
		$cfg['conditionExt'] = 'id<28675';

		return $this->Model->Del( $cfg );
	}
	
	function Del_1218_a()
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order_product';
		//$cfg['condition'] = array( 'id' => $id );
		$cfg['conditionExt'] = 'id<27766';

		return $this->Model->Del( $cfg );
	}

	function Get_1218()
	{
		$sql = "SELECT id FROM shopcenter_order_product WHERE order_id =28675 ";
		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->Get( $cfg );
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
		$sql = "SELECT o.*, c.name FROM shopcenter_order AS o LEFT JOIN shopcenter_channel AS c ON o.channel_id = c.id WHERE o.id = {$id}";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->Get( $cfg );
	}

	function Get09191( $id )
	{
		$sql = "SELECT o.* FROM shopcenter_order AS o WHERE o.id = {$id}";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->Get( $cfg );
	}


	function Get0919( $id )
	{
		$sql = "SELECT o.*, c.name FROM shopcenter_order AS o LEFT JOIN shopcenter_channel AS c ON o.channel_id = c.id WHERE o.target_id = {$id}";
		$sql = "SELECT o.* FROM shopcenter_order AS o WHERE o.target_id = {$id}";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->Get( $cfg );
	}

	function Get0919A( $id )
	{
		$sql = "SELECT o.* FROM shopcenter_order AS o WHERE o.id in({$id}) ";
		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}
	function Get0919B( $id )
	{
		$sql = "SELECT o.* FROM shopcenter_order AS o WHERE o.target_id in({$id}) ";
		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}

















	
	function Getcost( $logistics_sn )
	{
		$sql = "SELECT * FROM shopcenter_order WHERE logistics_sn = {$logistics_sn}";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->Get( $cfg );
	}

	function ClearLockCall($lockTime,$lockUser,$startID)
	{
		$IDS = array();
		$sql = "SELECT id FROM shopcenter_order WHERE lock_call_time < {$lockTime} AND lock_call=1 AND service_check = 0 AND id>{$startID} ";
		$cfg = array();
		$cfg['sql'] = $sql;
		$LockList = $this->Model->GetList( $cfg );
		$IDSA = ArrayVals($LockList,"id");
		foreach ( $IDSA as $val ){
			if((int)$val>0){$IDS[] = $val;}
		}


		$sql = "SELECT * FROM shopcenter_order WHERE lock_call_user_id={$lockUser} AND service_check = 0 AND id>{$startID} ";
		$cfg = array();
		$cfg['sql'] = $sql;
		$LockLists = $this->Model->GetList( $cfg );
		$IDSB = ArrayVals($LockLists,"id");
		foreach ( $IDSB as $val ){
			if((int)$val>0){$IDS[] = $val;}
		}
		
		if(count($IDS)>0){
			$newS = ToStr($IDS);
			$dataLock = array();
			$dataLock['lock_call_time'] = time();
			$dataLock['lock_call'] = 0;
			$dataLock['lock_call_user_id'] = '';
			$dataLock['lock_call_user_name'] = '';
			$this->Model->Update( array( 'table' => 'shopcenter_order', 'data' => $dataLock, 'conditionExt' =>' id in ('.$newS.') ' ) );
		}


		/*
		foreach ( $LockList as $key => $val )
		{
		  $dataLock['lock_call_time'] = time();
		  $dataLock['lock_call'] = 0;
		  $dataLock['lock_call_user_id'] = '';
		  $dataLock['lock_call_user_name'] = '';
		  $this -> Update( $val['id'], $dataLock );
		}
		*/
	}

	function GetLockCall($startID)
	{
		$sqls = "SELECT * FROM shopcenter_order WHERE lock_call=1 AND service_check = 0 AND id>".$startID." ";
		$cfgs = array();
		$cfgs['sql'] = $sqls;
		return $this->Model->GetList( $cfgs );
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
		
		//echo '/' .$this->Model->Get( $cfg ). '/<br>';

		return $this->Model->Get( $cfg );
	}


	function GetReceiveNumBySku( $orderId, $skuId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order_product';
		$cfg['condition'] = array( 'order_id' => $orderId, 'sku_id' => $skuId );
		$HaveVal = $this->Model->Get( $cfg );
		return $HaveVal['quantity'];
	}
	
	
	function GetUniqueByChannelParent( $channelParentId, $targetId )
	{
		$cfg = array();
		$cfg['sql']  = 'SELECT *,o.id as order_id FROM shopcenter_order AS o, shopcenter_channel AS c WHERE o.channel_id = c.id ';
		$cfg['sql'] .= "AND o.target_id = {$targetId} AND c.parent_id = {$channelParentId}";

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
				case 'xiaofwID':
					if ( (int)$val>0 )
						$conditionExt[] = "id>".$val."";
				break;
				case 'target_id':
					if ( strlen( $val ) )
						$conditionExt[] = "target_id LIKE '%{$val}%'";
				break;

				case 'locked':
					$conditionExt[] = 'lock_status > 0';
				break;

				case 'wait_service':
					$conditionExt[] = 'purchase_check > 0';
				break;
				case 'wait_service_all':
					$conditionExt[] = 'purchase_check > 0';
					$conditionExt[] = 'service_check = 0';
				break;

				case 'wait_service_call':
					$conditionExt[] = 'purchase_check > 0';
					$conditionExt[] = 'service_check = 0';
					$conditionExt[] = 'lock_call = 0';
				break;

				case 'wait_invoice':
					$conditionExt[] = 'order_invoice > 0';
					$conditionExt[] = 'order_invoice_status < 1';
				break;

				case 'wait_delivery':
					$conditionExt[] = 'delivery_status < 2';
				break;
				
				case 'warehouse_type':
			     	if ( strlen( $val ) )
					   $conditionExt[] = 'warehouse_id =' . ( $val );
				break;
				case 'call_timer':
				       $conditionExt[] = 'call_timer = 0';
					  // $conditionExt[] = 'call_timer' = 0;
				break;

				case 'phone':
					if ( strlen( $val ) )
						$conditionExt[] = "(order_shipping_phone LIKE '%{$val}%' OR order_shipping_mobile LIKE '%{$val}%')";
				break;

				case 'product_name':
					if ( strlen( $val ) )
						$conditionExt[] = "(id IN( SELECT shopcenter_order_product.order_id FROM shopcenter_order_product LEFT JOIN shopcenter_product ON shopcenter_product.id = shopcenter_order_product.product_id WHERE shopcenter_product.name LIKE '%{$val}%'))";
				break;
				case 'productID':
					if ( $val>0 )
						$conditionExt[] = "(id IN( SELECT shopcenter_order_product.order_id FROM shopcenter_order_product WHERE shopcenter_order_product.order_id>80091 AND shopcenter_order_product.product_id={$val}))";
				break;

				case 'logistics_company':
					if ( strlen( $val ) )
						$conditionExt[] = "logistics_company LIKE '%{$val}%'";
				break;

				case 'logistics_type':
					if ( $val==2 )
						$conditionExt[] = "LENGTH(logistics_sn) > 2 ";
					
					if ( $val==1 )
						$conditionExt[] = " (logistics_sn is NULL OR LENGTH(logistics_sn) <3)";
					
				break;

				case 'order_customer_name':
					if ( strlen( $val ) )
						$conditionExt[] = "order_customer_name LIKE '%{$val}%'";
				break;

				case 'order_shipping_name':
					if ( strlen( $val ) )
						$conditionExt[] = "order_shipping_name LIKE '%{$val}%'";
				break;

				case 'order_shipping_phone':
					if ( strlen( $val ) )
						$conditionExt[] = "order_shipping_phone LIKE '%{$val}%'";
				break;
				case 'order_shipping_mobile':
					if ( strlen( $val ) )
						$conditionExt[] = "order_shipping_mobile LIKE '%{$val}%'";
				break;

				case 'channel_name':
					if ( strlen( $val ) )
						$conditionExt[] = "channel_id IN ( SELECT id FROM shopcenter_channel where name LIKE '%{$val}%' )";
				break;
				case 'manage_id':
					if ( strlen( $val ) )
						$conditionExt[] = "(id IN( SELECT shopcenter_order_product.order_id FROM shopcenter_order_product LEFT JOIN shopcenter_supplier ON shopcenter_supplier.id = shopcenter_order_product.supplier_id WHERE shopcenter_supplier.manage_id={$val} ))";
				break;

				case 'begin_time':
					if ( $val )
						$conditionExt[] = 'order_time >= ' . ( $val );
				break;
				case 'end_time':
					if ( $val )
						$conditionExt[] = 'order_time <= ' . ( $val );
				break;

				case 'begin_delivery_time':
					if ( $val )
						$conditionExt[] = 'delivery_time >= ' . ( $val );
				break;
				case 'end_delivery_time':
					if ( $val )
						$conditionExt[] = 'delivery_time <= ' . ( $val );
				break;

				case 'begin_sign_time':
					if ( $val )
						$conditionExt[] = 'sign_time >= ' . ( $val );
				break;
				case 'end_sign_time':
					if ( $val )
						$conditionExt[] = 'sign_time <= ' . ( $val );
				break;

				case 'begin_purchase_check_time':
					if ( $val )
						$conditionExt[] = 'purchase_check_time >= ' . ( $val );
				break;
				case 'end_purchase_check_time':
					if ( $val )
						$conditionExt[] = 'purchase_check_time <= ' . ( $val );
				break;

				case 'begin_service_check_time':
					if ( $val )
						$conditionExt[] = 'service_check_time >= ' . ( $val );
				break;
				case 'end_service_check_time':
					if ( $val )
						$conditionExt[] = 'service_check_time <= ' . ( $val );
				break;

				case 'finance_recieve_time':
					if ( $val )
						$conditionExt[] = 'finance_recieve_time >= ' . ( $val );
				break;
				case 'print_status':
					//if ( $val )
						$conditionExt[] = 'print_status = ' . ( $val );
				break;
				//case 'purchase_check':
						//$conditionExt[] = 'purchase_check = ' . ( $val );
				//break;

				default:
					if ( $val != '' )
						$condition[$key] = $val;
				break;
			}
		}

		return array( $condition, $conditionExt );
	}

	function GetDeliveryProductList( $search = array(),$skuId = false, $offset = 0, $limit = 0 )
	{
		$sql  = "SELECT p.*,o.id ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE o.id>0 ";

		if ( $skuId && is_array( $skuId ) )
			$sql .= "AND p.sku_id IN ( " . implode( ',', $skuId ) . " ) ";
		elseif ( $skuId )
			$sql .= "AND sku_id = '{$skuId}' ";

		foreach ( $search as $key => $val )
		{
			
			
			if($key == 'wait_delivery')
			$sql .= "AND o.delivery_status <2 ";
			elseif( strlen( $val ) )
			$sql .= "AND o.". $key ." = '". $val ."' ";
		}


		$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}

	function GetDelivery_order_List( $search = array(), $skuId = false, $offset = 0, $limit = 0 )
	{
		$sql  = "SELECT id FROM shopcenter_order WHERE id>0 ";

		foreach ( $search as $key => $val )
		{
			if($key == 'wait_delivery')
			$sql .= "AND delivery_status <2 ";
			elseif( strlen( $val ) )
			$sql .= "AND ". $key ." = '". $val ."' ";
		}


		//$sql .= "GROUP BY channel_id,logistics_company ";
		//$sql .= "ORDER BY logistics_company ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}

	function GetDelivery_sku_List( $search , $skuId = false, $offset = 0, $limit = 0 )
	{
		$sql  = "SELECT p.*,o.*, SUM(p.quantity) AS total_quantity,COUNT(*) AS total_num ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE o.id >0 ";

		$sql .= "AND o.id in ( " . $search . " ) ";
		//$sql .= "AND o.id IN ( " . implode( ',', $search['id'] ) . " ) ";
		
		//echo $search;
		//echo  implode( ',', $search );

		$sql .= "GROUP BY sku_id ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}
	
/////////////////////////////////////////////////////////////出库单
	function GetDelivery_List( $search = array(), $skuId = false, $offset = 0, $limit = 0 )
	{
		$sql  = "SELECT * FROM shopcenter_order WHERE logistics_company<>'' ";

		foreach ( $search as $key => $val )
		{
			if($key == 'wait_delivery')
			$sql .= "AND delivery_status <2 ";
			elseif( strlen( $val ) )
			$sql .= "AND ". $key ." = '". $val ."' ";
		}


		$sql .= "GROUP BY channel_id,logistics_company ";
		$sql .= "ORDER BY logistics_company ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}
/////////////////////////////////////////////////////////////

	function GetListOrderByPP( $search = array(), $offset = 0, $limit = 0, $order = false )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );
		

		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		//$cfg['select'] = "*,LENGTH(logistics_sn) AS logistics_length";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		if ( $order == false )
			$cfg['order'] = "id desc";
		else
			$cfg['order'] = $order;

		return $this->Model->GetList( $cfg );
	}
	

	function GetList1203($productID,$channelID)
	{
		$sql  = "SELECT o.id AS orderID ";
		$sql .= "FROM shopcenter_order AS o LEFT JOIN shopcenter_order_product AS p ON o.id = p.order_id ";
		$sql .= "WHERE p.product_id={$productID} AND o.channel_id={$channelID} AND o.purchase_check=0 AND o.id>80091 ";

		$cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->GetList( $cfg );
	}
	
	function GetList1203_A($productID,$channelID)
	{
		$sql  = "SELECT o.id AS orderID ";
		$sql .= "FROM shopcenter_order AS o LEFT JOIN shopcenter_order_product AS p ON o.id = p.order_id ";
		$sql .= "WHERE p.product_id={$productID} AND o.channel_id={$channelID} AND o.purchase_check>0 AND o.id>80091 AND o.service_check = 0  ";

		$cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->GetList( $cfg );
	}

	function GetListStartID_service_check()
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		$cfg['select'] = "id";
		$cfg['condition'] = array("service_check"=>0);
		$cfg['key'] = 'id';
		$cfg['order'] = 'id';
		return $this->Model->Get( $cfg );
	}

	function GetListStartID_delivery_status()
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		$cfg['select'] = "id";
		$cfg['condition'] = array("lock_status"=>2,"delivery_type"=>1,"purchase_check"=>1,"service_check"=>1);
		$cfg['conditionExt'] = 'delivery_status < 2';
		$cfg['key'] = 'id';
		$cfg['order'] = 'id';
		return $this->Model->Get( $cfg );
	}
	
	function GetListStartID_purchase_check()
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		$cfg['select'] = "id";
		$cfg['condition'] = array("purchase_check"=>0);
		$cfg['key'] = 'id';
		return $this->Model->Get( $cfg );
	}
	
		
	function GetList( $search = array(), $offset = 0, $limit = 0, $order = false )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );
		

		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		//$cfg['select'] = "*,LENGTH(logistics_sn) AS logistics_length";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		if ( $order == false )
			$cfg['order'] = "id desc";
		else
			$cfg['order'] = $order;

		return $this->Model->GetList( $cfg );
	}



	function KP_parseCondition( $condition, $conditionExt )
	{
		if ( !$condition && !$conditionExt )
			return '';

		if ( is_array( $conditionExt ) )
			$conditionExt = implode( " AND ", $conditionExt );

		if ( is_array( $condition ) )
		{
			foreach ( $condition as $k => $v )
			{
				$conditionList[] = "$k = '" . addslashes( $v ) . "'";
			}

			$sql = @implode( " AND ", $conditionList );
		}

		if ( $sql && $conditionExt )
			return $sql . " AND {$conditionExt} ";
		elseif ( !$sql && $conditionExt )
			return $conditionExt;
		else
			return $sql;
	}
	

	function GetList_1( $search = array(), $offset = 0, $limit = 0, $order = false )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );
		
		$where = $this->KP_parseCondition( $condition, $conditionExt );
		
		if($where)
		{
		$where = ' AND '.$where;
		$where = str_replace('AND id','AND o.id',$where);
		$where = str_replace('AND status','AND o.status',$where);
		$where = str_replace('AND lock_status','AND o.lock_status',$where);
		$where = str_replace('AND delivery_status','AND o.delivery_status',$where);
		$where = str_replace('AND channel_id','AND o.channel_id',$where);
		$where = str_replace('AND order_invoice','AND o.order_invoice',$where);
		$where = str_replace('AND order_invoice_status','AND o.order_invoice_status',$where);
		$where = str_replace('AND sign_status','AND o.sign_status',$where);
		$where = str_replace('AND purchase_check','AND o.purchase_check',$where);
		$where = str_replace('AND service_check','AND o.service_check',$where);
		$where = str_replace('AND finance_recieve','AND o.finance_recieve',$where);
		$where = str_replace('AND target_id','AND o.target_id',$where);
		$where = str_replace('AND warehouse_id','AND o.warehouse_id',$where);
		$where = str_replace('AND order_shipping_name','AND o.order_shipping_name',$where);
		
		$where = str_replace('order_shipping_phone LIKE','o.order_shipping_phone LIKE',$where);
		$where = str_replace('order_shipping_mobile LIKE','o.order_shipping_mobile LIKE',$where);
		$where = str_replace('logistics_sn','o.logistics_sn',$where);
		$where = str_replace('AND (id','AND (o.id',$where);
		}
		
		//echo $where;
		
		
		$sql  = "SELECT o.*,pr.purchase_id AS purchaseID,s.name AS supplierName ";
		$sql .= "FROM shopcenter_order AS o LEFT JOIN shopcenter_purchase_relation AS pr ON o.id = pr.order_id ";
		$sql .= "LEFT JOIN shopcenter_purchase AS pu ON (pr.purchase_id = pu.id) ";
		$sql .= "LEFT JOIN shopcenter_supplier AS s ON (pu.supplier_id = s.id) ";
		$sql .= "WHERE o.temp_key>0 ";
		//$sql .= $condition;
		
		if($where)
		$sql .= $where;
		$sql .= " ORDER BY o.id desc ";

		$cfg = array();
		
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;




/*
		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';
		if ( $order == false )
			$cfg['order'] = "id desc";
		else
			$cfg['order'] = $order;

*/
		return $this->Model->GetList( $cfg );
	}
	

	function GetCall( $search = array() )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );

		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
        $cfg['order'] = "lock_call_time,id";

		return $this->Model->Get( $cfg );
	}
/*
	function GetCall( $search = array(), $offset = 0, $limit = 0, $order = false )
	{
		list( $condition, $conditionExt ) = $this->GetCondition( $search );

		$cfg = array();
		$cfg['table'] = 'shopcenter_order';
		//$cfg['select'] = "*,LENGTH(logistics_sn) AS logistics_length";
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = implode( ' AND ', $conditionExt );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';
        $cfg['order'] = "lock_call_time,id";

		return $this->Model->GetList( $cfg );
	}
*/	
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


	function GetProductList1011($orderId)
	{
		$sql  = "SELECT p.*,o.erp_sku AS erp_sku ";
		$sql .= "FROM shopcenter_order_product AS p ";
		$sql .= "LEFT JOIN shopcenter_product_sku AS o ON o.pid = p.sku_id ";
		$sql .= "where p.order_id=".$orderId." ";
		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
		
	}



	function GetErpSKU( $skuID )
	{
		$cfg = array();
		$cfg['select'] = 'erp_sku';
		$cfg['table'] = 'shopcenter_product_sku';
		$cfg['condition'] = array( 'id' => $skuID );
		$cfg['key'] = 'erp_sku';

		return $this->Model->Get( $cfg );
	}


	function GetProductList( $orderId = 0, $offset = 0, $limit = 0 )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order_product';
		$cfg['order'] = "id ASC";
		$cfg['condition'] = array( 'order_id' => $orderId );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		//$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function GetProductOne( $id = 0, $offset = 0, $limit = 0 )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_order_product';
		$cfg['order'] = "id ASC";
		$cfg['condition'] = array(  'id' => $id );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		//$cfg['key'] = 'id';

		return $this->Model->Get( $cfg );
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

	function GetNeedProductList0717( $skuId = false, $offset = 0, $limit = 0,$orderIDS )
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
		$sql .= "AND p.order_id IN ( " . implode( ',', $orderIDS ) . " ) ";

		$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}
	
	
	function GetSupplierNeedProductList( $skuId = false,$supplierId = false, $offset = 0, $limit = 0 )
	{
		$sql  = "SELECT p.*,o.channel_id AS channelID, o.order_comment AS orderComment ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE p.quantity > p.purchase_quantity + p.lock_quantity ";

		if ( $skuId && is_array( $skuId ) )
			$sql .= "AND p.sku_id IN ( " . implode( ',', $skuId ) . " ) ";
		elseif ( $skuId )
			$sql .= "AND sku_id = '{$skuId}' ";

		if ( $supplierId )
			$sql .= "AND p.supplier_id = '{$supplierId}' ";


		$sql .= "AND o.purchase_check = 1 ";
		$sql .= "AND o.service_check = 1 AND o.id>62411 ";

		//$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}
	
	
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
		$sql .= "AND o.order_time >= {$beginTime} ";
		$sql .= "AND o.order_time <= {$endTime} ";
		$sql .= "GROUP BY p.manager_user_id ";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}

	function GetFinanceReport( $beginTime, $endTime )
	{
		$sql  = "SELECT p.*,pp.board AS product_board, o.channel_id ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id LEFT JOIN shopcenter_product pp ON pp.id = p.product_id ";
		$sql .= "WHERE o.status = 1 AND o.finance_recieve = 1 AND o.service_check = 1 AND o.finance_recieve = 1 ";
		$sql .= "AND o.finance_recieve_time >= {$beginTime} ";
		$sql .= "AND o.finance_recieve_time <= {$endTime} ";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}

	function GetOrderSalesReport( $channelId, $beginTime, $endTime, $invoiceStatus, $channelParentId )
	{
		$beginTime = $beginTime;
		$endTime = $endTime;

		$sql  = "SELECT o.id, cp.name AS channel_parent_name, c.name AS channel_name, o.delivery_time, o.order_invoice_status, p.name AS product_name, ";
		$sql .= "op.price AS sales_price, op.quantity AS sales_quantity, op.price*op.quantity AS total_sales_price, ";
		$sql .= "wl.price AS stock_price, wl.quantity AS stock_quantity, wl.price*wl.quantity AS total_stock_price ";
		$sql .= "FROM shopcenter_order AS o, shopcenter_channel AS c, shopcenter_channel_parent AS cp, shopcenter_order_product AS op ";
		$sql .= "LEFT JOIN shopcenter_product AS p ON (op.product_id = p.id) ";
		$sql .= "LEFT JOIN shopcenter_warehouse_log AS wl ON (op.order_id = wl.target_id2 AND op.product_id = wl.product_id ) ";
		$sql .= "WHERE o.channel_id = c.id AND c.parent_id = cp.id AND o.id = op.order_id ";
		
		if ( $channelParentId )
			$sql .= " AND cp.id = {$channelParentId} ";

		if ( $channelId )
			$sql .= " AND o.channel_id = {$channelId} ";

		$sql .= "AND o.delivery_time >= {$beginTime} AND o.delivery_time <= {$endTime} ";
		if ( $invoiceStatus != '' )
			$sql .= " AND o.order_invoice_status = {$invoiceStatus} ";
		$sql .= "ORDER BY o.channel_id, o.id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}

	function GetFinanceRecieveReport( $channelId, $beginTime, $endTime, $invoiceStatus, $channelParentId )
	{
		$beginTime = $beginTime;
		$endTime = $endTime;

		$sql  = "SELECT o.id, cp.name AS channel_parent_name, c.name AS channel_name, o.finance_recieve_time, o.order_invoice_status, p.name AS product_name, ";
		$sql .= "op.price AS sales_price, op.quantity AS sales_quantity, op.price*op.quantity AS total_sales_price, op.price*op.quantity*op.payout_rate AS payout, ";
		$sql .= "op.price*op.quantity - op.price*op.quantity*op.payout_rate AS balance, ";
		$sql .= "wl.price AS stock_price, wl.quantity AS stock_quantity, wl.price*wl.quantity AS total_stock_price ";
		$sql .= "FROM shopcenter_order AS o, shopcenter_channel AS c, shopcenter_channel_parent AS cp, shopcenter_order_product AS op ";
		$sql .= "LEFT JOIN shopcenter_product AS p ON (op.product_id = p.id) ";
		$sql .= "LEFT JOIN shopcenter_warehouse_log AS wl ON (op.order_id = wl.target_id2 AND op.product_id = wl.product_id ) ";
		$sql .= "WHERE o.channel_id = c.id AND c.parent_id = cp.id AND o.id = op.order_id ";
		
		if ( $channelParentId )
			$sql .= " AND cp.id = {$channelParentId} ";

		if ( $channelId )
			$sql .= " AND o.channel_id = {$channelId} ";

		$sql .= "AND o.finance_recieve_time >= {$beginTime} AND o.finance_recieve_time <= {$endTime} ";
		if ( $invoiceStatus != '' )
			$sql .= " AND o.order_invoice_status = {$invoiceStatus} ";
		$sql .= "ORDER BY o.channel_id, o.id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}

	function GetFinanceRecieveTotalReport( $channelParentId, $beginTime, $endTime )
	{
		$beginTime = $beginTime;
		$endTime = $endTime;

		$sql  = "SELECT cp.name AS channel_parent_name, o.finance_recieve_time, o.finance_recieve, ";
		$sql .= "SUM(op.price*op.quantity) AS total_sales_price, SUM(op.price*op.quantity*op.payout_rate) AS total_payout, ";
		$sql .= "SUM(op.price*op.quantity - op.price*op.quantity*op.payout_rate) AS total_balance ";
		$sql .= "FROM shopcenter_order AS o, shopcenter_channel AS c, shopcenter_channel_parent AS cp, shopcenter_order_product AS op ";
		$sql .= "WHERE o.channel_id = c.id AND c.parent_id = cp.id AND o.id = op.order_id AND o.finance_recieve_time >= {$beginTime} AND o.finance_recieve_time <= {$endTime} ";
		
		if ( $channelParentId )
			$sql .= " AND cp.id = {$channelParentId} ";

		$sql .= "GROUP BY cp.id, date(from_unixtime(o.finance_recieve_time)), o.finance_recieve";

		$cfg = array();
		$cfg['sql'] = $sql;
debug($sql);
		return $this->Model->GetList( $cfg );
	}

	function GetProductSalesReport( $beginTime, $endTime, $channelId, $channelParentId )
	{
		$beginTime = $beginTime;
		$endTime = $endTime;

		$sql  = "SELECT op.product_id, p.name, SUM(op.quantity) AS total_quantity, SUM(op.price) AS total_price ";
		$sql .= "FROM shopcenter_order AS o, shopcenter_channel AS c, shopcenter_order_product AS op ";
		$sql .= "LEFT JOIN shopcenter_product AS p ON (op.product_id = p.id) ";
		//$sql .= "WHERE o.channel_id = c.id AND o.id = op.order_id AND o.status = 1 AND o.delivery_status = 2 ";
		$sql .= "WHERE o.channel_id = c.id AND o.id = op.order_id AND o.status = 1 AND o.service_check = 1 ";

		if ( $channelParentId )
			$sql .= " AND c.parent_id = {$channelParentId} ";

		if ( $channelId )
			$sql .= " AND o.channel_id = {$channelId} ";

		$sql .= "AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";

		$sql .= "GROUP BY op.product_id";
		//$sql .= "GROUP BY o.id";

		$cfg = array();
		$cfg['sql'] = $sql;
		
		
		
/*		
		$list = $this->Model->GetList( $cfg );
		foreach ( $list as $key => $val )
		{
		echo "===========================<br>";
		
		//echo $list[ $key ] . " = " . $val['product_id'];
		//echo "------------------------------<br>";
				foreach ( $list[ $key ] as $keys => $vals )
				{
				echo $keys . " = " . $vals . "<br>";
				}
		
		
		echo "===================================<br>";

		}
		
*/		
		
		
		

		return $this->Model->GetList( $cfg );
	}
	


	function GetProductSalesReportOne( $p_sku_id )
	{
		$sql  = "SELECT op.product_id, p.name, SUM(op.quantity) AS total_quantity ";
		$sql .= "FROM shopcenter_order AS o, shopcenter_order_product AS op ";
		$sql .= "LEFT JOIN shopcenter_product AS p ON (op.product_id = p.id) ";
		$sql .= "WHERE o.id = op.order_id AND o.status = 1 AND o.service_check = 1 ";

		$sql .= " AND op.sku_id = {$p_sku_id} ";
		$sql .= "GROUP BY op.product_id";

		$cfg = array();
		$cfg['sql'] = $sql;
		
		
		$list = $this->Model->Get( $cfg );
		//echo $sql .'<br>'.$list['total_quantity'] .'<br>------------------<br>';
		/*
		foreach ( $list as $key => $val )
		{
		echo "===========================<br>";
		
		//echo $list[ $key ] . " = " . $val['product_id'];
		//echo "------------------------------<br>";
				foreach ( $list[ $key ] as $keys => $vals )
				{
				echo $keys . " = " . $vals . "<br>";
				}
		
		
		echo "===================================<br>";

		}
		
	
	*/	
		
		$total_quantity=0;
		if((int)$list['total_quantity']>0)
		{
		$total_quantity = $list['total_quantity'] ;
		}

		return $total_quantity ;
	}
	
	
		
	function GetProductSalesReportOrder( $beginTime, $endTime, $channelId, $channelParentId ,$product_id)
	{
	//echo $product_id . "===========================<br>";
		$beginTime = $beginTime;
		$endTime = $endTime;

		$sql  = "SELECT o.id AS get_order_id ";
		$sql .= "FROM shopcenter_order AS o, shopcenter_channel AS c, shopcenter_order_product AS op ";
		$sql .= "LEFT JOIN shopcenter_product AS p ON (op.product_id = p.id) ";
		//$sql .= "WHERE o.channel_id = c.id AND o.id = op.order_id AND o.status = 1 AND o.delivery_status = 2 ";
		$sql .= "WHERE o.id = op.order_id AND o.status = 1 AND o.service_check = 1 ";
		$sql .= " AND op.product_id = {$product_id} ";

		if ( $channelParentId )
			$sql .= " AND c.parent_id = {$channelParentId} ";

		if ( $channelId )
			$sql .= " AND o.channel_id = {$channelId} ";

		$sql .= "AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";

		$sql .= "GROUP BY o.id";
		//$sql .= "GROUP BY o.id";

		$cfg = array();
		$cfg['sql'] = $sql;
		
		
/*		

		$list = $this->Model->GetList( $cfg );
		
		//$orderlist = array();
		//$orderlist = 'shopcenter_warehouse_stock';
		
		//echo $list['get_order_id'] . "----<br>";
		
		$orderlist='';
		foreach ( $list as $key => $val )
		{
		echo "/===========================1<br>";
		//echo $list['get_order_id'];
		
		echo  $key . " = " . $val['get_order_id'] . "<br>";
		$orderlist = $orderlist . "," .
		//echo "------------------------------<br>";
				//foreach ( $list[ $key ] as $keys => $vals )
				//{
				//echo $keys . " = " . $vals . "<br>";
				//}
		
		
		echo "/===================================2<br>";

		}

*/
		
		
		

		return $this->Model->GetList( $cfg );
	
}






	function GetProductOrderReport_total_price( $beginTime, $endTime, $channel_id)
	{
		$sql  = "SELECT SUM(o.total_money) AS total_price ";
		$sql .= "FROM shopcenter_order AS o ";
		$sql .= "WHERE o.status = 1 AND o.channel_id = {$channel_id} ";
		$sql .= "AND o.service_check <= 1 ";
		$sql .= "AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";
		//$sql .= "ORDER BY op.product_id ASC ";, 
		$sql .= "GROUP BY o.channel_id";

		$cfg = array();
		$cfg['sql'] = $sql;
		$get_total_price = $this->Model->Get( $cfg );
		
		$get_total_prices = $get_total_price['total_price'];
		if(!$get_total_prices){$get_total_prices=0;}
		return $get_total_prices;
	}


















	function GetProductOrderReport( $beginTime, $endTime)
	{
		$beginTime = $beginTime;
		$endTime = $endTime;
		
		$sqls  = "SELECT c.id AS channel_id,c.name AS channel_name ";
		$sqls .= "FROM  shopcenter_channel AS c ";
		$sqls .= "WHERE c.parent_id>0 ";
		$sqls .= "ORDER BY c.px ";
		$cfgs = array();
		$cfgs['sql'] = $sqls;

		$channel_list = $this->Model->GetList( $cfgs );
		
		
		$channel_Report = array();
		foreach ( $channel_list as $key => $val )
		{
		$channel_Report[$key]['channel_name'] = $val['channel_name'];
		$t_total_price = $this->GetProductOrderReport_total_price($beginTime, $endTime, $val['channel_id']);
		$channel_Report[$key]['total_price'] = $t_total_price ;
		$t_product_data = $this->GetProductOrderReport_product_data($beginTime, $endTime, $val['channel_id']) ;
		$channel_Report[$key]['product_data'] = $t_product_data;
		
		
		}
		
		return $channel_Report;
	}

function ArrayIndex1009( $list, $key )
{
	if ( !is_array( $list ) )
		return array();
	
	$new = array();
	foreach ( $list as $val )
	{
		$new[$val[$key]] = $val;
	}

	return $new;
}

	function Get_my_total_price1009( $beginTime, $endTime)
	{
		$sql  = "SELECT o.channel_id,SUM(o.total_money) AS total_price ";
		$sql .= "FROM shopcenter_order AS o ";
		$sql .= "WHERE o.status = 1 ";
		$sql .= "AND o.service_check <= 1 ";
		$sql .= "AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";
		
		//if ( $channel_id>0 )
		//$sql .= " AND o.channel_id = {$channel_id} ";

		//$sql .= "ORDER BY op.product_id ASC ";, 
		$sql .= "GROUP BY o.channel_id";

		$cfg = array();
		$cfg['sql'] = $sql;
		$tlist = $this->Model->GetList( $cfg );
		$list = $this->ArrayIndex1009($tlist,"channel_id");
		return $list;
		//$get_total_prices = $get_total_price['total_price'];
		//if(!$get_total_prices){$get_total_prices=0;}
		//return $get_total_prices;
	}

	function Get_my_total_price( $beginTime, $endTime, $channel_id)
	{
		$sql  = "SELECT SUM(o.total_money) AS total_price ";
		$sql .= "FROM shopcenter_order AS o ";
		$sql .= "WHERE o.status = 1 ";
		$sql .= "AND o.service_check <= 1 ";
		$sql .= "AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";
		
		if ( $channel_id>0 )
		$sql .= " AND o.channel_id = {$channel_id} ";

		//$sql .= "ORDER BY op.product_id ASC ";, 
		$sql .= "GROUP BY o.status";

		$cfg = array();
		$cfg['sql'] = $sql;
		$get_total_price = $this->Model->Get( $cfg );
		
		$get_total_prices = $get_total_price['total_price'];
		if(!$get_total_prices){$get_total_prices=0;}
		return $get_total_prices;
	}



    function  xiaofw1009(){
			$sqls  = "SELECT c.id AS channel_id,c.name AS channel_name ";
		$sqls .= "FROM  shopcenter_channel AS c ";
		$sqls .= "WHERE c.parent_id>0 ";
		$sqls .= "ORDER BY c.px";
		$cfgs = array();
		$cfgs['sql'] = $sqls;
		return $this->Model->GetList( $cfgs );

}
	function GetChannelSalesReport( $beginTime, $endTime, $channel_id)
	{
	//ob_end_flush();
	//set_time_limit(0); 

		$beginTime = $beginTime;
		$endTime = $endTime;
		
		if($channel_id>0)
		{
		$sqls  = "SELECT c.id AS channel_id,c.name AS channel_name ";
		$sqls .= "FROM  shopcenter_channel AS c ";
		$sqls .= "WHERE c.parent_id>0 AND c.id={$channel_id} ";
		$sqls .= "ORDER BY c.px";
		$cfgs = array();
		$cfgs['sql'] = $sqls;
		$channel_list = $this->Model->GetList( $cfgs );
		}
		else
		{
		$sqls  = "SELECT c.id AS channel_id,c.name AS channel_name ";
		$sqls .= "FROM  shopcenter_channel AS c ";
		$sqls .= "WHERE c.parent_id>0 ";
		$sqls .= "ORDER BY c.px";
		$cfgs = array();
		$cfgs['sql'] = $sqls;
		$channel_list = $this->Model->GetList( $cfgs );
		}

//echo "项目列表查询完毕<br>";
//flush();
//sleep(0);
		
		
		$channel_Report = array();
		$channel_Report['channel_list'] = $channel_list;
		$search_total_price = 0;

		$id = 0 ;
		for( $i=$beginTime; $i<$endTime ; $i=$i+86400 )
		{
//echo "<br><br>======================".$i."<br>";
//flush();
//sleep(0);
		$ii = $i+86399;
		$channel_Report['day_list'][$id]['nowday'] = date('Y-m-d',$i);
		//$channel_Report['day_list'][$id]['total_price'] = $this -> Get_my_total_price($i,$ii,$channel_id);
		$search_total_price = $search_total_price + $channel_Report['day_list'][$id]['total_price'];
		$ggglist = $this ->Get_my_total_price1009($i,$ii);
//echo "一天总数据查询完毕======================<br>";
//flush();
//sleep(0);
//echo "<br><br><br>";
			foreach ( $channel_list as $key => $val )
			{
			$channel_Report['day_list'][$id]['channel_list'][$key]['id'] = $val['channel_id'];
			$channel_Report['day_list'][$id]['channel_list'][$key]['name'] = $val['channel_name'];
			//$channel_Report['day_list'][$id]['channel_list'][$key]['total_price'] = $this -> Get_my_total_price($i,$ii,$val['channel_id']);
			$channel_Report['day_list'][$id]['channel_list'][$key]['total_price'] = (int)$ggglist[$val['channel_id']]['total_price'];
			}
		$id++;
//echo "项目完毕======================<br>";
//flush();
//sleep(0);
		}
		
			//foreach ( $channel_list as $key => $val )
			//{
			//$channel_Report['channel_allMoney'][$key]['total_price'] = $this -> Get_my_total_price($beginTime,$endTime,$val['channel_id']);;
		//	}
		
		
		
		
		$channel_Report['search_total_price'] = $search_total_price;
		return $channel_Report;
	}

		/*
		$sql  = "SELECT SUM(o.total_money) AS total_price, DATE_FORMAT(FROM_UNIXTIME(o.order_time), '%Y-%m-%d') AS oneday ";
		$sql .= "FROM shopcenter_order AS o ";
		//$sql .= "LEFT JOIN shopcenter_product AS p ON (op.product_id = p.id) ";
		//$sql .= "WHERE o.channel_id = c.id AND o.id = op.order_id AND o.status = 1 AND o.delivery_status = 2 ";
		//$sql .= "WHERE o.id = op.order_id AND o.status = 1 AND o.service_check = 1 ";
		$sql .= "WHERE o.channel_id >0 AND o.status = 1 AND o.service_check <= 1 ";
		//$sql .= " AND op.product_id = {$product_id} ";
		//$sql .= "AND o.service_check <= 1 ";

		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";
		//$sql .= "ORDER BY op.product_id ASC,o.channel_id  ";, 
		$sql .= " GROUP BY oneday";

		$cfg = array();
		$cfg['sql'] = $sql;

		$day_list = $this->Model->GetList( $cfg );



		$channel_Report['channel_list'] = $channel_list;
		$channel_Report['day_list'] = $day_list;
		return $channel_Report;
		*/

		
		/*
		foreach ( $channel_list as $key => $val )
		{
		$channel_Report[$key]['channel_name'] = $val['channel_name'];
		$t_total_price = $this->GetProductOrderReport_total_price($beginTime, $endTime, $val['channel_id']);
		$channel_Report[$key]['total_price'] = $t_total_price ;
		$t_product_data = $this->GetProductOrderReport_product_data($beginTime, $endTime, $val['channel_id']) ;
		$channel_Report[$key]['product_data'] = $t_product_data;
		
		//echo $val;
		//echo $key."=============".$val['channel_id']."========a".$t_total_price."===<br>";
		
		}
		*/

		/*
		$sql  = "SELECT SUM(o.total_money) AS total_price, DATE_FORMAT(FROM_UNIXTIME(o.order_time), '%Y-%m-%d') AS oneday ";
		$sql .= "FROM shopcenter_order AS o ";
		//$sql .= "LEFT JOIN shopcenter_product AS p ON (op.product_id = p.id) ";
		//$sql .= "WHERE o.channel_id = c.id AND o.id = op.order_id AND o.status = 1 AND o.delivery_status = 2 ";
		//$sql .= "WHERE o.id = op.order_id AND o.status = 1 AND o.service_check = 1 ";
		$sql .= "WHERE o.channel_id >0 AND o.status = 1 AND o.service_check <= 1 ";
		//$sql .= " AND op.product_id = {$product_id} ";
		//$sql .= "AND o.service_check <= 1 ";

		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";
		//$sql .= "ORDER BY op.product_id ASC,o.channel_id  ";, 
		$sql .= " GROUP BY oneday";

		$cfg = array();
		$cfg['sql'] = $sql;

		$day_list = $this->Model->GetList( $cfg );



		$channel_Report['channel_list'] = $channel_list;
		$channel_Report['day_list'] = $day_list;
		return $channel_Report;
		*/


/*



select 
trunc(to_date('19700101','YYYYMMDD')+t.record_datetime/86400+to_number(substr(tz_offset(sessiontimezone),1,3))/24,'dd') "����",
  distinct(dev_id),
  count(1)
  from t_report_visit_201211 t
  where t.record_datetime >1353168000 
  group by trunc(to_date('19700101','YYYYMMDD')+t.record_datetime/86400+to_number(substr(tz_offset(sessiontimezone),1,3))/24,'dd'),
  dev_id;




 ,DATE_ADD(DATE(add_time),INTERVAL 1 DAY)

                 ,DATE(add_time))  AS period 

FROM `ecs_order_info` 

GROUP BY period



		$sql  = "SELECT cp.name AS channel_parent_name, o.finance_recieve_time, o.finance_recieve, ";
		$sql .= "SUM(op.price*op.quantity) AS total_sales_price, SUM(op.price*op.quantity*op.payout_rate) AS total_payout, ";
		$sql .= "SUM(op.price*op.quantity - op.price*op.quantity*op.payout_rate) AS total_balance ";
		$sql .= "FROM shopcenter_order AS o, shopcenter_channel AS c, shopcenter_channel_parent AS cp, shopcenter_order_product AS op ";
		$sql .= "WHERE o.channel_id = c.id AND c.parent_id = cp.id AND o.id = op.order_id AND o.finance_recieve_time >= {$beginTime} AND o.finance_recieve_time <= {$endTime} ";
		
		if ( $channelParentId )
			$sql .= " AND cp.id = {$channelParentId} ";

		$sql .= "GROUP BY cp.id, date(from_unixtime(o.finance_recieve_time)), o.finance_recieve";
*/


    ///////////channelproduct
	

	
	
	
	function GetChannelProduct( $beginTime, $endTime,$channelID )
	{
		$id = 0 ;
		$all_total_price=0;
		$channel_day = array();
		//for( $i=$beginTime; $i<$endTime ; $i=$i+86400 )
		//{
		$i=$beginTime;
		$ii = $endTime;
		$channel_day['nowday'] = date('Y-m-d',$i).' → '.date('Y-m-d',$ii);
		
		
		
		
		$t_total_price = $this->GetProductOrderReport_total_price($i, $ii,$channelID);
		
		$channel_day['info'][$id]['total_price'] = $t_total_price ;
		
		$all_total_price=$t_total_price;
		
		$t_product_data = $this->GetProductOrderReport_product_data($i, $ii, $channelID) ;
		
		$channel_day['info'][$id]['product_data'] = $t_product_data;
		
		//foreach ( $channel_day['info'][$id]['product_data'] as $keys => $vals )
		//{
		//$t_order_list = $this->GetChannelProductOrderList_1($i, $ii, $channelID, $vals['get_pid'], $vals['get_price']) ;
		//$channel_day['info'][$id]['product_data'][$keys]['orders'] = $t_order_list;
		//}
		
		
		//$id++;
		//}
		
		
		$sqls  = "SELECT c.name AS channel_name ";
		$sqls .= "FROM  shopcenter_channel AS c ";
		$sqls .= "WHERE c.id={$channelID} ";
		$cfgs = array();
		$cfgs['sql'] = $sqls;
		$channel_name = $this->Model->Get( $cfgs );
		$channel_day['channel_name'] = $channel_name['channel_name'];


		$channel_day['all_total_price'] = $all_total_price;
		
		
		return $channel_day;
	}



	function GetProductOrderReport_product_data( $beginTime, $endTime, $channel_id)
	{
		$sql  = "SELECT op.product_id AS get_pid,op.price AS get_price,op.target_id AS target_id, SUM(op.quantity) AS total_quantity, SUM(op.price*op.quantity) AS total_price";
		$sql .= ", p.name AS p_name,p.board AS pro3c";
		$sql .= ", SUM(o.total_money) AS total_price_order,o.id AS OID ";




		$sql .= "FROM shopcenter_order AS o, shopcenter_order_product AS op ";
		$sql .= "LEFT JOIN shopcenter_product AS p ON (op.product_id = p.id) ";
		$sql .= "WHERE o.id = op.order_id AND o.status = 1 AND o.channel_id = {$channel_id} ";
		$sql .= " AND o.service_check <= 1 ";

		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";
		$sql .= " GROUP BY op.product_id,op.price ";
		//$sql .= " ORDER BY op.product_id";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	
	
	}


	function GetChannelProductOrderList_1(  $beginTime, $endTime, $channel_id, $productID, $price )
	{
		$sql  = "SELECT o.id AS orderIDS ";
		$sql .= "FROM shopcenter_order_product AS op, shopcenter_order AS o ";
		//$sql .= "LEFT JOIN shopcenter_order_product AS op ON (op.product_id = {$productID}) ";
		$sql .= "WHERE o.id = op.order_id AND o.status = 1 AND o.channel_id = {$channel_id} AND op.product_id = {$productID}  ";
		$sql .= " AND o.service_check <= 1 ";
		$sql .= " AND op.price = {$price} ";
		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";
		$sql .= " order by o.id ";
		
		//echo $sql;

		$cfg = array();
		$cfg['sql'] = $sql;
		$OrderList = $this->Model->GetList( $cfg );
		//echo count($OrderList) .'<br>';
		return $OrderList;
	}
	
	

	function GetChannelProductOrderList(  $beginTime, $endTime, $channel_id, $productID )
	{
		$sql  = "SELECT o.id AS orderIDS ";
		$sql .= "FROM shopcenter_order_product AS op, shopcenter_order AS o ";
		//$sql .= "LEFT JOIN shopcenter_order_product AS op ON (op.product_id = {$productID}) ";
		$sql .= "WHERE o.id = op.order_id AND o.status = 1 AND o.channel_id = {$channel_id} AND op.product_id = {$productID}  ";
		$sql .= " AND o.service_check <= 1 ";
		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";
		
		//echo $sql;

		$cfg = array();
		$cfg['sql'] = $sql;
		$OrderList = $this->Model->GetList( $cfg );
		//echo count($OrderList) .'<br>';
		return $OrderList;
	}
























	function GetNeedList_supplier_Total( $manageId )
	{
		$sql  = "SELECT p.supplier_id AS supplierId ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE (p.quantity > p.purchase_quantity + p.lock_quantity)  ";
		
		$sql .= "AND o.purchase_check = 1 ";
		$sql .= "AND o.service_check = 1 ";
		
		if ( $manageId>0 )
			$sql .= "AND (p.supplier_id IN( SELECT id FROM shopcenter_supplier WHERE manage_id={$manageId} )) ";



		$sql .= "GROUP BY p.supplier_id ";
		$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;


        return count($this->Model->GetList( $cfg ));
	}





	function GetNeedList_supplier()
	{
		$sql  = "SELECT p.supplier_id AS supplierId,s.name AS supplierName,s.manage_name AS manageName,s.manage_id AS manageID ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "INNER JOIN shopcenter_supplier AS s ON (s.id = p.supplier_id) ";
		$sql .= "WHERE (p.quantity > p.purchase_quantity + p.lock_quantity)  ";
		//$sql .= "WHERE p.lock_quantity=0 AND  p.purchase_quantity=0 ";
		
		$sql .= "AND o.purchase_check = 1 ";
		$sql .= "AND o.service_check = 1 ";
		$sql .= "AND s.key_mode = 0 ";

		$sql .= "GROUP BY p.supplier_id ";
		//$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}




	function GetNeedList_one1009($supplier_id = false )
	{
		$sql  = "SELECT p.*, SUM(p.quantity) AS total_quantity, SUM(p.purchase_quantity) AS total_purchase_quantity,COUNT(o.id) AS total_num ";
		$sql .= "FROM shopcenter_order_product AS p Inner JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE (p.quantity > p.purchase_quantity + p.lock_quantity)  ";


		if($supplier_id)
		$sql .= "AND p.supplier_id={$supplier_id} ";
		
		$sql .= "AND o.purchase_check = 1 ";
		$sql .= "AND o.service_check = 1 AND o.id>62411 ";

		$sql .= "GROUP BY sku_id ";
		//$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}
	

	function GetNeedList_one1110()
	{
		$data = array();
		$data['supplier_id'] = 343;
		$this->Model->Update( array(
			'table' => 'shopcenter_order_product',
			'data' => $data,
			'condition' => array( 'product_id' => 8886 )
		) );



		//$sql  = "SELECT p.*, SUM(p.quantity) AS total_quantity, SUM(p.purchase_quantity) AS total_purchase_quantity,COUNT(o.id) AS total_num ";
		$sql  = "SELECT p.*,o.*, p.quantity AS total_quantity, p.purchase_quantity AS total_purchase_quantity,o.id AS total_num ";
		$sql .= "FROM shopcenter_order_product AS p Inner JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE (p.quantity > p.purchase_quantity + p.lock_quantity)  ";
		//$sql .= "WHERE p.id>0  ";


		//if($supplier_id)
		//$sql .= "AND p.supplier_id={$supplier_id} ";
		
		$sql .= "AND o.purchase_check = 1 ";
		$sql .= "AND o.service_check = 1 AND o.id>62411 AND p.product_id=8886  ";

		//$sql .= "GROUP BY sku_id ";
		//$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	}
	
	

	function GetNeedList_one( $skuId = false, $supplier_id = false )
	{
		$sql  = "SELECT p.*, SUM(p.quantity) AS total_quantity, SUM(p.purchase_quantity) AS total_purchase_quantity,COUNT(*) AS total_num ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE (p.quantity > p.purchase_quantity + p.lock_quantity)  ";

		if ( $skuId && is_array( $skuId ) )
			$sql .= "AND p.sku_id IN ( " . implode( ',', $skuId ) . " ) ";
		elseif ( $skuId )
			$sql .= "AND sku_id = '{$skuId}' ";

		if($supplier_id)
		$sql .= "AND p.supplier_id={$supplier_id} ";
		
		$sql .= "AND o.purchase_check = 1 ";
		$sql .= "AND o.service_check = 1 ";

		$sql .= "GROUP BY p.supplier_id,sku_id ";
		$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}





























	function GetProductPurchasePrice( $id )
	{
		$sql  = "SELECT pp.price AS purchaseMoney";
		$sql .= " FROM shopcenter_purchase_product AS pp ";
		$sql .= " INNER JOIN shopcenter_purchase_relation AS r ON (pp.id = r.purchase_product_id ) ";
		$sql .= " WHERE r.order_product_id = {$id} ";
		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['key'] = 'purchaseMoney';
		$purchaseMoney = $this->Model->Get( $cfg );
		return $purchaseMoney;
	}

	function GetProductPurchaseCost( $id )
	{
		$sql  = "SELECT pp.help_cost AS costMoney";
		$sql .= " FROM shopcenter_purchase_product AS pp ";
		$sql .= " INNER JOIN shopcenter_purchase_relation AS r ON (pp.id = r.purchase_product_id ) ";
		$sql .= " WHERE r.order_product_id = {$id} ";
		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['key'] = 'costMoney';
		$costMoney = $this->Model->Get( $cfg );
		return $costMoney;
	}

	function GetProductOrderCost( $id )
	{
		$sql  = "SELECT order_shipping_cost AS costMoney";
		$sql .= " FROM shopcenter_order ";
		$sql .= " WHERE id = {$id} ";
		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['key'] = 'costMoney';
		$costMoney = $this->Model->Get( $cfg );
		return $costMoney;
	}


	function tongbuchengben()//同步成本
	{
	
		$sql  = "SELECT * FROM shopcenter_order_product WHERE is_upp=0 AND purchase_quantity>0";
		$cfg = array();
		$cfg['sql'] = $sql;
		$upData = $this->Model->GetList( $cfg );
		
		foreach ( $upData as $key => $val )
		{
		$data_a = array();
		//$data_a['upp_money'] = $this->GetProductPurchasePrice($val['id']) ;
		$data_a['stock_price'] = $this->GetProductPurchasePrice($val['id']) ;
		$data_a['is_upp'] = 1 ;
		$this->UpdateProduct( $val['id'], $data_a );
		}
}
	

	function Getkkprout( $id )
	{
		$cfg = array();
		$cfg['select'] = "cost_price AS stock_price";
		$cfg['table'] = 'shopcenter_product';
		$cfg['condition'] = array( 'id' => $id );
		$cfg['key'] = 'stock_price';

		return $this->Model->Get( $cfg );
	}
	
	
	
	function GetChannelgross( $beginTime, $endTime,$channelID=0, $board=0,$warehouseID=0, $supplierID=0, $supplierMe=0 )
	{
	
		$sql  = "SELECT * FROM shopcenter_order_product WHERE is_upp=0 AND purchase_quantity>0";
		$cfg = array();
		$cfg['sql'] = $sql;
		$upData = $this->Model->GetList( $cfg );
		
		foreach ( $upData as $key => $val )
		{
		$data_a = array();
		$data_a['stock_price'] = $this->GetProductPurchasePrice($val['id']) ;
		$data_a['is_upp'] = 1 ;
		$this->UpdateProduct( $val['id'], $data_a );
		}

	
		$sqls  = "SELECT op.id AS id FROM shopcenter_order_product AS op INNER JOIN shopcenter_order AS o ON (op.order_id = o.id ) WHERE op.price>0 AND o.warehouse_id=5 AND op.is_up=0 ";
		$cfgs = array();
		$cfgs['sql'] = $sqls;
		$upDatas = $this->Model->GetList( $cfgs );
		
		foreach ( $upDatas as $keys => $vals )
		{
		$data_b = array();
		$data_b['help_cost'] = $this->GetProductPurchaseCost($vals['id']) ;
		$data_b['is_up'] = 1 ;
		$this->UpdateProduct( $vals['id'], $data_b );
		}
	


		$sqlss  = "SELECT o.id AS id,op.id AS opId FROM shopcenter_order_product AS op INNER JOIN shopcenter_order AS o ON (op.order_id = o.id ) WHERE op.price>0 AND o.warehouse_id<>5 AND op.is_up=0 ";
		$cfgss = array();
		$cfgss['sql'] = $sqlss;
		$upDatass = $this->Model->GetList( $cfgss );
		
		foreach ( $upDatass as $keyss => $valss )
		{
		$data_c = array();
		$data_c['order_shipping_cost'] = $this->GetProductOrderCost($valss['id']) ;
		$data_c['is_up'] = 1 ;

		$this->UpdateProduct( $valss['opId'], $data_c );
		}
	
	
	
	


		$gross = array();
		
		$t_product_data = $this->GetProductOrderReport_gross_product_data_1($beginTime, $endTime, $channelID, $board,$warehouseID,$supplierID, $supplierMe) ;
		$gross['product_data'] = $t_product_data;
		
		return $gross;
	}
	
	
	
	function GetProductOrderReport_gross_product_data_1( $beginTime, $endTime, $channelID=0, $board=0,$warehouseID=0,$supplierID=0, $supplierMe=0 )
	{
		
		
		
		
		$sql  = "SELECT  op.id AS opId";
		$sql .= ",op.extra_name AS extraName,op.price AS salePrice,SUM(op.quantity) AS saleQuantity,SUM(op.purchase_quantity) AS purchaseQuantity,SUM(op.price*op.quantity) AS totalSalePrice,SUM(op.stock_price*op.quantity) AS totalstockPrice ";
		$sql .= ",p.id AS id,p.board AS product_board,p.name AS name ";
		//$sql .= " ";
		//$sql .= ",SUM(op.quantity) AS quantity,SUM(op.purchase_quantity) AS purchase_quantity ";
		$sql .= ",op.target_id AS targetId ";
		//$sql .= ",op.price AS salePrice,SUM(op.price*op.quantity) AS toatlSalePrice ";
		//$sql .= ",op.stock_price AS stock_price,SUM(op.stock_price*op.quantity) AS toatl_stock_price ";
		//$sql .= ",pp.price AS stock_prices,SUM(pp.price*op.quantity) AS toatl_stock_prices,SUM(op.quantity) AS pp_quantity,SUM(pp.help_cost*op.quantity) AS pp_cost ";
		$sql .= ", SUM(op.price*op.quantity*op.payout_rate) AS total_payout ";
		$sql .= ", SUM(op.order_invoice_cost+op.order_shipping_cost+op.help_cost*op.quantity) AS total_kdf ";
		//sql .= ",op.*,op.product_id AS get_pid,op.price AS get_price,op.target_id AS target_id, p.name AS p_name,op.extra_name AS p_channel_name, SUM(op.quantity) AS total_quantity, SUM(op.price) AS total_price, SUM(op.stock_price*op.quantity) AS total_stock_price,SUM(pp.price*pp.quantity) AS total_pp_price, SUM(op.price*op.quantity) AS total_sale_price, SUM(op.price*op.quantity*op.payout_rate) AS total_payout, SUM(o.order_invoice_cost+o.order_shipping_cost+pp.help_cost*op.quantity) AS total_zyf ";
		
		
		$sql .= " FROM shopcenter_order_product AS op ";
		$sql .= " INNER JOIN shopcenter_order AS o ON (op.order_id = o.id ) ";
		$sql .= " INNER JOIN shopcenter_product AS p ON (op.product_id=p.id) ";
		//$sql .= "LEFT JOIN shopcenter_purchase_relation AS r ON (r.order_product_id = op.id) ";
		//$sql .= "LEFT JOIN shopcenter_purchase_product AS pp ON (pp.id = r.purchase_product_id) ";
		$sql .= "WHERE o.status = 1 AND o.delivery_status = 2 ";
		
		if($channelID>0)
		$sql .= " AND o.channel_id = {$channelID} ";

		if($warehouseID>0)
		$sql .= " AND o.warehouse_id = {$warehouseID} ";
		
		//

		if($supplierID >0)
		{
		$sql .= " AND op.supplier_id = {$supplierID} ";
		}
		elseif($supplierMe>0)
		{
		$sql .= " AND (op.supplier_id IN( SELECT id FROM shopcenter_supplier WHERE manage_id ={$supplierMe} )) ";
		
		}

		if($board>0)
		$sql .= " AND p.board = {$board} ";
	
		//$sql .= " AND o.service_check <= 1 ";
		if ( $beginTime > 0 && $endTime >0 )
		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";
		
		
		$sql .= " GROUP BY op.product_id ";
		if($channelID>0)
		$sql .= ",op.target_id,op.price ";

		$sql .= " ORDER BY op.supplier_id,op.product_id";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	
	
	}

	function GetProductOrderReport_gross_product_data( $beginTime, $endTime, $channelID=0, $board=0 )
	{
		
		
		
		
		$sql  = "SELECT p.board AS product_board ";
		$sql .= ",p.id AS id ";
		$sql .= ",p.name AS name ";
		$sql .= ",op.extra_name AS extraName ";
		$sql .= ",SUM(op.quantity) AS quantity,SUM(op.purchase_quantity) AS purchase_quantity ";
		$sql .= ",op.target_id AS targetId ";
		$sql .= ",op.price AS salePrice,SUM(op.price*op.quantity) AS toatlSalePrice ";
		$sql .= ",op.stock_price AS stock_price,SUM(op.stock_price*op.quantity) AS toatl_stock_price ";
		$sql .= ",pp.price AS stock_prices,SUM(pp.price*op.quantity) AS toatl_stock_prices,SUM(op.quantity) AS pp_quantity,SUM(pp.help_cost*op.quantity) AS pp_cost ";
		$sql .= ", SUM(op.price*op.quantity*op.payout_rate) AS total_payout ";
		$sql .= ", SUM(o.order_invoice_cost+o.order_shipping_cost+pp.help_cost*op.quantity) AS total_kdf ";
		//sql .= ",op.*,op.product_id AS get_pid,op.price AS get_price,op.target_id AS target_id, p.name AS p_name,op.extra_name AS p_channel_name, SUM(op.quantity) AS total_quantity, SUM(op.price) AS total_price, SUM(op.stock_price*op.quantity) AS total_stock_price,SUM(pp.price*pp.quantity) AS total_pp_price, SUM(op.price*op.quantity) AS total_sale_price, SUM(op.price*op.quantity*op.payout_rate) AS total_payout, SUM(o.order_invoice_cost+o.order_shipping_cost+pp.help_cost*op.quantity) AS total_zyf ";
		
		
		$sql .= " FROM shopcenter_order_product AS op ";
		$sql .= " LEFT JOIN shopcenter_product AS p ON (p.id=op.product_id) ";
		$sql .= " LEFT JOIN shopcenter_order AS o ON (o.id=op.order_id ) ";
		$sql .= "LEFT JOIN shopcenter_purchase_relation AS r ON (r.order_product_id = op.id) ";
		$sql .= "LEFT JOIN shopcenter_purchase_product AS pp ON (pp.id = r.purchase_product_id) ";
		$sql .= "WHERE op.id>0 AND o.status = 1 AND o.delivery_status = 2 ";
		
		if($channelID>0)
		$sql .= " AND o.channel_id = {$channelID} ";

		if($board>0)
		$sql .= " AND p.board = {$board} ";
		
		//$sql .= " AND o.service_check <= 1 ";
		if ( $beginTime > 0 && $endTime >0 )
		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";
		
		
		$sql .= " GROUP BY op.product_id ";
		if($channelID>0)
		$sql .= ",op.target_id,op.price ";

		$sql .= " ORDER BY op.supplier_id,op.product_id";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	
	
	}





	function GetNeedList_gls( $skuId = false, $offset = 0, $limit = 0 )
	{
		$sql  = "SELECT o.target_id AS channel_target_id,o.channel_id AS channel_id,o.order_time AS order_time,o.order_shipping_name AS order_shipping_name,O.order_shipping_phone AS order_shipping_phone,O.order_shipping_mobile AS order_shipping_mobile,O.order_shipping_address AS order_shipping_address,O.order_shipping_zip AS order_shipping_zip,p.*, SUM(p.quantity) AS total_quantity, SUM(p.purchase_quantity) AS total_purchase_quantity,COUNT(*) AS total_num ";
		$sql .= "FROM shopcenter_order_product AS p LEFT JOIN shopcenter_order AS o ON o.id = p.order_id ";
		$sql .= "WHERE p.quantity > p.purchase_quantity + p.lock_quantity ";

		if ( $skuId && is_array( $skuId ) )
			$sql .= "AND p.sku_id IN ( " . implode( ',', $skuId ) . " ) ";
		elseif ( $skuId )
			$sql .= "AND sku_id = '{$skuId}' ";

		$sql .= "AND o.purchase_check = 1 ";
		$sql .= "AND o.service_check = 1 ";
		$sql .= "AND p.supplier_id = 63 ";

		$sql .= "GROUP BY sku_id ";
		$sql .= "ORDER BY order_id ASC ";

		$cfg = array();
		$cfg['sql'] = $sql;
		$cfg['limit'] = $limit;
		$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}
	
	
function StrValss( $list,$v)
{
	if ( !is_array( $list ) )
		return array();
	
	$new = ',';
	foreach ( $list as $val ){$new .= ','.$val[$v];}
	$new = str_replace(',,','',$new);
	$new = ToArray($new);
	$new = array_unique($new);
	$new = ToStr($new);
	return $new;
}

	function GetNeedList_mast()
	{
		$sqls  = "SELECT o.id AS orderID FROM shopcenter_order AS o WHERE o.purchase_check = 1 AND o.service_check = 1 AND o.delivery_status<2 AND o.lock_status<2  AND o.id>62411 ";
		$cfgs = array();
		$cfgs['sql'] = $sqls;
		$orderList = $this->Model->GetList( $cfgs );
		$orderIDS = $this->StrValss($orderList,"orderID");
		//echo $orderIDS."<br>";


		$sql  = "SELECT op.sku_id AS skuID, op.product_id AS productID, op.sku AS productSku ";
		$sql .= ",p.cost_price AS productPrice,SUM((op.quantity - op.purchase_quantity - op.lock_quantity)) AS productQuantity ";
		$sql .= "FROM shopcenter_order_product AS op ";
		//$sql .= "INNER JOIN shopcenter_order AS o ON o.id = op.order_id ";
		$sql .= "INNER JOIN shopcenter_supplier AS s ON (s.id = op.supplier_id) ";
		$sql .= "INNER JOIN shopcenter_product AS p ON (p.id = op.product_id) ";
		$sql .= "WHERE op.quantity > op.purchase_quantity + op.lock_quantity ";
		$sql .= "AND s.key_mode = 1 ";
		$sql .= "AND op.order_id in({$orderIDS}) ";
		$sql .= "GROUP BY skuID ";
		


		$cfg = array();
		$cfg['sql'] = $sql;
	//	$cfg['limit'] = $limit;
	//	$cfg['offset'] = $offset;

		return $this->Model->GetList( $cfg );
	}

	function Add1008( $data )
	{
		$this->Model->Add( array(
			'table' => 'shopcenter_store',
			'data' => $data
		) );

		return $this->Model->DB->LastID();
	}


	function StatTotal1008( $id )
	{
		$info = $this->Model->Get( array(
			'table' => 'shopcenter_warehouse_log',
			'select' => 'SUM(quantity) AS total_quantity, COUNT(*) AS total_breed',
			'condition' => array( 'target_id' => $id, 'type' => 1 )
		) );

		$this->Update1008( $id, $info );
	}

	function Update1008( $id, $data )
	{
		return $this->Model->Update( array(
			'table' => 'shopcenter_store',
			'data' => $data,
			'condition' => array( 'id' => $id )
		) );
	}
	

	function UpdateUnique1008( $warehouseId, $placeId, $skuId, $data, $dataExt = '' )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_stock';
		$cfg['data'] = $data;
		$cfg['dataExt'] = $dataExt;
		$cfg['condition'] = array( 'warehouse_id' => $warehouseId, 'place_id' => $placeId, 'sku_id' => $skuId );
		
		return $this->Model->Update( $cfg );
	}
	
	
	function GetUnique1008( $warehouseId, $placeId, $skuId )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_warehouse_stock';
		$cfg['condition'] = array( 'warehouse_id' => $warehouseId, 'place_id' => $placeId, 'sku_id' => $skuId );
		
		return $this->Model->Get( $cfg );
	}
	function AddStock1008( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_warehouse_stock', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Addppp1008( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_warehouse_log', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}
	
		
	function GetProductList_hurry( $orderId = 0, $offset = 0, $limit = 0 )
	{
		$sql  = "SELECT op.*,p.cost_price AS product_money ";
		$sql .= "FROM shopcenter_order_product AS op LEFT JOIN shopcenter_product AS p ON p.id = op.product_id ";
		$sql .= "WHERE op.order_id ={$orderId} ";


        $cfg = array();
		$cfg['sql'] = $sql;
		//$cfg['table'] = 'shopcenter_order_product';
		//$cfg['order'] = "id ASC";
		//$cfg['condition'] = array( 'order_id' => $orderId );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		//$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}



















	function Gup_data()
	{
		//$sql .= "WHERE o.channel_id = c.id AND o.id = op.order_id AND o.status = 1 AND o.delivery_status = 2 ";
		//$sql .= "WHERE o.id = op.order_id AND o.status = 1 AND o.service_check = 1 ";
		//$sql .= " AND op.product_id = {$product_id} ";
		//$sql  = "SELECT p.*, SUM(op.stock_price*quantity) AS total_stock_price, SUM(op.price*quantity) AS total_sale_price, SUM(op.price*p.quantity*p.payout_rate) AS total_payout ";
		
		//$sql  = "SELECT pp.help_cost AS p_help_cost,r.purchase_product_id AS pp_id,p.board AS product_board,op.*,op.product_id AS get_pid,op.price AS get_price,op.target_id AS target_id, p.name AS p_name,op.extra_name AS p_channel_name, SUM(op.quantity) AS total_quantity, SUM(op.price) AS total_price, SUM(op.stock_price*op.quantity) AS total_stock_price,SUM(pp.price*pp.quantity) AS total_pp_price, SUM(op.price*op.quantity) AS total_sale_price, SUM(op.price*op.quantity*op.payout_rate) AS total_payout, SUM(o.order_invoice_cost+o.order_shipping_cost+pp.help_cost*op.quantity) AS total_zyf ";
		
		
		
		$sql  = "SELECT pp.price AS cgjg,r.order_product_id AS oid ";
		$sql .= "FROM shopcenter_purchase_relation AS r ";
		//$sql .= "LEFT JOIN shopcenter_order_product AS op ON (op.id = r.order_product_id) ";
		$sql .= "LEFT JOIN shopcenter_purchase_product AS pp ON (pp.id = r.purchase_product_id) ";
		$sql .= "WHERE r.id >0 ";

		$cfg = array();
		$cfg['sql'] = $sql;

		return $this->Model->GetList( $cfg );
	
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

function GetDownload_jh_1($beginTime,$endTime,$channelID)
	{
		$sql  = "SELECT op.extra_name AS bankName,p.name AS productName,op.target_id AS targetID, op.price AS productMoney, SUM(op.quantity) AS totalQuantity, o.status AS orderStatus, o.service_check AS orderService,op.product_id AS productID ";
		$sql .= "FROM shopcenter_order AS o ";
		$sql .= "INNER JOIN shopcenter_order_product AS op ON (o.id = op.order_id) ";
		$sql .= "LEFT JOIN shopcenter_product AS p ON (p.id = op.product_id) ";
		$sql .= "WHERE o.channel_id = {$channelID} ";
		if ( $beginTime > 0 && $endTime >0 )
		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";

		$sql .= "GROUP BY o.service_check,o.status,op.price,op.target_id ";
		$sql .= "ORDER BY o.service_check,o.status,op.extra_name ";


        $cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->GetList( $cfg );
	}

function GetDownload_jh_1_1($beginTime,$endTime,$channelID,$productID,$productMoney,$targetID,$orderStatus,$orderService)
	{
		$sql  = "SELECT o.id AS orderID,o.target_id AS orderTargetID ";
		$sql .= "FROM shopcenter_order AS o ";
		//$sql .= "INNER JOIN shopcenter_order_product AS op ON (o.id = op.order_id AND op.id = {$productID} AND op.price = {$productMoney} AND op.target_id = {$targetID}  ) ";
		$sql .= "INNER JOIN shopcenter_order_product AS op ON (o.id = op.order_id AND op.price = {$productMoney} AND op.target_id = '{$targetID}' AND op.product_id = {$productID}) ";
		//$sql .= "LEFT JOIN shopcenter_product AS p ON (p.id = op.product_id) ";
		$sql .= "WHERE o.channel_id = {$channelID} AND o.status = {$orderStatus} AND o.service_check = {$orderService} ";
		if ( $beginTime > 0 && $endTime >0 )
		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";

		//$sql .= "GROUP BY o.service_check,o.status,op.price,op.target_id ";
		$sql .= "ORDER BY o.service_check,o.status,op.extra_name ";


        $cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->GetList( $cfg );
	}







////////////////////////////////////////////////////////////////////////////////////////////
function GetDownload_gf_01($beginTime,$endTime,$channelID)//所有
{
		$sql  = "SELECT o.id AS orderID,o.target_id AS orderTargetID ";
		$sql .= "FROM shopcenter_order AS o ";
		$sql .= "INNER JOIN shopcenter_order_product AS op ON (o.id = op.order_id) ";
		$sql .= "WHERE o.channel_id = {$channelID} ";
		if ( $beginTime > 0 && $endTime >0 )
		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";

        $cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->GetList( $cfg );
}

function GetDownload_gf_0($beginTime,$endTime,$channelID)//所有
{
		$sql  = "SELECT SUM(op.quantity) AS totalQuantity, SUM(op.quantity*op.price) AS totalMoney ";
		$sql .= "FROM shopcenter_order AS o ";
		$sql .= "INNER JOIN shopcenter_order_product AS op ON (o.id = op.order_id) ";
		$sql .= "WHERE o.channel_id = {$channelID} ";
		if ( $beginTime > 0 && $endTime >0 )
		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} ";

        $cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->Get( $cfg );
}

function GetDownload_gf_1($beginTime,$endTime,$channelID)//有效
{
		$sql  = "SELECT SUM(op.quantity) AS totalQuantity, SUM(op.quantity*op.price) AS totalMoney ";
		$sql .= "FROM shopcenter_order AS o ";
		$sql .= "INNER JOIN shopcenter_order_product AS op ON (o.id = op.order_id) ";
		$sql .= "WHERE o.channel_id = {$channelID} ";
		if ( $beginTime > 0 && $endTime >0 )
		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} AND o.status = 1 AND o.service_check = 1 ";

        $cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->Get( $cfg );
}
function GetDownload_gf_2($beginTime,$endTime,$channelID)//售后退货中
{
		$sql  = "SELECT SUM(op.quantity) AS totalQuantity, SUM(op.quantity*op.price) AS totalMoney ";
		$sql .= "FROM shopcenter_order AS o ";
		$sql .= "INNER JOIN shopcenter_order_product AS op ON (o.id = op.order_id) ";
		$sql .= "WHERE o.channel_id = {$channelID} ";
		if ( $beginTime > 0 && $endTime >0 )
		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} AND o.status = 2 AND o.service_check = 1 ";

        $cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->Get( $cfg );
}
function GetDownload_gf_3($beginTime,$endTime,$channelID)//售后退货完毕
{
		$sql  = "SELECT SUM(op.quantity) AS totalQuantity, SUM(op.quantity*op.price) AS totalMoney ";
		$sql .= "FROM shopcenter_order AS o ";
		$sql .= "INNER JOIN shopcenter_order_product AS op ON (o.id = op.order_id) ";
		$sql .= "WHERE o.channel_id = {$channelID} ";
		if ( $beginTime > 0 && $endTime >0 )
		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} AND o.status = 3 AND o.service_check = 1 ";

        $cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->Get( $cfg );
}
function GetDownload_gf_4($beginTime,$endTime,$channelID)//已取消
{
		$sql  = "SELECT SUM(op.quantity) AS totalQuantity, SUM(op.quantity*op.price) AS totalMoney ";
		$sql .= "FROM shopcenter_order AS o ";
		$sql .= "INNER JOIN shopcenter_order_product AS op ON (o.id = op.order_id) ";
		$sql .= "WHERE o.channel_id = {$channelID} ";
		if ( $beginTime > 0 && $endTime >0 )
		$sql .= " AND o.order_time >= {$beginTime} AND o.order_time <= {$endTime} AND o.status =1 AND o.service_check = 2 ";

        $cfg = array();
		$cfg['sql'] = $sql;
		return $this->Model->Get( $cfg );
}
/////////////////////////////////////////////////////////////////////////////////////////////



	function GetChannelName($channelId)
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_channel';
		$cfg['condition'] = array( 'id' => $channelId );
		$cfg['key'] = 'mini_name';
		return $this->Model->Get( $cfg );
	}



	function GetPurchaseByOrder( $orderId )//订单反查采购单
	{
		$sql  = "SELECT purchase_id ";
		$sql .= " FROM shopcenter_purchase_relation ";
		$sql .= " WHERE order_id = {$orderId} ";
		$sql .= " GROUP BY order_id ";
		$cfg = array();
		$cfg['key'] = 'purchase_id';
		$cfg['sql'] = $sql;
		return $this->Model->Get( $cfg );
	}

























	function GetChannelgrosss( $beginTime, $endTime,$channelID=0, $board=0,$warehouseID=0, $supplierID=0, $supplierMe=0 )
	{
	
		$sql  = "SELECT * FROM shopcenter_order_product WHERE is_upp=0 AND purchase_quantity>0";
		$cfg = array();
		$cfg['sql'] = $sql;
		$upData = $this->Model->GetList( $cfg );
		
		foreach ( $upData as $key => $val )
		{
		$data_a = array();
		//$data_a['upp_money'] = $this->GetProductPurchasePrice($val['id']) ;
		$data_a['stock_price'] = $this->GetProductPurchasePrice($val['id']) ;
		$data_a['is_upp'] = 1 ;
		$this->UpdateProduct( $val['id'], $data_a );
		}

/*
		$sqlk  = "SELECT * FROM shopcenter_order_product WHERE stock_price=0";
		$cfgk = array();
		$cfgk['sql'] = $sqlk;
		$upDatak = $this->Model->GetList( $cfgk );
		
		foreach ( $upDatak as $keyk => $valk )
		{
		$data_ak = array();
		//$data_a['upp_money'] = $this->GetProductPurchasePrice($val['id']) ;
		$data_ak['stock_price'] = $this->Getkkprout($valk['product_id']) ;
		$this->UpdateProduct( $valk['id'], $data_ak );
		}
		
*/		
		$sqls  = "SELECT op.id AS id FROM shopcenter_order_product AS op INNER JOIN shopcenter_order AS o ON (op.order_id = o.id ) WHERE op.price>0 AND o.warehouse_id=5 AND op.is_up=0 ";
		$cfgs = array();
		$cfgs['sql'] = $sqls;
		$upDatas = $this->Model->GetList( $cfgs );
		
		foreach ( $upDatas as $keys => $vals )
		{
		$data_b = array();
		$data_b['help_cost'] = $this->GetProductPurchaseCost($vals['id']) ;
		$data_b['is_up'] = 1 ;
		$this->UpdateProduct( $vals['id'], $data_b );
		}
	


		$sqlss  = "SELECT o.id AS id,op.id AS opId FROM shopcenter_order_product AS op INNER JOIN shopcenter_order AS o ON (op.order_id = o.id ) WHERE op.price>0 AND o.warehouse_id<>5 AND op.is_up=0 ";
		$cfgss = array();
		$cfgss['sql'] = $sqlss;
		$upDatass = $this->Model->GetList( $cfgss );
		
		foreach ( $upDatass as $keyss => $valss )
		{
		$data_c = array();
		$data_c['order_shipping_cost'] = $this->GetProductOrderCost($valss['id']) ;
		$data_c['is_up'] = 1 ;

		$this->UpdateProduct( $valss['opId'], $data_c );
		}
	
	
	
	


		$gross = array();
		
		//$t_total_price = $this->GetProductOrderReport_total_price($beginTime, $endTime,$channelID);
		//$gross['info']['total_price'] = $t_total_price ;
		//$all_total_price=$all_total_price+$t_total_price;
		$t_product_data = $this->GetProductOrderReport_gross_product_data_1($beginTime, $endTime, $channelID, $board,$warehouseID,$supplierID, $supplierMe) ;
		$gross['product_data'] = $t_product_data;
		
		//foreach ( $gross['info']['product_data'] as $keys => $vals )
		//{
		//$t_order_list = $this->GetChannelProductOrderList_1($beginTime, $endTime, $channelID, $vals['get_pid'], $vals['get_price']) ;
		//$gross['info']['product_data'][$keys]['orders'] = $t_order_list;
		//}
		
		return $gross;
	}











}
?>
