<?php


$CmsBlockCategoryModel = Core::ImportModel( 'CmsBlockCategory' );
$CmsBlockModel = Core::ImportModel( 'CmsBlock' );

$id = (int)$_GET['id'];

$info = $CmsBlockCategoryModel->Get( $id );

if ( !$info )
	Alert( '没有找到相关数据' );

if ( $CmsBlockModel->GetTotal( $id ) > 0 )
	Alert( '分类下面数据不为空,不能删除' );

if ( $CmsBlockCategoryModel->HasChildren( $id ) > 0 )
	Alert( '分类下面子分类不为空,不能删除' );

$CmsBlockCategoryModel->Del( $id );

Common::Loading( '?mod=cms.block.list' );

?>