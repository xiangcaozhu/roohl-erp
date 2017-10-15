<?php

$CenterProductModel = Core::ImportModel( 'CenterProduct' );

$productId = trim( $_GET['id'] );

$info = $CenterProductModel->Get( $productId );

echo $_GET['callback'] . '(' . PHP2JSON( array( 'product' => $info ) ) . ')';

exit();

?>