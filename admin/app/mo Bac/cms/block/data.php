<?php


$CmsBlockCategoryModel = Core::ImportModel( 'CmsBlockCategory' );
$CmsBlockModel = Core::ImportModel( 'CmsBlock' );

Core::LoadExtra( 'CmsBlock' );
$CmsBlockExtra = new CmsBlockExtra();

$id = (int)$_GET['id'];

$info = $CmsBlockModel->Get( $id );

if ( !$info )
	Alert( '没有找到相关数据' );

if ( !$_POST )
{
	$pattern = $CmsBlockExtra->GetExtraPattern( $info['content'], $info['pattern_id'] );

	if ( $pattern )
	{
		$tpl['html'] = Common::PageCode( 'cms/block/pattern/form.html', $pattern );
	}
	
	$tpl['pattern'] = $CmsBlockExtra->GetPattern( $info['pattern_id'] );
	$tpl['info'] = $info;
	$tpl['edit'] = true;

	Common::PageOut( 'cms/block/data.html', $tpl );
}
else
{
	$patternId = $info['pattern_id'];
	$blockMainList = $_POST['block_list'];
	$blockChildList = $_POST['block_child_list'];

	$blockContent = $CmsBlockExtra->GetSaveContent( $blockMainList, $blockChildList, $patternId );
	$blockContentOld = $CmsBlockExtra->UnPackContent( $info['content'] );

	$CmsBlockExtra->Clean( $blockContentOld, $blockContent, $patternId );

	$data = array();
	$data['content'] = $CmsBlockExtra->PackContent( $blockContent );

	$CmsBlockModel->Update( $id, $data );

	Common::Loading( '?mod=cms.block.data&id=' . $id );
}

?>