<?php


function ImportlogisticsSn( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

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

		if ( intval( $data['A'] ) > 0 )
		{
			$list[] = array(
				'order_id' => $data['A'],
				'logistics_company' => $data['B'],
				'logistics_sn' => $data['C'],
				'xiaofw' => $data['D'],
				'data' => $data,
			);
		}
	}

	return $list;
}

function ImportShippingCost( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

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

		if ( intval( $data['A'] ) > 0 )
		{
			$list[] = array(
				'logistics_sn' => $data['A'],
				'order_shipping_cost' => $data['B'],
				'data' => $data,
			);
		}
	}

	return $list;
}

function ImportSignTime( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

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

		if ( intval( $data['A'] ) > 0 )
		{
			$list[] = array(
				'order_id' => $data['A'],
				'sign_time' => $data['B'],
				'data' => $data,
			);
		}
	}

	return $list;
}

function ImportFinanceRecieveTime( $filePath )
{
	Core::LoadLib( 'PHPExcel/Reader/Excel5.php' );

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

		if ( intval( $data['A'] ) > 0 )
		{
			$list[] = array(
				'target_id' => $data['A'],
				'finance_recieve_time' => $data['B'],
				'data' => $data,
			);
		}
	}

	return $list;
}

?>