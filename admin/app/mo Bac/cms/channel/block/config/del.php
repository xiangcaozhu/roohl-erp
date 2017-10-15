<?php

$CmsBlockModel = Core::ImportModel( 'CmsBlock' );
$CmsChannelModel = Core::ImportModel( 'CmsChannel' );

$id = (int)$_GET['id'];

$info = $CmsChannelModel->GetBlockConfig( $id );

if ( !$info )
	Alert( '没有找到相关数据' );

$CmsChannelModel->DelBlockConfig( $id );

Core::LoadExtra( 'CmsBlock' );
$CmsBlockExtra = new CmsBlockExtra();

$blockList = $CmsChannelModel->GetBlockListByConfig( $id );

foreach ( $blockList as $val )
{
	$blockContentOld = $CmsBlockExtra->UnPackContent( $val['content'] );
	$CmsBlockExtra->Clean( $blockContentOld, array(), $info['pattern_id'] );

	$CmsChannelModel->DelBlock( $val['cid'], $val['config_id'] );
}

Common::Loading( '?mod=product.channel.block.config.list' );

?>