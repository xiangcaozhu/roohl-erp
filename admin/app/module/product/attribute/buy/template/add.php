<?php

$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );


if ( !$_POST )
{
	$tpl['attribute_template'] = Common::PageCode( 'product/attribute/buy/dom.html' );
	Common::PageOut( 'product/attribute/buy/template/add.html', $tpl );
}
else
{
	if ( Nothing( $_POST['name'] ) )
		Alert( '模板名称不能为空' );
	
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['add_time'] = time();

	$templateId = $CenterBuyAttributeModel->AddTemplate( $data );

	$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );

	/******** 检查购买属性 ********/
	$buyAttributeList = $CenterBuyAttributeExtra->ListProcess( $_POST['buy_attr'], $_POST['buy_attr_val'] );

	/******** 添加处理购买属性 ********/
	$CenterBuyAttributeExtra->ListUpdate( $buyAttributeList, 0, $templateId );

	Common::Loading( "?mod=product.attribute.buy.template.list" );
}

?>