<?php

/*
@@acc_free
@@acc_title="上传"

*/

$CmsSiteModel = Core::ImportModel( 'CmsSite' );
$CmsImageModel = Core::ImportModel( 'CmsImage' );
$CmsImageCategoryModel = Core::ImportModel( 'CmsImageCategory' );

$categoryId = (int)$_POST['cid'];
$categoryInfo = $CmsImageCategoryModel->Get( $categoryId );

if ( !$categoryInfo )
	exit( '未指定分类' );

$siteInfo = $CmsSiteModel->Get( $categoryInfo['site_id'] );

if ( !$siteInfo )
	exit( '未指定站点' );

if ( !$siteInfo )
	exit( '未指定站点' );

$rootPath		= $siteInfo['image_publish_path'];
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
$data['site_id'] = $siteInfo['id'];
$data['save_path'] = $savePath;
$data['save_name'] = $saveName;
$data['save_ext'] = $saveExt;
$data['title'] = $title;
$data['add_time'] = time();
$data['user_id'] = (int)$__Session['user_id'];

$CmsImageModel->Add( $data );

echo "1";

?>