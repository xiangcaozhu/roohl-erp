<?php
/*
@@acc_title="格兰仕独立采购 gls"
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );





$need_supplierList = $CenterOrderModel->GetNeedList_supplier();

$tpl['My_supplier'] = 0;

$needList_All = array();
foreach ( $need_supplierList as $key_a => $val_a )
{
$supplierName  = $CenterSupplierModel->Get( (int)$val_a['supplierId'] );
$need_supplierList[$key_a]['supplierName'] = $supplierName['manage_name'] .' → '. $supplierName['name'];




	$need_supplierList[$key_a]['is_my'] = 1;
	$temp_group = $__UserAuth['user_group'];
    if( ($temp_group!=38) && ($temp_group!=14) && ($temp_group!=15) )
    {
    if((int)$__UserAuth['user_id'] != (int)$supplierName['manage_id'] )
	$need_supplierList[$key_a]['is_my'] = 0;
	
	if((int)$val_a['supplierId']!=63 )
	$need_supplierList[$key_a]['is_my'] = 0;

	}



$lockList = $CenterPurchaseModel->GetAllLockList($val_a['supplierId']);
$needList = $CenterOrderModel->GetNeedList_one('',$val_a['supplierId'] );
foreach ( $needList as $key => $val )
{
    $my_isnew = 0;
	$CenterSkuDom = new CenterSkuDom( $val['sku'] );
	$skuInfo = $CenterSkuDom->InitProduct();

	if ( $lockList[$val['sku_id']] )
		{
		$needList[$key]['checked'] = true;
	$tpl['My_supplier'] = $val['supplier_id'];
		}
	else
		{
		$needList[$key]['checked'] = false;
		}

	
	if ( $lockList[$val['sku_id']] && $lockList[$val['sku_id']]['user_id'] != $__UserAuth['user_id'] )
		$needList[$key]['disabled'] = true;
	else
		$needList[$key]['disabled'] = false;

	$needList[$key]['onroad_quantity'] = (int)$CenterPurchaseModel->GetOnRoadNum( $val['sku_id'] );
	
	$stockInfo = $CenterWarehouseStockModel->GetLiveQuantityBySkuId( $val['sku_id'] );

	$needList[$key]['warehouse_quantity'] = (int)$stockInfo['quantity'];
	$needList[$key]['warehouse_lock_quantity'] = (int)$stockInfo['lock_quantity'];
	$needList[$key]['warehouse_live_quantity'] = (int)$stockInfo['live_quantity'];

	$needList[$key]['sku_info'] = $skuInfo;

	$tmp = $CenterOrderModel->GetNeedProductList( $val['sku_id'] );

	foreach ( $tmp as $k => $v )
	{
		$tmp[$k]['add_time'] = DateFormat( $v['add_time'] );
		
		if ( $tmp[$k]['manager_edit_user_id']>0 )
		{
		$my_isnew=1;
		$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $tmp[$k]['manager_edit_user_id'] );
	    $tmp[$k]['manager_edit_user_zh'] = $AdminArray['user_real_name'] ;
		}
	}

	$needList[$key]['list'] = $tmp;
	
	$needList[$key]['isnew'] = $my_isnew;
	$needList[$key]['supplierId'] = $val_a['supplierId'];
}

$need_supplierList[$key_a]['needList'] = $needList;

}
*/
Core::LoadDom( 'CenterSku' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

$needList = $CenterOrderModel->GetNeedList_gls();









foreach ( $needList as $key => $val )
{

	$CenterSkuDom = new CenterSkuDom( $val['sku'] );
	$skuInfo = $CenterSkuDom->InitProduct();
	$needList[$key]['sku_info'] = $skuInfo;


	$tmp = $CenterOrderModel->GetNeedProductList( $val['sku_id'] );
	$needList[$key]['list'] = $tmp;
	
	$channelInfo = $CenterChannelModel->Get( $val['channel_id'] );
    $needList[$key]['channel_name'] = $channelInfo['name'];

	
}



	$temp_group = $__UserAuth['user_group'];
    if( ($temp_group!=38) && ($temp_group!=14) && ($temp_group!=15) && ((int)$__UserAuth['user_id'] != 70 ))
    {
	$needList='';
	}


$tpl['need_list'] = $needList;

Common::PageOut( 'purchase/gls.html', $tpl );


?>