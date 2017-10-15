<?php
/*
@@acc_title="列表 product.brand.list"
*/
$CenterBrandModel = Core::ImportModel( 'CenterBrand' );

list( $page, $offset, $onePage ) = Common::PageArg();

$brandName = $_GET['brandName'];

$list = $CenterBrandModel->GetList($brandName, $offset, $onePage);
$total = $CenterBrandModel->GetTotal( $brandName );

$savePath = Core::GetConfig( 'upload_brand_logo' );
foreach ( $list as $key => $val )
{
if(!$list[$key]['brand_logo'])
$list[$key]['brand_logo'] = $savePath.'no.jpg';
}

$tpl['list'] = $list;

$tpl['brandName'] = $brandName;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );
$tpl['page_bars'] = Common::PageBars( $total, $onePage, $page );

// $CenterBrandModel->CreatBrandArray();

Common::PageOut( 'product/brand/list.html', $tpl );

?>