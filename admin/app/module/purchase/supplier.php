<?php
/*
@@acc_title="供应商管理 supplier"
*/
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterBrandModel = Core::ImportModel( 'CenterBrand' );


list( $page, $offset, $onePage ) = Common::PageArg( 200 );


$group_man=0;

if( $__UserAuth['user_group']==38 || $__UserAuth['user_group']==15 )
{
$search = array();
$group_man=1;
}
elseif($__UserAuth['user_group']==14)
{
$group_man=1;
$search = array(
                'manage_zj' => $__UserAuth['user_id'],
				);
}
elseif($__UserAuth['user_group']==12)
{
$search = array(
                'manage_id' => 83,
				);
}
else
{
$search = array(
           'manage_id' => $__UserAuth['user_id'],
		   );
}

$search = array();
$group_man=1;

//$search['manage_OK']=1;


$list = $CenterSupplierModel->GetList( $search, $offset, $onePage );
$total = $CenterSupplierModel->GetTotal( $search );


foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$T_brand = '';
	$y_product=explode(',',$val['y_product']);
	if ( is_array($y_product) )
	{
	foreach ( $y_product as $key_y => $val_y )
	{
	$brand_name = $CenterBrandModel->Get($val_y);
	$T_brand = $T_brand .$brand_name['name'].'　' ;
	}
	}
	$list[$key]['brand_name'] = $T_brand;


/*
Core::LoadLib( 'PY.class.php' );
$py = new PY(); 
$data = array();
$data['name_op'] = $py -> str2pyOne($val['name']);
$CenterSupplierModel->Update( $val['id'],$data );
*/

}


$tpl['group_man'] = $group_man;
$tpl['list'] = $list;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );





///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ( $_GET['excel']>0 )
{
	$header = array(
		'ID' => 'id',
		'产品经理' => 'manage_name',
		'公司名称' => 'name',
		'发货方式' => 'key_mode',
		'开户行' => 'accountbank',
		'帐号' => 'account_number',
	);


	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=\"" . DateFormat(time(), 'Y-m-d_H-i-s') . ".xls\"");
	header("Content-Transfer-Encoding:binary");
	echo ExcelXml( $header, $list );
	exit;
}
/////////////////////////////////////////////////////////////////////////////





Common::PageOut( 'supplier/list.html', $tpl );

?>