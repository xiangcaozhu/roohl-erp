<?php
/*
@@acc_free
*/
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

$sku = $_GET['sku'];
$skuId = $_GET['sku_id'];
$supplierId = $_GET['supplierId'];

if ( $_GET['type'] == 'add' )
{
	$lockInfo = $CenterPurchaseModel->GetLock( $skuId,$supplierId );

	if ( $lockInfo && $lockInfo['user_id'] != $__UserAuth['user_id'] )
		exit( '404' );
	if ( $lockInfo && $lockInfo['user_id'] == $__UserAuth['user_id'] )
		exit( '200' );

	$data = array();
	$data['add_time'] = time();
	$data['sku'] = $sku;
	$data['sku_id'] = $skuId;
	$data['supplierId'] = $supplierId;
	$data['user_id'] = $__UserAuth['user_id'];

	$CenterPurchaseModel->AddLock( $data );
	exit( '200' );
}
elseif ( $_GET['type'] == 'delete' )
{
	$lockInfo = $CenterPurchaseModel->GetLock( $skuId, $supplierId );

	if ( $lockInfo && $lockInfo['user_id'] != $__UserAuth['user_id'] )
		exit( '404' );

	$CenterPurchaseModel->DelLock( $skuId, $supplierId );
	exit( '200' );
}
elseif ( $_GET['type'] == 'get' )
{
	$list = $CenterPurchaseModel->GetLockList( $__UserAuth['user_id'] );

	Core::LoadDom( 'CenterSku' );
	foreach ( $list as $key => $val )
	{
		$CenterSkuDom = new CenterSkuDom( $val['sku'] );
		$skuInfo = $CenterSkuDom->InitProduct();

		$list[$key]['sku_info'] = $skuInfo;
	}

	echo PHP2JSON( $list );
	exit();
}

?>