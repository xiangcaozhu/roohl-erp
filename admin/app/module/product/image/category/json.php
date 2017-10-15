<?php

$ShopImageCategoryModel = Core::ImportModel( 'ShopImageCategory' );

$extTree = $ShopImageCategoryModel->GetExtTree();

echo PHP2JSON( $extTree );

exit();

?>