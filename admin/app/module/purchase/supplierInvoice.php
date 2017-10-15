<?php
/*
@@acc_title="供货商发票管理 supplierInvoice"
*/
$CenterSupplierModel = Core::ImportModel('CenterSupplier');
$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

if ( $_POST )
{
	$data = array();
	
	//$data['user_group'] = @implode( ',', $_POST['user_group'] );
	$data['add_time'] = time();
	$data['user_id'] = $__UserAuth['user_id'];
	$data['user_name'] = $__UserAuth['user_real_name'];
	$data['sn'] = $_POST['sn'];
	$data['supplier_id'] = $_POST['supplier_id'] ;
	$data['price'] = $_POST['price'] ;
	$data['purchase_id'] = implode( ',', $_POST['purchase_list_Id'] );


	if ( !$_POST['sn'] || !$_POST['price'] )
		Common::Alert( '请完整的填写资料' );
	if ( $CenterSupplierModel->GetInvoice( $_POST['sn'] ) )
		Common::Alert( '此发票号已经存在了' );


	$CenterSupplierModel->AddInvoice( $data );



$purchaseList = $_POST['purchase_list_Id'] ;
foreach ( $purchaseList as $key => $val )
{
$datas = array();
$datas['invoice_now'] = 1;
$CenterPurchaseModel->Update( $val,$datas );

}



Redirect( "?mod=purchase.supplierInvoice&id={$_POST['supplier_id']}" );	
}
else
{
$id = (int)$_GET['id'];
$supplierInfo = $CenterSupplierModel->Get($id);

$invoiceList = $CenterSupplierModel->GetInvoiceList($id);

$tpl['list'] = $invoiceList;
$tpl['supplierInfo'] = $supplierInfo;

 
 
$search = array();
$search['supplier_id']=$id;
$search['invoice_now']=0;
$search['status']=5;
$search['pay_status']=1;
$PurchaseList = $CenterPurchaseModel->GetList(  $search, $offset, $onePage );

$totalMoney=0;
foreach ( $PurchaseList as $key => $val )
{
$totalMoney+=$val['all_money'];
}



$tpl['purchaseList'] = $PurchaseList;
$tpl['totalMoney'] = $totalMoney;
Common::PageOut( 'supplier/supplier_invoice.html', $tpl );
}

//invoice_now

?>