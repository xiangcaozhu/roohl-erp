<?php

$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );

$keyWord = trim( $_POST['key'] );

$list = $CenterSupplierModel->Search( $keyWord );


echo PHP2JSON( $list );


exit();

?>