<?php
/*
@@acc_title="删除"
*/
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );

if ( $CenterProductModel->GetList( array( 'category_id' => intval( $_GET['id'] ), 'on_sell' => -1 ), 0, 1 ) )
	Alert( '分类下面存在产品,不允许删除!' );

if ( $CenterCategoryModel->GetOneChildList( intval( $_GET['id'] ) ) )
	Alert( '分类下面存在子分类,不允许删除!' );

$CenterCategoryModel->Del( intval( $_GET['id'] ) );

Common::Loading( '?mod=product.category' );

?>