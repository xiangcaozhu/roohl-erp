<?php

$CmsBlockModel = Core::ImportModel( 'CmsBlock' );
$CmsBlockCategoryModel = Core::ImportModel( 'CmsBlockCategory' );


$categoryId = (int)$_GET['cid'];

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$list = $CmsBlockModel->GetList( $categoryId, $offset, $onePage );
$total = $CmsBlockModel->GetTotal( $categoryId );

$patternList = ArrayIndex( $CmsBlockModel->GetPatternList(), 'id' );

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['update_time'] = DateFormat( $val['update_time'] );

	$list[$key]['pattern'] = $patternList[$val['pattern_id']];
}


$tpl['tree_script'] = PHP2JSON( $CmsBlockCategoryModel->GetExtTree() );

$tpl['list'] = $list;
$tpl['total'] = $total;
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

Common::PageOut( 'cms/block/list.html', $tpl );

?>