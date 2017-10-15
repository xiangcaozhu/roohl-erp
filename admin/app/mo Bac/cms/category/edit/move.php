<?php

/*
@@acc_title="移动分类"

*/

$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );

$CmsCategoryModel->BuildTree();

$CmsCategoryExtra = Core::ImportExtra( 'CmsCategory' );

$pid = (int)$_GET['pid'];
$cid = (int)$_GET['cid'];
$nid = (int)$_GET['next_cid'];

$CmsCategoryExtra->PositionMove( $pid, $cid, $nid, true );
$CmsCategoryModel->UpdateParentIdList();

echo PHP2JSON( array( 'code' => 200 ) );
exit();

?>