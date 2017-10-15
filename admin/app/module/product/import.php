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
	//testarray($productList);
	//exit;


//Update1011
	foreach ( $productList as $key => $val )
	{
		$pid = $val['scode'];
		$pmoney = (float)$val['sku'];
		//echo $pid."=".$pmoney."<br>";
		$CenterProductModel->Update1114( $pid,$pmoney );

	}


	$tpl['check'] = true;
	Common::PageOut( 'product/import/upload.html', $tpl );

}

?>