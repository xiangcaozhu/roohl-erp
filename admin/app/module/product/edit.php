<?php
/*
@@acc_title="编辑商品 edit"
*/
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );

$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );

$AdminModel = Core::ImportModel( 'Admin' );

//$CenterProductModel->Update0229();

/******** product ********/
$productId = (int)$_GET['id'];
$productInfo = $CenterProductModel->Get( $productId );

if ( !$productInfo )
	Alert( '错误的产品编号' );

/******** Category ********/
$categoryId = $productInfo['cid'];
$categoryInfo = $CenterCategoryModel->Get( $categoryId );

if ( !$categoryInfo )
	Alert( '分类不存在' );

if ( !$_POST )
{
	$productInfo = $CenterProductExtra->ExplainOne( $productInfo );

	$categoryBrandList = $CenterCategoryModel->GetBrandList( $categoryId );


	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $__UserAuth['user_id'] );
	//$list[$key]['user_name_zh'] = $AdminArray['user_real_name'] ;

$search = array();
switch ( $__UserAuth['user_group'] )
		{
			case 12:
			    $search = array( 'manage_id' => (int)$AdminArray['user_product_1'] );
			break;
			case 13:
			    $search = array( 'manage_id' => (int)$__UserAuth['user_id'] );
			break;
			case 14:
			    //$search = array( 'status' => 2, 'sign_top_zj' =>  $__UserAuth['user_id'] );
			break;
			case 15:
			   // $search = array( 'status' => 2 );
			break;
			case 38:
			   //$search = array( 'status' => 2 );
			break;
			default:
			    $search = array( 'manage_id' =>  -1 );
			break;
}

//$search = array( 'manage_id' =>  -1 );
$search = array();
$supplierList = $CenterSupplierModel->GetList($search);



	
	$tpl['category'] = $categoryInfo;
	$tpl['product'] = $productInfo;
	$tpl['brand_list'] = $categoryBrandList;
	
	
	$supplier_List=explode(',',$productInfo['supplier_id']);
	if ( is_array($supplier_List) )
	  {
	  foreach ( $supplierList as $key => $val )
	 {
      if ( in_array($val['id'],$supplier_List) )
		 $supplierList[$key]['selected'] = 1;
	 }
	 }
	$tpl['supplier_list'] = $supplierList;
	

	/******** Buy Attribute ********/

	// 自定义
	$CenterBuyAttributeExtra = new CenterBuyAttributeExtra();
	$buyAttributeList = $CenterBuyAttributeExtra->GetGroup( $productId );
	
	



	$tpl['attribute_template'] = Common::PageCode( 'product/attribute/buy/dom.html' );
	
	
	
	
	
		foreach ( $buyAttributeList as $key => $val )
		{
		foreach ( $val['value_list'] as $keys => $vals )
		{
		if($vals['service']==1)
		{
		$buyAttributeList[$key]['value_list'][$keys]['service_name'] = '客服操作';
		}
		else
		{
		$buyAttributeList[$key]['value_list'][$keys]['service_name'] = '';
		}
		}
		
		}	
		
		
		
	$tpl['attribute_form'] = Common::PageCode( 'product/attribute/buy/form.html', array( 'buy_attribute_list' => $buyAttributeList ) );

	// 模板
	$buyAttributeTemplateList = $CenterBuyAttributeModel->GetTemplateList();
	
	
	
	
	
	
	

		
		
		
	$tpl['buy_attribute_template_list'] = $buyAttributeTemplateList;

	//$userList = $AdminModel->GetAdministratorListcp();
	//$tpl['user_list'] = $userList;

	$tpl['edit'] = true;

	Common::PageOut( 'product/form.html', $tpl, $parentTpl );
}
else
{
	if ( Nothing( $_POST['name'] ) )
		exit( '产品名称不能为空' );

	if ( NoHtml( $_POST['name'] ) != $productInfo['name'] )
	{
		if ( $CenterProductModel->GetByName( NoHtml( $_POST['name'] ) ) )
			exit( '已经存在相同的产品名称' );
	}

	//$managerUserInfo = $AdminModel->GetAdministrator( intval( $_POST['manager_user_id'] ) );

	//if ( !$managerUserInfo )
	//	exit( '请选择产品经理' );

	if ( !$_POST['board'] )
		exit( '请选择类型' );

	/******** product ********/
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['summary'] = NoHtml( $_POST['summary'] );
	$data['brand_id'] = (int)$_POST['brand_id'];
	
	if($_POST['supplier_id'])
	$data['supplier_id'] = implode(',',$_POST['supplier_id']);
	
	$data['market_price'] = $_POST['market_price'];
	$data['cost_price'] = $_POST['cost_price'];
	
	$data['weight'] = $_POST['weight'];
	$data['board'] = $_POST['board'];
	$data['update_time'] = time();
	$data['supplier_now'] = $_POST['supplier_now'];

	//$data['manager_user_name'] = $managerUserInfo['user_name'];
	//$data['manager_user_real_name'] = $managerUserInfo['user_real_name'];
	//$data['manager_user_id'] = $managerUserInfo['user_id'];

	/******** 定义购买属性 ********/
	// 使用模板
	$data['buy_attribute_template_id'] = (int)$_POST['buy_attribute_template_id'];

	// 使用自定义的购买属性
	if ( $_POST['buy_attribute_type'] == -1 )
		$data['buy_attribute_template_id'] = -1;
	
	/******** Update ********/
	$CenterProductModel->Update( $productId, $data );

	$data = array();

	Core::LoadLib( 'GD.class.php' );
	$Gd = new GD();
/*
	if ( $_POST['image_list_file'] )
	{
		$tmpFile = Core::GetConfig( 'file_upload_tmp_path' ) . $_POST['image_list_file'] . '.tmp';
		$savePath = Common::GetProductPicturePath( $productId );
		$ext = 'jpg';
		if ( $Gd->IsImage( $tmpFile ) )
		{
			if ( !FileExists( $savePath ) )
				MakeDirTree( $savePath );

			$pictureSizeList = Core::GetConfig( 'product_picture_size' );
			foreach ( $pictureSizeList as $type => $size )
			{
				$Gd->Thumb( $tmpFile, $size['width'], $size['height'], Common::GetProductPicturePath( $productId, $type ), $ext );
			}

			@unlink( $tmpFile );
			$data['image_list'] = 1;
			$data['image_index'] = 1;
		}
	}
*/
	if ( $data )
		$CenterProductModel->Update( $productId, $data );

	/******** 购买属性 ********/
	// 检查购买属性
	$buyAttributeList = $CenterBuyAttributeExtra->ListProcess( $_POST['buy_attr'], $_POST['buy_attr_val'] );

	// 添加处理购买属性
	$CenterBuyAttributeExtra->ListUpdate( $buyAttributeList, $productId );

	echo $productId;
}

?>