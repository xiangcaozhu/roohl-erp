<?php
/*
@@acc_title="产品导入 import"
*/
$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );
$AdminModel = Core::ImportModel( 'Admin' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );

Core::LoadFunction( 'ImportProduct.inc.php' );


if ( !$_POST )
{
	$tpl['check'] = true;
	Common::PageOut( 'product/import/upload.html', $tpl );
}
else
{	
	if ( !$_FILES['file']['tmp_name'] )
		return false;

	$savePath = Core::GetConfig( 'file_upload_tmp_path' );
	$fileName = md5( GetRand( 32 ) );
	$saveFile = $savePath . $fileName  . ".tmp";

	if ( !@move_uploaded_file( $_FILES['file']['tmp_name'], $saveFile ) )
	{
		Alert( '上传文件失败' );
	}

	$productList = ImportProduct( $saveFile );

	$list = array();
	foreach ( $productList as $key => $val )
	{
		$productList[$key]['summary'] = $val['summary'];

		$categoryInfo = $CenterCategoryModel->Get( $val['cid'] );
		$productList[$key]['cname'] = $categoryInfo['name'];

		if ( $CenterProductModel->GetUnique( $val['name'] ) )
		{
			$productList[$key]['exists'] = true;
		}

		$supplier = $CenterSupplierModel->Get( $val['supplier_now'] );
		$productList[$key]['supplier_name'] = $supplier['name'];
	}

	$tpl['list'] = $productList;
	$tpl['file_name'] = $fileName;

	Common::PageOut( 'product/import/check.html', $tpl );
}

?>