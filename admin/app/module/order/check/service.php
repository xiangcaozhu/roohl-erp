<?php
/*
@@acc_title="客服确认 service"
*/
$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );
$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );



$staticSearch = array();
$staticSearch['wait_service'] = 1;

include( Core::BLock( 'order.list' ) );



foreach ( $list as $key => $val )
{
      $list[$key]['frontChange']=0;
	  $list[$key]['NoEdit']=0;
	  foreach ( $val['list'] as $key_a => $val_a )
      {
	  $AttributeID = $CenterBuyAttributeExtra->ParseSkuAttribute_toID( $val_a['sku_info']['content'] );
	  $list[$key]['list'][$key_a]['service'] = (int)$AttributeID;
	  if((int)$AttributeID>0)
	      $list[$key]['frontChange']=1;
	  
	  if ( $val_a['lock_quantity'] > 0 || $val_a['purchase_quantity'] > 0 || $val_a['delivery_quantity'] > 0 )
	      $list[$key]['NoEdit']=1;
	      
	  
	  
	  
      }
}

$tpl['list'] = $list;
$tpl['channel_list'] = $channelList;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

Common::PageOut( 'order/check/service.html', $tpl );

?>