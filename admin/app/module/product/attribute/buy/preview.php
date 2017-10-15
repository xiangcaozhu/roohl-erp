<?php

/*
@@acc_free
@@acc_title="预览"

*/

$templateId = $_GET['id'];

$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );
$buyAttributeList = $CenterBuyAttributeExtra->ListProcess( $_POST['buy_attr'], $_POST['buy_attr_val'] );

$tpl['buy_attribute_list'] = $buyAttributeList;

$html = Common::PageCode( 'product/attribute/buy/preview.html', $tpl, false, false );

echo PHP2JSON( array( 'html' => $html ) );
exit;

?>