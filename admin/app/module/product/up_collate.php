<?php
/*
@@acc_title="渠道产品对照表导入 import_collate"
*/
$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );
$AdminModel = Core::ImportModel( 'Admin' );
$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );


Core::LoadFunction( 'Importcollate.inc.php' );
Core::LoadDom( 'CenterSku' );


if ( !$_POST )
{
	$tpl['check'] = true;
	Common::PageOut( 'product/import/upload_collate_1.html', $tpl );
}
else
{	
	if ( !$_FILES['file']['tmp_name'] )
		return false;

	$savePath = Core::GetConfig( 'file_upload_tmp_path' );
	$fileName = md5( GetRand( 32 ) );
	$saveFile = $savePath . $fileName  . ".tmp";

	if ( !@move_uploaded_file( $_FILES['file']['tmp_name'], $saveFile ) )
	{
		Alert( '上传文件失败' );
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$collateList = UpCollate( $saveFile );

	$list = array();
	foreach ( $collateList as $key => $val )
	{
		$collateList[$key]['channel_id'] = $val['channel_id'];

		$collateInfo = $CenterChannelModel->Get( $val['channel_id'] );
		$collateList[$key]['channel_name'] = $collateInfo['name'];
		
		$sku = trim( $val['sku'] );
		$CenterSkuDom = new CenterSkuDom( $sku );
		$skuInfo = $CenterSkuDom->InitProduct();
		$skuId = $CenterSkuDom->id;
		$product_id = $skuInfo['product']['id'];

		$collateList[$key]['product_id'] = $product_id;
		$collateList[$key]['sku'] = $sku;
		$collateList[$key]['product_name'] = $skuInfo['product']['name'];
		
		
	    $collateOne = $ProductCollateModel->GetUnique( $val['target_id'] );
		if ($collateOne)
		{
		     $collateList[$key]['exists'] = true;
			 $collateList[$key]['collateOne'] =  $collateOne;
			 
			 $T_price =   $ProductCollateModel->GetPriceOne( $collateOne['id'] );
			 $collateList[$key]['price'] = $T_price;
			 $collateList[$key]['sku_price']='white';
			 if( $T_price != $collateList[$key]['AllMoney'])
			 { 
			 $collateList[$key]['sku_price']='red';
			 }

			 
			 $collateList[$key]['sku_err']='white';
			 if($collateOne['sku'] != $collateList[$key]['sku'])
			 { 
			 $collateList[$key]['sku_err']='red';
			 }
			
			 
		}

		
/////////////////////////////////////////////////////////////////////////////////////////
	if($val['channel_id']==62)
	{
	$bank_info = GetHtm_gf( $val['bank_link'] );
	$list[$key]['bank_info'] = $bank_info;
	if($bank_info['Pmoney'] != $one_money['price'])
	{
	$list[$key]['money_err']= "red";
	}
	
	
	
	$list[$key]['p_no']=$bank_info['Pno'];
	$list[$key]['p_money']=$bank_info['Pmoney'];
	$list[$key]['p_name']=$bank_info['Pname'];
	$list[$key]['p_link']=$val['bank_link'];
	$list[$key]['p_ser']=$val['gf_ser'];
	
	//echo $bank_info['Ppic'].'==='.$list[$key]['sku_info']['product']['id'];
	//GetPic($bank_info['Ppic'],$list[$key]['sku_info']['product']['id']); 
	
	//if($bank_info['Pname'])
	//{
	//$data = array();
	//$data['bank_name'] = $bank_info['Pname'];
	//$data['upok'] = 2;
	//$data['bank_link'] ='http://shop.ccb.com/products/pd_'.$val['target_id'].'.jhtml';
	//$ProductCollateModel->Update( $val['id'], $data );
	//}
	
	
	
	}
/////////////////////////////////////////////////////////////////////////////////////////

			
			
			
			
			
			
	}
///////////////////////////////////////////
	$header = array(
		'序号' => '1',
		'渠道ID' => '62',
		'渠道编号' => 'p_no',
		'SKU' => 'channel_name',
		'价格' => 'p_money',
		'类型' => '1',
		'链接' => 'p_link',
		'银行名称' => 'p_name',
		'编码' => 'p_ser',
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
	echo ExcelXml( $header,$list);
	exit;
///////////////////////////////////////////////////
	$tpl['list'] = $collateList;
	$tpl['file_name'] = $fileName;
	
	
	Common::PageOut( 'product/import/check_collate_up.html', $tpl );
}

?>