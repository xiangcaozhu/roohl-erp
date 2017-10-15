<?php
/*
@@acc_title="修改采购单 edit"
*/
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

$purchaseId = (int)$_GET['id'];

$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );

if ( !$purchaseInfo )
	Alert( '没有找到采购单' );

$purchaseProductList = $CenterPurchaseModel->GetProductList( $purchaseId );
$purchaseProductList = $CenterPurchaseExtra->ExplainProduct( $purchaseProductList );

if ( !$_POST )
{
	$supplierInfo = $CenterSupplierModel->Get( $purchaseInfo['supplier_id'] );
	$purchaseInfo['supplier_name'] = $supplierInfo['name'];

	$tpl['list'] = $purchaseProductList;
	$tpl['info'] = $purchaseInfo;

	$warehouseList = $CenterWarehouseModel->GetList();
	$tpl['warehouse_list'] = $warehouseList;
	$purchaseTypeList = Core::GetConfig( 'purchase_type' );
	$tpl['info']['type_name'] = $purchaseTypeList[$purchaseInfo['type']];
	$tpl['payment_type_list'] = Core::GetConfig( 'purchase_payment_type' );


	Common::PageOut( 'purchase/edit.html', $tpl );
}
else
{
	foreach ( $purchaseProductList as $val )
	{
		$price = floatval( $_POST['price'][$val['id']] );
		$quantity = intval( $_POST['quantity'][$val['id']] );
		$comment = $_POST['row_comment'][$val['id']];

		if ( $quantity <= 0 )
			exit( '产品行采购数量不能为0' );

		if ( $quantity < $val['receive_quantity'] )
			exit( '产品行采购数量不能小于已收货数量' );
	}

	$CenterPurchaseModel->Model->DB->Begin();

$My_total_money = 0;
$My_all_money = 0;
	
	foreach ( $purchaseProductList as $val )
	{
		$price = floatval( $_POST['price'][$val['id']] );
		$quantity = intval( $_POST['quantity'][$val['id']] );
		$comment = $_POST['row_comment'][$val['id']];

		$relationList = $val['relation_list'] ? $val['relation_list'] : array();
		$purchaseProductId = $val['id'];

		if ( $purchaseInfo['type'] == 2 )
		{
			// 采购数量增加
			if ( $quantity > $val['quantity'] )
			{
				$overNum = $quantity - $val['quantity']; // 增加的总数

				$orderProductList = $CenterPurchaseExtra->AllotOrderProduct( $val['sku_id'], $overNum );

				foreach ( $orderProductList as $v )
				{
					$appendNum = $v['_num'];

					if ( !$appendNum )
						continue;

					if ( $relInfo = $CenterPurchaseModel->GetRelationUnique( $purchaseProductId, $v['id'] ) )
					{
						$CenterPurchaseModel->UpdateRelation( $relInfo['id'], false, "quantity = quantity + {$appendNum}" );
					}
					else
					{
						$d = array();
						$d['quantity'] = $appendNum;
						$d['purchase_id'] = $purchaseId;
						$d['purchase_product_id'] = $purchaseProductId;
						$d['order_id'] = $v['order_id'];
						$d['order_product_id'] = $v['id'];
						$d['add_time'] = time();

						$CenterPurchaseModel->AddRelation( $d );
					}

					$CenterOrderModel->UpdateProduct( $v['id'], false, "purchase_quantity = purchase_quantity + " . $appendNum );
				}
			}
			
			// 采购数量减少
			elseif ( $quantity < $val['quantity'] )
			{
				$lostNum = $val['quantity'] - $quantity; // 减少的总数

				$relationList = array_reverse( $relationList );

				foreach ( $relationList as $v )
				{
					if ( $lostNum == 0 )
						break;

					if ( $lostNum > $v['quantity'] )
						$reduceNum = $v['quantity'];
					else
						$reduceNum = $lostNum;

					if ( !$reduceNum )
						break;

					$lostNum = $lostNum - $reduceNum;

					if ( $relInfo = $CenterPurchaseModel->GetRelationUnique( $v['purchase_product_id'], $v['order_product_id'] ) )
					{					
						if ( $v['quantity'] == $reduceNum )
						{
							$CenterPurchaseModel->DelRelation( $relInfo['id'] );
						}
						else
						{
							$CenterPurchaseModel->UpdateRelation( $relInfo['id'], false, "quantity = quantity - {$reduceNum}" );
						}

						$CenterOrderModel->UpdateProduct( $v['order_product_id'], false, "purchase_quantity = purchase_quantity - " . $reduceNum );
					}
				}

			}
		}

		$data = array();
		$data['price'] = $price;
		$data['quantity'] = $quantity;
		$data['comment'] = $comment;
		
		$data['help_cost'] = floatval( $_POST['help_cost'][$val['id']] );
		$mn_1 = $_POST['quantity'][$val['id']] * $_POST['price'][$val['id']];
		$mn_2 = $_POST['quantity'][$val['id']] * $_POST['help_cost'][$val['id']];
		$mn_3 = $mn_1 + $mn_2 ;
		$data['total_money'] = floatval($mn_1  );
		$data['total_cost'] = floatval( $mn_2 );
		$data['all_money'] = floatval( $mn_3 );
		
		$My_total_cost = $My_total_cost + $mn_2;
        $My_all_money =  $My_all_money + $mn_3;




		$CenterPurchaseModel->UpdateProduct( $purchaseProductId, $data );
	}

	$CenterPurchaseModel->Model->DB->Commit();
	$CenterPurchaseModel->StatTotal( $purchaseId );

	$data = array();
	$data['comment'] = $_POST['comment'];
	$data['warehouse_id'] = $_POST['warehouse_id'];
	$data['plan_arrive_time'] = strtotime( $_POST['plan_arrive_time'] );
	$data['payment_type'] = $_POST['payment_type'];
	
	$data['total_cost'] = $My_total_cost;
	$data['all_money'] = $My_all_money;


	if ( $_POST['supplier'] )
		$data['supplier_id'] = $_POST['supplier'];
		
	$data['close_group'] = -1;
	
	$data['sign_pro_mg'] = 0;
	$data['sign_ope_mj'] = 0;
	$data['sign_ope_vc'] = 0;
	$data['pay_status'] = 0;
	$data['is_edit'] = 1;
	
	

/*

global $__Config;
global $__UserAuth;

$AdminModel = Core::ImportModel( 'Admin' );
$adminInfo = $AdminModel->GetAdministrator( $__UserAuth['user_id'] );
$groupId = $adminInfo['user_group'];

$Ptotal_money = $CenterPurchaseModel->Get( $purchaseId );


//需要经理审核
$data['sign_pro_mg'] = -1;


//需要总监审核
if ( $Ptotal_money['total_money'] >= $__Config['purchase_money'][0] )
$data['sign_ope_mj'] = -1;
else
$data['sign_ope_mj'] = 0;
				
if( $groupId == 14 )
$data['sign_ope_mj'] = -1;
				
//需要副总审核
if ( $Ptotal_money['total_money'] >= $__Config['purchase_money'][1] )
$data['sign_ope_vc'] = -1;
else
$data['sign_ope_vc'] = 0;


if( $this->groupId == 15 )
{
$data['sign_ope_vc'] = -1;
$data['sign_ope_mj'] = 0;
}

*/


	$CenterPurchaseModel->Update( $purchaseId, $data );

	// 更新采购单的收货状态
	$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );
	Core::LoadDom( 'CenterPurchase' );
	$CenterPurchaseDom = new CenterPurchaseDom( $purchaseInfo );
	$CenterPurchaseDom->UpdateStatus();

	echo 200;
}
?>