<?php
/*
@@acc_free
*/
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );
$CenterBrandModel = Core::ImportModel( 'CenterBrand' );

$categoryId = (int)$_GET['id'];

$categoryInfo = $CenterCategoryModel->Get( $categoryId );

if ( !$categoryInfo )
	Common::Error( '没有找到分类信息' );

$extraInfo = $CenterCategoryModel->GetExtra( $categoryId );

if ( !$extraInfo )
{
	$data = array();
	$data['cid'] = $categoryId;
	$CenterCategoryModel->AddExtra( $data );
}

if ( !$_POST )
{
	$categoryList = $CenterCategoryModel->BuildTree();

	foreach ( $categoryList as $key => $val )
	{
		$categoryList[$key]['indent'] = str_repeat( '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $val['deep'] );

		if ( $val['id'] == $categoryId )
			$categoryList[$key]['selected'] = 'selected';
	}

	$tpl['category_list'] = $categoryList;

	$extraInfo['ad_top_url'] = Core::GetConfig( 'category_picture_url' ) . $extraInfo['ad_top'];
	$extraInfo['ad_left_url'] = Core::GetConfig( 'category_picture_url' ) . $extraInfo['ad_left'];

	$tpl['extra'] = $extraInfo;
	$tpl['category'] = $categoryInfo;

	Common::PageOut( 'product/category/extra.html', $tpl );
}
else
{
	$data = array();
	$data['commend_pic'] = NoHtml( $_POST['commend_pic'] );
	$data['commend_text'] = NoHtml( $_POST['commend_text'] );
	$data['hot_sell'] = NoHtml( $_POST['hot_sell'] );
	$data['hot_key_word'] = NoHtml( $_POST['hot_key_word'] );
	$data['ad_top_link'] = NoHtml( $_POST['ad_top_link'] );
	$data['ad_left_link'] = NoHtml( $_POST['ad_left_link'] );

	if ( $_FILES['ad_top']['tmp_name'] )
	{
		$ext = GetFileExt( $_FILES['ad_top']['name'] );
		$fileName = "ad_top_{$categoryId}.{$ext}";
		$savePath = Core::GetConfig( 'category_picture_path' ) . $fileName;

		$data['ad_top'] = $fileName;

		@move_uploaded_file( $_FILES['ad_top']['tmp_name'], $savePath );
	}

	if ( $_FILES['ad_left']['tmp_name'] )
	{
		$ext = GetFileExt( $_FILES['ad_left']['name'] );
		$fileName = "ad_left_{$categoryId}.{$ext}";
		$savePath = Core::GetConfig( 'category_picture_path' ) . $fileName;

		$data['ad_left'] = $fileName;

		@move_uploaded_file( $_FILES['ad_left']['tmp_name'], $savePath );
	}

	$CategoryModel->UpdateExtra( $categoryId, $data );

	Redirect( '?mod=product.category.list' );
}

?>