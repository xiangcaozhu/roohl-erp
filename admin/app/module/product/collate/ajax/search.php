<?php

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$ProductCollate = Core::ImportModel( 'ProductCollate' );

$channelId = intval( $_GET['channel_id'] );
$keyWord = trim( $_POST['key'] );

$list = $ProductCollate->Search( $keyWord, $channelId );

echo PHP2JSON( $list );

exit();

?>