<?php

$CmsBlockModel = Core::ImportModel( 'CmsBlock' );
$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );

$id = (int)$_GET['id'];

$info = $CmsCategoryModel->GetBlockConfig( $id );

if ( !$info )
	Alert( '没有找到相关数据' );

$CmsCategoryModel->DelBlockConfig( $id );

Core::LoadExtra( 'CmsBlock' );
$CmsBlockExtra = new CmsBlockExtra();

$blockList = $CmsCategoryModel->GetBlockListByConfig( $id );

foreach ( $blockList as $val )
{
	$blockContentOld = $CmsBlockExtra->UnPackContent( $val['content'] );
	$CmsBlockExtra->Clean( $blockContentOld, array(), $info['pattern_id'] );

	$CmsCategoryModel->DelBlock( $val['cid'], $val['config_id'] );
}

Common::Loading( '?mod=cms.category.block.config.list' );

?>