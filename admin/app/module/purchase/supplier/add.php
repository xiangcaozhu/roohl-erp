<?php
/*
@@acc_title="添加"
*/
	if( !$_POST )
	{
		Common::PageOut( 'supplier/add.html', $tpl );
	}
	else
	{
		$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );

	if ( $CenterSupplierModel->GetByName( NoHtml( $_POST['name'] ) ) )
	    Common::Alert( '已经存在相同的供货商名称！' );

Core::LoadLib( 'PY.class.php' );
$py = new PY(); 

		$data = array();
		$data['name'] = $_POST['name'];
		$data['y_product'] = $_POST['y_product'];
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
		$data['add_time'] = time();
		$data['update_time'] = time();
		$data['user_id'] = $__UserAuth['user_id'];
		$data['name_op'] = $py -> str2pyOne($data['name']);

		$supplierInfo = $CenterSupplierModel->Add($data);

		if( !$supplierInfo )
			Common::Alert('保存失败！请联系管理员！');
		else
			Redirect('?mod=purchase.supplier');
	}
?>