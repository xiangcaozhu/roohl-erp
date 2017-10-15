<?php

/*
@@acc_title="移动分类"

*/

$CenterCategoryExtra = Core::ImportExtra( 'CenterCategory' );

$pid = (int)$_GET['pid'];
$cid = (int)$_GET['cid'];
$nid = (int)$_GET['next_cid'];

$CenterCategoryExtra->PositionMove( $pid, $cid, $nid, true );

echo PHP2JSON( array( 'code' => 200 ) );
exit();

?>