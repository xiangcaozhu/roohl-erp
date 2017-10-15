<?php

$CmsProductModel = Core::ImportModel( 'CmsProduct' );

$productId = (int)$_GET['pid'];

$info = $CmsProductModel->Get( $productId );

echo PHP2JSON( $info );

exit();

?>