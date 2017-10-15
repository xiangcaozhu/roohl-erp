<?php

$id = (int)$_GET['id'];

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

$channelInfo = $CenterChannelModel->Get($id);

if( !$channelInfo )
	Common::Alert( '不存在此ID！' );

if( !$_POST )
{
	$tpl = $channelInfo;

	Common::PageOut( 'system/channel/edit.html', $tpl );
}
else
{
	$data = array();

	$data['name'] = $_POST['name'];

	$CenterChannelModel->Update( $id, $data );

	Redirect( '?mod=system.channel' );
}

?>