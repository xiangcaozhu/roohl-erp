<?php
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

global $__UserAuth;

		$purchaseId = (int)$_GET['id'];
		
		
		$PurchaseInfo = $CenterPurchaseModel->Get($purchaseId );
		$paymenttype = $PurchaseInfo['payment_type'];
		
		if($paymenttype==1)
		{
		}
		else
		{
		}
		
		
		$pay_status = (int)$_GET['pay_status'];
		$data['pay_status'] = $pay_status;
		
		
		if($pay_status==-1)
		{
		$data['pay_lock_time'] = time();
		$data['pay_lock_user_id'] = $__UserAuth['user_id'];
		$data['pay_lock_user_name'] = $__UserAuth['user_real_name'];
		}
		else
		{
		$data['pay_time'] = time();
		$data['pay_user_id'] = $__UserAuth['user_id'];
		$data['pay_user_name'] = $__UserAuth['user_real_name'];
		}

		$CenterPurchaseModel->Update($purchaseId , $data );


header( "refresh:0;url=?mod=purchase.check" );
?>