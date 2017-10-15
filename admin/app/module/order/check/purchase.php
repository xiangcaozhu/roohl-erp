<?php
/*
@@acc_title="产品经理确认 purchase"
*/

$manage_id=0;
if($__UserAuth['user_id']==83 || $__UserAuth['user_id']==101){$manage_id = 83;}
if($__UserAuth['user_id']==63 || $__UserAuth['user_id']==113){$manage_id = 63;}
if($__UserAuth['user_id']==97){$manage_id = 97;}
if ( strlen( $_GET['service_check'] ) == 0 )
{
	$staticSearch = array();
	$staticSearch['service_check'] = 0;
	$_GET['service_check'] = 0;
}

//if($manage_id>0){$staticSearch['manage_id'] = $manage_id;}

$onePage=1;
$ggop = 1;
if((int)$_GET['purchase_check']<1){
  $onePage=5;
  $ggop = 0;
}

include( Core::BLock( 'order.list_212' ) );



$tpl['C_UID'] = (int)$__UserAuth['user_id'];

/*

$temp_group = $__UserAuth['user_group'];

$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );

foreach ( $list as $key => $val )
{
	$list[$key]['is_my'] = 1;
    if( ($temp_group!=38) && ($temp_group!=14) && ($temp_group!=15)  && ($temp_group!=42) )
    {
	foreach ( $list[$key]['list'] as $key_p => $val_p )
	{
	$supplierInfo  = $CenterSupplierModel->Get( (int)$list[$key]['list'][$key_p]['productInfo']['supplier_now'] );
	
	$t_user = (int)$__UserAuth['user_id'];
	if($temp_group==12){
	$t_user = $CenterSupplierModel->GetMyJl((int)$__UserAuth['user_id']);
	}
	
	if( $t_user!= (int)$supplierInfo['manage_id'] )
	$list[$key]['is_my'] = 0;
	}
	}
}
*/




$tpl['list'] = $list;
$tpl['channel_list'] = $channelList;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );
$tpl['page_bar_a'] = Common::PageBar_a( $total, $onePage, $page );
$tpl['page_bar_b'] = Common::PageBar_b( $total, $onePage, $page );
//if($onePage>999)
//$tpl['onePage'] = '';
//else
$tpl['onePage'] = '，每页 <b>'.$onePage.'</b> 条记录';

Common::PageOut( 'order/check/purchase.html', $tpl );

?>