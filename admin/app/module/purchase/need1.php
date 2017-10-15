<?php
/*
@@acc_title="按需采购 need"
*/
if((int)$_GET['APAP']>0){
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$html = "";



									
	$supplierId = $_GET['supplierId'];
	$sku_id = $_GET['sku_id'];
	$sks = "one_".$sku_id."_".$supplierId;
	$tmp = $CenterOrderModel->GetSupplierNeedProductList( $sku_id,$supplierId );

	foreach ( $tmp as $k => $v )
	{
		$channelName = $CenterOrderModel->GetChannelName( $v['channelID'] );
		$html .= '<table cellspacing="0" class="data" id="grid_table" style="margin-bottom:15px;"><thead><tr class="header"><th width="60"><div align="center">订单号</div></th><th width="40"><div align="center">需求</div></th><th width="40"><div align="center">售价</div></th><th width="60"><div align="center">银行</div></th></tr></thead><tbody><tr>';
		$html .= '<td align="center">'.$v['order_id'].'</td><td align="center">'.$v['quantity'].'</td><td align="center">'.$v['price'].'</td><td align="center">'.$channelName.'</td></tr>';
		if($v['orderComment']!="" && $v['orderComment']!="|"){
		$html .= '<tr><td colspan="4">客户：'.$v['orderComment'].'</td></tr>';
		}

		if($v['purchaseCheck']!=""){
		$html .= '<tr><td colspan="4">产品部：'.$v['purchaseCheck'].'</td></tr>';
		}
		if($v['serviceCheck']!=""){
		$html .= '<tr><td colspan="4">客服部：'.$v['serviceCheck'].'</td></tr>';
		}
		$html .= '</tbody></table>';

	}
echo "<script>parent.flushaa('".$html."','".$sks."');</script>";

exit();
}else{
}
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$ActionLogModel = Core::ImportModel( 'ActionLog' );

Core::LoadDom( 'CenterSku' );



$need_supplierList = $CenterOrderModel->GetNeedList_supplier();

$tpl['My_supplier'] = 0;

$needList_All = array();

$tpl['S_supplier'] = 0;




foreach ( $need_supplierList as $key_a => $val_a ){
//$supplierName  = $CenterSupplierModel->Get( (int)$val_a['supplierId'] );
$need_supplierList[$key_a]['supplierName'] = $val_a['manageName'] .' → '. $val_a['supplierName'];




	$need_supplierList[$key_a]['is_my'] = 1;
	$temp_group = $__UserAuth['user_group'];
    if( ($temp_group!=38) && ($temp_group!=14) && ($temp_group!=15) )
    {
	
	$t_user = (int)$__UserAuth['user_id'];
	if($temp_group==12){$t_user = $CenterSupplierModel->GetMyJl((int)$__UserAuth['user_id']);}
	
    if($t_user != (int)$val_a['manageID'] )
	$need_supplierList[$key_a]['is_my'] = 0;
	}

if ( $_GET['S_supplier']==$val_a['supplierId'] ){//////////////////////////////aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa

$S_supplier = $_GET['S_supplier'];
$tpl['S_supplier'] = $_GET['S_supplier'];


$lockList = $CenterPurchaseModel->GetAllLockList($val_a['supplierId']);
$needList = $CenterOrderModel->GetNeedList_one1110($val_a['supplierId'] );

echo count($needList);
TestArray($needList);

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

	$needList[$key]['sku_info'] = $skuInfo;
	
	
	
	
	
	$needList[$key]['onroad_quantity'] = (int)$CenterPurchaseModel->GetOnRoadNum( $val['sku_id'] );
	$stockInfo = $CenterWarehouseStockModel->GetLiveQuantityBySkuId( $val['sku_id'] );

	$needList[$key]['warehouse_quantity'] = (int)$stockInfo['quantity'];
	$needList[$key]['warehouse_lock_quantity'] = (int)$stockInfo['lock_quantity'];
	$needList[$key]['warehouse_live_quantity'] = (int)$stockInfo['live_quantity'];


	$needList[$key]['isnew'] = $my_isnew;
	$needList[$key]['supplierId'] = $val_a['supplierId'];
}


}//////////////////////////////aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa


$need_supplierList[$key_a]['needList'] = $needList;

}


$tpl['need_supplier'] = $need_supplierList;

Common::PageOut( 'purchase/new/need.html', $tpl );


?>