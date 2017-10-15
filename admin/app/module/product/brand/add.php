<?php

/*
@@acc_title="添加新的品牌"
*/

$CenterBrandModel = Core::ImportModel( 'CenterBrand' );

if ( !$_POST )
{
	Common::PageOut( 'product/brand/add.html', $tpl );
}
else
{
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['url'] = NoHtml( $_POST['url'] );
	$data['add_time'] = time();
	$data['logo'] = 0;

	if ( Nothing( $data['name'] ) )
		Alert( '品牌名称不能为空' );

	$id = $CenterBrandModel->Add( $data );

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
		$data = array();
		$data['logo'] = 1;

		$CenterBrandModel->Update( $id, $data );
	}

	Redirect( '?mod=product.brand.list' );
}

?>