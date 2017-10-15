<?php

$CmsBlockModel = Core::ImportModel( 'CmsBlock' );
$CmsProductModel = Core::ImportModel( 'CmsProduct' );

$id = (int)$_GET['id'];

$info = $CmsProductModel->GetBlockConfig( $id );

if ( !$info )
	Alert( '没有找到相关数据' );

$CmsProductModel->DelBlockConfig( $id );

Core::LoadExtra( 'CmsBlock' );
$CmsBlockExtra = new CmsBlockExtra();

$blockList = $CmsProductModel->GetBlockListByConfig( $id );

foreach ( $blockList as $val )
{
	$blockContentOld = $CmsBlockExtra->UnPackContent( $val['content'] );
	$CmsBlockExtra->Clean( $blockContentOld, array(), $info['pattern_id'] );

	$CmsProductModel->DelBlock( $val['cms_pid'], $val['config_id'] );
}

Common::Loading( '?mod=cms.product.block.config.list' );

?>