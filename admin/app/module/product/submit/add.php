<?php

$ProductSubmitModel = Core::ImportModel( 'ProductSubmit' );


if ( !$_POST )
{
	Common::PageOut( 'product/submit/add.html', $tpl, $parentTpl );
}
else
{
	$targetId = trim( $_POST['target_id'] );

	if ( !$targetId )
		exit( '产品编号不能为空' );

	//if ( $ProductSubmitModel->GetUnique( $channelId, $targetId ) )
	//	exit( '已经存在相同的记录了' );
	
	$data = array();
	$data['target_id'] = $targetId;
	$data['target_category_id'] = trim( $_POST['target_category_id'] );
	$data['supply_type'] = trim( $_POST['supply_type'] );
	$data['name'] = trim( $_POST['name'] );
	$data['summary'] = trim( $_POST['summary'] );
	$data['description'] = trim( $_POST['description'] );
	$data['price'] = trim( $_POST['price'] );
	$data['supply_price'] = trim( $_POST['supply_price'] );
	$data['payout_rate'] = trim( $_POST['payout_rate'] );
	$data['submit_issue'] = trim( $_POST['submit_issue'] );
	$data['add_time'] = time();
	$data['user_id'] = $__UserAuth['id'];

	if ( !$data['name'] )
		exit( '产品名称不能为空' );
	if ( !$data['target_category_id'] )
		exit( '分类编号不能为空' );
	if ( !$data['supply_price'] )
		exit( '给银行的成本不能为空' );
	if ( !$data['payout_rate'] )
		exit( '费率不能为空' );

	$ProductSubmitModel->Add( $data );

	echo 200;
}

?>