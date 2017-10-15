<?php

/*
@@acc_title="Ajax获取JSON"

*/

$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );

$ckeckedList = explode( ',', $_GET['checked'] );

$extTree = $CmsCategoryModel->GetExtTree( $_GET['checkbox'], $ckeckedList );
echo PHP2JSON( $extTree );

exit();

?>