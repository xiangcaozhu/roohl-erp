<?php
//建设银行 →龙卡商城
function ImportJianShe( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );
	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	$PHPReader = new PHPExcel_Reader_Excel5();
	if( !$PHPReader->canRead( $filePath ) ){exit( '错误的Excel文件' );}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();
	//echo $rowNum;

	$list = array();
	$k=0;
	$TT_order_id='';
	for ( $i = 3; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
		
		$data['AA'] = $Sheet->getCell( 'AA' . "{$i}" )->getValue();
		$data['AB'] = $Sheet->getCell( 'AB' . "{$i}" )->getValue();
		$data['AE'] = $Sheet->getCell( 'AE' . "{$i}" )->getValue();
		$data['AC'] = $Sheet->getCell( 'AC' . "{$i}" )->getValue();
		
		$data['AD'] = $Sheet->getCell( 'AD' . "{$i}" )->getValue();
		$data['AF'] = $Sheet->getCell( 'AF' . "{$i}" )->getValue();
		$data['AG'] = $Sheet->getCell( 'AG' . "{$i}" )->getValue();
		$data['AH'] = $Sheet->getCell( 'AH' . "{$i}" )->getValue();
		$data['AI'] = $Sheet->getCell( 'AI' . "{$i}" )->getValue();
		$data['AJ'] = $Sheet->getCell( 'AJ' . "{$i}" )->getValue();
		$data['AK'] = $Sheet->getCell( 'AK' . "{$i}" )->getValue();
		$data['AL'] = $Sheet->getCell( 'AL' . "{$i}" )->getValue();
		$data['AM'] = $Sheet->getCell( 'AM' . "{$i}" )->getValue();
		$data['AN'] = $Sheet->getCell( 'AN' . "{$i}" )->getValue();
		$data['AO'] = $Sheet->getCell( 'AO' . "{$i}" )->getValue();
		$data['AP'] = $Sheet->getCell( 'AP' . "{$i}" )->getValue();
		$data['AQ'] = $Sheet->getCell( 'AQ' . "{$i}" )->getValue();
		$data['AR'] = $Sheet->getCell( 'AR' . "{$i}" )->getValue();

		$data['AS'] = $Sheet->getCell( 'AS' . "{$i}" )->getValue();
		$data['AT'] = $Sheet->getCell( 'AT' . "{$i}" )->getValue();
		$data['AU'] = $Sheet->getCell( 'AU' . "{$i}" )->getValue();
		$data['AV'] = $Sheet->getCell( 'AV' . "{$i}" )->getValue();
		$data['AW'] = $Sheet->getCell( 'AW' . "{$i}" )->getValue();
		$data['AX'] = $Sheet->getCell( 'AX' . "{$i}" )->getValue();
		$data['AY'] = $Sheet->getCell( 'AY' . "{$i}" )->getValue();
		$data['AZ'] = $Sheet->getCell( 'AZ' . "{$i}" )->getValue();
		
		
		
		if($data['A']===$TT_order_id || $data['A']=='')
		{
		$k++;
		$T_order_id = $TT_order_id .'-'.$k;
		$T_order_user_name = $TT_order_user_name;
		$T_shipping_user_name = $TT_shipping_user_name;
		$T_shipping_address = $TT_shipping_address;
		$T_shipping_phone = $TT_shipping_phone;
		$T_shipping_phone2 = $TT_shipping_phone2;
		$T_shipping_zip = $TT_shipping_zip;
		$T_comment =$TT_comment ;
		$T_shipping_order_time =$TT_shipping_order_time ;
		}
		else
		{
		$k=0;
		$T_order_id = $data['A'];
		$TT_order_id = $data['A'];
		
		$T_order_user_name = $data['Z'];
		$TT_order_user_name = $data['Z'];
		$T_shipping_user_name = $data['Z'];
		$TT_shipping_user_name = $data['Z'];

		$T_shipping_address = $data['AA'] . "-" . $data['AB'] ;
		$TT_shipping_address = $data['AA'] . "-" . $data['AB'] ;
		
		$T_shipping_phone =$data['AC'];
		$TT_shipping_phone = $data['AC'];
		
		$T_shipping_phone2 = $data['AD'];
		$TT_shipping_phone2 = $data['AD'];
		
		$T_shipping_zip = $data['AF'];
		$TT_shipping_zip = $data['AF'];
		
		$T_comment = $data['N'];
		$TT_comment = $data['N'];
		
		$T_shipping_order_time =$data['L'];
		$TT_shipping_order_time =$data['L'];
		}
				//$invoice_header = trim($data['AE']);
				//if($invoice_header==''){$invoice_header = $T_shipping_user_name;}
		
			
			if(($data['C']=='特价订单') || ($data['C']=='团购订单'))
			{
			$coupon_price='';
			}
			else
			{
			$coupon_price= $data['U']*-1;
			}
			
			$list[] = array(
				//'no' => $data['A'],
				'order_id' => $T_order_id,
				'pid' => $data['AN'],
				'num' => $data['AR'],
				'price' => $data['AP'],
				'coupon_price' => $coupon_price,
				'plan_times' => trim( $data['AU'] ),
				'invoice_header' => $data['AL'],
				'order_user_name' => $T_order_user_name,
				'shipping_user_name' => $T_shipping_user_name,
				'shipping_user_sn' => '',
				'shipping_phone' => $T_shipping_phone,
				'shipping_phone2' => $T_shipping_phone2,
				'shipping_address' => $T_shipping_address,
				'shipping_zip' => $T_shipping_zip,
				'comment' => $T_comment,
				'shipping_order_time' => $T_shipping_order_time,
				
				'order_invoice_header' =>$data['AL'],
				'total_pay_money' => $data['V']+$data['W'],
				'total_pay_num' => $data['AR'],
				'extra_name' => $data['AO'],
				'shipping_pssj' => '',
				'buy_type' => '',
				//'buy_type' => $data['H'],

				//'data' => $data,
			);
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 10;
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		//$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];
		
		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];
		
		$orderData['ppIDS'] = 60;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],60 );
		
		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['sale_price'] = $val['price'];
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['price']-$val['coupon_price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'timeing' => $val['shipping_order_time'],
		);
	}
	return $orderList;
}


//建设银行 →善荣商城
function ImportJianSheSR( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );
	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	$PHPReader = new PHPExcel_Reader_Excel5();
	if( !$PHPReader->canRead( $filePath ) ){exit( '错误的Excel文件' );}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();
	//echo $rowNum;

	$list = array();
	$k=0;
	$TT_order_id='';
	for ( $i = 3; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
		
		$data['AA'] = $Sheet->getCell( 'AA' . "{$i}" )->getValue();
		$data['AB'] = $Sheet->getCell( 'AB' . "{$i}" )->getValue();
		$data['AE'] = $Sheet->getCell( 'AE' . "{$i}" )->getValue();
		$data['AC'] = $Sheet->getCell( 'AC' . "{$i}" )->getValue();
		
		$data['AD'] = $Sheet->getCell( 'AD' . "{$i}" )->getValue();
		$data['AF'] = $Sheet->getCell( 'AF' . "{$i}" )->getValue();
		$data['AG'] = $Sheet->getCell( 'AG' . "{$i}" )->getValue();
		$data['AH'] = $Sheet->getCell( 'AH' . "{$i}" )->getValue();
		$data['AI'] = $Sheet->getCell( 'AI' . "{$i}" )->getValue();
		$data['AJ'] = $Sheet->getCell( 'AJ' . "{$i}" )->getValue();
		$data['AK'] = $Sheet->getCell( 'AK' . "{$i}" )->getValue();
		$data['AL'] = $Sheet->getCell( 'AL' . "{$i}" )->getValue();
		$data['AM'] = $Sheet->getCell( 'AM' . "{$i}" )->getValue();
		$data['AN'] = $Sheet->getCell( 'AN' . "{$i}" )->getValue();
		$data['AO'] = $Sheet->getCell( 'AO' . "{$i}" )->getValue();
		$data['AP'] = $Sheet->getCell( 'AP' . "{$i}" )->getValue();
		$data['AQ'] = $Sheet->getCell( 'AQ' . "{$i}" )->getValue();
		$data['AR'] = $Sheet->getCell( 'AR' . "{$i}" )->getValue();

		$data['AS'] = $Sheet->getCell( 'AS' . "{$i}" )->getValue();
		$data['AT'] = $Sheet->getCell( 'AT' . "{$i}" )->getValue();
		$data['AU'] = $Sheet->getCell( 'AU' . "{$i}" )->getValue();
		$data['AV'] = $Sheet->getCell( 'AV' . "{$i}" )->getValue();
		$data['AW'] = $Sheet->getCell( 'AW' . "{$i}" )->getValue();
		$data['AX'] = $Sheet->getCell( 'AX' . "{$i}" )->getValue();
		$data['AY'] = $Sheet->getCell( 'AY' . "{$i}" )->getValue();
		$data['AZ'] = $Sheet->getCell( 'AZ' . "{$i}" )->getValue();
		
		
		
		if($data['A']===$TT_order_id || $data['A']=='')
		{
		$k++;
		$T_order_id = $TT_order_id .'-'.$k;
		$T_order_user_name = $TT_order_user_name;
		$T_shipping_user_name = $TT_shipping_user_name;
		$T_shipping_address = $TT_shipping_address;
		$T_shipping_phone = $TT_shipping_phone;
		$T_shipping_phone2 = $TT_shipping_phone2;
		$T_shipping_zip = $TT_shipping_zip;
		$T_comment =$TT_comment ;
		$T_shipping_order_time =$TT_shipping_order_time ;
		}
		else
		{
		$k=0;
		$T_order_id = $data['A'];
		$TT_order_id = $data['A'];
		
		$T_order_user_name = $data['Z'];
		$TT_order_user_name = $data['Z'];
		$T_shipping_user_name = $data['Z'];
		$TT_shipping_user_name = $data['Z'];

		$T_shipping_address = $data['AA'] . "-" . $data['AB'] ;
		$TT_shipping_address = $data['AA'] . "-" . $data['AB'] ;
		
		$T_shipping_phone =$data['AC'];
		$TT_shipping_phone = $data['AC'];
		
		$T_shipping_phone2 = $data['AD'];
		$TT_shipping_phone2 = $data['AD'];
		
		$T_shipping_zip = $data['AF'];
		$TT_shipping_zip = $data['AF'];
		
		$T_comment = $data['N'];
		$TT_comment = $data['N'];
		
		$T_shipping_order_time =$data['L'];
		$TT_shipping_order_time =$data['L'];
		}
				//$invoice_header = trim($data['AE']);
				//if($invoice_header==''){$invoice_header = $T_shipping_user_name;}
		
			
			if(($data['C']=='特价订单') || ($data['C']=='团购订单'))
			{
			$coupon_price='';
			}
			else
			{
			$coupon_price= $data['U']*-1;
			}
			
			$list[] = array(
				//'no' => $data['A'],
				'order_id' => $T_order_id,
				'pid' => $data['AN'],
				'num' => $data['AR'],
				'price' => $data['AP'],
				'coupon_price' => $coupon_price,
				'plan_times' => trim( $data['AU'] ),
				'invoice_header' => $data['AL'],
				'order_user_name' => $T_order_user_name,
				'shipping_user_name' => $T_shipping_user_name,
				'shipping_user_sn' => '',
				'shipping_phone' => $T_shipping_phone,
				'shipping_phone2' => $T_shipping_phone2,
				'shipping_address' => $T_shipping_address,
				'shipping_zip' => $T_shipping_zip,
				'comment' => $T_comment,
				'shipping_order_time' => $T_shipping_order_time,
				
				'order_invoice_header' =>$data['AL'],
				'total_pay_money' => $data['V']+$data['W'],
				'total_pay_num' => $data['AR'],
				'extra_name' => $data['AO'],
				'shipping_pssj' => '',
				'buy_type' => '',
				//'buy_type' => $data['H'],

				//'data' => $data,
			);
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 22;
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		//$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];
		
		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];
		
		$orderData['ppIDS'] = 68;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],68 );
		
		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['sale_price'] = $val['price'];
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['price']-$val['coupon_price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'timeing' => $val['shipping_order_time'],
		);
	}
	return $orderList;
}





// 交通银行
function ImportJiaoTong( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	$k=0;
	$TT_order_id='';

	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
				//$invoice_header = trim($data['G']);
				//if($invoice_header==''){$invoice_header = $data['C'];}
		
		if ( intval( $data['A'] ) > 0 )
		{
			
			$T_phone = $data['D'];
			$T_phone =str_replace('手机：','',$T_phone);
			$T_phone =str_replace('电话：','',$T_phone);
			$T_phones=explode("，",$T_phone);
			
			
	if($data['A']===$TT_order_id || $data['A']=='')
		{
		$k++;
		$T_order_id = $TT_order_id .'-'.$k;
		}
		else
		{
		$k=0;
		$T_order_id = $data['A'];
		$TT_order_id = $data['A'];
		}
		
		
		$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'pid' => $data['H'],
				'num' => $data['M'],
				'price' => $data['L'],
				'plan_times' => trim( $data['K'] ),
				'invoice_header' => $data['G'],
				'order_user_name' => $data['C'],
				'shipping_user_name' => $data['C'],
				'coupon_price' => $data['Q'],
				//'shipping_user_sn' => $data['L'],
				'shipping_phone' => $T_phones[1],
				'shipping_phone2' => $T_phones[0],
				'shipping_address' => $data['E'],
				'shipping_zip' => $data['F'],
				'comment' => $data['Z'],
				'shipping_order_time' => $data['B'],
				
				'order_invoice_header' => $invoice_header,
				'total_pay_money' => $data['P'],
				'total_pay_num' => $data['M'],
				'extra_name' => $data['I'],
				'buy_type' => '',



				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 11;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = '';
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 61;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],61 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['sale_price'] = $val['price'];
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['I'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}





// 广发银行
function ImportGuangFa( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 5; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
		
		if (  $data['B'] )
		{
			$planTimes = (int)trim( $data['I'] );
			if($planTimes==9){$planTimes=12;}
			$list[] = array(
				'no' => $data['B'],
				'order_id' => $data['B'],
				'pid' => $data['C'],
				'num' => $data['H'],
				'price' => $data['E'],
				'plan_times' => $planTimes,
				'invoice_header' => $data['T'],
				'order_user_name' => $data['U'],
				'shipping_user_name' => $data['U'],
				//'coupon_price' => 0,
				'coupon_price' => $data['E']-$data['J'],
				//'shipping_user_sn' => $data['L'],
				'shipping_phone' => $data['V'],
				'shipping_phone2' => $data['W'],
				'shipping_address' => $data['X'],
				'shipping_zip' => $data['Y'],
				'shipping_pssj' => $data['AC'],
				'comment' => $data['AA'].'|'.$data['AB'],
				'shipping_order_time' => substr($data['B'],0,4).'-'.substr($data['B'],4,2).'-'.substr($data['B'],6,2).' 08:00:00',
				
				'order_invoice_header' => $data['T'],
				'total_pay_money' => $data['J'],
				'total_pay_num' => $data['H'],
				'extra_name' => $data['D'],
				//'buy_type' => $data['X'],

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 12;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 62;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],62 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['C'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}

// 银联数据
function ImportYinLian( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 3; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
		
		if (  $data['A']  )
		{
			//$T_phone = $data['O'];
			//$T_phones=explode("，",$T_phone);
			$list[] = array(
				'no' => $data['A'],
				'order_id' => $data['D'],
				'pid' => $data['O'],
				'num' => $data['Q'],
				'price' => $data['V'],
				'plan_times' => 1,
				'invoice_header' => '',
				'order_user_name' => $data['G'],
				'shipping_user_name' => $data['G'],
				//'coupon_price' => 0,
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				'shipping_phone' =>$data['H'],
				'shipping_phone2' => $data['I'],
				'shipping_address' => $data['J'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => '',
				'shipping_order_time' => $data['F'],
				
				'order_invoice_header' => '',//2014030711390112170-1
				'total_pay_money' => $data['Q']*$data['V'],
				'total_pay_num' => $data['Q'],
				'extra_name' => $data['P'],
				'buy_type' => '',


				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 2;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];
		$orderData['ppIDS'] = 69;


		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],69 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['F'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}


// 工行集采
function ImportGongHangJiCai( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	$k=0;
	$TT_order_id='';

	for ( $i = 3; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
		$data['AA'] = $Sheet->getCell( 'AA' . "{$i}" )->getValue();
		$data['AB'] = $Sheet->getCell( 'AB' . "{$i}" )->getValue();
		$data['AC'] = $Sheet->getCell( 'AC' . "{$i}" )->getValue();
		$data['AD'] = $Sheet->getCell( 'AD' . "{$i}" )->getValue();
		$data['AE'] = $Sheet->getCell( 'AE' . "{$i}" )->getValue();
		$data['AF'] = $Sheet->getCell( 'AF' . "{$i}" )->getValue();
		$data['AG'] = $Sheet->getCell( 'AG' . "{$i}" )->getValue();
		$data['AH'] = $Sheet->getCell( 'AH' . "{$i}" )->getValue();
		$data['AI'] = $Sheet->getCell( 'AI' . "{$i}" )->getValue();
		$data['AJ'] = $Sheet->getCell( 'AJ' . "{$i}" )->getValue();
		$data['AK'] = $Sheet->getCell( 'AK' . "{$i}" )->getValue();
		$data['AL'] = $Sheet->getCell( 'AL' . "{$i}" )->getValue();
		$data['AM'] = $Sheet->getCell( 'AM' . "{$i}" )->getValue();
		$data['AN'] = $Sheet->getCell( 'AN' . "{$i}" )->getValue();
		$data['AO'] = $Sheet->getCell( 'AO' . "{$i}" )->getValue();
		$data['AP'] = $Sheet->getCell( 'AP' . "{$i}" )->getValue();
		$data['AQ'] = $Sheet->getCell( 'AQ' . "{$i}" )->getValue();
		$data['AR'] = $Sheet->getCell( 'AR' . "{$i}" )->getValue();
		$data['AS'] = $Sheet->getCell( 'AS' . "{$i}" )->getValue();
		$data['AT'] = $Sheet->getCell( 'AT' . "{$i}" )->getValue();
		$data['AU'] = $Sheet->getCell( 'AU' . "{$i}" )->getValue();
		$data['AV'] = $Sheet->getCell( 'AV' . "{$i}" )->getValue();
		$data['AW'] = $Sheet->getCell( 'AW' . "{$i}" )->getValue();
		$data['AX'] = $Sheet->getCell( 'AX' . "{$i}" )->getValue();
		$data['AY'] = $Sheet->getCell( 'AY' . "{$i}" )->getValue();
		$data['AZ'] = $Sheet->getCell( 'AZ' . "{$i}" )->getValue();
		$data['BA'] = $Sheet->getCell( 'BA' . "{$i}" )->getValue();
		$data['BB'] = $Sheet->getCell( 'BB' . "{$i}" )->getValue();
		$data['BC'] = $Sheet->getCell( 'BC' . "{$i}" )->getValue();
		$data['BD'] = $Sheet->getCell( 'BD' . "{$i}" )->getValue();
		$data['BE'] = $Sheet->getCell( 'BE' . "{$i}" )->getValue();
		$data['BF'] = $Sheet->getCell( 'BF' . "{$i}" )->getValue();
		$data['BG'] = $Sheet->getCell( 'BG' . "{$i}" )->getValue();
		$data['BH'] = $Sheet->getCell( 'BH' . "{$i}" )->getValue();
		$data['BI'] = $Sheet->getCell( 'BI' . "{$i}" )->getValue();
		$data['BJ'] = $Sheet->getCell( 'BJ' . "{$i}" )->getValue();
		$data['BK'] = $Sheet->getCell( 'BK' . "{$i}" )->getValue();
		$data['BL'] = $Sheet->getCell( 'BL' . "{$i}" )->getValue();
		$data['BM'] = $Sheet->getCell( 'BM' . "{$i}" )->getValue();
		$data['BN'] = $Sheet->getCell( 'BN' . "{$i}" )->getValue();
		$data['BO'] = $Sheet->getCell( 'BO' . "{$i}" )->getValue();
		$data['BP'] = $Sheet->getCell( 'BP' . "{$i}" )->getValue();
		$data['BQ'] = $Sheet->getCell( 'BQ' . "{$i}" )->getValue();
		$data['BR'] = $Sheet->getCell( 'BR' . "{$i}" )->getValue();




//////////////////////////////////////////////////////////
		if($data['B']===$TT_order_id || $data['B']=='')
		{
		$k++;
		$T_order_id = $TT_order_id .'-'.$k;
		$T_order_user_name = $TT_order_user_name;
		$T_shipping_user_name = $TT_shipping_user_name;
		$T_shipping_address = $TT_shipping_address;
		$T_shipping_phone = $TT_shipping_phone;
		$T_shipping_phone2 = $TT_shipping_phone2;
		$T_shipping_zip = $TT_shipping_zip;
		$T_comment =$TT_comment ;
		$T_shipping_order_time =$TT_shipping_order_time ;
		}
		else
		{
		$k=0;
		$T_order_id = $data['B'];
		$TT_order_id = $data['B'];
		
		$T_order_user_name = $data['AF'];
		$TT_order_user_name = $data['AF'];
		$T_shipping_user_name = $data['AF'];
		$TT_shipping_user_name = $data['AF'];

		$T_shipping_address = $data['AG'] . "-" . $data['AH'] ;
		$TT_shipping_address = $data['AG'] . "-" . $data['AH'] ;
		
		$T_shipping_phone =$data['AL'];
		$TT_shipping_phone = $data['AL'];
		
		$T_shipping_phone2 = $data['AM'];
		$TT_shipping_phone2 = $data['AM'];
		
		$T_shipping_zip = $data['AP'];
		$TT_shipping_zip = $data['AP'];
		
		$T_comment = $data['K'] . "-" .$data['L'];
		$TT_comment = $data['K'] . "-" .$data['L'];
		
		$T_shipping_order_time =$data['F'];
		$TT_shipping_order_time =$data['F'];
		}
//////////////////////////////////////////////////////		
		//if (  $data['A']  )
		//{
			$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'order_user_name' => $T_order_user_name,
				'shipping_user_name' => $T_order_user_name,
				'shipping_address' => $T_shipping_address,
				'shipping_phone' =>$T_shipping_phone,
				'shipping_phone2' => $T_shipping_phone2,
				'shipping_order_time' => $T_shipping_order_time,

				'pid' => $data['BJ'],
				'num' => $data['BN'],
				'price' => $data['BM']-$data['S'],
				'plan_times' => 1,
				'invoice_header' =>  $data['AU'],
				//'coupon_price' => 0,
				'coupon_price' => $data['O']-$data['X'],
				//'shipping_user_sn' => $data['L'],
				

				'shipping_zip' => $T_shipping_zip,
				'shipping_pssj' => '',
				'comment' => $T_comment,
				
				'order_invoice_header' => $data['AU'],//2014030711390112170-1
				'total_pay_money' => $data['X'],
				'total_pay_num' => $data['BN'],
				'extra_name' => $data['BL'],
				'buy_type' => '',


				//'data' => $data,
			);
	//	}
/////////////////////////////////////////////
}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 27;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		//$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 84;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],84 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['AL'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}





// 工行融E购
function ImportRongEGou( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	$k=0;
	$TT_order_id='';

	for ( $i = 3; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
		$data['AA'] = $Sheet->getCell( 'AA' . "{$i}" )->getValue();
		$data['AB'] = $Sheet->getCell( 'AB' . "{$i}" )->getValue();
		$data['AC'] = $Sheet->getCell( 'AC' . "{$i}" )->getValue();
		$data['AD'] = $Sheet->getCell( 'AD' . "{$i}" )->getValue();
		$data['AE'] = $Sheet->getCell( 'AE' . "{$i}" )->getValue();
		$data['AF'] = $Sheet->getCell( 'AF' . "{$i}" )->getValue();
		$data['AG'] = $Sheet->getCell( 'AG' . "{$i}" )->getValue();
		$data['AH'] = $Sheet->getCell( 'AH' . "{$i}" )->getValue();
		$data['AI'] = $Sheet->getCell( 'AI' . "{$i}" )->getValue();
		$data['AJ'] = $Sheet->getCell( 'AJ' . "{$i}" )->getValue();
		$data['AK'] = $Sheet->getCell( 'AK' . "{$i}" )->getValue();
		$data['AL'] = $Sheet->getCell( 'AL' . "{$i}" )->getValue();
		$data['AM'] = $Sheet->getCell( 'AM' . "{$i}" )->getValue();
		$data['AN'] = $Sheet->getCell( 'AN' . "{$i}" )->getValue();
		$data['AO'] = $Sheet->getCell( 'AO' . "{$i}" )->getValue();
		$data['AP'] = $Sheet->getCell( 'AP' . "{$i}" )->getValue();
		$data['AQ'] = $Sheet->getCell( 'AQ' . "{$i}" )->getValue();
		$data['AR'] = $Sheet->getCell( 'AR' . "{$i}" )->getValue();
		$data['AS'] = $Sheet->getCell( 'AS' . "{$i}" )->getValue();
		$data['AT'] = $Sheet->getCell( 'AT' . "{$i}" )->getValue();
		$data['AU'] = $Sheet->getCell( 'AU' . "{$i}" )->getValue();
		$data['AV'] = $Sheet->getCell( 'AV' . "{$i}" )->getValue();
		$data['AW'] = $Sheet->getCell( 'AW' . "{$i}" )->getValue();
		$data['AX'] = $Sheet->getCell( 'AX' . "{$i}" )->getValue();
		$data['AY'] = $Sheet->getCell( 'AY' . "{$i}" )->getValue();
		$data['AZ'] = $Sheet->getCell( 'AZ' . "{$i}" )->getValue();
		$data['BA'] = $Sheet->getCell( 'BA' . "{$i}" )->getValue();
		$data['BB'] = $Sheet->getCell( 'BB' . "{$i}" )->getValue();
		$data['BC'] = $Sheet->getCell( 'BC' . "{$i}" )->getValue();
		$data['BD'] = $Sheet->getCell( 'BD' . "{$i}" )->getValue();
		$data['BE'] = $Sheet->getCell( 'BE' . "{$i}" )->getValue();
		$data['BF'] = $Sheet->getCell( 'BF' . "{$i}" )->getValue();
		$data['BG'] = $Sheet->getCell( 'BG' . "{$i}" )->getValue();
		$data['BH'] = $Sheet->getCell( 'BH' . "{$i}" )->getValue();
		$data['BI'] = $Sheet->getCell( 'BI' . "{$i}" )->getValue();
		$data['BJ'] = $Sheet->getCell( 'BJ' . "{$i}" )->getValue();
		$data['BK'] = $Sheet->getCell( 'BK' . "{$i}" )->getValue();
		$data['BL'] = $Sheet->getCell( 'BL' . "{$i}" )->getValue();
		$data['BM'] = $Sheet->getCell( 'BM' . "{$i}" )->getValue();
		$data['BN'] = $Sheet->getCell( 'BN' . "{$i}" )->getValue();
		$data['BO'] = $Sheet->getCell( 'BO' . "{$i}" )->getValue();
		$data['BP'] = $Sheet->getCell( 'BP' . "{$i}" )->getValue();
		$data['BQ'] = $Sheet->getCell( 'BQ' . "{$i}" )->getValue();
		$data['BR'] = $Sheet->getCell( 'BR' . "{$i}" )->getValue();




//////////////////////////////////////////////////////////
		if($data['B']===$TT_order_id || $data['B']=='')
		{
		$k++;
		$T_order_id = $TT_order_id .'-'.$k;
		$T_order_user_name = $TT_order_user_name;
		$T_shipping_user_name = $TT_shipping_user_name;
		$T_shipping_address = $TT_shipping_address;
		$T_shipping_phone = $TT_shipping_phone;
		$T_shipping_phone2 = $TT_shipping_phone2;
		$T_shipping_zip = $TT_shipping_zip;
		$T_comment =$TT_comment ;
		$T_shipping_order_time =$TT_shipping_order_time ;
		}
		else
		{
		$k=0;
		$T_order_id = $data['B'];
		$TT_order_id = $data['B'];
		
		$T_order_user_name = $data['AG'];
		$TT_order_user_name = $data['AG'];
		$T_shipping_user_name = $data['AG'];
		$TT_shipping_user_name = $data['AG'];

		$T_shipping_address = $data['AH'] . "-" . $data['AI'] ;
		$TT_shipping_address = $data['AH'] . "-" . $data['AI'] ;
		
		$T_shipping_phone =$data['AM'];
		$TT_shipping_phone = $data['AM'];
		
		$T_shipping_phone2 = $data['AN'];
		$TT_shipping_phone2 = $data['AN'];
		
		$T_shipping_zip = $data['AQ'];
		$TT_shipping_zip = $data['AQ'];
		
		$T_comment = $data['K'] . "-" .$data['L'];
		$TT_comment = $data['K'] . "-" .$data['L'];
		
		$T_shipping_order_time =$data['F'];
		$TT_shipping_order_time =$data['F'];
		}
//////////////////////////////////////////////////////		
		//if (  $data['A']  )
		//{
		$FQS = (int)$data['Z'];
		if($FQS==0){$FQS=1;}
			$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'order_user_name' => $T_order_user_name,
				'shipping_user_name' => $T_order_user_name,
				'shipping_address' => $T_shipping_address,
				'shipping_phone' =>$T_shipping_phone,
				'shipping_phone2' => $T_shipping_phone2,
				'shipping_order_time' => $T_shipping_order_time,

				'pid' => $data['BK'],
				'num' => $data['BO'],
				'price' => $data['BN']-$data['T'],
				'plan_times' => $FQS,
				'invoice_header' =>  $data['AV'],
				//'coupon_price' => 0,
				'coupon_price' => $data['P']-$data['Y'],
				//'shipping_user_sn' => $data['L'],
				

				'shipping_zip' => $T_shipping_zip,
				'shipping_pssj' => '',
				'comment' => $T_comment,
				
				'order_invoice_header' => $data['AV'],//2014030711390112170-1
				'total_pay_money' => $data['Y'],
				'total_pay_num' => $data['BO'],
				'extra_name' => $data['BM'],
				'buy_type' => '',


				//'data' => $data,
			);
	//	}
/////////////////////////////////////////////
}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 13;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		//$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 70;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],70 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['AL'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}


//中信银行
function ImportZhongXin( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();


	$list = array();
	for ( $i = 5; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
		$data['AA'] = $Sheet->getCell( 'AA' . "{$i}" )->getValue();
		$data['AB'] = $Sheet->getCell( 'AB' . "{$i}" )->getValue();

		
		if ( intval( $data['A'] ) > 0 )
		{
			$list[] = array(
				'no' => $data['B'],
				'order_id' => $data['B'],
				'pid' => $data['C'],
				'num' => $data['E'],
				'price' => $data['F'],
				'plan_times' => $data['G'],
				'invoice_header' => $data['O'],
				'order_user_name' => $data['R'],
				'shipping_user_name' => $data['R'],
				//'coupon_price' => 0,
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				'shipping_phone' => $data['T'],
				'shipping_phone2' => $data['U'],
				'shipping_address' => $data['V'],
				'shipping_zip' => $data['W'],
				//'shipping_pssj' => $data['AA'],
				'comment' => $data['M'].'|'.$data['Y'],
				'shipping_order_time' => substr($data['B'],0,4).'-'.substr($data['B'],4,2).'-'.substr($data['B'],6,2).' 08:00:00',
				
				'order_invoice_header' => $data['O'],
				'total_pay_money' => $data['F']*$data['E'],
				'total_pay_num' => $data['E'],
				'extra_name' => $data['D'],
				'buy_type' => $data['L'],

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 1;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		//$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 55;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],55 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['AL'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}
	return $orderList;
}



































// 通联支付
function ImportTongLian( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 3; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		$data['AA'] = $Sheet->getCell( 'AA' . "{$i}" )->getValue();
		$data['AB'] = $Sheet->getCell( 'AB' . "{$i}" )->getValue();
		$data['AC'] = $Sheet->getCell( 'AC' . "{$i}" )->getValue();
		$data['AD'] = $Sheet->getCell( 'AD' . "{$i}" )->getValue();
		$data['AE'] = $Sheet->getCell( 'AE' . "{$i}" )->getValue();
		$data['AF'] = $Sheet->getCell( 'AF' . "{$i}" )->getValue();
		$data['AG'] = $Sheet->getCell( 'AG' . "{$i}" )->getValue();
		$data['AH'] = $Sheet->getCell( 'AH' . "{$i}" )->getValue();
		$data['AI'] = $Sheet->getCell( 'AI' . "{$i}" )->getValue();
		$data['AJ'] = $Sheet->getCell( 'AJ' . "{$i}" )->getValue();
		$data['AK'] = $Sheet->getCell( 'AK' . "{$i}" )->getValue();
		$data['AL'] = $Sheet->getCell( 'AL' . "{$i}" )->getValue();
		$data['AM'] = $Sheet->getCell( 'AM' . "{$i}" )->getValue();
		$data['AN'] = $Sheet->getCell( 'AN' . "{$i}" )->getValue();
		$data['AO'] = $Sheet->getCell( 'AO' . "{$i}" )->getValue();
		$data['AP'] = $Sheet->getCell( 'AP' . "{$i}" )->getValue();
		$data['AQ'] = $Sheet->getCell( 'AQ' . "{$i}" )->getValue();
		$data['AR'] = $Sheet->getCell( 'AR' . "{$i}" )->getValue();
		$data['AS'] = $Sheet->getCell( 'AS' . "{$i}" )->getValue();
		$data['AT'] = $Sheet->getCell( 'AT' . "{$i}" )->getValue();
		$data['AU'] = $Sheet->getCell( 'AU' . "{$i}" )->getValue();
		$data['AV'] = $Sheet->getCell( 'AV' . "{$i}" )->getValue();
		
		if (  $data['B']  )
		{
			$T_phone = $data['AB'];
			$T_phones=explode("/",$T_phone);
			//if($data['K']==0){
			//$Tprice = $data['L']/1000;
			//$total_pay_money = $data['L']/1000;
			//}else{
			//$Tprice = $data['M']/$data['L'];
			//$total_pay_money = $data['O'];
			//}
			
			
			
			$list[] = array(
				'no' => $data['B'],
				'order_id' => $data['B'],
				'pid' => $data['D'],
				'num' => $data['L'],

				'price' => $data['M']/(int)$data['L'],
				'plan_times' => 1,
				'invoice_header' => $data['AD'],
				'order_user_name' => $data['AA'],
				'shipping_user_name' => $data['AA'],
				//'coupon_price' => 0,
				'coupon_price' => $data['M']-$data['Q'],
				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$T_phones[0],
				'shipping_phone2' => $T_phones[1],
				'shipping_address' => $data['AC'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => $data['A']."：".$data['AE'],
				'shipping_order_time' => $data['T'],
				
				'order_invoice_header' => $data['AD'],
				'total_pay_money' => $data['Q'],
				'total_pay_num' => $data['L'],
				'extra_name' => $data['E'],
				'buy_type' => '',


				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 14;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 71;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],71 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['E'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}


//民生
function ImportMinSheng( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		for ( $c = 65; $c < 91; $c++ )
		{
			$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
		}
		
		if ( intval( $data['A'] ) )
		{
			
			
		if($data['A']===$TT_order_id )
		{
		$k++;
		$T_order_id = $TT_order_id .'-'.$k;
		}
		else
		{
		$k=0;
		$T_order_id = $data['A'];
		$TT_order_id = $data['A'];
		}
			
			
			
			$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'pid' => $data['G'],
				'num' => $data['J'],
				'price' => $data['I'],
				'plan_times' => 1,
				'invoice_header' => $data['H'],
				'order_user_name' => $data['C'],
				'shipping_user_name' => $data['C'],
				//'coupon_price' => 0,
				'coupon_price' => $data['O'],
				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['E'],
				'shipping_phone2' => '',
				'shipping_address' => $data['D'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => '',
				'shipping_order_time' => $data['B'],
				
				'order_invoice_header' => $data['H'],
				'total_pay_money' => $data['N'],
				'total_pay_num' => $data['J'],
				'extra_name' => $data['H'],
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 4;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 72;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],72 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['E'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}

// 易礼网
function ImportYiLiWang( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
		
		if (  trim($data['A'])  )
		{


		if(trim($data['A'])===$TT_order_id )
		{
		$k++;
		$T_order_id = $TT_order_id .'-'.$k;
		}
		else
		{
		$k=0;
		$T_order_id = trim($data['A']);
		$TT_order_id = trim($data['A']);
		}
			
			$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'pid' => trim($data['S']),
				'num' => trim($data['U']),
				'price' => trim($data['V']),
				'plan_times' => 1,
				'invoice_header' => '',
				'order_user_name' => $data['J'],
				'shipping_user_name' => $data['J'],
				//'coupon_price' => 0,
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>trim($data['K']),
				'shipping_phone2' => trim($data['K']),
				'shipping_address' =>trim( $data['M']).trim( $data['N']).trim( $data['O']).trim( $data['P']),
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => $data['T'],
				//'shipping_order_time' =>  substr($data['B'],0,4).'-'.substr($data['B'],4,2).'-'.substr($data['B'],6,2).' 08:00:00',CheckExcelDate($data['C'])
				'shipping_order_time' =>  CheckExcelDate($data['B']),
				
				'order_invoice_header' => '',//2014030711390112170-1
				'total_pay_money' => trim($data['U']*$data['V']),
				'total_pay_num' => trim($data['U']),
				'extra_name' => trim($data['R']),
				'buy_type' => '',


				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 15;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 73;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],73 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['F'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}

// 平安
function ImportPingAn( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		for ( $c = 65; $c < 91; $c++ )
		{
			$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
		}
		
		if ( intval( $data['B'] ) )
		{
			$list[] = array(
				'no' => $data['B'],
				'order_id' => $data['B'],
				'pid' => trim($data['D']),
				'num' => 1,
				'price' => $data['W'],
				'plan_times' => (int)$data['U'],
				'invoice_header' => $data['AD'],
				'order_user_name' => $data['P'],
				'shipping_user_name' => $data['P'],
				//'coupon_price' => 0,
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['Q'],
				'shipping_phone2' => $data['R'],
				'shipping_address' => $data['S'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => $data['AF'].$data['K'].$data['L'],
				'shipping_order_time' => $data['G'],
				
				'order_invoice_header' => $data['AD'],
				'total_pay_money' => $data['W'],
				'total_pay_num' => 1,
				'extra_name' => $data['F'],
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 18;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		//$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 58;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],58 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['E'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}
// 农商
function ImportNongShang( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		for ( $c = 65; $c < 91; $c++ )
		{
			$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
		}
		
		if ( intval( $data['C'] ) )
		{
			$list[] = array(
				'no' => $data['B'],
				'order_id' => $data['B'],
				'pid' => trim($data['M']),
				'num' => $data['S'],
				'price' => $data['R'],
				'plan_times' => 1,
				'invoice_header' => '',
				'order_user_name' => $data['G'],
				'shipping_user_name' => $data['G'],
				//'coupon_price' => 0,
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['H'],
				'shipping_phone2' => $data['H'],
				'shipping_address' => $data['J'].'-'.$data['K'],
				'shipping_zip' => $data['I'],
				'shipping_pssj' => '',
				'comment' => '',
				'shipping_order_time' => $data['C'],
				
				'order_invoice_header' => '',
				'total_pay_money' => $data['D'],
				'total_pay_num' => $data['S'],
				'extra_name' => $data['N'],
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 16;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 74;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],74 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['E'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}


// 邮乐
function ImportYouLe( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		//for ( $c = 65; $c < 91; $c++ )
		//{
			//$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
	//	}
		
		if ( intval( $data['C'] ) )
		{


	if($data['C']===$TT_order_id || $data['C']=='')
		{
		$k++;
		$T_order_id = $TT_order_id .'_'.$k;
		}
		else
		{
		$k=0;
		$T_order_id = $data['C'];
		$TT_order_id = $data['C'];
		}



			$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'pid' => trim($data['H']),
				'num' => $data['O'],
				'price' => $data['Q'],
				'plan_times' => 1,
				'invoice_header' => '',
				'order_user_name' => $data['X'],
				'shipping_user_name' => $data['X'],
				//'coupon_price' => 0,
				'coupon_price' => 0,


				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['Y'],
				'shipping_phone2' => $data['Z'],
				'shipping_address' => $data['R']."、".$data['S']."、".$data['T']."、".$data['U'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => '',
				'shipping_order_time' => substr($data['B'],0,4).'-'.substr($data['B'],4,2).'-'.substr($data['B'],6,2).' 08:00:00',
				
				'order_invoice_header' => '',
				'total_pay_money' => $data['AH'],
				'total_pay_num' => $data['O'],
				'extra_name' => $data['I'],
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 19;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 77;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],77 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['E'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}
// 邮乐


// 邮储
function ImportYouChu( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

$k=0;
	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		//for ( $c = 65; $c < 91; $c++ )
		//{
			//$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
	//	}

		
		if ( intval( $data['C'] ) )
		{


	if($data['C']===$TT_order_id || $data['C']=='')
		{
		$k++;
		$T_order_id = $TT_order_id .'_'.$k;
		}
		else
		{
		$k=0;
		$T_order_id = $data['C'];
		$TT_order_id = $data['C'];
		}



			$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'pid' => trim($data['H']),
				'num' => $data['O'],
				'price' => $data['Q'],
				'plan_times' => 1,
				'invoice_header' => '',
				'order_user_name' => $data['X'],
				'shipping_user_name' => $data['X'],
				//'coupon_price' => 0,
				'coupon_price' => 0,


				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['Y'],
				'shipping_phone2' => $data['Z'],
				'shipping_address' => $data['R']."、".$data['S']."、".$data['T']."、".$data['U'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => '',
				'shipping_order_time' => substr($data['B'],0,4).'-'.substr($data['B'],4,2).'-'.substr($data['B'],6,2).' 08:00:00',
				
				'order_invoice_header' => '',
				'total_pay_money' => $data['AH'],
				'total_pay_num' => $data['O'],
				'extra_name' => $data['I'],
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}


	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 20;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];
		$orderData['ppIDS'] = 78;


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];


		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],78 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['E'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}
// 邮储



// 三位度
function ImportSanWeiDu( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	$k=0;
	$TT_order_id='';

	for ( $i = 5; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
				//$invoice_header = trim($data['G']);
				//if($invoice_header==''){$invoice_header = $data['C'];}
		
		if ( intval( $data['A'] ) > 0 )
		{
						
			
	if($data['A']===$TT_order_id || $data['A']=='')
		{
		$k++;
		$T_order_id = $TT_order_id .'_'.$k;
		}
		else
		{
		$k=0;
		$T_order_id = $data['A'];
		$TT_order_id = $data['A'];
		}
		
		
		$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'pid' => $data['F'],
				'num' => (int)$data['K'],
				'price' =>  (float)$data['P'],
				'plan_times' => 1,
				'invoice_header' => '',
				'order_user_name' => $data['L'],
				'shipping_user_name' => $data['L'],
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				'shipping_phone' => $data['M'],
				'shipping_phone2' => '',
				'shipping_address' => $data['N'],
				'shipping_zip' => '',
				'comment' => $data['H'],
				'shipping_order_time' => $data['D'],
				
				'order_invoice_header' => '',
				'total_pay_money' => (float)$data['P']*(int)$data['K'],
				'total_pay_num' => (int)$data['K'],
				'extra_name' => $data['G'],
				'buy_type' => '',



				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 21;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = '';
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 79;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],79 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['sale_price'] = $val['price'];
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['I'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}




// 惠家有
function ImportHJY( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		//for ( $c = 65; $c < 91; $c++ )
		//{
			//$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
	//	}
		
		if ($data['A']!="" )
		{
			$list[] = array(
				'no' => $data['A'],
				'order_id' => $data['A'],
				'pid' => trim($data['K']),
				'num' => $data['J'],
				'price' => $data['R'],
				'plan_times' => 1,
				'invoice_header' => '',
				'order_user_name' => $data['N'],
				'shipping_user_name' => $data['N'],
				//'coupon_price' => 0,
				'coupon_price' => 0,


				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['D'],
				'shipping_phone2' => '',
				'shipping_address' => $data['O'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => $data['S'],
				'shipping_order_time' => CheckExcelDate($data['B']),
				
				'order_invoice_header' => '',
				'total_pay_money' => $data['R']*$data['J'],
				'total_pay_num' => $data['J'],
				'extra_name' => $data['H'],
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}


	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 23;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];
		$orderData['ppIDS'] = 80;


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];


		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],80 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['E'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}
// 惠家有


// E中信
function ImportEzhongxin( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	$k=0;
	$TT_order_id='';

	for ( $i = 3; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
				//$invoice_header = trim($data['G']);
				//if($invoice_header==''){$invoice_header = $data['C'];}
		
		if ($data['A'])
		{
						
			
	if($data['A']===$TT_order_id || $data['A']=='')
		{
		$k++;
		$T_order_id = $TT_order_id .'_'.$k;
		}
		else
		{
		$k=0;
		$T_order_id = $data['A'];
		$TT_order_id = $data['A'];
		}
		
		
		$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'pid' => $data['B'],
				'num' => (int)$data['M'],
				'price' =>  (float)$data['I'],
				'plan_times' => 1,
				'invoice_header' =>$data['V'],
				'order_user_name' => $data['N'],
				'shipping_user_name' => $data['N'],
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				'shipping_phone' => $data['S'],
				'shipping_phone2' => '',
				'shipping_address' => $data['O'].$data['P'].$data['Q'].$data['R'],
				'shipping_zip' => '',
				'comment' => $data['Y'],
				'shipping_order_time' => substr($data['A'],0,4).'-'.substr($data['A'],4,2).'-'.substr($data['A'],6,2).' 08:00:00',
				
				'order_invoice_header' => '',
				'total_pay_money' => (float)$data['I']*(int)$data['M'],
				'total_pay_num' => (int)$data['M'],
				'extra_name' => $data['C'],
				'buy_type' => '',



				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 24;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = '';
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 81;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],81 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['sale_price'] = $val['price'];
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['C'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}

// E中信

// 乐易通
function ImportLeYiTong( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	$k=0;
	$TT_order_id='';

	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
				//$invoice_header = trim($data['G']);
				//if($invoice_header==''){$invoice_header = $data['C'];}
		
		if ($data['A'])
		{
								
		$list[] = array(
				'no' => $data['D'],
				'order_id' => $data['D'],
				'pid' => $data['A'],
				'num' => (int)$data['F'],
				'price' =>  (float)$data['H'],
				'plan_times' => 1,
				'invoice_header' =>'',
				'order_user_name' => $data['I'],
				'shipping_user_name' => $data['I'],
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				'shipping_phone' => $data['J'],
				'shipping_phone2' => '',
				'shipping_address' => $data['K'],
				'shipping_zip' => '',
				'comment' => '',
				'shipping_order_time' => CheckExcelDate($data['C']),
				
				'order_invoice_header' => '',
				'total_pay_money' => (float)$data['H']*(int)$data['F'],
				'total_pay_num' => (int)$data['F'],
				'extra_name' => $data['E'],
				'buy_type' => '',



				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 17;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = '';
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 76;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],76 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['sale_price'] = $val['price'];
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['C'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}

//乐易通

// 北京积分
function ImportBJjifen( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	$k=0;
	$TT_order_id='';

	for ( $i = 3; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
/*
		$data['AA'] = $Sheet->getCell( 'AA' . "{$i}" )->getValue();
		$data['AB'] = $Sheet->getCell( 'AB' . "{$i}" )->getValue();
		$data['AC'] = $Sheet->getCell( 'AC' . "{$i}" )->getValue();
		$data['AD'] = $Sheet->getCell( 'AD' . "{$i}" )->getValue();
		$data['AE'] = $Sheet->getCell( 'AE' . "{$i}" )->getValue();
		$data['AF'] = $Sheet->getCell( 'AF' . "{$i}" )->getValue();
		$data['AG'] = $Sheet->getCell( 'AG' . "{$i}" )->getValue();
		$data['AH'] = $Sheet->getCell( 'AH' . "{$i}" )->getValue();
		$data['AI'] = $Sheet->getCell( 'AI' . "{$i}" )->getValue();
		$data['AJ'] = $Sheet->getCell( 'AJ' . "{$i}" )->getValue();
		$data['AK'] = $Sheet->getCell( 'AK' . "{$i}" )->getValue();
		$data['AL'] = $Sheet->getCell( 'AL' . "{$i}" )->getValue();
		$data['AM'] = $Sheet->getCell( 'AM' . "{$i}" )->getValue();
		$data['AN'] = $Sheet->getCell( 'AN' . "{$i}" )->getValue();
		$data['AO'] = $Sheet->getCell( 'AO' . "{$i}" )->getValue();
		$data['AP'] = $Sheet->getCell( 'AP' . "{$i}" )->getValue();
		$data['AQ'] = $Sheet->getCell( 'AQ' . "{$i}" )->getValue();
		$data['AR'] = $Sheet->getCell( 'AR' . "{$i}" )->getValue();
		$data['AS'] = $Sheet->getCell( 'AS' . "{$i}" )->getValue();
		$data['AT'] = $Sheet->getCell( 'AT' . "{$i}" )->getValue();
		$data['AU'] = $Sheet->getCell( 'AU' . "{$i}" )->getValue();
		$data['AV'] = $Sheet->getCell( 'AV' . "{$i}" )->getValue();
		$data['AW'] = $Sheet->getCell( 'AW' . "{$i}" )->getValue();
		$data['AX'] = $Sheet->getCell( 'AX' . "{$i}" )->getValue();
		$data['AY'] = $Sheet->getCell( 'AY' . "{$i}" )->getValue();
		$data['AZ'] = $Sheet->getCell( 'AZ' . "{$i}" )->getValue();
		$data['BA'] = $Sheet->getCell( 'BA' . "{$i}" )->getValue();
		$data['BB'] = $Sheet->getCell( 'BB' . "{$i}" )->getValue();
		$data['BC'] = $Sheet->getCell( 'BC' . "{$i}" )->getValue();
		$data['BD'] = $Sheet->getCell( 'BD' . "{$i}" )->getValue();
		$data['BE'] = $Sheet->getCell( 'BE' . "{$i}" )->getValue();
		$data['BF'] = $Sheet->getCell( 'BF' . "{$i}" )->getValue();
		$data['BG'] = $Sheet->getCell( 'BG' . "{$i}" )->getValue();
		$data['BH'] = $Sheet->getCell( 'BH' . "{$i}" )->getValue();
		$data['BI'] = $Sheet->getCell( 'BI' . "{$i}" )->getValue();
		$data['BJ'] = $Sheet->getCell( 'BJ' . "{$i}" )->getValue();
		$data['BK'] = $Sheet->getCell( 'BK' . "{$i}" )->getValue();
		$data['BL'] = $Sheet->getCell( 'BL' . "{$i}" )->getValue();
		$data['BM'] = $Sheet->getCell( 'BM' . "{$i}" )->getValue();
		$data['BN'] = $Sheet->getCell( 'BN' . "{$i}" )->getValue();
		$data['BO'] = $Sheet->getCell( 'BO' . "{$i}" )->getValue();
		$data['BP'] = $Sheet->getCell( 'BP' . "{$i}" )->getValue();
		$data['BQ'] = $Sheet->getCell( 'BQ' . "{$i}" )->getValue();
		$data['BR'] = $Sheet->getCell( 'BR' . "{$i}" )->getValue();

*/

if ((int)$data['Q']>0){

//////////////////////////////////////////////////////////
		if($data['D']===$TT_order_id || $data['D']=='')
		{
		$k++;
		$T_order_id = $TT_order_id .'-'.$k;
		$T_order_user_name = $TT_order_user_name;
		$T_shipping_user_name = $TT_shipping_user_name;
		$T_shipping_address = $TT_shipping_address;
		$T_shipping_phone = $TT_shipping_phone;
		$T_shipping_phone2 = $TT_shipping_phone2;
		$T_shipping_zip = $TT_shipping_zip;
		$T_comment =$TT_comment ;
		$T_shipping_order_time =$TT_shipping_order_time ;
		}
		else
		{
		$k=0;
		$T_order_id = $data['D'];
		$TT_order_id = $data['D'];
		
		$T_order_user_name = $data['G'];
		$TT_order_user_name = $data['G'];
		$T_shipping_user_name = $data['G'];
		$TT_shipping_user_name = $data['G'];

		$T_shipping_address = $data['J'];
		$TT_shipping_address = $data['J'];
		
		$T_shipping_phone =$data['H'];
		$TT_shipping_phone = $data['H'];
		
		$T_shipping_phone2 = $data['I'];
		$TT_shipping_phone2 = $data['I'];
		
		//$T_shipping_zip = $data['AP'];
		//$TT_shipping_zip = $data['AP'];
		
		$T_comment = $data['K'].'_'.$data['L'];
		$TT_comment = $data['K'].'_'.$data['L'];
		
		$T_shipping_order_time = CheckExcelDate($data['F']);
		$TT_shipping_order_time = CheckExcelDate($data['F']);
		}
//////////////////////////////////////////////////////		
		//if (  $data['A']  )
		//{
			$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'order_user_name' => $T_order_user_name,
				'shipping_user_name' => $T_order_user_name,
				'shipping_address' => $T_shipping_address,
				'shipping_phone' =>$T_shipping_phone,
				'shipping_phone2' => $T_shipping_phone2,
				'shipping_order_time' => $T_shipping_order_time,

				'pid' => $data['O'],
				'num' => $data['Q'],
				'price' => $data['V']/$data['Q'],
				'plan_times' => 1,
				'invoice_header' =>  '',
				//'coupon_price' => 0,
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				

				'shipping_zip' => $T_shipping_zip,
				'shipping_pssj' => '',
				'comment' => $T_comment,
				
				'order_invoice_header' => '',//2014030711390112170-1
				'total_pay_money' => $data['V'],
				'total_pay_num' => $data['Q'],
				'extra_name' => $data['P'],
				'buy_type' => '',


				//'data' => $data,
			);
	//	}
/////////////////////////////////////////////
}
}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 25;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		//$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 82;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],82 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['AL'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}
//北京积分

// 资和信
function ImportZiHeXin( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	$k=0;
	$TT_order_id='';

	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
/*
		$data['AA'] = $Sheet->getCell( 'AA' . "{$i}" )->getValue();
		$data['AB'] = $Sheet->getCell( 'AB' . "{$i}" )->getValue();
		$data['AC'] = $Sheet->getCell( 'AC' . "{$i}" )->getValue();
		$data['AD'] = $Sheet->getCell( 'AD' . "{$i}" )->getValue();
		$data['AE'] = $Sheet->getCell( 'AE' . "{$i}" )->getValue();
		$data['AF'] = $Sheet->getCell( 'AF' . "{$i}" )->getValue();
		$data['AG'] = $Sheet->getCell( 'AG' . "{$i}" )->getValue();
		$data['AH'] = $Sheet->getCell( 'AH' . "{$i}" )->getValue();
		$data['AI'] = $Sheet->getCell( 'AI' . "{$i}" )->getValue();
		$data['AJ'] = $Sheet->getCell( 'AJ' . "{$i}" )->getValue();
		$data['AK'] = $Sheet->getCell( 'AK' . "{$i}" )->getValue();
		$data['AL'] = $Sheet->getCell( 'AL' . "{$i}" )->getValue();
		$data['AM'] = $Sheet->getCell( 'AM' . "{$i}" )->getValue();
		$data['AN'] = $Sheet->getCell( 'AN' . "{$i}" )->getValue();
		$data['AO'] = $Sheet->getCell( 'AO' . "{$i}" )->getValue();
		$data['AP'] = $Sheet->getCell( 'AP' . "{$i}" )->getValue();
		$data['AQ'] = $Sheet->getCell( 'AQ' . "{$i}" )->getValue();
		$data['AR'] = $Sheet->getCell( 'AR' . "{$i}" )->getValue();
		$data['AS'] = $Sheet->getCell( 'AS' . "{$i}" )->getValue();
		$data['AT'] = $Sheet->getCell( 'AT' . "{$i}" )->getValue();
		$data['AU'] = $Sheet->getCell( 'AU' . "{$i}" )->getValue();
		$data['AV'] = $Sheet->getCell( 'AV' . "{$i}" )->getValue();
		$data['AW'] = $Sheet->getCell( 'AW' . "{$i}" )->getValue();
		$data['AX'] = $Sheet->getCell( 'AX' . "{$i}" )->getValue();
		$data['AY'] = $Sheet->getCell( 'AY' . "{$i}" )->getValue();
		$data['AZ'] = $Sheet->getCell( 'AZ' . "{$i}" )->getValue();
		$data['BA'] = $Sheet->getCell( 'BA' . "{$i}" )->getValue();
		$data['BB'] = $Sheet->getCell( 'BB' . "{$i}" )->getValue();
		$data['BC'] = $Sheet->getCell( 'BC' . "{$i}" )->getValue();
		$data['BD'] = $Sheet->getCell( 'BD' . "{$i}" )->getValue();
		$data['BE'] = $Sheet->getCell( 'BE' . "{$i}" )->getValue();
		$data['BF'] = $Sheet->getCell( 'BF' . "{$i}" )->getValue();
		$data['BG'] = $Sheet->getCell( 'BG' . "{$i}" )->getValue();
		$data['BH'] = $Sheet->getCell( 'BH' . "{$i}" )->getValue();
		$data['BI'] = $Sheet->getCell( 'BI' . "{$i}" )->getValue();
		$data['BJ'] = $Sheet->getCell( 'BJ' . "{$i}" )->getValue();
		$data['BK'] = $Sheet->getCell( 'BK' . "{$i}" )->getValue();
		$data['BL'] = $Sheet->getCell( 'BL' . "{$i}" )->getValue();
		$data['BM'] = $Sheet->getCell( 'BM' . "{$i}" )->getValue();
		$data['BN'] = $Sheet->getCell( 'BN' . "{$i}" )->getValue();
		$data['BO'] = $Sheet->getCell( 'BO' . "{$i}" )->getValue();
		$data['BP'] = $Sheet->getCell( 'BP' . "{$i}" )->getValue();
		$data['BQ'] = $Sheet->getCell( 'BQ' . "{$i}" )->getValue();
		$data['BR'] = $Sheet->getCell( 'BR' . "{$i}" )->getValue();

*/

if ((int)$data['I']>0){

//////////////////////////////////////////////////////////
		if($data['A']===$TT_order_id || $data['A']=='')
		{
		$k++;
		$T_order_id = $TT_order_id .'-'.$k;
		$T_order_user_name = $TT_order_user_name;
		$T_shipping_user_name = $TT_shipping_user_name;
		$T_shipping_address = $TT_shipping_address;
		$T_shipping_phone = $TT_shipping_phone;
		$T_shipping_phone2 = $TT_shipping_phone2;
		$T_shipping_zip = $TT_shipping_zip;
		$T_comment =$TT_comment ;
		$T_shipping_order_time =$TT_shipping_order_time ;
		}
		else
		{
		$k=0;
		$T_order_id = $data['A'];
		$TT_order_id = $data['A'];
		
		$T_order_user_name = $data['C'];
		$TT_order_user_name = $data['C'];
		$T_shipping_user_name = $data['C'];
		$TT_shipping_user_name = $data['C'];

		$T_shipping_address = $data['E'];
		$TT_shipping_address = $data['E'];
		
		$T_shipping_phone =$data['D'];
		$TT_shipping_phone = $data['D'];
		
		$T_shipping_phone2 = $data['D'];
		$TT_shipping_phone2 = $data['D'];
		
		//$T_shipping_zip = $data['AP'];
		//$TT_shipping_zip = $data['AP'];
		
		$T_comment = $data['J'];
		$TT_comment = $data['J'];
		
		$T_shipping_order_time = CheckExcelDate($data['B']);
		$TT_shipping_order_time = CheckExcelDate($data['B']);
		}
//////////////////////////////////////////////////////		
		//if (  $data['A']  )
		//{
			$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'order_user_name' => $T_order_user_name,
				'shipping_user_name' => $T_order_user_name,
				'shipping_address' => $T_shipping_address,
				'shipping_phone' =>$T_shipping_phone,
				'shipping_phone2' => $T_shipping_phone2,
				'shipping_order_time' => $T_shipping_order_time,

				'pid' => $data['F'],
				'num' => $data['I'],
				'price' => $data['H'],
				'plan_times' => 1,
				'invoice_header' =>  '',
				//'coupon_price' => 0,
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				

				'shipping_zip' => $T_shipping_zip,
				'shipping_pssj' => '',
				'comment' => $T_comment,
				
				'order_invoice_header' => '',//2014030711390112170-1
				'total_pay_money' => $data['H']*$data['I'],
				'total_pay_num' => $data['I'],
				'extra_name' => $data['G'],
				'buy_type' => '',


				//'data' => $data,
			);
	//	}
/////////////////////////////////////////////
}
}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 26;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		//$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 83;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],83 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['AL'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}
//资和信


// 内购网
function ImportNeiGouWang( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	$k=0;
	$TT_order_id='';

	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
				//$invoice_header = trim($data['G']);
				//if($invoice_header==''){$invoice_header = $data['C'];}
		
		if ($data['A'])
		{
								
		$list[] = array(
				'no' => $data['D'],
				'order_id' => $data['D'],
				'pid' => $data['B'],
				'num' => (int)$data['F'],
				'price' =>  (float)$data['M'],
				'plan_times' => 1,
				'invoice_header' =>'',
				'order_user_name' => $data['G'],
				'shipping_user_name' => $data['G'],
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				'shipping_phone' => $data['H'],
				'shipping_phone2' => '',
				'shipping_address' => $data['I'],
				'shipping_zip' => '',
				'comment' => $data['N'],
				//'shipping_order_time' => CheckExcelDate($data['D']),
				'shipping_order_time' => substr($data['D'],0,4).'-'.substr($data['D'],4,2).'-'.substr($data['D'],6,2).' 08:00:00',
				
				'order_invoice_header' => '',
				'total_pay_money' => (float)$data['M']*(int)$data['F'],
				'total_pay_num' => (int)$data['F'],
				'extra_name' => $data['C'],
				'buy_type' => '',



				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 28;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = '';
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 85;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],85 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['sale_price'] = $val['price'];
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['C'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}
// 内购网

//民生员工福利
function ImportMinShengFL( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		for ( $c = 65; $c < 91; $c++ )
		{
			$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
		}
		
		if ( intval( $data['A'] ) )
		{
			
			
		if($data['A']===$TT_order_id )
		{
		$k++;
		$T_order_id = $TT_order_id .'-'.$k;
		}
		else
		{
		$k=0;
		$T_order_id = $data['A'];
		$TT_order_id = $data['A'];
		}
			
			
			
			$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'pid' => $data['G'],
				'num' => $data['J'],
				'price' => $data['I'],
				'plan_times' => 1,
				'invoice_header' => $data['H'],
				'order_user_name' => $data['C'],
				'shipping_user_name' => $data['C'],
				//'coupon_price' => 0,
				'coupon_price' => $data['O'],
				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['E'],
				'shipping_phone2' => '',
				'shipping_address' => $data['D'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => '',
				'shipping_order_time' => $data['B'],
				
				'order_invoice_header' => $data['H'],
				'total_pay_money' => $data['N'],
				'total_pay_num' => $data['J'],
				'extra_name' => $data['H'],
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 29;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 86;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],86 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['E'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}
//民生员工福利



// 聪明购
function ImportCMG( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	$k=0;
	$TT_order_id='';

	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
				//$invoice_header = trim($data['G']);
				//if($invoice_header==''){$invoice_header = $data['C'];}
		
		if ($data['A'])
		{
								
		$list[] = array(
				'no' => $data['A'],
				'order_id' => $data['C'],
				'pid' => $data['S'],
				'num' => (int)$data['V'],
				'price' =>  (float)$data['Q'],
				'plan_times' => (int)$data['R'],
				'invoice_header' =>$data['M'],
				'order_user_name' => $data['F'],
				'shipping_user_name' => $data['F'],
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				'shipping_phone' => $data['G'],
				'shipping_phone2' => '',
				'shipping_address' => $data['H'],
				'shipping_zip' => '',
				'comment' => $data['J']."@".$data['K'],
				'shipping_order_time' => CheckExcelDate($data['D']),
				//'shipping_order_time' => substr($data['D'],0,4).'-'.substr($data['D'],4,2).'-'.substr($data['D'],6,2).' 08:00:00',
				
				'order_invoice_header' => $data['M'],
				'total_pay_money' => (float)$data['Q']*(int)$data['V'],
				'total_pay_num' => (int)$data['V'],
				'extra_name' => $data['T']."@".$data['U'],
				'buy_type' => '',



				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 30;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = '';
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 87;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],87 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['sale_price'] = $val['price'];
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['C'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}
// 聪明购



// 招商银行
function ImportZhaoShang( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	$k=0;
	$TT_order_id='';

	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
				//$invoice_header = trim($data['G']);
				//if($invoice_header==''){$invoice_header = $data['C'];}
		
		if ($data['A'])
		{
								
		$list[] = array(
				'no' => $data['A'],
				'order_id' => $data['A'],
				'pid' => $data['C'],
				'num' => 1,
				'price' =>  (float)$data['K'],
				'plan_times' => 1,
				'invoice_header' =>'',
				'order_user_name' => $data['M'],
				'shipping_user_name' => $data['M'],
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				'shipping_phone' => $data['O'],
				'shipping_phone2' => '',
				'shipping_address' => $data['P'],
				'shipping_zip' => $data['Q'],
				'comment' => "客户单号：".$data['B']."@".$data['R'],
				'shipping_order_time' => CheckExcelDate($data['I']),
				//'shipping_order_time' => substr($data['D'],0,4).'-'.substr($data['D'],4,2).'-'.substr($data['D'],6,2).' 08:00:00',
				
				'order_invoice_header' => '',
				'total_pay_money' => (float)$data['K'],
				'total_pay_num' => 1,
				'extra_name' => $data['G'],
				'buy_type' => '',



				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 31;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = '';
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 88;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],88 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['sale_price'] = $val['price'];
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['C'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}
// 招商银行


//民生
function ImportMinShengSHQ( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		for ( $c = 65; $c < 91; $c++ )
		{
			$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
		}
		
		if ( intval( $data['A'] ) )
		{
			
			
		if($data['A']===$TT_order_id )
		{
		$k++;
		$T_order_id = $TT_order_id .'-'.$k;
		}
		else
		{
		$k=0;
		$T_order_id = $data['A'];
		$TT_order_id = $data['A'];
		}
			
			
			
			$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'pid' => $data['G'],
				'num' => $data['J'],
				'price' => $data['I'],
				'plan_times' => 1,
				'invoice_header' => $data['H'],
				'order_user_name' => $data['C'],
				'shipping_user_name' => $data['C'],
				//'coupon_price' => 0,
				'coupon_price' => $data['O'],
				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['E'],
				'shipping_phone2' => '',
				'shipping_address' => $data['D'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => '',
				'shipping_order_time' => $data['B'],
				
				'order_invoice_header' => $data['H'],
				'total_pay_money' => $data['N'],
				'total_pay_num' => $data['J'],
				'extra_name' => $data['H'],
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 32;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 89;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],89 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['E'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}

//光大APP
function ImportGuangDaApp( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 3; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		for ( $c = 65; $c < 91; $c++ )
		{
			$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
		}
		
		if ( $data['A'] )
		{
			
			
		if($data['A']===$TT_order_id )
		{
		$k++;
		$T_order_id = $TT_order_id .'-'.$k;
		}
		else
		{
		$k=0;
		$T_order_id = $data['A'];
		$TT_order_id = $data['A'];
		}
			
		$JJ = (float)$data['M'];
		$JH = (int)$data['L'];
		//echo $JJ."@".$JH;
		$JKJ = $JJ/$JH;
			
			$list[] = array(
				'no' => $T_order_id,
				'order_id' => $T_order_id,
				'pid' => $data['B'],
				'num' => (int)$data['L'],
				'price' => $JKJ,
				'plan_times' => 1,
				'invoice_header' => '',
				'order_user_name' => $data['G'],
				'shipping_user_name' => $data['G'],
				//'coupon_price' => 0,
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['F'],
				'shipping_phone2' => $data['E'],
				'shipping_address' => $data['J'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => '',
				'shipping_order_time' => CheckExcelDate($data['O']),
				
				'order_invoice_header' => '',
				'total_pay_money' => $data['M'],
				'total_pay_num' => $data['L'],
				'extra_name' => $data['C'],
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 33;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 90;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],90 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['E'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}

//光大APP
function ImportYiYuanTong( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		for ( $c = 65; $c < 91; $c++ )
		{
			$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
		}
		
		if ( $data['A'] )
		{
				$list[] = array(
				'no' => $data['A'],
				'order_id' => $data['A'],
				'pid' => $data['B'],
				'num' => (int)$data['E'],
				'price' => $data['D'],
				'plan_times' => 1,
				'invoice_header' => '',
				'order_user_name' => $data['G'],
				'shipping_user_name' => $data['G'],
				//'coupon_price' => 0,
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['H'],
				'shipping_phone2' => '',
				'shipping_address' => $data['I'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => $data['J'],
				'shipping_order_time' => DateFormat(time(),"Y-m-d H:i:s"),
				
				'order_invoice_header' => '',
				'total_pay_money' => $data['F'],
				'total_pay_num' => $data['E'],
				'extra_name' => $data['C'],
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 34;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 91;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],91 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['E'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}


//广发福利
function ImportGuangFaFL( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();


$marketArray = array();
$marketNum = 1;

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		for ( $c = 65; $c < 91; $c++ )
		{
			$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
		}
		
		if ( intval( $data['E'] ) )
		{
	
	/*
	
		if (in_array($data['E'], $marketArray))
	{
		$NowMarketID = $data['E'].'_'.$marketNum;
		$marketNum++;
	}else{
		$marketArray[] = $data['E'];
		$NowMarketID = $data['E'];
		//$marketNum = 1;
	}
	*/

			
			
			
			$list[] = array(
				'no' => $data['F']."_".$data['A'],
				'order_id' => $data['F']."_".$data['A'],
				'pid' => $data['C'],
				'num' => $data['E'],
				'price' => $data['P']/$data['E']/60,
				'plan_times' => 1,
				'invoice_header' => '',
				'order_user_name' => $data['G'],
				'shipping_user_name' => $data['G'],
				//'coupon_price' => 0,
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['M'],
				'shipping_phone2' => '',
				'shipping_address' => $data['I'].$data['J'].$data['K'].$data['L'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => '',
				'shipping_order_time' => substr($data['F'],0,4).'-'.substr($data['F'],4,2).'-'.substr($data['F'],6,2).' 08:00:00',
				
				'order_invoice_header' => '',
				'total_pay_money' => $data['P']/60,
				'total_pay_num' => $data['E'],
				'extra_name' => $data['D'],
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 35;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 92;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],92 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['D'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}

//麒麟博朗集采
function ImportQiLinBLJC( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();


$marketArray = array();
$marketNum = 1;

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		for ( $c = 65; $c < 91; $c++ )
		{
			$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
		}
		
		if ( intval( $data['B'] ) )
		{
			
			$list[] = array(
				'no' => $data['B'],
				'order_id' => $data['B'],
				'pid' => $data['A'],
				'num' => $data['H'],
				'price' => $data['I'],
				'plan_times' => 1,
				'invoice_header' => '',
				'order_user_name' => $data['D'],
				'shipping_user_name' => $data['D'],
				//'coupon_price' => 0,
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['E'],
				'shipping_phone2' => '',
				'shipping_address' => $data['F'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => '',
				'shipping_order_time' => $data['C'],
				
				'order_invoice_header' => '',
				'total_pay_money' => $data['I'],
				'total_pay_num' => $data['H'],
				'extra_name' => $data['G'],
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 36;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 93;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],93 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['G'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}
//珍品网
function ImportZhenPinWang( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	
	$PHPReader = new PHPExcel_Reader_Excel5();

	if( !$PHPReader->canRead( $filePath ) )
	{
		exit( '错误的Excel文件' );
	}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();


$marketArray = array();
$marketNum = 1;

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		for ( $c = 65; $c < 91; $c++ )
		{
			$data['A' . chr( $c )] = $Sheet->getCell( 'A' . chr( $c ) . "{$i}" )->getValue();
		}
		
		if (  $data['A'] )
		{
			
			$list[] = array(
				'no' => $data['A'],
				'order_id' => $data['A'],
				'pid' => $data['C'],
				'num' => $data['I'],
				'price' => $data['H'],
				'plan_times' => 1,
				'invoice_header' => '',
				'order_user_name' => $data['J'],
				'shipping_user_name' => $data['J'],
				//'coupon_price' => 0,
				'coupon_price' => 0,
				//'shipping_user_sn' => $data['L'],
				

				'shipping_phone' =>$data['K'],
				'shipping_phone2' => '',
				'shipping_address' => $data['L'],
				'shipping_zip' => '',
				'shipping_pssj' => '',
				'comment' => '',
				'shipping_order_time' => $data['B'],
				
				'order_invoice_header' => '',
				'total_pay_money' => $data['H'],
				'total_pay_num' => $data['I'],
				'extra_name' => $data['D']."[".$data['E']."][".$data['F']."]",
				'buy_type' => '',

				//'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 37;
		//$orderData['order_time'] = time();
		$orderData['order_time'] = strtotime($val['shipping_order_time']);
		$orderData['order_sell_type'] = 0;
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_shipping_pssj'] = $val['shipping_pssj'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );
		$orderProductData['extra_name'] = $val['extra_name'];
		$orderProductData['buy_type'] = $val['buy_type'];

		$orderData['ppIDS'] = 94;

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'],94 );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );


		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['sale_price'] = FormatMoney($val['price']);
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['total_pay_money_one'] = FormatMoney($val['total_pay_money']/$val['total_pay_num']);
		//$orderProductData['payout_rate'] = $priceInfo['payout_rate'];


		$orderProductData['price'] = FormatMoney($priceInfo['price']);
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['D'] ),
			'timeing' => $val['shipping_order_time'],
		);
	}

	return $orderList;
}

?>