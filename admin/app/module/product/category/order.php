<?php
/*
@@acc_free
*/
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );

$CenterCategoryModel->BuildTree();
$CenterCategoryModel->Order( intval( $_GET['id'] ), $_GET['type'] );

Redirect( '?mod=product.category&open=' .$_GET['open'] );

?>