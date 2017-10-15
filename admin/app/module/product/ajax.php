<?php
/*
@@acc_free
*/
$ProductModel = Core::ImportModel( 'Product' );

if ( $_GET['type'] == 'get' )
{

	$productId = (int)$_GET['id'];

	$productInfo = $ProductModel->Get( $productId );
	$productDescriptionInfo = $ProductModel->GetDescription( $productId );

	$code = '200';

	if ( !$productInfo )
		$code = '404';

	//if ( !$productInfo['is_on_sale'] )
	//	$code = '503';

	echo PHP2JSON( array( 'code' => $code, 'product' => @array_merge( $productInfo, $productDescriptionInfo ) ) );
}

if ( $_GET['type'] == 'price_modify' )
{

	$productId = (int)$_POST['id'];

	$productInfo = $ProductModel->Get( $productId );
	
	$data = array();
	$data['price'] = $_POST['price'];
	$ProductModel->Update( $productId, $data );
	$ProductModel->UpdateIndexByProduct( $productId, $data );

	echo PHP2JSON( array( 'code' => 200 ) );
}
?>