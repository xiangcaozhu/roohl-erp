<?php
/*
@@acc_free
*/
$CategoryModel = Core::ImportModel( 'Category' );
$ProductModel = Core::ImportModel( 'Product' );
$SupplierModel = Core::ImportModel( 'Supplier' );

$productId = intval( $_GET['id'] );

$productInfo = array();
$productInfo['name'] = NoHtml( $_POST['name'] );
$productInfo['summary'] = NoHtml( $_POST['summary'] );
$productInfo['cid'] = $categoryId;
$productInfo['brand_id'] = (int)$_POST['brand_id'];
$productInfo['price'] = $_POST['price'];
$productInfo['market_price'] = $_POST['market_price'];
$productInfo['vip_price'] = $_POST['vip_price'];
$productInfo['sale_price'] = $_POST['sale_price'];
$productInfo['clean_price'] = $_POST['clean_price'];
$productInfo['is_on_sale'] = (int)$_POST['is_on_sale'];
$productInfo['is_free_shipping'] = $_POST['is_free_shipping'];
$productInfo['image_list'] = 0;
$productInfo['add_time'] = time();
$productInfo['update_time'] = time();
$productInfo['supplier_id'] = $_POST['supplier_id'];
$productInfo['warehouse'] = $_POST['warehouse'];
$productInfo['warehouse_num'] = (int)$_POST['warehouse_num'];
$productInfo['weight'] = $_POST['weight'];
$productInfo['image_detail'] = $_POST['image_detail_order'];


$productDecription = array();
$productDecription['pid'] = 0;
$productDecription['cid'] = $categoryId;
$productDecription['description'] = $_POST['description'];
$productDecription['commend_product'] = NoHtml( $_POST['commend_product'] );
$productDecription['key_word'] = NoHtml( $_POST['key_word'] );
$productDecription['supplier_price'] = $_POST['supplier_price'];
$productDecription['supplier_supply_type'] = NoHtml( $_POST['supplier_supply_type'] );
$productDecription['supplier_carry_type'] = NoHtml( $_POST['supplier_carry_type'] );
$productDecription['supplier_balance_type'] = NoHtml( $_POST['supplier_balance_type'] );
$productDecription['supplier_product_manager'] = NoHtml( $_POST['supplier_product_manager'] );
$productDecription['supplier_linkman'] = NoHtml( $_POST['supplier_linkman'] );
$productDecription['supplier_phone'] = NoHtml( $_POST['supplier_phone'] );
$productDecription['supplier_address'] = NoHtml( $_POST['supplier_address'] );
$productDecription['supplier_name'] = NoHtml( $_POST['supplier_name'] );
$productDecription['warehouse'] = NoHtml( $_POST['warehouse'] );


$ButAttributeExtra = Core::ImportExtra( 'BuyAttribute' );

$buyAttributeList = $ButAttributeExtra->ListProcess( $_POST['buy_attr'], $_POST['buy_attr_val'] );

$tpl['buy_attribute_list'] = $buyAttributeList;
$tpl['description'] = $productDecription;
$tpl['product'] = $productInfo;


Common::PageOut( 'product/preview.html', $tpl, false, false );

?>