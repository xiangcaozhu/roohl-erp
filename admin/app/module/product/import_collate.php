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
	Common::PageOut( 'product/import/upload_collate.html', $tpl );
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

	$collateList = ImportCollate( $saveFile );

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
		
		
	    if ( $ProductCollateModel->GetUnique( $val['target_id'] ) )
		     $collateList[$key]['exists'] = true;

		
		
	/*	
		switch($val['channel_id'])
			{
				case 68:
				   if($val['Type']==2){
					$collateList[$key]['M1'] = $val['AllMoney'];
					$collateList[$key]['C1'] = 0.05;
					$collateList[$key]['M3'] = $val['AllMoney'];
					$collateList[$key]['C3'] = 0.04;
					$collateList[$key]['M6'] = $val['AllMoney'];
					$collateList[$key]['C6'] = 0.05;
					$collateList[$key]['M12'] = $val['AllMoney'];
					$collateList[$key]['C12'] = 0.07;
					$collateList[$key]['M15'] = $val['AllMoney'];
					$collateList[$key]['C15'] = 0.00;
					$collateList[$key]['M18'] = $val['AllMoney'];
					$collateList[$key]['C18'] = 0.00;
					$collateList[$key]['M24'] = $val['AllMoney'];
					$collateList[$key]['C24'] = 0.00;
					}
					else
					{
					$collateList[$key]['M1'] = $val['AllMoney'];
					$collateList[$key]['C1'] = 0.05;
					$collateList[$key]['M3'] = $val['AllMoney'];
					$collateList[$key]['C3'] = 0.03;
					$collateList[$key]['M6'] = $val['AllMoney'];
					$collateList[$key]['C6'] = 0.04;
					$collateList[$key]['M12'] = $val['AllMoney'];
					$collateList[$key]['C12'] = 0.05;
					$collateList[$key]['M15'] = $val['AllMoney'];
					$collateList[$key]['C15'] = 0.00;
					$collateList[$key]['M18'] = $val['AllMoney'];
					$collateList[$key]['C18'] = 0.00;
					$collateList[$key]['M24'] = $val['AllMoney'];
					$collateList[$key]['C24'] = 0.00;
					}
				break;
				case 60:
				   if($val['Type']==2){
					$collateList[$key]['M1'] = $val['AllMoney'];
					$collateList[$key]['C1'] = 0.02;
					$collateList[$key]['M3'] = $val['AllMoney'];
					$collateList[$key]['C3'] = 0.04;
					$collateList[$key]['M6'] = $val['AllMoney'];
					$collateList[$key]['C6'] = 0.06;
					$collateList[$key]['M12'] = $val['AllMoney'];
					$collateList[$key]['C12'] = 0.08;
					$collateList[$key]['M15'] = $val['AllMoney'];
					$collateList[$key]['C15'] = 0.00;
					$collateList[$key]['M18'] = $val['AllMoney'];
					$collateList[$key]['C18'] = 0.10;
					$collateList[$key]['M24'] = $val['AllMoney'];
					$collateList[$key]['C24'] = 0.12;
					}
					else
					{
					$collateList[$key]['M1'] = $val['AllMoney'];
					$collateList[$key]['C1'] = 0.02;
					$collateList[$key]['M3'] = $val['AllMoney'];
					$collateList[$key]['C3'] = 0.03;
					$collateList[$key]['M6'] = $val['AllMoney'];
					$collateList[$key]['C6'] = 0.04;
					$collateList[$key]['M12'] = $val['AllMoney'];
					$collateList[$key]['C12'] = 0.05;
					$collateList[$key]['M15'] = $val['AllMoney'];
					$collateList[$key]['C15'] = 0.00;
					$collateList[$key]['M18'] = $val['AllMoney'];
					$collateList[$key]['C18'] = 0.08;
					$collateList[$key]['M24'] = $val['AllMoney'];
					$collateList[$key]['C24'] = 0.11;
					}
				break;
////////////////////////////////////////////////////////////////////////家居百货（1）/电脑手机数码（2）/家电美容（3）/配饰奢侈品（4）

				case 61:
					$collateList[$key]['M1'] = $val['AllMoney'];
					$collateList[$key]['M3'] = $val['AllMoney'];
					$collateList[$key]['M6'] = $val['AllMoney'];
					$collateList[$key]['M12'] = $val['AllMoney'];
					$collateList[$key]['M15'] = $val['AllMoney'];
					$collateList[$key]['M18'] = $val['AllMoney'];
					$collateList[$key]['M24'] = $val['AllMoney'];
				   
					$collateList[$key]['C3'] = 0.0;
					$collateList[$key]['C15'] = 0.00;
					$collateList[$key]['C18'] = 0.0;
					$collateList[$key]['C24'] = 0.0;

				   if($val['Type']==1){
					$collateList[$key]['C1'] = 0.20;
					$collateList[$key]['C6'] = 0.23;
					$collateList[$key]['C12'] = 0.245;
					}
					if($val['Type']==2){
					$collateList[$key]['C1'] = 0.05;
					$collateList[$key]['C6'] = 0.08;
					$collateList[$key]['C12'] = 0.095;
					}
					if($val['Type']==3){
					$collateList[$key]['C1'] = 0.08;
					$collateList[$key]['C6'] = 0.11;
					$collateList[$key]['C12'] = 0.125;
					}
					if($val['Type']==4){
					$collateList[$key]['C1'] = 0.10;
					$collateList[$key]['C6'] = 0.13;
					$collateList[$key]['C12'] = 0.145;
					}
				break;



				case 62:
					$collateList[$key]['M1'] = $val['AllMoney'];
					$collateList[$key]['M3'] = $val['AllMoney'];
					$collateList[$key]['M6'] = $val['AllMoney'];
					$collateList[$key]['M12'] = $val['AllMoney'];
					$collateList[$key]['M15'] = $val['AllMoney'];
					$collateList[$key]['M18'] = $val['AllMoney'];
					$collateList[$key]['M24'] = $val['AllMoney'];

					$collateList[$key]['C1'] = 0.08;
					$collateList[$key]['C3'] = 0.08;
					$collateList[$key]['C6'] = 0.08;
					$collateList[$key]['C12'] = 0.08;
					$collateList[$key]['C15'] = 0.00;
					$collateList[$key]['C18'] = 0.09;
					$collateList[$key]['C24'] = 0.10;
					
					break;




///////////////////////////////////////////////////////////////////////////
				default:
				break;
			}
			*/
			
					$collateList[$key]['M1'] = 1;
					$collateList[$key]['M3'] = 1;
					$collateList[$key]['M6'] = 1;
					$collateList[$key]['M12'] = 1;
					$collateList[$key]['M15'] = 1;
					$collateList[$key]['M18'] = 1;
					$collateList[$key]['M24'] = 1;

					$collateList[$key]['C1'] = 0;
					$collateList[$key]['C3'] = 0;
					$collateList[$key]['C6'] = 0;
					$collateList[$key]['C12'] = 0;
					$collateList[$key]['C15'] = 0;
					$collateList[$key]['C18'] = 0;
					$collateList[$key]['C24'] = 0;
			
			
			
			
			
	}

	$tpl['list'] = $collateList;
	$tpl['file_name'] = $fileName;
	
	
	Common::PageOut( 'product/import/check_collate.html', $tpl );
}

?>