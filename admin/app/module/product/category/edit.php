<?php
/*
@@acc_title="编辑"
*/
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );
$CenterBrandModel = Core::ImportModel( 'CenterBrand' );

$categoryId = (int)$_GET['id'];

$categoryInfo = $CenterCategoryModel->Get( $categoryId );

if ( !$categoryInfo )
	Common::Error( '没有找到分类信息' );

$categoryBrandList = $CenterCategoryModel->GetBrandList( $categoryId );

if ( $_POST )
{
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['sort_name'] = NoHtml( $_POST['sort_name'] );
	$data['attribute_type_id'] = intval( $_POST['attribute_type_id'] );
	$data['hidden'] = intval( $_POST['hidden'] );
	$data['update_time'] = time();
	$data['attribute_list'] = @implode( ',', $_POST['attribute'] );

	if ( Nothing( $data['name'] ) )
		Alert( '分类名称不能为空' );

	$CenterCategoryModel->Update( $categoryId, $data );

	if ( is_array( $_POST['brand'] ) )
	{
		foreach ( $_POST['brand'] as $bid )
		{
			if ( !$categoryBrandList[$bid] )
			{
				$data = array();
				$data['cid'] = $categoryId;
				$data['bid'] = $bid;
				$CenterCategoryModel->AddBrand( $data );
			}
			else
			{
				$categoryBrandList[$bid]['holding'] = 1;
			}
		}
	}

	foreach ( $categoryBrandList as $val )
	{
		if ( !$val['holding'] )
		{
			$CenterCategoryModel->DelBrand( $categoryId, $val['id'] );
		}
	}

	$CenterCategoryModel->BuildTree();
	$CenterCategoryModel->UpdateParentIdList();

	Common::Loading( "?mod=product.category&id={$categoryId}" );
	exit();
}

?>