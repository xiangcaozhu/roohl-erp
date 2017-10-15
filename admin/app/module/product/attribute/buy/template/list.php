<?php

$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );

$list = $CenterBuyAttributeModel->GetTemplateList();

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['update_time'] = DateFormat( $val['update_time'] );
}

$tpl['list'] = $list;


Common::PageOut( 'product/attribute/buy/template/list.html', $tpl );

?>