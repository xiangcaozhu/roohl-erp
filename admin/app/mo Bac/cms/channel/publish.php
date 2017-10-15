<?php

include( Core::Block( 'cms.site' ) );

Core::LoadClass( 'CmsContentPublish' );

$CmsContentPublish = new CmsContentPublish();

$status = $CmsContentPublish->PublishChannel( $_GET['id'] );

Common::Loading( '?mod=cms.channel.list&site=' . $_GET['site'] );

?>