<?php

include( Core::Block( 'cms.site' ) );

$CmsImageModel = Core::ImportModel( 'CmsImage' );
$CmsImageCategoryModel = Core::ImportModel( 'CmsImageCategory' );

$CmsImageCategoryModel->SetSiteId( $siteId );

$CmsImageExtra = Core::ImportExtra( 'CmsImage' );

$categoryId = (int)$_GET['id'];

$search = array();
$search['cid'] = $categoryId;
$search['site_id'] = $siteId;

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

$imageList		= $CmsImageModel->GetList( $search, $offset, $onePage );
$total		= $CmsImageModel->GetTotal( $search );


foreach ( $imageList as $key => $val )
{
	$imageList[$key] = $CmsImageExtra->ExplainOne( $val );

	$imageList[$key]['add_time'] = DateFormat( $val['add_time'] );
	$imageList[$key]['update_time'] = DateFormat( $val['update_time'] );
}

$tpl['image_list'] = $imageList;
$tpl['total'] = $total;

$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

$tpl['page'] = $page;
$tpl['page_num'] = ceil( $total / $onePage );

Common::PageOut( 'cms/media/image/list.html', $tpl );

?>