<?php
/*
@@acc_free
*/
$ProductModel = Core::ImportModel( 'Product' );
$ProductExtra = Core::ImportExtra( 'Product' );

$productId = (int)$_GET['pid'];

$info = $ProductModel->Get( $productId );
$info = $ProductExtra->ExplainOne( $info );

echo PHP2JSON( $info );

exit();

?>