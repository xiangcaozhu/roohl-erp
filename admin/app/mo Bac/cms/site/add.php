<?php

$CmsSiteModel = Core::ImportModel( 'CmsSite' );

if ( !$_POST )
{
	Common::PageOut( 'cms/site/form.html', $tpl );
}
else
{
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['domain'] = NoHtml( $_POST['domain'] );
	$data['publish_url'] = NoHtml( $_POST['publish_url'] );
	$data['publish_path'] = NoHtml( $_POST['publish_path'] );
	$data['image_publish_url'] = NoHtml( $_POST['image_publish_url'] );
	$data['image_publish_path'] = NoHtml( $_POST['image_publish_path'] );
	$data['add_time'] = time();
	$data['update_time'] = time();

	if ( Nothing( $data['name'] ) )
		Alert( '请填写名称' );

	if ( Nothing( $data['domain'] ) )
		Alert( '请填写域名' );

	if ( Nothing( $data['publish_url'] ) )
		Alert( '请填写根URL' );

	if ( Nothing( $data['publish_path'] ) )
		Alert( '请填发布路径' );

	$CmsSiteModel->Add( $data );

	Common::Loading( '?mod=cms.site.list' );
}

?>