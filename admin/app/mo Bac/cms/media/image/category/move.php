<?php

/*
@@acc_title="移动分类"

*/

$siteId = intval( $_GET['site'] );

$CmsImageCategoryModel = Core::ImportModel( 'CmsImageCategory' );
$CmsImageCategoryModel->SetSiteId( $siteId );

$pid = (int)$_GET['pid'];
$cid = (int)$_GET['cid'];
$nid = (int)$_GET['next_cid'];

$CmsImageCategoryModel->PositionMove( $pid, $cid, $nid, true );

echo PHP2JSON( array( 'code' => 200 ) );
exit();

?>