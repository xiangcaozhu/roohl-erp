<?php

$CenterProductModel = Core::ImportModel( 'CenterProduct' );

$keyWord = trim( $_POST['key'] );
$supplier_id = $_GET['supplier_id'];
$list = $CenterProductModel->Search( $keyWord, $supplier_id );

echo PHP2JSON( $list );

exit();

?>