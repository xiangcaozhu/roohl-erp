<?php
/*
@@acc_title="创建支出单 nopay_creatS"
*/

if ( $_GET['supplierId']==0 )
{
header( "refresh:0;url=?mod=purchase.nopay_creat" );
}
else
{

$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterPurchaseExtra = Core::ImportExtra( 'CenterPurchase' );

$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

$supplierList = $CenterSupplierModel->GetList();
$warehouseList = $CenterWarehouseModel->GetList();
$purchaseTypeList = Core::GetConfig( 'purchase_type' );
$purchaseStatusList = Core::GetConfig( 'purchase_status' );
$purchaseReceiveStatusList = Core::GetConfig( 'purchase_receive_status' );
$purchaseProductTypeList = Core::GetConfig( 'purchase_product_type' );
$purchasePaymentTypeList = Core::GetConfig( 'purchase_payment_type' );

list( $page, $offset, $onePage ) = Common::PageArg( 9999 );
global $__UserAuth;
global $__Config;

$search = array();
/*
switch ( $__UserAuth['user_group'] )
		{
			case 12:
			    $search = array('user_id' =>  $__UserAuth['user_id'] );
			break;
			case 13:
			    $search = array('sign_top_jl' =>  $__UserAuth['user_id'] );
			break;
			case 14:
			    //$search = array('sign_top_zj' =>  $__UserAuth['user_id'] );
			break;
			case 15:
			   // $search = array( 'status' => 3 );
			break;
			case 16:
			   // $search = array( 'status' => 3 );
			break;
			case 38:
			   // $search = array( 'status' => 3 );
			break;
			default:
			    $search = array('user_id' =>  -1 );
			break;
}
*/
$search['pay_status']=-1;
//$search['payment_type']= (int)$_GET['paymentType'];

$search['ready_pay'] = 0;



if((int)$_GET['supplierId'] > 0 )
$search['supplier_id'] = (int)$_GET['supplierId'];


//$search = array('status' => 2);


$list = $CenterPurchaseModel->GetList(  $search, $offset, $onePage );
$total = $CenterPurchaseModel->GetTotal( $search );
Core::LoadClass( 'WorkFlow' );
$WorkFlow = new WorkFlow( 'Purchase' );


$AdminModel = Core::ImportModel( 'Admin' );


$all_money_all=0;
foreach ( $list as $key => $val )
{
	

	
	
	$all_money_all+=$val['all_money'];
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['plan_arrive_time'] = DateFormat( $val['plan_arrive_time'] , 'Y-m-d' );
	$list[$key]['supplier_name'] = $supplierList[$val['supplier_id']]['name'];
	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];
	$list[$key]['type_name'] = $purchaseTypeList[$val['type']];
	$list[$key]['status_name'] = $purchaseStatusList[$val['status']];
	$list[$key]['receive_status_name'] = $purchaseReceiveStatusList[$val['receive_status']];
	$list[$key]['product_type_name'] = $purchaseProductTypeList[$val['product_type']];
	$list[$key]['payment_type_name'] = $purchasePaymentTypeList[$val['payment_type']];
	
	
	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $val['user_id'] );
	$list[$key]['user_name_zh'] = $AdminArray['user_real_name'] ;
	

	$WorkFlow->SetInfo( $val );
	$list[$key]['workflow_status_name'] = $WorkFlow->GetStatus();
	$list[$key]['workflow_allow_do'] = $WorkFlow->AllowDo();


    $sign_jl = $AdminModel->GetAdministrator( $val['sign_top_jl'] );
	$sign_zj = $AdminModel->GetAdministrator( $val['sign_top_zj'] );
	$sign_fz = $AdminModel->GetAdministratorListcp_2();
	
	
	
	if($val['user_group']==12)
	$list[$key]['user_grouping'] = "产品助理";
	elseif($val['user_group']==13)
	$list[$key]['user_grouping'] = "产品经理";
	elseif($val['user_group']==14)
	$list[$key]['user_grouping'] = "产品总监";
	elseif($val['user_group']==15)
	$list[$key]['user_grouping'] = "产品副总";
	elseif($val['user_group']==16)
	$list[$key]['user_grouping'] = "财务";
	else
	$list[$key]['user_grouping'] = "其他人员";



if($val['user_id'] == $__UserAuth['user_id'])
  {
    $list[$key]['del_bottom'] = '<a href="?mod=purchase.del&id='.$val['id'].'&go=1" onclick="return confirm(\'确定删除吗?\');">删除</a> / <a href="?mod=purchase.edit&id='.$val['id'].'&checking=yes&go=1">修改</a>';
    $list[$key]['print_bottom'] = '<td width="80" align="center"><a href="?mod=purchase.print&id='.$val['id'].'" target="_blank">打印采购单</a></td>';
	
	}

if($val['user_id'] == $__UserAuth['user_id'] && $val['pay_status'] > 0 )
    $list[$key]['del_bottom'] = '<a href="?mod=purchase.new.Donext&id='.$val['id'].'" onclick="return confirm(\'所有执行操作已完成，确认提交到下个工作流吗?\');">确认完成</a>';

if($val['user_id'] == $__UserAuth['user_id'] && $val['pay_status'] < 0 )
    $list[$key]['del_bottom'] = "";


if ( $val['close_group'] == 16 && $val['user_id'] == $__UserAuth['user_id'] )
    $list[$key]['del_bottom'] = '<a href="?mod=purchase.del&id='.$val['id'].'&go=1" onclick="return confirm(\'确定删除吗?\');">删除</a> / <a href="?mod=purchase.edit&id='.$val['id'].'&checking=yes&go=1">修改</a>';

	
////////////////////////////////////////////////////////产品经理
$list[$key]['sign_pro_mg'] = "";
if ( $val['sign_pro_mg']<0 )
	$list[$key]['sign_pro_mg'] = ' <font>→ 待</font><font title="级别：产品经理">'.$sign_jl['user_real_name'].'</font><font>审核</font>';

if ( $__UserAuth['user_group'] == 13 && $val['sign_pro_mg'] < 0 )
	$list[$key]['sign_pro_mg'] = ' <font>→ [ 产品经理审核：</font><a href="?mod=purchase.check&id='.$val['id'].'&checking=yes&go=1" onclick="return confirm(\'确定要审核通过吗?\');">通过</a> / <a style="" onclick="ActionLog('.$val['id'].', 1, 1);">拒绝</a> <font>]</font>';

if ( $val['sign_pro_mg']>0 )
	$list[$key]['sign_pro_mg'] = ' <font>→ [ </font><strong title="级别：产品经理">'.$val['sign_pro_mg_name'].'</strong><b>√</b> <font>]</font>';

if ( $val['close_group'] == 13 )
	$list[$key]['sign_pro_mg'] = ' <font>→ [ </font><strong title="级别：产品经理">'.$val['close_name'].'</strong><em>拒绝×</em> <font>]</font>';


if($val['user_group']>=14)
    $list[$key]['sign_pro_mg'] = "";


/*
	if ( $val['sign_pro_mg'] >0 )
	$list[$key]['sign_pro_mg'] = ' <font>→ [ 产品经理:</font><strong>'.$val['sign_pro_mg_name'].'</strong><b>√</b> <font>]</font>';
	elseif ( $__UserAuth['user_group'] == 13 )
	$list[$key]['sign_pro_mg'] = ' <font>→ [ 产品经理:</font><a href="?mod=purchase.check&id='.$val['id'].'&checking=yes&go=1" onclick="return confirm(\'确定要审核通过吗?\');">审核通过</a> <font>]</font>';
	elseif ( !$val['sign_pro_mg'] )
	$list[$key]['sign_pro_mg'] = ' <font>→ 待产品经理</font><strong>'.$sign_jl['user_real_name'].'</strong><font>审核</font>';
    else
	$list[$key]['sign_pro_mg'] = ' <font>→ [ 产品经理</font><strong>那你说</strong><font>无需审核 ]</font>';
*/

////////////////////////////////////////////////////产品总监
$list[$key]['sign_ope_mj'] ="";
if ( $val['sign_ope_mj'] < 0 )
	$list[$key]['sign_ope_mj'] = ' <font>→ 待<font title="级别：产品总监">'.$sign_zj['user_real_name'].'</font>审核</font>';

if ( $__UserAuth['user_group'] == 14 && $val['sign_ope_mj'] < 0 && $val['sign_pro_mg']>0 )
	$list[$key]['sign_ope_mj'] = ' <font>→ [ 产品总监审核：</font><a href="?mod=purchase.check&id='.$val['id'].'&checking=yes&go=1" onclick="return confirm(\'确定要审核通过吗?\');">通过</a> / <a style="" onclick="ActionLog('.$val['id'].', 1, 1);">拒绝</a> <font>]</font>';

if ( $val['sign_ope_mj'] > 0 )
	$list[$key]['sign_ope_mj'] = ' <font>→ [ </font><strong title="级别：产品总监">'.$val['sign_ope_mj_name'].'</strong><b>√</b> <font>]</font>';

if ( $val['close_group'] == 14 )
	$list[$key]['sign_ope_mj'] = ' <font>→ [ </font><strong title="级别：产品总监">'.$val['close_name'].'</strong><em>拒绝×</em> <font>]</font>';


if($val['user_group']==15)
    $list[$key]['sign_ope_mj'] = "";

/*
	if ( $val['sign_ope_mj'] >0 )
	$list[$key]['sign_ope_mj'] = ' <font>→ [ 产品总监:</font><strong>'.$val['sign_ope_mj_name'].'</strong><b>√</b> <font>]</font>';
	elseif ( $__UserAuth['user_group'] == 14 && $val['sign_ope_mj'] < 0 && $val['sign_pro_mg'] >=0 )
	$list[$key]['sign_ope_mj'] = ' <font>→ [ 产品总监:</font><a href="?mod=purchase.check&id='.$val['id'].'&checking=yes&go=1" onclick="return confirm(\'确定要审核通过吗?\');">审核通过</a> <font>]</font>';
	elseif ( $val['sign_ope_mj'] < 0 )
	$list[$key]['sign_ope_mj'] = ' <font>→ 待产品总监<strong>'.$sign_zj['user_real_name'].'</strong>审核</font>';
	else
	$list[$key]['sign_ope_mj'] = '';
*/

////////////////////////////////////////////////////产品副总
$list[$key]['sign_ope_vc'] ="";
if ( $val['sign_ope_vc'] < 0 )
     $list[$key]['sign_ope_vc'] = ' <font>→ 待<font title="级别：产品副总">'.$sign_fz[0]['user_real_name'].'</font>审核</font>';

if ( $__UserAuth['user_group'] == 15 && $val['sign_ope_vc'] < 0 && $val['sign_ope_mj'] >=0 )
     $list[$key]['sign_ope_vc'] = ' <font>→ [ 产品副总审核：</font><a href="?mod=purchase.check&id='.$val['id'].'&checking=yes&go=1" onclick="return confirm(\'确定要审核通过吗?\');">通过</a> / <a style="" onclick="ActionLog('.$val['id'].', 1, 1);">拒绝</a> <font>]</font>';

if ( $val['close_group'] == 15 )
	$list[$key]['sign_ope_vc'] = ' <font>→ [ </font><strong title="级别：产品副总">'.$val['close_name'].'</strong><em>拒绝×</em> <font>]</font>';


/*
	if ( $val['sign_ope_vc'] >0 )
	$list[$key]['sign_ope_vc'] = ' <font>→ [ 产品副总:</font>'.$val['sign_ope_vc_name'].'<b>√</b> <font>]</font>';
	elseif ( $__UserAuth['user_group'] == 15 && $val['sign_ope_vc'] < 0 && $val['sign_ope_mj'] >0 )
	$list[$key]['sign_ope_vc'] = ' <font>→ [ 产品副总:</font><a href="?mod=purchase.check&id='.$val['id'].'&checking=yes&go=1" onclick="return confirm(\'确定要审核通过吗?\');">审核通过</a> <font>]</font>';
	elseif ( $val['sign_ope_vc'] < 0 )
	$list[$key]['sign_ope_vc'] = ' <font>→ 待产品副总<strong>'.$sign_fz[0]['user_real_name'].'</strong>审核</font>';
	else
	$list[$key]['sign_ope_vc'] = '';
*/
////////////////////////////////////////////////////pay_lock_user

if ( $val['is_edit'] ==0 )
{


if ( $val['pay_status'] ==0 )
	$list[$key]['pay_lock_user'] = ' <font>→ 待<font>财务审核</font></font>';
	
if ( $val['pay_status'] ==-1 )
	$list[$key]['pay_lock_user'] = ' <font>→ [ 财务已审核：</font><strong>'.$val['pay_lock_user_name'].'</strong><b>≌</b> <font>]</font>';

if ( $val['pay_status'] ==1 )
	$list[$key]['pay_lock_user'] = ' <font>→ [ 财务审核通过：</font><strong>'.$val['pay_lock_user_name'].'</strong><b>√</b> <font>]</font>';

if ( $__UserAuth['user_group'] == 16 && $val['pay_status'] == 0 && $val['workflow_status']==5 )
     $list[$key]['pay_lock_user'] = ' <font>→ [ 财务审核：</font><a href="?mod=purchase.new.payup&id='.$val['id'].'&pay_status=-1" onclick="return confirm(\'确定要接受吗?\');">接受审核</a> <font>]</font>';


////////////////////////////////////////////////////pay_lock_user

	$list[$key]['pay_user'] = ' <font>→ 待<font>财务付款</font></font>';
	

if ( $val['pay_status'] ==1 )
	$list[$key]['pay_user'] = ' <font>→ [ 已付款：</font><strong>'.$val['pay_user_name'].'</strong><b>√</b> <font>]</font>';

if ( $__UserAuth['user_group'] == 16 && $val['pay_status'] == -1 )
     $list[$key]['pay_user'] = ' <font>→ [ </font><a href="?mod=purchase.new.payup&id='.$val['id'].'&pay_status=1" onclick="return confirm(\'确定付款已经完成吗?\');">付款完成</a> <font>]</font>';



if ( $val['close_group'] == 16 )
    {
	$list[$key]['pay_user'] = ' <font>→ [ 财务拒绝：</font><strong>'.$val['close_name'].'</strong><em>×</em> <font>]</font>';
	$list[$key]['pay_lock_user'] ="";
	}



}
else
{

if( $val['user_id'] == $__UserAuth['user_id'] )
	$list[$key]['pay_user'] = ' <font>→ [ 采购单修改中</font>  / <a href="?mod=purchase.new.recall&id='.$val['id'].'" onclick="return confirm(\'确定重新提报吗?\');">重新提报</a> <font>]</font>';
else
	$list[$key]['pay_user'] = ' <font>→ [ 采购单修改中</font> <font>]</font>';

}

//$list[$key]['re_bottom'] = "";
//if($val['close_group'] > 0 && $val['user_id'] == $__UserAuth['user_id'] )
  //  $list[$key]['re_bottom'] = ' / <a href="?mod=purchase.new.recall&id='.$val['id'].'" onclick="return confirm(\'确定重新提报吗?\');">重新提报</a>';

//if($val['close_group'] < 0 && $val['user_id'] == $__UserAuth['user_id'] )
  //  $list[$key]['re_bottom'] = ' / <a href="?mod=purchase.new.recall&id='.$val['id'].'" onclick="return confirm(\'确定重新提报吗?\');">重新提报</a>';





	
////////////////////////////////////////////////////
	$purchaseProductList = $CenterPurchaseModel->GetProductList( $val['id'] );
    $purchaseProductList = $CenterPurchaseExtra->ExplainProduct( $purchaseProductList );
	     
		 foreach ( $purchaseProductList as $key_p => $val_p )
		 {
		 $purchaseOrderList = $CenterPurchaseModel->GetOrderListByPurchase_20( $val_p['id'],$val['id'] );
		 $purchaseProductList[$key_p]['orderList'] = $purchaseOrderList;
		 
		 }
	
    $list[$key]['purchaseProductList'] = $purchaseProductList;
	
	
	
	
	


}

//$tpl['warehouse_list'] = $warehouseList;
//$tpl['supplier_list'] = $supplierList;

$tpl['list'] = $list;
$tpl['all_money_all'] = FormatMoney($all_money_all);
//$tpl['page'] = $page;
//$tpl['total'] = $total;
//$tpl['page_num'] = ceil( $total / $onePage );
//$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

if( $__UserAuth['user_group']==38 || $__UserAuth['user_group']==15 || $__UserAuth['user_group']==16 )
{
$search_1 = array();
}
elseif($__UserAuth['user_group']==14)
{
$search_1 = array('manage_zj' => $__UserAuth['user_id'],);
}
else
{
$search_1 = array('manage_id' => $__UserAuth['user_id'],);
}
$search_1 = array();
$tpl['Supplier_list']  = $CenterSupplierModel->GetList( $search_1 );


Common::PageOut( 'purchase/nopay_creatS.html', $tpl );
}
?>