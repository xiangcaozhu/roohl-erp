<?php

$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$purchaseId = (int)$_GET['purchase_id'];
$purchaseInfo = $CenterPurchaseModel->Get( $purchaseId );

if ( !$purchaseInfo )
	Alert( '没有找到对应的采购单' );

$newtime = time();
$CenterPurchaseModel->Model->DB->Begin();

$CenterPurchaseModel->Update( $purchaseId, array(
	'pay_status' => 1,
	//'pay_invoice' => $_POST['pay_invoice'],
	'pay_time' => $newtime,
	'pay_user_id' => $_GET['pay_user_id'],
	'pay_user_name' => $_GET['pay_user_name'],
	//'pay_invoice_time' => strtotime( $_POST['pay_invoice_time'] ),
) );

$CenterPurchaseModel->Model->DB->Commit();

echo '<div style="margin:0px auto;width:98%"><span style="color:green;float:left;">已付款</span><span style="float:right;">'.$_GET['pay_user_name'].'</span></div><br><div style="margin:0px auto;width:98%"><small>'.date('y-m-d G:i', $newtime ).'</small></div>';
//$CenterPurchaseModel->StatTotal( $purchaseId );

//Common::Loading();
?> 