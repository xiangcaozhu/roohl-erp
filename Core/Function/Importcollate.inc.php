<?php
function ImportCollate( $filePath )
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
				'channel_id' => $data['B'],
				'target_id' => $data['C'],
				'sku' => $data['D'],
				'AllMoney' => 1,
				'Type' => 1,
				'bank_link' => '',
				'gf_ser' => '',
				//'manager_user_real_name' => $data['D'],
				//'market_price' => $data['F'],
				'data' => $data,
			);
		}
	}

	return $list;
}




function UpCollate( $filePath )
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
				'channel_id' => $data['B'],
				'bank_name' => $data['C'],
				'target_id' => $data['D'],
				'sku' => $data['E'],
				'AllMoney' => 1,
				'bank_link' => '',
				'gf_ser' => '',
				//'supplier_now' => $data['F'],
				//'manager_user_real_name' => $data['D'],
				//'market_price' => $data['F'],
				'data' => $data,
			);
		}
	}

	return $list;
}
?>