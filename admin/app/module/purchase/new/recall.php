<?php
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

		$purchaseId = (int)$_GET['id'];
		
		$data['add_time'] = time();
		$data['workflow_status'] = -1;
		$data['close_user'] = 0;
		$data['close_name'] = '';
		$data['close_group'] = 0;
		$data['close_comment'] = '';
		$data['is_edit'] = 0;

		$CenterPurchaseModel->Update($purchaseId , $data );



	/******** workflow ********/
	$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );

	Core::LoadClass( 'WorkFlow' );
	$WorkFlow = new WorkFlow( 'Purchase' );
	$WorkFlow->SetInfo( $purchaseInfo );
	$WorkFlow->NextFlow();


global $__UserAuth;

if($__UserAuth['user_group'] > 13 )
   {
	$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );

	Core::LoadClass( 'WorkFlow' );
	$WorkFlow = new WorkFlow( 'Purchase' );
	$WorkFlow->SetInfo( $purchaseInfo );
	$WorkFlow->NextFlow();
	}


header( "refresh:0;url=?mod=purchase.check" );
?>