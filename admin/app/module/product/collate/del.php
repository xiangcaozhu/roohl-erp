<?php
/*
@@acc_title="删除"
*/
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );


$collateId = (int)$_GET['id'];

$collateInfo = $ProductCollateModel->Get( $collateId );

if ( !$collateInfo )
	Alert( '没有找到指定的对应关系' );

$ProductCollateModel->Del( $collateId );
$ProductCollateModel->DelPrice( $collateId );

Common::Loading();

?>