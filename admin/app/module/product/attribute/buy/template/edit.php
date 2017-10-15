<?php

$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );

$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );

$templateId = (int)$_GET['id'];

$info = $CenterBuyAttributeModel->GetTemplate( $templateId );

if ( !$info )
	Alert( '没有找到模板信息' );

if ( !$_POST )
{
	$tpl['info'] = $info;

	/******** Buy Attribute ********/
	//$buyAttributeList = $BuyAttributeModel->GetList( 0, $templateId );
	$buyAttributeList = $CenterBuyAttributeExtra->GetGroup( 0, $templateId );

	$tpl['attribute_template'] = Common::PageCode( 'product/attribute/buy/dom.html' );
	$tpl['attribute_form'] = Common::PageCode( 'product/attribute/buy/form.html', array( 'buy_attribute_list' => $buyAttributeList ) );

	Common::PageOut( 'product/attribute/buy/template/edit.html', $tpl );
}
else
{
	if ( Nothing( $_POST['name'] ) )
		Alert( '模板名称不能为空' );
	
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );

	$CenterBuyAttributeModel->UpdateTemplate( $templateId, $data );
	
	/******** 检查购买属性 ********/
	$buyAttributeList = $CenterBuyAttributeExtra->ListProcess( $_POST['buy_attr'], $_POST['buy_attr_val'] );

	/******** 添加处理购买属性 ********/
	$CenterBuyAttributeExtra->ListUpdate( $buyAttributeList, 0, $templateId );

	Common::Loading( "?mod=product.attribute.buy.template.list" );
}

?>