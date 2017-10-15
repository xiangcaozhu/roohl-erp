<?php
/*
@@acc_free
*/
$CategoryModel = Core::ImportModel( 'Category' );
$ProductModel = Core::ImportModel( 'Product' );

if ( !$_POST )
{
	/******** product ********/
	$productId = (int)$_GET['id'];
	$productInfo = $ProductModel->Get( $productId );

	if ( !$productInfo )
		Common::Error( '请选择需要操作的商品' );

	/******** product ********/
	$data = array();
	$data['is_on_sale'] = $_GET['type'] == 'up' ? 1 : 0;

	$ProductModel->Update( $productId, $data );

	$data = array();
	$data['is_on_sale'] = $_GET['type'] == 'up' ? 1 : 0;

	$ProductModel->UpdateIndexByProduct( $productId, $data );
}
else
{
	if ( $_POST['pid'] )
	{
		foreach ( $_POST['pid'] as $productId )
		{
			$data = array();
			$data['is_on_sale'] = $_GET['type'] == 'up' ? 1 : 0;

			$ProductModel->Update( $productId, $data );

			$data = array();
			$data['is_on_sale'] = $_GET['type'] == 'up' ? 1 : 0;

			$ProductModel->UpdateIndexByProduct( $productId, $data );
		}
	}
}

Redirect();

?>