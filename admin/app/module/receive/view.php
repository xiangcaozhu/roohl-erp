<?php
/*
@@acc_free
*/
$CenterReceiveExtra = Core::ImportExtra( 'CenterReceive' );

$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );

include( Core::Block( 'warehouse' ) );

$receiveId = (int)$_GET['id'];

$receiveInfo = $CenterReceiveModel->Get( $receiveId );

if ( !$receiveInfo )
	Alert( '没有找到收货单' );

$receiveTypeList = Core::GetConfig( 'receive_type' );
$receiveInfo['type_name'] = $receiveTypeList[$receiveInfo['type']];

$receiveProductList = $CenterReceiveModel->GetProductList( $receiveId );
$receiveProductList = $CenterReceiveExtra->ExplainProduct( $receiveProductList );

$tpl['list'] = $receiveProductList;
$tpl['info'] = $receiveInfo;

Common::PageOut( 'receive/view.html', $tpl );


?>