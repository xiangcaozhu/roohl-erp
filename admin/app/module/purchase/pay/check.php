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
	//'pay_status' => $_POST['pay_status'],
	'pay_invoice' => 1,
	//'pay_time' => strtotime( $_POST['pay_time'] ),
	'pay_invoice_time' => $newtime,
	'pay_invoice_user_id' => $_GET['pay_invoice_user_id'],
	'pay_invoice_user_name' => $_GET['pay_invoice_user_name'],
	'pay_invoice_order' => $_GET['pay_invoice_order'],

) );

$CenterPurchaseModel->Model->DB->Commit();

echo '<div style="margin:0px auto;width:98%"><span style="color:green;float:left;">有发票</span><span style="float:right;">'.$_GET['pay_invoice_order'].'</span></div><br /><div style="margin:0px auto;width:98%"><span style="float:left;">'.$_GET['pay_invoice_user_name'].'</span><span style="float:right;"><small>'.date('y-m-d G:i', $newtime ).'</small></span></div>';





//$CenterPurchaseModel->StatTotal( $purchaseId );

//Common::Loading();
?>