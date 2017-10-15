<?php
/*
@@acc_title="供应商管理账目 supplier_money"
*/
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

$onePage=99999;
list( $page, $offset, $onePage ) = Common::PageArg( 9999 );

$group_man=0;

//if( $__UserAuth['user_group']==38 || $__UserAuth['user_group']==15 || $__UserAuth['user_group']==16 )
//{
$search = array();
$group_man=1;
/*
}
elseif($__UserAuth['user_group']==14)
{
$group_man=1;
$search = array(
                'manage_zj' => $__UserAuth['user_id'],
				);
}
else
{
$search = array(
           'manage_id' => $__UserAuth['user_id'],
		   );
}
*/

$list = $CenterSupplierModel->GetList( $search, $offset, $onePage );
$total = $CenterSupplierModel->GetTotal( $search );

/*
$listasd = $CenterPurchaseModel->GetSupplierMoneyaa();

foreach ( $listasd as $a => $b )
{
echo $b['id'].'<br>';
}
foreach ( $listasd as $a => $b )
{
echo $b['all_money'].'<br>';
}
*/

foreach ( $list as $key => $val )
{
$list[$key]['supplier_money'] = $CenterPurchaseModel->GetSupplierMoney(  $val['id'] );
$list[$key]['supplier_invoice'] = $CenterSupplierModel->GetInvoiceTotal(  $val['id'] );
$list[$key]['supplier_invoice_no'] = $list[$key]['supplier_money']['pay_money']['pay_all_money']-$list[$key]['supplier_invoice'];

}
//$invoiceList = $CenterSupplierModel->GetInvoiceList($id);supplierinfo.supplier_money.pay_money.pay_all_money

$tpl['group_man'] = $group_man;
$tpl['list'] = $list;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

Common::PageOut( 'supplier/supplier_money.html', $tpl );

?>