<?php

$CenterBrandModel = Core::ImportModel( 'CenterBrand' );
$CenterProductModel = Core::ImportModel( 'CenterProduct' );

Core::LoadDom( 'CenterProduct' );
Core::LoadDom( 'CenterSku' );


/*
$list = $CenterBrandModel->G3();


$excelList = array();
foreach ( $list as $key => $val )
{
	$CenterSkuDom = new CenterSkuDom( $val['Psku'] );
	$skuInfo = $CenterSkuDom->InitProduct();
	//$list[$key]['skuInfo'] = $skuInfo;

	$list[$key]['is_base'] = $skuInfo['is_base'];
	$list[$key]['attribute'] = $skuInfo['attributetKK'];

			$excelList_one = array(
				'pid' => $val['Pid'],
				'pname' => $val['Pname'],
				'sku_name' => $skuInfo['attributetKK'],	
				'sku' => $val['Psku'],	
				'sku_id' => $val['Psku_id'],	
				'is_base' => $val['is_base'],	
				'erp_sku' => $val['erp_sku'],	
			);
			$excelList[] = $excelList_one ;



}



	$header = array(
		'商品ID' => 'pid',
		'商品名称' => 'pname',
		'属性' => 'sku_name',
		'分期SKU' => 'sku',
		'分期SKUid' => 'sku_id',
		'分期级别' => 'is_base',
		'ERP_SKU' => 'erp_sku',

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
	echo ExcelXml( $header, $excelList, 'order_id', array() );
	exit;







exit;

*/
$a = array();
$b = array();
$c = 0;
foreach ( $list as $key => $val )
{
	$productInfo = $CenterProductModel->Get( $val['pid'] );
	$CenterProductDom = new CenterProductDom( $productInfo );
	$buyAttributeList = $CenterProductDom->GetAttributeList();
	if ( $buyAttributeList )
	{
		//$a[$key] = $val;
		//$a[$key]['buyAttributeList'] = $buyAttributeList;
		foreach ( $buyAttributeList as $k => $v )
		{
			foreach ( $v['value_list'] as $ks => $vs )
			{
				if($vs['service']==0){
					//$a[$key]['skuInfos'][$ks] = $vs;
				
					$sku = $CenterProductDom->GetSku1012($k,$ks);
					$CenterSkuDom = new CenterSkuDom( $sku );
					$skuInfo = $CenterSkuDom->InitProduct();
					$tKey = $key."_".$k."_".$ks;
					$a[$tKey]['pid'] = $val['pid'];
					$a[$tKey]['pname'] = $val['pname'];
					$a[$tKey]['sid'] = $val['sid'];
					$a[$tKey]['sname'] = $val['sname'];


					$a[$tKey]['sku_id'] = $skuInfo['id'];
					$a[$tKey]['sku'] = $skuInfo['sku'];
					$a[$tKey]['is_base'] = $skuInfo['is_base'];
					$a[$tKey]['erp_sku'] = $skuInfo['erp_sku'];
					$a[$tKey]['sku_name'] = $vs['name'];
					$a[$tKey]['id'] = $skuInfo['id'];
					//$p = md5($skuInfo['content']);
					//$q = md5('a:1:{i:'.$k.';a:2:{s:5:"input";s:'.strlen($ks).':"'.$ks.'";s:3:"vid";s:'.strlen($ks).':"'.$ks.'";}}');
					
					//if($p!=$q){
					//	$c = $c.",".$skuInfo['id'];
						
					//}
				
				
				}
			
			}
		}

		
		
		
		
		
	}else{
		$b[$key] = $val;
		$sku = $CenterProductDom->GetBaseSku();
		$CenterSkuDom = new CenterSkuDom( $sku );
		$skuInfo = $CenterSkuDom->InitProduct();
		//unset($skuInfo['product']);
		//$b[$key]['skuInfo'] = $skuInfo;


					$tKey = $key;
					$b[$tKey]['pid'] = $val['pid'];
					$b[$tKey]['pname'] = $val['pname'];
					$b[$tKey]['sid'] = $val['sid'];
					$b[$tKey]['sname'] = $val['sname'];


					$b[$tKey]['sku_id'] = $skuInfo['id'];
					$b[$tKey]['sku'] = $skuInfo['sku'];
					$b[$tKey]['is_base'] = $skuInfo['is_base'];
					$b[$tKey]['erp_sku'] = $skuInfo['erp_sku'];
					$b[$tKey]['sku_name'] = '';






	}

}



$excelList = array();
		foreach ( $a as $v )
		{
			$excelList_one = array(
				'sid' => $v['sid'],	
				'sname' => $v['sname'],	
				'pid' => $v['pid'],
				'pname' => $v['pname'],
				'sku_name' => $v['sku_name'],	
				'sku' => $v['sku'],	
				'sku_id' => $v['sku_id'],	
				'is_base' => $v['is_base'],	
				'erp_sku' => $v['erp_sku'],	
			);
			$excelList[] = $excelList_one ;
		}


	$header = array(
		'供货商ID' => 'sid',
		'供货商' => 'sname',
		'商品ID' => 'pid',
		'商品名称' => 'pname',
		'属性' => 'sku_name',
		'分期SKU' => 'sku',
		'分期SKUid' => 'sku_id',
		'分期级别' => 'is_base',
		'ERP_SKU' => 'erp_sku',

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
	echo ExcelXml( $header, $excelList, 'order_id', array() );
	exit;




/*


*/
?>