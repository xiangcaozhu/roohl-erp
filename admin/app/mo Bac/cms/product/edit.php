<?php

$CmsBlockModel = Core::ImportModel( 'CmsBlock' );
$CmsProductModel = Core::ImportModel( 'CmsProduct' );

$productId = (int)$_GET['id'];
$productInfo = $CmsProductModel->Get( $productId );

if ( !$productInfo )
	Alert( '没有找到产品数据' );

/******** Block ********/
Core::LoadExtra( 'CmsBlock' );
$CmsBlockExtra = new CmsBlockExtra();

if ( !$_POST )
{
	$blockDataList = $CmsProductModel->GetBlockList( $productId );
	$blockDataList = ArrayIndex( $blockDataList, 'config_id' );

	$blockConfigList = $CmsProductModel->GetBlockConfigList();

	$blockList = array();
	foreach ( $blockConfigList as $key => $val )
	{
		$pattern = $CmsBlockExtra->GetExtraPattern( $blockDataList[$val['id']]['content'], $val['pattern_id'] );

		if ( $pattern )
		{
			$pattern['multi_name'] = "[{$val['id']}]";
			$pattern['multi_id'] = "{$val['id']}_";

			$blockList[$key]['html'] = Common::PageCode( 'cms/block/pattern/form.html', $pattern );
			$blockList[$key]['name'] = $val['name'];
			$blockList[$key]['id'] = $val['id'];
			$blockList[$key]['type'] = $pattern['type'];
		}
	}

	$tpl['block_list'] = $blockList;
	$tpl['product'] = $productInfo;

	Common::PageOut( 'cms/product/edit.html', $tpl );
}
else
{
	$blockDataList = $CmsProductModel->GetBlockList( $productId );
	$blockDataList = ArrayIndex( $blockDataList, 'config_id' );

	$blockConfigList = $CmsProductModel->GetBlockConfigList();

	if ( $_POST['block_list'] )
	{
		foreach ( $_POST['block_list'] as $blockIndex => $blockMainList )
		{
			$patternId = $blockConfigList[$blockIndex]['pattern_id'];
			$blockChildList = $_POST['block_child_list'][$blockIndex];

			$blockContent = $CmsBlockExtra->GetSaveContent( $blockMainList, $blockChildList, $patternId );

			$blockContentOld = $CmsBlockExtra->UnPackContent( $blockDataList[$blockIndex]['content'] );

			$CmsBlockExtra->Clean( $blockContentOld, $blockContent, $patternId );

			$data = array();
			$data['pid'] = $productId;
			$data['pattern_id'] = $patternId;
			$data['config_id'] = $blockConfigList[$blockIndex]['id'];
			$data['content'] = $CmsBlockExtra->PackContent( $blockContent );

			$CmsProductModel->ReplaceBlock( $data );
		}
	}

	Common::Loading( "?mod=cms.product.list" );
	exit();
}

?>