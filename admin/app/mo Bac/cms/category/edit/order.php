<?php

/*
@@acc_title="调整排序"

*/

Core::LoadExtra( 'CmsCategory' );
$CmsCategoryExtra = new CmsCategoryExtra();

$pid = (int)$_GET['pid'];
$cid = (int)$_GET['cid'];
$nid = (int)$_GET['next_cid'];

$CmsCategoryExtra->PositionMove( $pid, $cid, $nid );

echo PHP2JSON( array( 'code' => 200 ) );
exit();

?>