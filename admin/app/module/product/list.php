<?php
/*
@@acc_title="商品列表 list"
*/
$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );

$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );


$AdminModel = Core::ImportModel( 'Admin' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

//$ProductCollateModel = Core::ImportModel( 'ProductCollate' );

//$CenterChannelModel = Core::ImportModel( 'CenterChannel' );





$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );
$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );


$CenterOrderModel = Core::ImportModel( 'CenterOrder' );


$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );





list( $page, $offset, $onePage ) = Common::PageArg( 10 );

$categoryList = $CenterCategoryModel->BuildTree();

foreach ( $categoryList as $key => $val )
{
	$categoryList[$key]['indent'] = str_repeat( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $val['deep'] );
}

$tpl['category_list'] = $categoryList;

$_GET['cid'] = (int)$_GET['cid'];

if ( $_GET['cid'] )
{
	$cidList = $CenterCategoryModel->GetChildID( $_GET['cid'] );
	array_unshift( $cidList, $_GET['cid'] );
}

$onSell = -1;

if ( $_GET['act'] == 'on' )
	$onSell = 1;
elseif ( $_GET['act'] == 'off' )
	$onSell = 0;

$search = array();
$search['category_id'] = (int)$_GET['cid'];
$search['product_id'] = intval( $_GET['pid'] );
$search['on_sell'] = $onSell;
$search['begin_time'] = $_GET['begin_date'] ? strtotime( $_GET['begin_date'] . " 00:00:00" ) : '';
$search['end_time'] = $_GET['end_date'] ? strtotime( $_GET['end_date'] . " 24:00:00" ) : '';
$search['word'] =  $_GET['word'] ;
$search['warehouse'] = trim( $_GET['warehouse'] );
$search['order'] = trim( $_GET['order'] );
$search['by'] = trim( $_GET['by'] );
$search['supplier_now'] = trim( $_GET['supplier_now'] );

//echo $search['word'];
//$search['manager_user_id'] = (int)$_GET['manager_user_id'];

$productList = $CenterProductModel->GetList( $search, $offset, $onePage );
$productList = $CenterProductExtra->Explain( $productList );

$total = $CenterProductModel->GetTotal( $search );

Core::LoadDom( 'CenterSku' );
foreach ( $productList as $key => $val )
{
	$supplierInfo = $CenterSupplierModel->Get($val['supplier_now']);
	$manageName = $AdminModel->GetAdministrator($supplierInfo['manage_id']);
	$productList[$key]['Manage_name'] = $manageName['user_real_name'].'<br>'.$manageName['user_phone'];
	
	if($manageName['user_id'] == $__UserAuth['user_id'])
	$productList[$key]['Manage_edit'] = 1;
	else
	$productList[$key]['Manage_edit'] = 0;

	if( $__UserAuth['user_group'] == 38 || $__UserAuth['user_group'] == 15 )
	$productList[$key]['Manage_edit'] = 1;

	
	//$search_Collate = array('product_id' => $val['id'],);
	//$CollateList = $ProductCollateModel->GetList( $search_Collate );
	//foreach ( $CollateList as $key_c => $val_c )
	//{
//	$channelInfo = $CenterChannelModel->Get($val_c['channel_id']);
//	$CollateList[$key_c]['channel_name'] = $channelInfo['mini_name'];
//	}
//	$productList[$key]['collate_list'] = $CollateList;
	
	
	$productList[$key]['add_time'] = DateFormat( $val['add_time'] );
	$productList[$key]['update_time'] = DateFormat( $val['update_time'] );
	$productList[$key]['category'] = $categoryList[$val['cid']]['name'];
	
	
	$CenterBuyAttributeExtra = new CenterBuyAttributeExtra();

	$buyAttributeList = $CenterBuyAttributeModel->GetList( $val['id'] );
	$productList[$key]['myinfo'] =  $buyAttributeList[0]['name'] ;
	



if((int)$search['product_id']>0 || $search['word']){	
	$p_All_id = $CenterProductModel->GetSaleAll( $val['id']  );
	




if(count($p_All_id)==0)
{
    //$productList[$key]['attributeList'] = array();
	
	$p_sku_id = $CenterProductModel->GetBaseSku( $val['id']  );
	//echo $val['id'] . '==' . $p_sku_id['id'] . '<br>';

   if($p_sku_id>0)
   {
	$productList[$key]['attributeList'][$val['id']]['attribute'] = '常规';
	$productList[$key]['attributeList'][$val['id']]['service'] = 0;
	$stockInfo = $CenterWarehouseStockModel->GetLiveQuantityBySkuId( $p_sku_id['id'] );
	$productList[$key]['attributeList'][$val['id']]['warehouse_quantity'] = (int)$stockInfo['quantity'];
	$productList[$key]['attributeList'][$val['id']]['warehouse_lock_quantity'] = (int)$stockInfo['lock_quantity'];
	$productList[$key]['attributeList'][$val['id']]['warehouse_live_quantity'] = (int)$stockInfo['live_quantity'];
	
	$productList[$key]['attributeList'][$val['id']]['onroad_quantity'] = (int)$CenterPurchaseModel->GetOnRoadNum( $p_sku_id['id'] );
	
	$p_sale = $CenterOrderModel->GetProductSalesReportOne($p_sku_id['id']);
	$productList[$key]['attributeList'][$val['id']]['sale'] = $p_sale;
   
   }
   else
   {
	$productList[$key]['attributeList'][$val['id']]['attribute'] = '常规';
	$productList[$key]['attributeList'][$val['id']]['service'] = 0;
	$stockInfo = $CenterWarehouseStockModel->GetLiveQuantityBySkuId( $p_sku_id['id'] );
	$productList[$key]['attributeList'][$val['id']]['warehouse_quantity'] = (int)$stockInfo['quantity'];
	$productList[$key]['attributeList'][$val['id']]['warehouse_lock_quantity'] = (int)$stockInfo['lock_quantity'];
	$productList[$key]['attributeList'][$val['id']]['warehouse_live_quantity'] = (int)$stockInfo['live_quantity'];
	
	$productList[$key]['attributeList'][$val['id']]['onroad_quantity'] = (int)$CenterPurchaseModel->GetOnRoadNum( $p_sku_id['id'] );
	
	$productList[$key]['attributeList'][$val['id']]['sale'] = 0;
   
   }





}
else
{

	$p_sku_id = $CenterProductModel->GetSaleSku( $val['id']  );
	$p_sku_attribute = array();
	$p_sku_good_id = array();
	foreach ( $p_sku_id as $keys => $v )
    {
	$sku = $CenterProductExtra->Id2Sku( $v['id'] );
	$CenterSkuDom = new CenterSkuDom( $sku );
	$attribute_value_id = $CenterSkuDom->InitProduct_3();
	
	//echo $attribute_value_id . '----<br>';
	$p_sku_attribute[] = $attribute_value_id ;
	$p_sku_good_id[$attribute_value_id] = $v['id'];
	}
	//$p_sku_good = implode( ',', $p_sku_good );
	
	//foreach ( $p_sku_good as $keys => $v )
   // {
	//echo $keys .'=='. $v . '-------------<br>';

	//}
//echo $keys .'===============<br>';
	
	

	//$productList[$key]['attributeList'] = $p_All_id;


	
	
	
	foreach ( $p_All_id as $keys => $v )
    {
	
	
	
	//echo $v['id'] . '<br>=======================';
if (in_array($v['id'],$p_sku_attribute))
  {
    $sku_p_id = $p_sku_good_id[$v['id']];
    //echo $v['id'] .'-'. $sku_p_id . '<br>=======================';
	$sku = $CenterProductExtra->Id2Sku( $sku_p_id );
//	echo $v['id'] .  '==' . $sku . '===' . $p_sku_good_id[$v['id']] . '<br>';
	$CenterSkuDom = new CenterSkuDom( $sku );
	$sku_attribute = $CenterSkuDom->InitProduct_1();
	
	$productList[$key]['attributeList'][$keys]['attribute'] = $v['name'];
	$productList[$key]['attributeList'][$keys]['service'] = $sku_attribute['service'];
	$stockInfo = $CenterWarehouseStockModel->GetLiveQuantityBySkuId( $p_sku_good_id[$v['id']] );
	$productList[$key]['attributeList'][$keys]['warehouse_quantity'] = (int)$stockInfo['quantity'];
	$productList[$key]['attributeList'][$keys]['warehouse_lock_quantity'] = (int)$stockInfo['lock_quantity'];
	$productList[$key]['attributeList'][$keys]['warehouse_live_quantity'] = (int)$stockInfo['live_quantity'];
	$productList[$key]['attributeList'][$keys]['onroad_quantity'] = (int)$CenterPurchaseModel->GetOnRoadNum( $sku_p_id );
	
	$p_sale = $CenterOrderModel->GetProductSalesReportOne( $sku_p_id );
	$productList[$key]['attributeList'][$keys]['sale'] = $p_sale;

  }
else
  {
	
	$productList[$key]['attributeList'][$keys]['attribute'] = $v['name'];
	$productList[$key]['attributeList'][$keys]['service'] = 0;
	$productList[$key]['attributeList'][$keys]['warehouse_quantity'] = 0;
	$productList[$key]['attributeList'][$keys]['warehouse_lock_quantity'] = 0;
	$productList[$key]['attributeList'][$keys]['warehouse_live_quantity'] = 0;
	$productList[$key]['attributeList'][$keys]['onroad_quantity'] = 0;
	$productList[$key]['attributeList'][$keys]['sale'] = 0;

  }
	
	
	
	}


}

}//////////////////////


/*
echo "Value: " . key($buyAttributeList) . "=============<br />";
	foreach ($buyAttributeList as $value)
{
  //echo "Value: " . key($value) . "<br />";
  
  print_r(array_keys($value));
  	//foreach ($value as $valuess)
//{
  //echo "Valuess: " . $valuess . "----<br />";
//}


}
echo "-------------------<br />";
*/









	
}

$tpl['product_list'] = $productList;
$tpl['total'] = $total;

$tpl['page'] = $page;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );


$tpl['type'] = $_GET['act'];



parse_str( $_SERVER['QUERY_STRING'], $q );
unset( $q['order'] );
unset( $q['by'] );
$tpl['order_uri'] = http_build_query( $q );


                                                                              
$userList = $AdminModel->GetAdministratorListcp();
$tpl['user_list'] = $userList;





Common::PageOut( 'product/list.html', $tpl );

?>