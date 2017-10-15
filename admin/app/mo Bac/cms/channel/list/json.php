<?php

/*
@@acc_title="Ajax获取JSON"

*/

$CmsChannelModel = Core::ImportModel( 'CmsChannel' );
$CmsChannelModel->SetSiteId( intval( $_GET['site'] ) );

$ckeckedList = explode( ',', $_GET['checked'] );

$extTree = $CmsChannelModel->GetExtTree( $_GET['checkbox'], $ckeckedList );
echo PHP2JSON( $extTree );

exit();

?>