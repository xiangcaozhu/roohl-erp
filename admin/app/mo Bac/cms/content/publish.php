<?php

include( Core::Block( 'cms.site' ) );

Core::LoadClass( 'CmsContentPublish' );

$CmsContentPublish = new CmsContentPublish();

$status = $CmsContentPublish->PublishDetail( $_GET['content_id'] );

Common::Loading();

?>