<?php

/*
@@acc_title="移动分类"

*/

$CmsChannelExtra = Core::ImportExtra( 'CmsChannel' );

$pid = (int)$_GET['pid'];
$cid = (int)$_GET['cid'];
$nid = (int)$_GET['next_cid'];

$siteId = intval( $_GET['site'] );

$CmsChannelExtra->PositionMove( $siteId, $pid, $cid, $nid, true );

// 调整了上级分类,需要"更新上级分类路径"字段
$CmsChannelModel = Core::ImportModel( 'CmsChannel' );
$CmsChannelModel->SetSiteId( $siteId );
$CmsChannelModel->BuildTree();
$CmsChannelModel->UpdateParentIdList();

echo PHP2JSON( array( 'code' => 200 ) );
exit();

?>