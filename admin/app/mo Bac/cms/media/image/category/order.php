<?php

/*
@@acc_title="调整排序"

*/

$siteId = intval( $_GET['site'] );

$CmsImageCategoryModel = Core::ImportModel( 'CmsImageCategory' );
$CmsImageCategoryModel->SetSiteId( $siteId );

$pid = (int)$_GET['pid'];
$cid = (int)$_GET['cid'];
$nid = (int)$_GET['next_cid'];

$siteId = intval( $_GET['site'] );

$CmsImageCategoryModel->PositionMove( $pid, $cid, $nid );

echo PHP2JSON( array( 'code' => 200 ) );
exit();

?>