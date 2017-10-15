<?php

/*
@@acc_title="调整排序"

*/

$CenterCategoryExtra = Core::ImportExtra( 'CenterCategory' );

$pid = (int)$_GET['pid'];
$cid = (int)$_GET['cid'];
$nid = (int)$_GET['next_cid'];

$CenterCategoryExtra->PositionMove( $pid, $cid, $nid );

echo PHP2JSON( array( 'code' => 200 ) );
exit();

?>