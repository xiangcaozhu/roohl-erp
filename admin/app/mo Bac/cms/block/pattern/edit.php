<?php

/*
@@acc_title="编辑模型"

*/

$CmsBlockModel = Core::ImportModel( 'CmsBlock' );

$id = (int)$_GET['id'];

$pattern = $CmsBlockModel->GetPattern( $id );

if ( !$pattern )
	Alert( '错误的编号' );

if ( !$_POST )
{
	$pattern['config'] = unserialize( $pattern['content'] );

	$tpl = $pattern;
	$tpl['edit'] = true;

	Common::PageOut( 'cms/block/pattern/field_config.html', $tpl );
}
else
{
	if ( Nothing( $_POST['name'] ) )
		Alert( '名称不能为空' );
	
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['update_time'] = time();
	
	$config = array();
	if ( $_POST['main_field'] )
	{
		foreach ( $_POST['main_field']['name'] as $key => $fieldName )
		{
				
			$config['main_field_list'][$fieldName] = array(
				'alias_name' => htmlspecialchars( $_POST['main_field']['alias_name'][$key] ),
				'name' => htmlspecialchars( $_POST['main_field']['name'][$key] ),
				'type' => $_POST['main_field']['type'][$key],
				'width' => $_POST['main_field']['width'][$key],
				'height' => $_POST['main_field']['height'][$key],
			);
		}
	}

	if ( $_POST['child_field'] )
	{
		foreach ( $_POST['child_field']['name'] as $key => $fieldName )
		{
				
			$config['child_field_list'][$fieldName] = array(
				'alias_name' => htmlspecialchars( $_POST['child_field']['alias_name'][$key] ),
				'name' => htmlspecialchars( $_POST['child_field']['name'][$key] ),
				'type' => $_POST['child_field']['type'][$key],
				'width' => $_POST['child_field']['width'][$key],
				'height' => $_POST['child_field']['height'][$key],
			);
		}
	}

	$data['content'] = serialize( $config );

	$CmsBlockModel->UpdatePattern( $id, $data );
	Common::Loading( '?mod=cms.block.pattern.list' );
}

?>