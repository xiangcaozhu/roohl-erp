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

	$list = array();
	$k=0;
	for ( $i = 2; $i <= $rowNum; $i++ )
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
		
		if($data['A']=='')
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
		
		$T_order_user_name = $data['J'];
		$TT_order_user_name = $data['J'];
		$T_shipping_user_name = $data['J'];
		$TT_shipping_user_name = $data['J'];

		$T_shipping_address = $data['K'] . "-" . $data['L'] . "-" . $data['M'] . "-" . $data['O'];
		$TT_shipping_address = $data['K'] . "-" . $data['L'] . "-" . $data['M'] . "-" . $data['O'];
		
		$T_shipping_phone ='';
		$TT_shipping_phone = '';
		
		$T_shipping_phone2 = $data['P'];
		$TT_shipping_phone2 = $data['P'];
		
		$T_shipping_zip = $data['N'];
		$TT_shipping_zip = $data['N'];
		
		$T_comment = "{$data['T']}<br>{$data['U']}<br>发票抬头:{$data['V']}<br>{$data['Q']}";
		$TT_comment = "{$data['T']}<br>{$data['U']}<br>发票抬头:{$data['V']}<br>{$data['Q']}";
		
		$T_shipping_order_time =substr($data['A'],0,4).'-'.substr($data['A'],4,2).'-'.substr($data['A'],6,2).' 08:00:00';
		$TT_shipping_order_time =substr($data['A'],0,4).'-'.substr($data['A'],4,2).'-'.substr($data['A'],6,2).' 08:00:00';
		}
				$invoice_header = trim($data['AE']);
				if($invoice_header==''){$invoice_header = $T_shipping_user_name;}
		
			$list[] = array(
				//'no' => $data['A'],
				'order_id' => $T_order_id,
				'pid' => $data['B'],
				'num' => $data['S'],
				'price' => $data['F'],
				'coupon_price' => $data['E'],
				'plan_times' => trim( $data['G'] ),
				'invoice_header' => $data['V'],
				'order_user_name' => $T_order_user_name,
				'shipping_user_name' => $T_shipping_user_name,
				'shipping_user_sn' => '',
				'shipping_phone' => $T_shipping_phone,
				'shipping_phone2' => $T_shipping_phone2,
				'shipping_address' => $T_shipping_address,
				'shipping_zip' => $T_shipping_zip,
				'comment' => $T_comment,
				'shipping_order_time' => $T_shipping_order_time,
				
				'order_invoice_header' => $invoice_header,
				'total_pay_money' => $data['Q'],
				'total_pay_num' => $data['AK'],
				'extra_name' => $data['C'].'<br>['.$data['I'].']<br>['.$data['H'].']',

				'data' => $data,
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
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
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

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'] );
		
		if ( !$collateInfo )
			$orderProductData['collate_error'] = '对照表不存在';
		
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['sale_price'] = $val['price'];
		
		if($priceInfo['price'] != $val['price'])
		  $orderProductData['price_error'] = '提报价格和销售价格不符合！';
		
		$orderProductData['coupon_price'] = $val['coupon_price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'timeing' => $val['shipping_order_time'],
		);
	}
	return $orderList;
}













//建设银行 → 善融商城
function ImportJianSheasd( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );
	$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
	$PHPReader = new PHPExcel_Reader_Excel5();
	if( !$PHPReader->canRead( $filePath ) ){exit( '错误的Excel文件' );}

	$PHPExcel = $PHPReader->load( $filePath );
	$Sheet = $PHPExcel->getSheet(0);
	$rowNum = $Sheet->getHighestRow();

	$list = array();
	$k=0;
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
		
		if($data['A']=='')
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
		
		$T_order_user_name = $data['S'];
		$TT_order_user_name = $data['S'];
		$T_shipping_user_name = $data['S'];
		$TT_shipping_user_name = $data['S'];

		$T_shipping_address = $data['T'] . "-" . $data['U'];
		$TT_shipping_address = $data['T'] . "-" . $data['U'];
		
		$T_shipping_phone = $data['V'];
		$TT_shipping_phone = $data['V'];
		
		$T_shipping_phone2 = $data['W'];
		$TT_shipping_phone2 = $data['W'];
		
		$T_shipping_zip = $data['Y'];
		$TT_shipping_zip = $data['Y'];
		
		$T_comment = "{$data['L']}\n\n{$data['AD']}\n\n{$data['AE']}\n\n{$data['AF']}";
		$TT_comment = "{$data['L']}\n\n{$data['AD']}\n\n{$data['AE']}\n\n{$data['AF']}";
		
		$T_shipping_order_time =$data['J'];
		$TT_shipping_order_time =$data['J'];
		}
				$invoice_header = trim($data['AE']);
				if($invoice_header==''){$invoice_header = $T_shipping_user_name;}
		
			$list[] = array(
				//'no' => $data['A'],
				'order_id' => $T_order_id,
				'pid' => $data['AG'],
				'num' => $data['AK'],
				'price' => $data['AI'],
				'plan_times' => 1,
				'invoice_header' => $data['AE'],
				'order_user_name' => $T_order_user_name,
				'shipping_user_name' => $T_shipping_user_name,
				'shipping_user_sn' => '',
				'shipping_phone' => $T_shipping_phone,
				'shipping_phone2' => $T_shipping_phone2,
				'shipping_address' => $T_shipping_address,
				'shipping_zip' => $T_shipping_zip,
				'comment' => $T_comment,
				'shipping_order_time' => $T_shipping_order_time,
				
				'order_invoice_header' => $invoice_header,
				'total_pay_money' => $data['Q'],
				'total_pay_num' => $data['AK'],
				//'extra_name' => $data['AB'],

				'data' => $data,
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
		$orderData['order_invoice_header'] = $val['invoice_header'];
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];
		//$orderData['extra_name'] = $val['extra_name'];
		
		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'] );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = 0;

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'timeing' => $val['shipping_order_time'],
		);
	}
	return $orderList;
}



//光大银行
function ImportGuangDa( $filePath )
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
	for ( $i = 4; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
		
				$invoice_header = trim($data['U']);
				if($invoice_header==''){$invoice_header = $data['O'];}
		if ( intval( $data['A'] ) > 0 )
		{
			$list[] = array(
				'no' => $data['A'],
				'order_id' => $data['B'] .'-'. $data['A'],
				'pid' => $data['C'],
				'num' => $data['I'],
				'price' => $data['G'],
				'plan_times' => trim( $data['J'] ),
				'invoice_header' => $data['U'],
				'order_user_name' => $data['M'],
				'shipping_user_name' => $data['O'],
				'shipping_user_sn' => $data['L'],
				'shipping_phone' => $data['P'],
				//'shipping_phone2' => $data['U'],
				'shipping_address' => $data['Q'],
				'shipping_zip' => $data['R'],
				'comment' => "{$data['S']}\n\n{$data['T']}\n\n{$data['U']}\n\n{$data['V']}",
				'shipping_order_time' => substr($data['Z'],0,4).'-'.substr($data['Z'],4,2).'-'.substr($data['Z'],6,2).' '.substr($data['Z'],9,2).':'.substr($data['Z'],11,2).':'.substr($data['Z'],13,2),
				
				'order_invoice_header' => $invoice_header,
				'total_pay_money' => $data['H'],
				'total_pay_num' => $data['I'],
				//'extra_name' => $data['D'],
				


				'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 3;
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
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];
		//$orderData['extra_name'] = $val['extra_name'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		#$orderProductData['price'] = $val['price'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'] );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
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
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
				$invoice_header = trim($data['G']);
				if($invoice_header==''){$invoice_header = $data['C'];}
		
		if ( intval( $data['A'] ) > 0 )
		{
			$list[] = array(
				'no' => $data['A'],
				'order_id' => $data['A'],
				'pid' => $data['H'],
				'num' => $data['M'],
				'price' => $data['L'],
				'plan_times' => trim( $data['K'] ),
				'invoice_header' => $data['G'],
				'order_user_name' => $data['C'],
				'shipping_user_name' => $data['C'],
				//'shipping_user_sn' => $data['L'],
				'shipping_phone' => $data['D'],
				//'shipping_phone2' => $data['U'],
				'shipping_address' => $data['E'],
				'shipping_zip' => $data['F'],
				'comment' => "{$data['Z']}",
				'shipping_order_time' => $data['B'],
				
				'order_invoice_header' => $invoice_header,
				'total_pay_money' => $data['P'],
				'total_pay_num' => $data['M'],
				//'extra_name' => $data['I'],


				'data' => $data,
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
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];
		//$orderData['extra_name'] = $val['extra_name'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'] );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

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
				'no' => $data['C'],
				'order_id' => $data['C'],
				'pid' => $data['D'],
				'num' => $data['F'],
				'price' => $data['U'],
				'plan_times' => trim( $data['T'] ),
				'invoice_header' => $data['L'],
				'order_user_name' => $data['N'],
				'shipping_user_name' => $data['N'],
				'shipping_user_sn' => $data['S'],
				'shipping_phone' => $data['P'],
				'shipping_phone2' => $data['Q'],
				'shipping_address' => $data['R'],
				'shipping_zip' => $data['S'],
				'comment' => $data['AB'],
				'shipping_order_time' => substr($data['C'],0,4).'-'.substr($data['C'],4,2).'-'.substr($data['C'],6,2).' 08:08:08',
				
				'order_invoice_header' => $data['L'],
				'total_pay_money' => $data['U'],
				'total_pay_num' => $data['F'],

				'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 8;
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
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		
		$orderData['order_invoice_header'] = $val['order_invoice_header'];
		$orderData['total_pay_money'] = $val['total_pay_money'];
		$orderData['total_pay_num'] = $val['total_pay_num'];


		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		#$orderProductData['price'] = $val['price'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'] );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
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

	$Sheet2 = $PHPExcel->getSheet(1);
	$rowNum2 = $Sheet2->getHighestRow();

	if ( $rowNum != $rowNum2 )
	{
		exit( '订单行和产品行不一致' );
	}

	$list = array();
	for ( $i = 1; $i <= $rowNum; $i++ )
	{
		$data = array();
		$data2 = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}

		for ( $c = 65; $c < 91; $c++ )
		{
			$data2[chr( $c )] = $Sheet2->getCell( chr( $c ) . "{$i}" )->getValue();
		}
		
		if ( intval( $data['B'] ) > 0 )
		{
			$list[] = array(
				'no' => $data['B'],
				'channel' => $data['C'],
				'order_id' => $data['A'],
				'pid' => $data2['B'],
				'order_user_name' => $data['G'],
				'shipping_user_name' => $data['G'],
				'shipping_user_sn' => $data['H'],
				'shipping_phone' => $data['I'],
				'shipping_phone2' => '',
				'shipping_address' => $data['F'],
				'shipping_zip' => $data['E'],
				'price' => $data2['D'],
				'plan_times' => 1,
				'num' => $data2['G'],
				'comment' => "",
				'data' => $data,
				'data2' => $data2,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 8;
		$orderData['order_time'] = time();
		$orderData['order_sell_type'] = 0;
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['order_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];

		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		#$orderProductData['price'] = $val['price'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( array( $val['data'], $val['data2'] ) );

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'] );
		$priceInfo = $ProductCollateModel->GetPriceByPrice( $collateInfo['id'], trim( $val['price'] ) );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderData['order_instalment_times'] = $priceInfo['instalment_times'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data2']['C'] ),
		);
	}

	return $orderList;
}



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
	for ( $i = 1; $i <= $rowNum; $i++ )
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
		
		if ( intval( $data['A'] ) > 0 )
		{
			$list[] = array(
				'no' => $data['A'],
				'channel' => $data['B'],
				'order_id' => $data['C'],
				'pid' => $data['D'],
				'order_user_name' => $data['F'],
				'order_customer_card' => $data['G'],
				'shipping_user_name' => $data['H'],
				'shipping_user_sn' => $data['I'],
				'shipping_phone' => $data['J'],
				'shipping_phone2' => $data['K'],
				'shipping_address' => $data['M'] . $data['N'] . $data['O'] . $data['P'],
				'shipping_zip' => $data['Q'],
				'price' => $data['T'],
				'plan_times' => trim( $data['S'] ),
				'num' => $data['Z'],
				'comment' => $data['AA'],
				'invoice_header' => $data['X'],
				'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 38;
		$orderData['order_time'] = time();
		$orderData['order_sell_type'] = 0;
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_customer_card'] = $val['order_customer_card'];
		$orderData['order_shipping_name'] = $val['shipping_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'] ? $val['plan_times'] : 1;
		$orderData['order_invoice_header'] = $val['invoice_header'];

		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		#$orderProductData['price'] = $val['price'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'] );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['R'] ),
		);
	}

	return $orderList;
}



function ImportHuaXia( $filePath )
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
	for ( $i = 1; $i <= $rowNum; $i++ )
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
		
		if ( intval( $data['A'] ) > 0 )
		{
			$list[] = array(
				'no' => $data['A'],
				'channel' => $data['B'],
				'order_id' => $data['C'],
				'pid' => $data['D'],
				'order_user_name' => $data['F'],
				'order_customer_card' => $data['G'],
				'shipping_user_name' => $data['H'],
				'shipping_user_sn' => $data['I'],
				'shipping_phone' => $data['J'],
				'shipping_phone2' => $data['K'],
				'shipping_address' => $data['M'] . $data['N'] . $data['O'] . $data['P'],
				'shipping_zip' => $data['Q'],
				'price' => $data['T'],
				'plan_times' => trim( $data['S'] ),
				'num' => $data['Y'],
				'comment' => $data['Z'] . ' 赠品:' . $data['AA'] . ' ' . $data['L'],
				'invoice_header' => $data['W'],
				'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 15;
		$orderData['order_time'] = time();
		$orderData['order_sell_type'] = 0;
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_customer_card'] = $val['order_customer_card'];
		$orderData['order_shipping_name'] = $val['order_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'] > 0 ? $val['plan_times'] : 1;
		$orderData['order_invoice_header'] = $val['invoice_header'];

		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		#$orderProductData['price'] = $val['price'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'] );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['R'] ),
		);
	}

	return $orderList;
}



function ImportSina( $filePath )
{
	exit( '错误的Excel文件' );

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
	for ( $i = 1; $i <= $rowNum; $i++ )
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
		
		if ( intval( $data['A'] ) > 0 )
		{
			$list[] = array(
				'no' => $data['A'],
				'channel' => $data['B'],
				'order_id' => $data['C'],
				'pid' => $data['D'],
				'order_user_name' => $data['F'],
				'shipping_user_name' => $data['H'],
				'shipping_user_sn' => $data['I'],
				'shipping_phone' => $data['J'],
				'shipping_phone2' => $data['K'],
				'shipping_address' => $data['M'] . $data['N'] . $data['O'] . $data['P'],
				'shipping_zip' => $data['Q'],
				'price' => $data['T'],
				'plan_times' => trim( $data['S'] ),
				'num' => $data['Y'],
				'comment' => $data['Z'] . ' 赠品:' . $data['AA'],
				'invoice_header' => $data['X'],
				'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 15;
		$orderData['order_time'] = time();
		$orderData['order_sell_type'] = 0;
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_shipping_name'] = $val['order_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'];
		$orderData['order_invoice_header'] = $val['invoice_header'];

		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		#$orderProductData['price'] = $val['price'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'] );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['R'] ),
		);
	}

	return $orderList;
}


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

	$list = array();
	for ( $i = 2; $i <= $rowNum; $i++ )
	{
		$data = array();

		for ( $c = 65; $c < 91; $c++ )
		{
			$data[chr( $c )] = $Sheet->getCell( chr( $c ) . "{$i}" )->getValue();
		}
		
		if ( intval( $data['A'] ) > 0 )
		{
			$list[] = array(
				'no' => $data['A'],
				'channel' => 42,
				'order_id' => $data['C'],
				'pid' => $data['E'],
				'order_user_name' => $data['D'],
				'order_customer_card' => '',
				'shipping_user_name' => $data['D'],
				'shipping_user_sn' => '',
				'shipping_phone' => $data['J'],
				'shipping_phone2' => $data['J'],
				'shipping_address' => $data['H'],
				'shipping_zip' => $data['I'],
				'price' => '',
				'plan_times' => '',
				'num' => trim( $data['G'] ),
				'comment' => '',
				'invoice_header' => '',
				'data' => $data,
			);
		}
	}

	$orderList = array();
	foreach ( $list as $val )
	{
		$orderData = array();
		$orderData['target_id'] = $val['order_id'];
		$orderData['channel_id'] = 42;
		$orderData['order_time'] = time();
		$orderData['order_sell_type'] = 0;
		$orderData['order_customer_name'] = $val['order_user_name'];
		$orderData['order_customer_card'] = $val['order_customer_card'];
		$orderData['order_shipping_name'] = $val['order_user_name'];
		$orderData['order_shipping_phone'] = $val['shipping_phone'];
		$orderData['order_shipping_mobile'] = $val['shipping_phone2'];
		$orderData['order_shipping_card'] = $val['shipping_user_sn'];
		$orderData['order_shipping_zip'] = $val['shipping_zip'];
		$orderData['order_shipping_address'] = $val['shipping_address'];
		$orderData['order_comment'] = $val['comment'];
		$orderData['order_instalment_times'] = $val['plan_times'] > 0 ? $val['plan_times'] : 1;
		$orderData['order_invoice_header'] = $val['invoice_header'];

		$orderProductData = array();
		$orderProductData['target_id'] = $val['pid'];
		$orderProductData['quantity'] = $val['num'];
		#$orderProductData['price'] = $val['price'];
		$orderProductData['comment'] = $val['comment'];
		$orderProductData['import_data'] = serialize( $val['data'] );

		$collateInfo = $ProductCollateModel->GetUnique( $val['pid'] );
		$priceInfo = $ProductCollateModel->GetPrice( $collateInfo['id'], $val['plan_times'] );

		$orderProductData['price'] = $priceInfo['price'];
		$orderProductData['payout_rate'] = $priceInfo['payout_rate'];

		$orderList[] = array(
			'data' => $orderData,
			'product_data' => $orderProductData,
			'product_extra' => array( 'name' => $val['data']['E'] ),
		);
	}

	return $orderList;
}





?>