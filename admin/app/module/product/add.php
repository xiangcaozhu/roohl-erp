<?php
/*
@@acc_title="添加商品 add"
*/
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterBrandModel = Core::ImportModel( 'CenterBrand' );
$CenrterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );

$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );

$AdminModel = Core::ImportModel( 'Admin' );

if ( !$_POST )
{
	if ( !$_GET['cid'] )
	{
		$categoryTree = $CenterCategoryModel->BuildTree();

		$categoryList = array();
		$topCategoryList = array();
		foreach ( $categoryTree as $key => $val )
		{
			$categoryList[$val['pid']][] = $val;

			if ( !$val['pid'] )
				$topCategoryList[] = $val;
		}

		Common::PageOut( 'product/add_select_category.html', $tpl );
	}
	else
	{
		$categoryId = $_GET['cid'];
		$categoryInfo = $CenterCategoryModel->Get( $categoryId );
		$categoryBrandList = $CenterCategoryModel->GetBrandList( $categoryId );
		$supplierList = $CenterSupplierModel->GetList();
		
		if ( !$categoryInfo )
			Alert( '分类不存在' );

		$tpl['category'] = $categoryInfo;

		$tpl['brand_list'] = $categoryBrandList;
		$tpl['supplier_list'] = $supplierList;

		/******** Buy Attribute ********/
		$buyAttributeTemplateList = $CenrterBuyAttributeModel->GetTemplateList();
		$tpl['buy_attribute_template_list'] = $buyAttributeTemplateList;
		$tpl['attribute_template'] = Common::PageCode( 'product/attribute/buy/dom.html' );

		$userList = $AdminModel->GetAdministratorListcp();
		$tpl['user_list'] = $userList;

		$tpl['edit'] = false;

		Common::PageOut( 'product/form.html', $tpl, $parentTpl );
	}
}
else
{
	if ( Nothing( $_POST['name'] ) )
		exit( '产品名称不能为空' );

	if ((int) $_POST['supplier_now'] == 0 )
		exit( '默认供货商必选' );

	if ( $CenterProductModel->GetByName( NoHtml( $_POST['name'] ) ) )
		exit( '已经存在相同的产品名称' );


	$managerUserInfo = $AdminModel->GetAdministrator( intval( $_POST['manager_user_id'] ) );

	//if ( !$managerUserInfo )
		//exit( '请选择产品经理' );

	if ( !$_POST['board'] )
		exit( '请选择类型' );

	//if ( !$_POST['market_price'] )
		//exit( '请填写市场价' );

	//if ( !$_POST['cost_price'] )
		//exit( '请填写成本价' );

	/******** category ********/
	$categoryId = $_GET['cid'];
	$categoryInfo = $CenterCategoryModel->Get( $categoryId );
	
	if ( !$categoryInfo )
		exit( '分类不存在' );
	
	/******** product ********/
	$data = array();
	$data['name'] = NoHtml( $_POST['name'] );
	$data['summary'] = NoHtml( $_POST['summary'] );
	$data['cid'] = $categoryId;
	$data['brand_id'] = (int)$_POST['brand_id'];
	$data['image_list'] = 0;
	$data['add_time'] = time();
	$data['update_time'] = time();
	$data['supplier_id'] = $_POST['supplier_id'];
	$data['weight'] = $_POST['weight'];
	$data['board'] = $_POST['board'];
	$data['buy_attribute_template_id'] = -1;
	$data['market_price'] = $_POST['market_price'];
	$data['cost_price'] = $_POST['cost_price'];

	$data['user_name'] = $__UserAuth['user_name'];
	$data['user_real_name'] = $__UserAuth['user_real_name'];
	$data['user_id'] = $__UserAuth['user_id'];

	$data['manager_user_name'] = $managerUserInfo['user_name'];
	$data['manager_user_real_name'] = $managerUserInfo['user_real_name'];
	$data['manager_user_id'] = $managerUserInfo['user_id'];
	
	$data['supplier_now'] = $_POST['supplier_now'];
	if($_POST['supplier_id'])
	$data['supplier_id'] = implode(',',$_POST['supplier_id']);

		

	/******** Insert ********/
	$productId = $CenterProductModel->Add( $data );

	$data = array();

	Core::LoadLib( 'GD.class.php' );
	$Gd = new GD();

	if ( $_POST['image_list_file'] )
	{
		$tmpFile = Core::GetConfig( 'file_upload_tmp_path' ) . $_POST['image_list_file'] . '.tmp';
		$savePath = Common::GetProductPicturePath( $productId );

		if ( $Gd->IsImage( $tmpFile ) )
		{
			if ( !FileExists( $savePath ) )
				MakeDirTree( $savePath );

			$pictureSizeList = Core::GetConfig( 'product_picture_size' );
			foreach ( $pictureSizeList as $type => $size )
			{
				$Gd->Thumb( $tmpFile, $size['width'], $size['height'], Common::GetProductPicturePath( $productId, $type ), 'jpg' );
			}

			@unlink( $tmpFile );
			$data['image_list'] = 1;
		}
	}

	if ( $data )
		$CenterProductModel->Update( $productId, $data );

	/******** 购买属性 ********/
	// 检查购买属性
	$buyAttributeList = $CenterBuyAttributeExtra->ListProcess( $_POST['buy_attr'], $_POST['buy_attr_val'] );

	// 添加处理购买属性
	$CenterBuyAttributeExtra->ListUpdate( $buyAttributeList, $productId );

	/******** 生成基础SKU ********/
	Core::LoadDom( 'CenterProduct' );
	$CenterProductDom = new CenterProductDom( $productId );
	$sku = $CenterProductDom->GetBaseSku();

	
	
	echo $productId;
}

?>