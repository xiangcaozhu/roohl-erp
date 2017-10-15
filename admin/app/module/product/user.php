<?php
/*
@@acc_free
*/
//$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );
//$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
//$CenterBrandModel = Core::ImportModel( 'CenterBrand' );
//$CenrterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );

$AdminModel = Core::ImportModel( 'Admin' );

/******** product ********/
$productId = (int)$_GET['product_id'];
$user_id = (int)$_GET['user_id'];
$productInfo = $CenterProductModel->Get( $productId );

if ( !$productInfo )
{
	Alert( '错误的产品编号' );
}else{
/******** Category ********/
//$categoryInfo = $CenterCategoryModel->Get( $productInfo['cid'] );

/*
if ( !$_GET['cid'] )
{
	$tpl['product'] = $productInfo;
	$tpl['category'] = $categoryInfo;

	Common::PageOut( 'product/move.html', $tpl, $parentTpl );
}
else
{
	$categoryId = $_GET['cid'];
	$categoryInfo = $CenterCategoryModel->Get( $categoryId );

	if ( $productInfo['cid'] == $categoryId )
		Alert( '新的分类不能为当前分类' );

	if ( !$categoryInfo )
		Alert( '选择的分类不存在' );

*/	

		$userinfo = $AdminModel->GetAdministrator( $user_id );




	$data = array();
	$data['manager_user_id'] = $user_id;
	$data['manager_user_name'] = $userinfo['user_name'];
	$data['manager_user_real_name'] = $userinfo['user_real_name'];
	
	/******** Update ********/
	$CenterProductModel->Update( $productId, $data );

	//Common::Loading( '?mod=product.list&cid=' . $_GET['fcid'] );
//}
echo $userinfo['user_real_name'];
}
?>