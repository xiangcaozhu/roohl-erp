<?php

$ShopImageModel = Core::ImportModel( 'ShopImage' );

$ShopImageExtra = Core::ImportExtra( 'ShopImage' );

$categoryId = (int)$_GET['cid'];

$search = array();
$search['cid'] = $categoryId;

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$imageList		= $ShopImageModel->GetList( $search, $offset, $onePage );
$total		= $ShopImageModel->GetTotal( $search );


foreach ( $imageList as $key => $val )
{
	$imageList[$key] = $ShopImageExtra->ExplainOne( $val );

	$imageList[$key]['add_time'] = DateFormat( $val['add_time'] );
	$imageList[$key]['update_time'] = DateFormat( $val['update_time'] );
}

$json = array();
$json['list'] = $imageList;
$json['total'] = $total;

echo PHP2JSON( $json );

?>