<?php
/*
@@acc_title="渠道商品对照表 collate"
*/
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

$onePage=20;
if ( $_GET['excel'] )
{
	$offset = 0;
	$onePage = 0;
}

list( $page, $offset, $onePage ) = Common::PageArg( $onePage );

$search = array(
	//'upok' => 1,
	'sku' => $_GET['sku'],
	'target_id' => $_GET['target_id'],
	'channel_id' => $_GET['channel_id'],
	'begin_time' => strtotime( $_GET['begin_date'] ),
	'end_time' => strtotime( $_GET['end_date'] ),
);

$list = $ProductCollateModel->GetList( $search, $offset, $onePage );
$total = $ProductCollateModel->GetTotal( $search );

$channelList = $CenterChannelModel->GetList();

Core::LoadDom( 'CenterSku' );

foreach ( $list as $key => $val )
{
	$CenterSkuDom = new CenterSkuDom( $val['sku'] );
	$list[$key]['sku_info'] = $CenterSkuDom->InitProduct();
	$list[$key]['channel_name'] = $channelList[$val['channel_id']]['name'];
	$list[$key]['product_id'] = $list[$key]['sku_info']['product']['id'];
	$list[$key]['product_name'] =$list[$key]['sku_info']['product']['name'];
	
	$one_money = $ProductCollateModel->GetPrice( $val['id'], 1 ); 
	$list[$key]['one_money'] = FormatMoney($one_money['price']);
	
	$Supplie_id = $ProductCollateModel->GetSupplie_id( $list[$key]['sku_info']['product']['id'] );
	$list[$key]['supplier_name'] = $ProductCollateModel->GetSupplie( $Supplie_id );
	
	
	
	if($val['channel_id']==600)
	{
	$bank_info = GetHtm_jh( 'http://shop.ccb.com/products/pd_'.$val['target_id'].'.jhtml' );
	$list[$key]['bank_info'] = $bank_info;
	if($bank_info['Pmoney'] != $one_money['price'])
	{
	$list[$key]['money_err']= "red";
	}
	
	//echo $bank_info['Ppic'].'==='.$list[$key]['sku_info']['product']['id'];
	GetPic($bank_info['Ppic'],$list[$key]['sku_info']['product']['id']); 
	
	if($bank_info['Pname'])
	{
	$data = array();
	$data['bank_name'] = $bank_info['Pname'];
	//$data['upok'] = 2;
	$data['bank_link'] ='http://shop.ccb.com/products/pd_'.$val['target_id'].'.jhtml';
	$ProductCollateModel->Update( $val['id'], $data );
	}
	
	
	
	}

	
	
}







if ( $_GET['excel'] )
{

	$header = array(
		'商品ID' => 'product_id',
		'商品SKU' => 'sku',
		'产品名称' => 'product_name',
		'销售渠道' => 'channel_name',
		'渠道产品编号' => 'target_id',
		'销售价格' => 'one_money',
		'银行链接' => 'bank_link',
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
}




$tpl['list'] = $list;
$tpl['channel_list'] = $channelList;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );

Common::PageOut( 'product/collate/bank.html', $tpl, $parentTpl );

?>