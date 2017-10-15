<?php

/*
@@acc_title="调整排序"

*/

$CmsChannelExtra = Core::ImportExtra( 'CmsChannel' );

$pid = (int)$_GET['pid'];
$cid = (int)$_GET['cid'];
$nid = (int)$_GET['next_cid'];

$siteId = intval( $_GET['site'] );

$CmsChannelExtra->PositionMove( $siteId, $pid, $cid, $nid );

echo PHP2JSON( array( 'code' => 200 ) );
exit();

?>