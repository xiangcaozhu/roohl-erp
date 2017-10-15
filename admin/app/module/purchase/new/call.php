<?php
$AdminModel = Core::ImportModel( 'Admin' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
        
		global $__UserAuth;
		$adminInfo = $AdminModel->GetAdministrator( $__UserAuth['user_id'] );
		$groupId = $adminInfo['user_group'];
/*
$CenterWorkflowModel = Core::ImportModel( 'CenterWorkflow' );
		$data = array();
		$data['flow_name'] = 'Purchase';
		$data['flow_status'] = 9;
		$data['target_id'] = (int)$_GET['id'];
		$data['user_id'] = 0;
		$data['group_id'] = $groupId;
		$data['add_user_id'] = $__UserAuth['user_id'];
		$data['add_time'] = time();
		$data['is_delete'] = 0;
		$data['comment'] = $_POST['comment'];

		$CenterWorkflowModel->Add( $data );
*/

		$toFlow = array();
		//$toFlow['workflow_status'] = 9;
		$toFlow['close_user'] = $__UserAuth['user_id'];
		$toFlow['close_name'] = $__UserAuth['user_real_name'];
		$toFlow['close_group'] = $groupId;
		$toFlow['close_comment'] = $_POST['comment'];
		$CenterPurchaseModel->Update( (int)$_GET['id'], $toFlow );

/*
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$orderId = (int)$_GET['id'];

$orderInfo = $CenterOrderModel->Get( $orderId );

if ( !$orderInfo )
	Alert( '没有找到指定的订单' );


$data = array();
$data['call_status'] = 1;
$data['call_timer'] = $orderInfo['call_timer'] + 1;

$CenterOrderModel->Update( $orderId, $data );

$ActionLogModel = Core::ImportModel( 'ActionLog' );

$data = array();
$data['user_id'] = $__UserAuth['user_id'];
$data['user_name'] = $__UserAuth['user_name'];
$data['comment'] = $_POST['comment'];
$data['action'] = 'order_call_service' ;
$data['type'] = 0;
$data['add_time'] = time();
$data['target_id'] = $orderId;

$ActionLogModel->Add( $data );

Common::Loading();
*/

header( "refresh:0;url=?mod=purchase.check" );
?>