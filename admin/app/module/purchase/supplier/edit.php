<?php
/*
@@acc_title="编辑"
*/
$id = (int)$_GET['id'];

$CenterSupplierModel = Core::ImportModel('CenterSupplier');
$CenterBrandModel = Core::ImportModel( 'CenterBrand' );
$AdminModel = Core::ImportModel( 'Admin' );



$supplierInfo = $CenterSupplierModel->Get($id);

if( !$supplierInfo )
	Common::Alert( '不存在此ID！' );



global $__UserAuth;
$my_group = $__UserAuth['user_group'];

if( !$_POST )
{
	$tpl = $supplierInfo;
	$tpl['my_group'] = $my_group;
	
    $cp_list = $AdminModel->GetAdministratorListcp_all();
	$tpl['cp_list'] = $cp_list;
	
	


     $brandList = $CenterBrandModel->GetList();
	 $y_product=explode(',',$supplierInfo['y_product']);
	 
	  if ( is_array($y_product) )
	  {
	  foreach ( $brandList as $key => $val )
	 {
      if ( in_array($val['id'],$y_product) )
		 $brandList[$key]['selected'] = 1;
	 }
	 }
	 $tpl['brandList'] = $brandList;




$group_man=0;
if( $__UserAuth['user_group']==38 || $__UserAuth['user_group']==15 )
{
$group_man=1;
}
elseif($__UserAuth['user_group']==14)
{
$group_man=1;
}
else{}

$group_man=1;
$tpl['group_man'] = $group_man;
	
	

	Common::PageOut( 'supplier/edit.html', $tpl );
}
else
{

	if ( $CenterSupplierModel->GetByNameNoId( NoHtml( $_POST['name'] ),$id ) )
	    Common::Alert( '已经存在相同的供货商名称！' );


Core::LoadLib( 'PY.class.php' );
$py = new PY(); 


	$data = array();

	$data['key_mode'] = $_POST['key_mode'];
	$data['name'] = $_POST['name'];
	$data['y_product'] = implode(',',$_POST['y_product']);
	$data['scope'] = GetPY($_POST['name']);
	$data['linkman'] = $_POST['linkman'];
	$data['phone'] = $_POST['phone'];
	$data['company_address'] = $_POST['company_address'];
	$data['company_phone'] = $_POST['company_phone'];
	$data['company_person'] = $_POST['company_person'];
	$data['company_nature'] = $_POST['company_nature'];
	$data['registered_capital'] = $_POST['registered_capital'];
	$data['tax'] = $_POST['tax'];
	$data['account_number'] = $_POST['account_number'];
	$data['accountbank'] = $_POST['accountbank'];
	$data['opennumber'] = $_POST['opennumber'];
	$data['comment'] = $_POST['comment'];
	$data['manage_id'] = $_POST['manage_id'];
	$T_name = $AdminModel->GetAdministrator($_POST['manage_id']);
	$data['manage_name'] = $T_name['user_real_name'];
	$data['update_time'] = time();

	$data['name_op'] = $py -> str2pyOne($data['name']);

	$CenterSupplierModel->Update( $id, $data );

	Redirect( '?mod=purchase.supplier' );
}

?>