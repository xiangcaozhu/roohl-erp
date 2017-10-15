<?php

$staticSearch = array();
$staticSearch['collate_status'] = 0;

include( Core::BLock( 'order.list' ) );


$tpl['list'] = $list;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

$tpl['list'] = $list;

Common::PageOut( 'order/import/collate.html', $tpl );

?>