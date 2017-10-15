<?php
/*
@@acc_title="常规采购 general"
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

Core::LoadDom( 'CenterSku' );

	$type = (int)$_POST['type'];
	$productType = (int)$_POST['product_type'];
	$paymentType = (int)$_POST['payment_type'];
	$invoiceType = (int)$_POST['invoice_type'];
	$warehouseId = (int)$_POST['warehouse_id'];
	$supplierId = (int)$_POST['supplier'];


	if ( count( $_POST['sku'] ) == 0 )
		exit( '请录入产品' );

	//if ( !$productType )
		//exit( '请选择产品类型' );
	if ( !$paymentType )
		exit( '请选择付款方式' );
	if ( !$invoiceType )
		exit( '请选择发票类型' );
	if ( !$warehouseId )
		exit( '请选择仓库' );
	if ( !$supplierId )
		exit( '请填写正确的供应商' );


$My_total_money = 0;
$My_all_money = 0;

	$productDataList = array();
	
	foreach ( $_POST['sku'] as $key => $sku )
	{
		$CenterSkuDom = new CenterSkuDom( $sku );
		$skuInfo = $CenterSkuDom->InitProduct();
		
		$data = array();
		$data['sku'] = $sku;
		$data['sku_id'] = $CenterProductExtra->Sku2Id( $sku );
		$data['product_id'] = intval( $_POST['pid'][$key] );
		
		
		$data['quantity'] = intval( $_POST['quantity'][$key] );
		$data['price'] = floatval( $_POST['price'][$key] );
		$data['help_cost'] = floatval( $_POST['help_cost'][$key] );
		
		$mn_1 = $_POST['quantity'][$key] * $_POST['price'][$key];
		$mn_2 = $_POST['quantity'][$key] * $_POST['help_cost'][$key];
		$mn_3 = $mn_1 + $mn_2 ;
		$data['total_money'] = floatval($mn_1  );
		$data['total_cost'] = floatval( $mn_2 );
		$data['all_money'] = floatval( $mn_3 );
		
		$My_total_cost = $My_total_cost + $mn_2;
        $My_all_money =  $My_all_money + $mn_3;

		
		
		
		
		$data['history_price'] = $CenterPurchaseModel->GetProductHistoryPrice( $sku );
		$data['comment'] = trim( $_POST['row_comment'][$key] );
		$data['add_time'] = time();
		$data['manager_user_id'] = $skuInfo['product']['manager_user_id'];
		$data['manager_user_name'] = $skuInfo['product']['manager_user_name'];
		$data['manager_user_real_name'] = $skuInfo['product']['manager_user_real_name'];

		if ( $data['quantity'] <= 0 )
			exit( '数量必须大于零' );

		if ( !$data['sku'] || !$data['sku_id'] )
			exit( 'SKU信息错误' );
			
			

		$productDataList[] = $data;
	}

		//$orderIDS="0,".implode(",",$_POST['orderID']);
		$orderIDS=$_POST['orderID'];



	$data = array();
	$data['supplier_id'] = intval( $_POST['supplier'] );
	$data['warehouse_id'] = intval( $_POST['warehouse_id'] );
	$data['comment'] = trim( $_POST['comment'] );
	$data['user_id'] = $__UserAuth['user_id'];
	$data['user_name'] = $__UserAuth['user_name'];
	$data['add_time'] = time();
	$data['type'] = $type;
	$data['status'] = 0;
	$data['workflow_status'] = -1;
	$data['receive_status'] = 1;
	$data['into_status'] = 1;
	$data['product_type'] = $_POST['product_type'];
	$data['payment_type'] = $paymentType;
	$data['invoice_type'] = $invoiceType;
	
	$data['total_cost'] = $My_total_cost;
	$data['all_money'] = $My_all_money;
	
	if($_POST['plan_arrive_time'])
	    $plan_arrive_time = strtotime( $_POST['plan_arrive_time'] );
	else
	    $plan_arrive_time = time();
		
	$data['plan_arrive_time'] = $plan_arrive_time;

	$CenterPurchaseModel->Model->DB->Begin();

	$purchaseId = $CenterPurchaseModel->Add( $data );

	foreach ( $productDataList as $val )
	{
		$val['purchase_id'] = $purchaseId;
		$purchaseProductId = $CenterPurchaseModel->AddProduct( $val );

		// 按需采购的处理
		if ( $type == 2 )
		{
			$orderProductList = $CenterPurchaseExtra->AllotOrderProduct0717( $val['sku_id'], $val['quantity'],$orderIDS );
			foreach ( $orderProductList as $v )
			{
				$appendNum = $v['_num'];

				if ( !$appendNum )
					continue;

				$d = array();
				$d['quantity'] = $appendNum;
				$d['purchase_id'] = $purchaseId;
				$d['purchase_product_id'] = $purchaseProductId;
				$d['order_id'] = $v['order_id'];
				$d['order_product_id'] = $v['id'];
				$d['sale_price'] = $v['sale_price'];
				$d['add_time'] = time();

				$CenterPurchaseModel->AddRelation( $d );
				$CenterOrderModel->UpdateProduct( $v['id'], false, "purchase_quantity = purchase_quantity + " . $appendNum );
			}
		}
	}

	if ( $type == 2 )
	{
		$CenterPurchaseModel->DelLockByUser( $__UserAuth['user_id'] );
	}

	$CenterPurchaseModel->Model->DB->Commit();
	$CenterPurchaseModel->StatTotal( $purchaseId );

	$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );

	Core::LoadClass( 'WorkFlow' );
	$WorkFlow = new WorkFlow( 'Purchase' );
	$WorkFlow->SetInfo( $purchaseInfo );
	$WorkFlow->NextFlow();


		$data = array();
		$data['pay_status'] = -1;
		$data['status'] = 3;
		$data['pay_lock_time'] = time();
		$data['pay_lock_user_id'] = 66;
		$data['pay_lock_user_name'] = 'a';
		$CenterPurchaseModel->Update($purchaseId , $data );




		$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );
		if($purchaseInfo['warehouse_id'] == 5)
		{
			$Purchase_order = $CenterPurchaseModel->GetPurchaseListByOrder( $purchaseId );	
			foreach ( $Purchase_order as $val_order )
			{
				$CenterOrderModel->Model->DB->Begin();
				$CenterOrderModel->Update( $val_order['order_id'], array( 'warehouse_id' => 5 ) );
				$CenterOrderModel->Model->DB->Commit();
			}
		}




global $__UserAuth;

if($__UserAuth['user_group'] > 13 )
   {
	Core::LoadClass( 'WorkFlow' );

	$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );
	$WorkFlow = new WorkFlow( 'Purchase' );
	$WorkFlow->SetInfo( $purchaseInfo );
	$WorkFlow->NextFlow();
	}




	echo '200';

?>