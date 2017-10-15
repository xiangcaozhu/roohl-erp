<?php
/*
@@acc_free
*/
$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$AdminModel = Core::ImportModel( 'Admin' );

Core::LoadFunction( 'ImportProduct.inc.php' );

$savePath = Core::GetConfig( 'file_upload_tmp_path' );
$fileName = $_GET['file'];
$saveFile = $savePath . $fileName  . ".tmp";

if ( !file_exists( $saveFile ) )
{
	Alert( '没有找到待导入文件' );
}

$productList = ImportProduct( $saveFile );

// check
foreach ( $productList as $key => $val )
{
	if ( $CenterProductModel->GetUnique( $val['name'] ) )
		Alert( '产品已存在' );

	//$adminInfo = $AdminModel->GetAdministratorByRealName( $val['manager_user_real_name'] );
	//$productList[$key]['manager_user_id'] = $adminInfo['user_id'];
	//$productList[$key]['manager_user_name'] = $adminInfo['user_name'];
	//$productList[$key]['manager_user_real_name'] = $adminInfo['user_real_name'];
	//if ( !$adminInfo['user_id'] )
		//Alert( '产品经理不存在:'.$val['manager_user_real_name'] );

	if ( $val['board'] < 0 || $val['board'] > 3 )
		Alert( '类型错误:'.$val['board'] );

	//if ( !$val['market_price'] )
		//Alert( '市场价不能为空' );

	if ( !$val['cost_price'] )
		Alert( '成本价不能为空' );
}


$CenterProductModel->Model->DB->Begin();

$importCounter = 0;
$skipCounter = 0;

foreach ( $productList as $val )
{
	if ( $CenterProductModel->GetUnique( $val['name'] ) )
	{
		$skipCounter++;
		continue;
	}

	$data = array();
	$data['cid'] = $val['cid'];
	$data['name'] = $val['name'];
	$data['summary'] = $val['summary'];
	//$data['market_price'] = $val['market_price'];
	$data['cost_price'] = $val['cost_price'];
	$data['add_time'] = time();
	$data['update_time'] = time();
	//$data['weight'] = $val['weight'] ? $val['weight'] : 0.0001;
	$data['board'] = $val['board'];
	$data['supplier_now'] = $val['supplier_now'];

	//$data['user_name'] = $__UserAuth['user_name'];
	//$data['user_real_name'] = $__UserAuth['user_real_name'];
	//$data['user_id'] = $__UserAuth['user_id'];

	//$data['manager_user_name'] = $val['manager_user_name'];
	//$data['manager_user_real_name'] = $val['manager_user_real_name'];
	//$data['manager_user_id'] = $val['manager_user_id'];

	$CenterProductModel->Add( $data );

	$importCounter++;
}

$CenterProductModel->Model->DB->Commit();

Common::Loading( '?mod=product.import', "导入{$importCounter}个商品,跳过{$skipCounter}个产品(已经存在)" );

?>