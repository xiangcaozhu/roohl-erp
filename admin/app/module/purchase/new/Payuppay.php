<?php
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

global $__UserAuth;

		
$purchaseList = explode(',',$_GET['purchase_list_Id']) ;
foreach ( $purchaseList as $key_list => $val_list )
{
		
		
		//$purchaseId = (int)$_GET['id'];
		$purchaseId = (int)$val_list;
		
		
		//$PurchaseInfo = $CenterPurchaseModel->Get($purchaseId );
		//$paymenttype = $PurchaseInfo['payment_type'];
		
		//if($paymenttype==1)
	//	{
	//	}
	//	else
	//	{
	//	}
		
		
		$data = array();
		//$pay_status = (int)$_GET['pay_status'];
		//$data['pay_status'] = $pay_status;
		$data['pay_status'] = 1;
		
		
		//if($pay_status==-1)
		//{
		//$data['pay_lock_time'] = time();
		//$data['pay_lock_user_id'] = $__UserAuth['user_id'];
		//$data['pay_lock_user_name'] = $__UserAuth['user_real_name'];
		//}
		//else
		//{
		$data['pay_time'] = time();
		$data['pay_user_id'] = $__UserAuth['user_id'];
		$data['pay_user_name'] = $__UserAuth['user_real_name'];
		//}

		$CenterPurchaseModel->Update($purchaseId , $data );
}

$PayId=(int)$_GET['id'];
$dataPay = array();
$dataPay['pay_time'] = time();
$dataPay['status'] = 2;
$CenterPurchaseModel->UpdatePay($PayId , $dataPay );


header( "refresh:0;url=?mod=purchase.paylist&status=".(int)$_GET['status']."" );
?>