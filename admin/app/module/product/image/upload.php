<?php

/*
@@acc_free
@@acc_title="上传"

*/

$ShopImageModel = Core::ImportModel( 'ShopImage' );
$ShopImageCategoryModel = Core::ImportModel( 'ShopImageCategory' );

$categoryId = (int)$_POST['cid'];
$categoryInfo = $ShopImageCategoryModel->Get( $categoryId );

if ( !$categoryInfo )
	exit( '未指定分类' );

$rootPath		= Core::GetConfig( 'picture_path' );
$title			= GetFileName( $_FILES['file']['name'] );

$saveName	= md5( GetRand( 32 ) );
$savePath		= substr( $saveName, 0, 2 ) . '/' . substr( $saveName, 2, 2 ) . '/';
$saveExt		= GetFileExt( $_FILES['file']['name'] );

$saveFolder	= $rootPath . $savePath;
$saveFile		= $saveFolder . $saveName . '.' .  $saveExt;
$saveFileThumb	= $saveFolder . $saveName . '_min.' . $saveExt;

$tmpFile = Core::GetConfig( 'picture_tmp_path' ) . $saveName . '.' . $saveExt;

if ( !@move_uploaded_file( $_FILES['file']['tmp_name'], $tmpFile ) )
	exit('error #1, can\'t move file');

Core::LoadLib( 'GD.class.php' );
$Gd = new GD();

if ( !$Gd->IsImage( $tmpFile ) )
{
	@unlink( $tmpFile );
	exit('error image file');
}

if ( !FileExists( $saveFolder ) )
	MakeDirTree( $saveFolder );

// 移动图片
copy( $tmpFile, $saveFile );
$Gd->Thumb( $tmpFile, 64, 64, $saveFileThumb );

@unlink( $tmpFile );

$data = array();
$data['cid'] = $categoryInfo['id'];
$data['save_path'] = $savePath;
$data['save_name'] = $saveName;
$data['save_ext'] = $saveExt;
$data['title'] = $title;
$data['add_time'] = time();
$data['user_id'] = (int)$__Session['user_id'];

$ShopImageModel->Add( $data );

echo "1";

?>