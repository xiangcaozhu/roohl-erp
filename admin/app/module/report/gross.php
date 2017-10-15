<?php
/*
@@acc_title="产品销售毛利表 gross"
*/
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterChannelParentModel = Core::ImportModel( 'CenterChannelParent' );

$channelList = $CenterChannelModel->GetList();
$channelParentList = $CenterChannelParentModel->GetList();




$CenterSupplierModel = Core::ImportModel( 'CenterSupplier' );


$supplierMe =0;
if( $__UserAuth['user_group']==38 || $__UserAuth['user_group']==15 || $__UserAuth['user_group']==14 || $__UserAuth['user_group']==39 || $__UserAuth['user_group']==16 )
{
$search = array();
}
//elseif($__UserAuth['user_group']==14)
//{
//$search = array('manage_zj' => $__UserAuth['user_id'],);
//$supplierMe = $__UserAuth['user_id'];
//}
else
{
$search = array( 'manage_id' => $__UserAuth['user_id'],);
$supplierMe = $__UserAuth['user_id'];
}
$supplierMe =0;
$search = array();
$supplierList = $CenterSupplierModel->GetList( $search, $offset, $onePage );
$tpl['Supplier_list'] = $supplierList;



/*
$list_m = $CenterOrderModel->Gup_data();
foreach ( $list_m as $key => $val )
{
echo $val['oid'].'-'.$val['cgjg'].'<br />';

$data = array();
$data['stock_price'] = $val['cgjg'];

$CenterOrderModel->UpdateProduct( $val['oid'], $data );

}
*/



	$tpl['channel_list'] = $channelList;
	$tpl['channel_parent_list'] = $channelParentList;

if ( !$_POST )
{

	Common::PageOut( 'report/gross.html', $tpl );
}
else
{
	$beginTime = $_POST['begin_date'] ? strtotime( $_POST['begin_date'] . ' 00:00:00' ) : false;
	$endTime = $_POST['end_date'] ? strtotime( $_POST['end_date'] . ' 23:59:59' ) : false;
	
	$tpl['nowday']='';
	if ( $beginTime > 0 && $endTime >0 )
	$tpl['nowday'] = '日期：'.date('Y-m-d',$beginTime).' → '.date('Y-m-d',$endTime);










	$channelID = (int)$_POST['channel_id'];
		$tpl['channel_name'] = '';
		if($channelID>0)
		{
		$channel_name = $CenterChannelModel->Get( $channelID );
		$tpl['channel_name'] = $channel_name['name'];
		}


     $warehouseID = (int)$_POST['warehouse_id'];
     $supplierID = (int)$_POST['supplier_id'];

		
		
	$board = (int)$_POST['board'];


	
	$list = $CenterOrderModel->GetChannelgross( $beginTime,$endTime,$channelID, $board, $warehouseID, $supplierID, $supplierMe );
	
	
	$M_1=0;
	$M_2=0;
	$M_3=0;
	$M_4=0;
	$M_5=0;
	$M_6=0;
	$M_7=0;
	$M_8=0;
	
	
	foreach ( $list['product_data'] as $key => $val )
	{
		//产品名称
		if($val['extraName'])
		$list['product_data'][$key]['nameing'] = $val['extraName'] ;
		else
		$list['product_data'][$key]['nameing'] = $val['name'] ;
		
		if($channelID==0)
		$list['product_data'][$key]['nameing'] = $val['name'] ;
		//产品名称

		//产品类型
		if($list['product_data'][$key]['product_board']==1)
		$list['product_data'][$key]['board'] = '3C' ;
		else
		$list['product_data'][$key]['board'] = '非3C' ;
		//产品类型

		
		//总运营费 总税金 总佣金 总运费
		if($list['product_data'][$key]['product_board']==1)
		$T_total_yyf = $val['totalSalePrice']*0.01 ;
		else
		$T_total_yyf = $val['totalSalePrice']*0.04 ;

		$list['product_data'][$key]['totalYyf'] = $T_total_yyf ;
		
		$T_total_sj = $val['totalSalePrice']*0.015;
		$list['product_data'][$key]['totalSj'] = $T_total_sj ;
		
		$T_total_payout = $val['total_payout'] ;
		$list['product_data'][$key]['totalPayout'] = $T_total_payout;
		
		$T_total_kdf = $val['total_kdf'] ;
		$list['product_data'][$key]['totalKdf'] = $T_total_kdf;
		//总运营费 总税金 总佣金 总运费
		
		//总成本
		$T_toatl_stock_price = $val['totalstockPrice'];
		
		//if((int)$val['purchaseQuantity']==0)
		  // $T_toatl_stock_price = $val['toatl_stock_price'];
		
		//$list['product_data'][$key]['toatlStockPrice'] = $T_toatl_stock_price;
		//总成本

		
		//总毛利润
		$T_profit = $val['totalSalePrice'] - $T_toatl_stock_price - $T_total_payout - $T_total_kdf - $T_total_yyf - $T_total_sj ;
		$list['product_data'][$key]['profit'] = $T_profit;
		//总毛利润
		
				
		if( ((int)$val['salePrice']>0) || ($val['targetId']) )
		{
		}
		else
		{
		$list['product_data'][$key]['targetId'] = '赠品' ;
		$list['product_data'][$key]['toatlSalePrice'] = '赠品' ;
		}

		if(((int)$val['purchase_quantity']!=0) && ((int)$val['purchase_quantity']!=(int)$val['quantity']))
		   $list['product_data'][$key]['quantity_error'] = 1 ;
		else
		   $list['product_data'][$key]['quantity_error'] = 0 ;
		
		
		
		
			$M_1+=$val['totalSalePrice'];
			$M_2+=$T_toatl_stock_price;
			$M_3+=$T_total_payout;
			$M_4+=$T_total_kdf;
			$M_5+=$T_total_sj;
			$M_6+=$T_total_yyf;
			$M_7+=$T_profit;

	}

	$tpl['M_1'] = $M_1;	
	$tpl['M_2'] = $M_2;	
	$tpl['M_3'] = $M_3;	
	$tpl['M_4'] = $M_4;	
	$tpl['M_5'] = $M_5;	
	$tpl['M_6'] = $M_6;	
	$tpl['M_7'] = $M_7;	
	
		
$tpl['list'] = $list;


if ( $_POST['excel']==1 )
{
$product_m = $list['product_data'];

$d=0;
foreach ( $product_m as $p_key => $p_val ) 
{
    $d++;
	
if($channelID>0)
{	
	$excelList_one = array(
        'list_id' => $d,
		'targetId' => $p_val['id'],	
        'id' => $p_val['id'],	
        'board' => $p_val['board'],
		'nameing' => $p_val['nameing'],
		'salePrice' => $p_val['salePrice'],
		'quantity' => $p_val['saleQuantity'],
		'totalSalePrice' => FormatMoney($p_val['totalSalePrice']),
		'totalStockPrice' => FormatMoney($p_val['totalstockPrice']),
		'totalPayout' => FormatMoney($p_val['totalPayout']),
		'totalKdf' => FormatMoney($p_val['totalKdf']),
		'totalSj' => FormatMoney($p_val['totalSj']),
		'totalYyf' => FormatMoney($p_val['totalYyf']),
		'profit' => FormatMoney($p_val['profit']),
    );
}
else
{
	$excelList_one = array(
        'list_id' => $d,
        'id' => $p_val['id'],	
        'board' => $p_val['board'],
		'nameing' => $p_val['nameing'],
		'quantity' => $p_val['saleQuantity'],
		'totalSalePrice' => FormatMoney($p_val['totalSalePrice']),
		'totalStockPrice' => FormatMoney($p_val['totalstockPrice']),
		'totalPayout' => FormatMoney($p_val['totalPayout']),
		'totalKdf' => FormatMoney($p_val['totalKdf']),
		'totalSj' => FormatMoney($p_val['totalSj']),
		'totalYyf' => FormatMoney($p_val['totalYyf']),
		'profit' => FormatMoney($p_val['profit']),
    );

}


    $excelList[] = $excelList_one ;
}


$d++;

		
if($channelID>0)
{	
	$excelList_one = array(
        'list_id' => '',
		'targetId' => '',	
        'id' => '',	
        'board' => '',
		'nameing' => '',
		'salePrice' => '',
		'quantity' => '',
		'totalSalePrice' => FormatMoney($M_1),
		'totalStockPrice' => FormatMoney($M_2),
		'totalPayout' => FormatMoney($M_3),
		'totalKdf' => FormatMoney($M_4),
		'totalSj' => FormatMoney($M_5),
		'totalYyf' => FormatMoney($M_6),
		'profit' => FormatMoney($M_7),
    );
}
else
{
	$excelList_one = array(
        'list_id' => '',
        'id' => '',	
        'board' => '',
		'nameing' => '',
		'quantity' => '',
		'totalSalePrice' => FormatMoney($M_1),
		'totalStockPrice' => FormatMoney($M_2),
		'totalPayout' => FormatMoney($M_3),
		'totalKdf' => FormatMoney($M_4),
		'totalSj' => FormatMoney($M_5),
		'totalYyf' => FormatMoney($M_6),
		'profit' => FormatMoney($M_7),
    );

}

$excelList[] = $excelList_one ;

if($channelID>0)
{
	$header = array(
		'序号' => 'list_id',
		'银行编号' => 'targetId',
		'商品ID' => 'id',
		'类型' => 'board',
		'商品名称' => 'nameing',
		'单价' => 'salePrice',
		'数量' => 'quantity',
		'总销售' => 'totalSalePrice',
		'总成本' => 'totalStockPrice',
		'总佣金' => 'totalPayout',
		'总运费' => 'totalKdf',
		'总税金' => 'totalSj',
		'总运营费' => 'totalYyf',
		'毛利润' => 'profit',
	);
}
else
{
	$header = array(
		'序号' => 'list_id',
		'商品ID' => 'id',
		'类型' => 'board',
		'商品名称' => 'nameing',
		'数量' => 'quantity',
		'总销售' => 'totalSalePrice',
		'总成本' => 'totalStockPrice',
		'总佣金' => 'totalPayout',
		'总运费' => 'totalKdf',
		'总税金' => 'totalSj',
		'总运营费' => 'totalYyf',
		'毛利润' => 'profit',
	);
}


	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=\"" . DateFormat(time(), 'Y-m-d_H-i-s') . ".xls\"");
	header("Content-Transfer-Encoding:binary");
	echo ExcelXml( $header, $excelList);
	exit;
}
		Common::PageOut( 'report/gross.html', $tpl );
}
?>