<?php


$CmsBlockCategoryModel = Core::ImportModel( 'CmsBlockCategory' );
$CmsBlockModel = Core::ImportModel( 'CmsBlock' );

$id = (int)$_GET['id'];

$info = $CmsBlockModel->Get( $id );

if ( !$info )
	Alert( '没有找到相关数据' );

Core::LoadExtra( 'CmsBlock' );
$CmsBlockExtra = new CmsBlockExtra();

$CmsBlockModel->Del( $id );

$blockContentOld = $CmsBlockExtra->UnPackContent( $info['content'] );
$CmsBlockExtra->Clean( $blockContentOld, array(), $info['pattern_id'] );

Common::Loading( '?mod=cms.block.list' );

?>