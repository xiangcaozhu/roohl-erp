<?php

$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );
$CmsProductModel = Core::ImportModel( 'CmsProduct' );

if ( $CmsProductModel->GetList( array( 'category_id' => intval( $_GET['id'] ) ), 0, 1 ) )
	Alert( '分类下面存在产品,不允许删除!' );

if ( $CmsCategoryModel->GetOneChildList( intval( $_GET['id'] ) ) )
	Alert( '分类下面存在子分类,不允许删除!' );

$CmsCategoryModel->Del( intval( $_GET['id'] ) );

Common::Loading( '?mod=cms.category.list' );

?>