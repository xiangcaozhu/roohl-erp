<?php
/*
@@acc_title="删除商品 dellgood"
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

*/
Core::LoadDom( 'CenterOrder' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );


//&orderID={rowp.id}&purchaseID={val.id}&productID={Productval.product_id}&productSku={Productval.sku}
	$orderID = (int)$_GET['orderID'];
	$purchaseID = (int)$_GET['purchaseID'];
	$productID = (int)$_GET['productID'];
	$productSku = $_GET['productSku'];
	$relationID = (int)$_GET['relationID'];
	$purchasePID = (int)$_GET['purchasePID'];
	$supplierID = (int)$_GET['supplierID'];
	


	$purchaseInfo = $CenterPurchaseModel -> Get( $purchaseID );
	$purchaseRelationInfo = $CenterPurchaseModel -> GetRelationInfo( $relationID );
	$purchaseProductInfo = $CenterPurchaseModel -> GetProduct( $purchasePID );
    
	//print_r($purchaseInfo);
	//echo '<hr>';
	//print_r($purchaseProductInfo);
	//echo '<hr>';
	//print_r($purchaseRelationInfo);
	//echo '<hr>';
	//echo $purchaseRelationInfo['quantity'].'==='.$purchaseProductInfo['quantity'];
	if(($purchaseRelationInfo['quantity']>0)&&($purchaseProductInfo['quantity']>0)&&($purchaseRelationInfo['quantity']==$purchaseProductInfo['quantity']))
	{
	$CenterPurchaseModel->DelProduct( $purchasePID );	
	}
	else
	{
		$data = array();
		$data['quantity'] = $purchaseProductInfo['quantity']-$purchaseRelationInfo['quantity'];
		$data['receive_quantity'] = $purchaseProductInfo['receive_quantity']-$purchaseRelationInfo['into_quantity'];
		$data['into_quantity'] = $purchaseProductInfo['into_quantity']-$purchaseRelationInfo['into_quantity'];
		$tmp_total_cost = ($purchaseProductInfo['quantity']-$purchaseRelationInfo['quantity'])*$purchaseProductInfo['help_cost'];
		$data['total_cost'] = $tmp_total_cost;
		$tmp_total_money = ($purchaseProductInfo['quantity']-$purchaseRelationInfo['quantity'])*$purchaseProductInfo['price'];
		$data['total_money'] = $tmp_total_money;
		$data['all_money'] = $tmp_total_cost+$tmp_total_money ;
		$CenterPurchaseModel->UpdateProduct( $purchasePID,$data );
	}
	$CenterPurchaseModel->StatTotal( $purchaseID );
	
	$CenterPurchaseModel->DelRelation( $relationID );
	
	




	
	//print_r($purchaseProductInfo);
	
	
	
	
	
	$orderInfo = $CenterOrderModel -> Get( $orderID );
	
$CenterOrderModel->UpdateProduct( $purchaseRelationInfo['order_product_id'], false, "purchase_quantity = purchase_quantity - " . $purchaseRelationInfo['quantity'] );
if($purchaseRelationInfo['lock_quantity']>0 && $orderInfo['warehouse_id']==5 )
{
$CenterOrderModel->UpdateProduct( $purchaseRelationInfo['order_product_id'], false, "lock_quantity = lock_quantity - " . $purchaseRelationInfo['quantity'] );
$CenterOrderModel->UpdateProduct( $purchaseRelationInfo['order_product_id'], false, "into_quantity = into_quantity - " . $purchaseRelationInfo['quantity'] );
$CenterOrderModel->UpdateProduct( $purchaseRelationInfo['order_product_id'], false, "delivery_quantity = delivery_quantity - " . $purchaseRelationInfo['quantity'] );
}
	
	//更新定单的完成状态
	$OrderDom = new CenterOrderDom( $orderID );
	$OrderDom->UpdateStatus_del();		

	

header( "refresh:0;url=?mod=purchase.nopay_creat&supplierId=".$supplierID."" );


?>