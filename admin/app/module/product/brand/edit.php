<?php

$CenterBrandModel = Core::ImportModel( 'CenterBrand' );

$id = (int)$_GET['id'];

$info = $CenterBrandModel->Get( $id );

if ( !$info )
	Common::Error( '错误的编号' );

if ( !$_POST )
{
	$info['img_url'] = Core::GetConfig( 'brand_picture_url' ) . "{$id}.jpg";

	$tpl['brand'] = $info;

	Common::PageOut( 'product/brand/edit.html', $tpl );
}
else
{
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['url'] = NoHtml( $_POST['url'] );

	if ( Nothing( $data['name'] ) )
		Alert( '品牌名称不能为空' );

	Core::LoadLib( 'GD.class.php' );
	$Gd = new GD();

	if ( $_FILES['logo']['tmp_name'] )
	{
		$ext = GetFileExt( $_FILES['logo']['name'] );
		$tmpFile = Core::GetConfig( 'upload_tmp_path' ) . $id . '_logo.' . $ext;

		@move_uploaded_file( $_FILES['logo']['tmp_name'], $tmpFile );

		if ( $Gd->IsImage( $tmpFile ) )
		{
			$Gd->Thumb( $tmpFile, Core::GetConfig( 'brand_picture_width' ), Core::GetConfig( 'brand_picture_width' ), Core::GetConfig( 'brand_picture_path' ) . "{$id}.jpg" );
		}

		@unlink( $tmpFile );
		$data['logo'] = 1;
	}

	$CenterBrandModel->Update( $id, $data );

	Common::Loading( $_POST['redirect'] );
}

?>