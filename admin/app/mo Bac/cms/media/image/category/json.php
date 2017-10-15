<?php

include( Core::Block( 'cms.site' ) );

$CmsImageCategoryModel = Core::ImportModel( 'CmsImageCategory' );
$CmsImageCategoryModel->SetSiteId( $siteId );

$extTree = $CmsImageCategoryModel->GetExtTree();

echo PHP2JSON( $extTree );

exit();

?>