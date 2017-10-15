<?php

/*
@@acc_free

*/

$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );

if ( $_GET['type'] == 'list' )
{
	list( $page, $offset, $onePage ) = Common::PageArg( 10 );

	$list = $BuyAttributeModel->GetTemplateList( $offset, $onePage );

	$tpl['list'] = $list;

	$html = Common::PageCode( 'product/attribute/buy/template/dialog_list.html', $tpl, false, false );
	$total = $CenterBuyAttributeModel->GetTemplateTotal();

	echo PHP2JSON( array( 'html' => $html, 'total' => $total ) );
	exit;
}
elseif ( $_GET['type'] == 'preview' )
{	
	$templateId = $_GET['id'];

	$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );
	$buyAttributeList = $CenterBuyAttributeExtra->GetGroup( 0, $templateId );

	$tpl['buy_attribute_list'] = $buyAttributeList;

	$html = Common::PageCode( 'product/attribute/buy/preview.html', $tpl, false, false );

	echo PHP2JSON( array( 'html' => $html, 'total' => $total ) );
	exit;
}
elseif ( $_GET['type'] == 'apply' )
{
	$templateId = $_GET['id'];

	$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );
	$buyAttributeList = $CenterBuyAttributeExtra->GetGroup( 0, $templateId, -10000 );

	$tpl['buy_attribute_list'] = $buyAttributeList;
	$tpl['is_template'] = true;

	$html = Common::PageCode( 'product/attribute/buy/form.html', $tpl );

	echo PHP2JSON( array( 'html' => $html, 'total' => $total ) );
	exit;
}

?>