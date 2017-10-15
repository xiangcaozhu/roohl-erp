<?php
/*
@@acc_freet
@@acc_title="待开发票订单 print_invoice"
$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );
$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );
*/



//$staticSearch = array();
//$staticSearch['wait_invoice'] = 1;

include( Core::BLock( 'order.list60' ) );


foreach ( $list as $key => $val )
{
	  foreach ( $list[$key]['list'] as $key_a => $val_a )
      {
	  $list[$key]['list'][$key_a]['okMoney'] =  $val_a['total_price']- $val_a['coupon_price'];
	  
	  //if($list[$key]['channel_id'] != 60 )
	 // {
	//  $list[$key]['list'][$key_a]['okMoney'] =  $val_a['total_price'];
	//  $list[$key]['list'][$key_a]['coupon_price'] =  0;
	//  }
	  
	  
	  
      }
}


$tpl['list'] = $list;

//$tpl['channel_list'] = $channelList;
$tpl['user_real_name'] = $__UserAuth['user_real_name'];;
//$tpl['total'] = $total;
//$tpl['page_num'] = ceil( $total / $onePage );
//$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

Common::PageOut( 'order/print_invoice.html', $tpl, '', '' );

?>