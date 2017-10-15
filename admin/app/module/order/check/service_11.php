<?php
/*
@@acc_title="客服确认_1 service_1"
*/

$onePage=1;
if((int)$_GET['service_check']<1)
  $onePage=3;


$staticSearch = array();
$staticSearch['wait_service'] = 1;

include( Core::BLock( 'order.list_211' ) );

$tpl['C_UID'] = (int)$__UserAuth['user_id'];


/*
foreach ( $list as $key => $val )
{
      $list[$key]['frontChange']=0;
	  $list[$key]['NoEdit']=0;
	  foreach ( $val['list'] as $key_a => $val_a )
      {
	  	 if($val_a['price']>0){
		  $list[$key]['coupon_price']=$val_a['price']*$val_a['quantity'];
		  if((int)$val_a['coupon_price']>0 )
	      $list[$key]['coupon_price']=$val_a['price']*$val_a['quantity']-$val_a['coupon_price'];
		  }

	  $AttributeID = $CenterBuyAttributeExtra->ParseSkuAttribute_toID( $val_a['sku_info']['content'] );
	  $list[$key]['list'][$key_a]['service'] = (int)$AttributeID;
	  if((int)$AttributeID>0)
	      $list[$key]['frontChange']=1;
	  
	  if ( $val_a['lock_quantity'] > 0 || $val_a['purchase_quantity'] > 0 || $val_a['delivery_quantity'] > 0 )
	      $list[$key]['NoEdit']=1;
	      
	  
	  
	  
      }
}
*/



$tpl['user_call'] = $__UserAuth['user_call'];
$tpl['list'] = $list;
$tpl['channel_list'] = $channelList;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );
$tpl['page_bar_a'] = Common::PageBar_a( $total, $onePage, $page );
$tpl['page_bar_b'] = Common::PageBar_b( $total, $onePage, $page );
if($onePage>999)
$tpl['onePage'] = '';
else
$tpl['onePage'] = '，每页 <b>'.$onePage.'</b> 条记录';

Common::PageOut( 'order/check/service_1.html', $tpl );

?>