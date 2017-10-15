<?php


$CmsBlockCategoryModel = Core::ImportModel( 'CmsBlockCategory' );

$extTree = $CmsBlockCategoryModel->GetExtTree();

echo PHP2JSON( $extTree );

exit();

?>