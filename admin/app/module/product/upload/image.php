<?php

/*
@@acc_free
@@acc_title="上传图片"

*/

$ProductModel = Core::ImportModel( 'Product' );

Core::LoadLib( 'GD.class.php' );

if ( $_POST )
{
	$error = null;

	do
	{
		if ( !$_FILES['picture']['tmp_name'] )
		{
			$error['fail'] = 1;
			break;
		}

		$title = GetFileName( $_FILES['picture']['name'] );

		$saveName	= md5( GetRand( 32 ) );
		$savePath		= substr( $saveName, 0, 2 ) . '/' . substr( $saveName, 2, 2 ) . '/';
		$saveName	= substr( $saveName, 0, 16 ) . '_' . time();
		$saveExt		= GetFileExt( $_FILES['picture']['name'] );

		$saveFullPath = Common::GetPicturePath( $savePath );

		$tmpFile = Core::GetConfig( 'picture_tmp_path' ) . $saveName . '.' . $saveExt;

		if ( !@move_uploaded_file( $_FILES['picture']['tmp_name'], $tmpFile ) )
		{
			$error['fail'] = 2;
			break;
		}

		$Gd = new GD();

		if ( !$Gd->IsImage( $tmpFile ) )
		{
			@unlink( $tmpFile );
			$error['error_image'] = 1;
			break;
		}

		if ( !FileExists( $saveFullPath ) )
			MakeDirTree( $saveFullPath );

		// 3种尺寸的照片
		copy( $tmpFile, Common::GetPicturePath( $savePath, $saveName, $saveExt, 1 ) );
		$Gd->Thumb( $tmpFile, Core::GetConfig( 'picture_detail_width_2' ), Core::GetConfig( 'picture_detail_width_2' ), Common::GetPicturePath( $savePath, $saveName, $saveExt, 2 ) );
		$Gd->Thumb( $tmpFile, Core::GetConfig( 'picture_detail_width_3' ), Core::GetConfig( 'picture_detail_width_3' ), Common::GetPicturePath( $savePath, $saveName, $saveExt, 3 ) );

		@unlink( $tmpFile );

		$data = array();
		$data['pid'] = (int)$_GET['pid'];
		$data['save_path'] = $savePath;
		$data['save_name'] = $saveName;
		$data['save_ext'] = $saveExt;
		$data['title'] = $title;
		$data['add_time'] = time();
		$data['user_id'] = (int)$__Session['user_id'];

		$pictureId = $ProductModel->AddPicture( $data );

		$data['id'] = $pictureId;
		$data['thumb3_url'] = Common::GetPictureUrl( $savePath, $saveName, $saveExt, 3 );
		$data['thumb2_url'] = Common::GetPictureUrl( $savePath, $saveName, $saveExt, 2 );
		$data['full_url'] = Common::GetPictureUrl( $savePath, $saveName, $saveExt, 1 );

		if ( $_GET['pid'] )
		{
			$productId = (int)$_GET['pid'];
			$productInfo = $ProductModel->Get( $productId );

			if ( $productInfo )
			{
				$pdata = array();
				$pdata['image_detail'] = $productInfo['image_detail'] ? $productInfo['image_detail'] . ',' . $pictureId : $pictureId;

				$ProductModel->Update( $productId, $pdata );
			}
		}
	}
	while (false);

	echo PHP2JSON( array( 'error' => $error, 'data' => $data ) );
	exit();
}

?>