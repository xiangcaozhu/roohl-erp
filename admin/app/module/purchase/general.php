<?php
/*
@@acc_title="常规采购 general"
*/
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );

if ( (int)$_GET['supplier'] == 0  )
{

if( $__UserAuth['user_group']==38 || $__UserAuth['user_group']==15 )
{
$search = array();
}
elseif($__UserAuth['user_group']==14)
{
$search = array('manage_zj' => $__UserAuth['user_id'],);
}
else
{
$search = array('manage_id' => $__UserAuth['user_id'],);
}

$search = array();



$tpl['Supplier_list']  = $CenterSupplierModel->GetList( $search, $offset, $onePage );
Common::PageOut( 'purchase/new/form_s.html', $tpl );


}
else
{



$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );



Core::LoadDom( 'CenterSku' );

if ( !$_POST )
{
	$tpl['type'] = 'new';
	$tpl['payment_type_list'] = Core::GetConfig( 'purchase_payment_type' );

	$warehouseList = $CenterWarehouseModel->GetList(0, 0, 1);
	$tpl['warehouse_list'] = $warehouseList;
	$tpl['supplierId'] = (int)$_GET['supplier'];
	$supplierName  = $CenterSupplierModel->Get( (int)$_GET['supplier'] );
	$tpl['supplierName'] = $supplierName['name'];

	Common::PageOut( 'purchase/new/formA.html', $tpl );
}
else
{
	$type = (int)$_POST['type'];
	$productType = (int)$_POST['product_type'];
	$paymentType = (int)$_POST['payment_type'];
	$invoiceType = (int)$_POST['invoice_type'];
	$warehouseId = (int)$_POST['warehouse_id'];
	$supplierId = (int)$_POST['supplier'];



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

	if ( count( $_POST['sku'] ) == 0 )
		exit( '请录入产品' );


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
		$data['history_price'] = $CenterPurchaseModel->GetProductHistoryPrice( $sku );
		$data['comment'] = trim( $_POST['row_comment'][$key] );
		$data['add_time'] = time();
		$data['manager_user_id'] = $skuInfo['product']['manager_user_id'];
		$data['manager_user_name'] = $skuInfo['product']['manager_user_name'];
		$data['manager_user_real_name'] = $skuInfo['product']['manager_user_real_name'];

		if ( $data['quantity'] <= 0 )
			exit( '数量必须大于零' );
		//if ( $data['price'] == 0 )
		//	exit( '采购价不能为0' );
		if ( !$data['sku'] || !$data['sku_id'] )
			exit( 'SKU信息错误' );

		$productDataList[] = $data;
	}



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
	$data['plan_arrive_time'] = strtotime( $_POST['plan_arrive_time'] );

	$CenterPurchaseModel->Model->DB->Begin();

	$purchaseId = $CenterPurchaseModel->Add( $data );

	foreach ( $productDataList as $val )
	{
		$val['purchase_id'] = $purchaseId;
		$purchaseProductId = $CenterPurchaseModel->AddProduct( $val );

		// 按需采购的处理
		if ( $type == 2 )
		{
			$orderProductList = $CenterPurchaseExtra->AllotOrderProduct( $val['sku_id'], $val['quantity'] );
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

	/******** workflow ********/
	$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );

	Core::LoadClass( 'WorkFlow' );
	$WorkFlow = new WorkFlow( 'Purchase' );
	$WorkFlow->SetInfo( $purchaseInfo );
	$WorkFlow->NextFlow();

	echo '200';
}
}
?>