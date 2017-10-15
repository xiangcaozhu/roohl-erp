<?php

/*
@@acc_free
@@acc_title="删除图片"

*/

$ProductModel = Core::ImportModel( 'Product' );

$info = $ProductModel->GetPicture( $_GET['id'] );

$code = '404';
do
{
	if ( $info )
	{
		@unlink( Common::GetPicturePath( $info['save_path'], $info['save_name'], $info['save_ext'], 1 ) );
		@unlink( Common::GetPicturePath( $info['save_path'], $info['save_name'], $info['save_ext'], 2 ) );
		@unlink( Common::GetPicturePath( $info['save_path'], $info['save_name'], $info['save_ext'], 3 ) );
	}

	$ProductModel->DelPicture( $_GET['id'] );

	if ( $_GET['pid'] )
	{
		if ( $productInfo = $ProductModel->Get( $_GET['pid'] ) )
		{
			if ( $tmp = GetExplode( ',', $productInfo['image_detail'] ) )
			{
				foreach ( $tmp as $k => $v )
				{
					if ( $v == $_GET['id'] )
						unset( $tmp[$k] );
				}

				$data = array();
				$data['image_detail'] = @implode( ',', $tmp );

				$ProductModel->Update( $_GET['pid'], $data );
			}
		}
	}

	$code = '200';

}
while ( false );

echo PHP2JSON( array( 'code' => $code ) );
?>