<?php

/*
@@acc_title="Ajax获取JSON"

*/

$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );

$ckeckedList = explode( ',', $_GET['checked'] );

$extTree = $CenterCategoryModel->GetExtTree( $_GET['checkbox'], $ckeckedList );
echo PHP2JSON( $extTree );

exit();

?>