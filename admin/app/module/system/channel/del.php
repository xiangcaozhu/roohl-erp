<?php

$id = (int)$_GET['id'];

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterChannelModel->Del($id);

Redirect( '?mod=system.channel' );

?>