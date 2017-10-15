<?php

$CmsProductModel = Core::ImportModel( 'CmsProduct' );

if ( !$_POST )
{
	/******** product ********/
	$data = array();
	$data['cms_flag'] = $_GET['type'] == 'del' ? '-1' : '1';

	$CmsProductModel->Update( $_GET['id'], $data );
}
else
{
	if ( $_POST['cms_product_id'] )
	{
		foreach ( $_POST['cms_product_id'] as $cmsProductId )
		{
			$data = array();
			$data['cms_flag'] = $_GET['type'] == 'del' ? '-1' : '1';

			$CmsProductModel->Update( $cmsProductId, $data );
		}
	}
}

Redirect();

?>