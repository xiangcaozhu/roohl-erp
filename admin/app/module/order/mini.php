<?php
/*
@@acc_freet
@@acc_title="产品经理确认 purchase"



$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );
$ActionLogModel = Core::ImportModel( 'ActionLog' );
$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$channelList = $CenterChannelModel->GetList();
$warehouseList = $CenterWarehouseModel->GetList();
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
//list( $page, $offset, $onePage ) = Common::PageArg( 50 );

*/

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$search_purchase_check = array('purchase_check' => '0',);
$search_purchase_manage = 0;



$temp_group = $__UserAuth['user_group'];
    if( ($temp_group!=38) && ($temp_group!=14) && ($temp_group!=15) )
    {
	$search_purchase_check['manage_id'] = $__UserAuth['user_id'];
	$search_purchase_manage = $__UserAuth['user_id'];
	}




$purchase_check_total = $CenterOrderModel->GetTotal( $search_purchase_check );
$purchase_check_total = (int)$purchase_check_total;


$purchase_total = $CenterOrderModel->GetNeedList_supplier_Total($search_purchase_manage);
$purchase_total = (int)$purchase_total;







	$tpl['purchase_check_total'] = $purchase_check_total;
	$tpl['purchase_total'] = $purchase_total;



Common::PageOut( 'order/mini.html', $tpl, '','' );

?>