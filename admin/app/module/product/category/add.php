<?php
/*
@@acc_title="添加"
*/
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );
$CenterBrandModel = Core::ImportModel( 'CenterBrand' );

if ( $_POST )
{
	$pid = (int)$_GET['id'];

	$data = array();
	$data['pid'] = $pid;
	$data['name'] = NoHtml( $_POST['name'] );
	$data['sort_name'] = NoHtml( $_POST['sort_name'] );
	$data['attribute_type_id'] = intval( $_POST['attribute_type_id'] );
	$data['add_time'] = time();
	$data['update_time'] = time();
	$data['product_num'] = 0;
	$data['attribute_list'] = @implode( ',', $_POST['attribute'] );
	$data['order_id'] = $CenterCategoryModel->GetMinOrderId( $pid ) - 1;
	$data['hidden'] = intval( $_POST['hidden'] );

	if ( Nothing( $data['name'] ) )
		Alert( '分类名称不能为空' );

	$categoryId = $CenterCategoryModel->Add( $data );

	if ( is_array( $_POST['brand'] ) )
	{
		foreach ( $_POST['brand'] as $bid )
		{
			$data = array();
			$data['cid'] = $categoryId;
			$data['bid'] = $bid;
			$CenterCategoryModel->AddBrand( $data );
		}
	}

	$CenterCategoryModel->BuildTree();
	$CenterCategoryModel->UpdateParentIdList();

	Common::Loading( "?mod=product.category&id={$_GET['id']}" );
}

?>