<?php

$ProductSubmitModel = Core::ImportModel( 'ProductSubmit' );

list( $page, $offset, $onePage ) = Common::PageArg( 20 );

if ( $_GET['excel'] )
{
	$offset = 0;
	$onePage = 0;
}

$search = array(
	'target_id' => $_GET['target_id'],
	'begin_time' => strtotime( $_GET['begin_date'] ),
	'end_time' => strtotime( $_GET['end_date'] ),
);

$list = $ProductSubmitModel->GetList( $search, $offset, $onePage );
$total = $ProductSubmitModel->GetTotal( $search );


foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );

	$list[$key]['img_l'] = "L{$val['target_id']}.jpg";
	$list[$key]['img_s'] = "S{$val['target_id']}.jpg";
}

if ( $_GET['excel'] )
{
	$excelList = $list;

	$header = array(
		'产品编号' => 'target_id',
		'供货商编号' => '',
		'分类编号' => 'target_category_id',
		'名称' => 'name',
		'简单描述' => 'summary',
		'详细描述' => 'description',
		'小图片名称' => 'img_s',
		'大图片名称' => 'img_l',
		'给银行的成本' => 'supply_price',
		'提报期次' => 'submit_issue',
		'销售价格' => 'price',
		'费率' => 'payout_rate',
		'创建日期' => 'add_time',
	);


	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=\"" . date('Y-m-d_H-i-s') . ".xls\"");
	header("Content-Transfer-Encoding:binary");
	echo ExcelXml( $header, $excelList, 'id', array( 'id', 'add_time', 'supplier_name', 'type_name', 'status_name', 'product_type_name', 'payment_type_name', 'comment' ) );
	exit;
}

$tpl['list'] = $list;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

Common::PageOut( 'product/submit/list.html', $tpl, $parentTpl );

?>