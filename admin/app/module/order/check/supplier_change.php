<?php
/*
@@acc_freet
*/
$CenterProductModel = Core::ImportModel( 'CenterProduct' );

$productId = (int)$_GET['p_id'];
$supplierId = (int)$_GET['supplier_id'];

	$data = array();
	$data['supplier_now'] = $supplierId;
	$CenterProductModel->Update( $productId, $data );

echo '200';
?>