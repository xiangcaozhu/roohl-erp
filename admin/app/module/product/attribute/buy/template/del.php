<?php

$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );

$templateId = (int)$_GET['id'];

$info = $CenterBuyAttributeModel->GetTemplate( $templateId );

if ( !$info )
	Alert( '没有找到模板信息' );

$buyAttributeList = $CenterBuyAttributeModel->GetList( 0, $templateId );

foreach ( $buyAttributeList as $val )
{
	$CenterBuyAttributeModel->DelValueByAid( $val['id'] );
	$CenterBuyAttributeModel->Del( $val['id'] );
}

$CenterBuyAttributeModel->DelTemplate( $templateId );

Common::Loading( "?mod=product.attribute.buy.template.list" );

?>