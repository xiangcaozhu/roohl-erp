<?php
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
global $__UserAuth;

		$purchaseId = (int)$_GET['id'];
		
		
		$data['status'] = 3;

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

header( "refresh:0;url=?mod=purchase.check" );

//header( "refresh:0;url=?mod=purchase.new.purchase&id=". $purchaseId ."" );
?>