<?php


function ExportOrder( $list )
{
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=order.csv");
	header("Content-Transfer-Encoding:binary");
	$fp = fopen('php://output', 'w');

	foreach ( $list as $line )
	{
		foreach ( $line as $k => $v )
		{
			$line[$k] = mb_convert_encoding( $v, 'GB2312', 'auto' );
		}
		
		fputcsv( $fp, $line );
	}

	fclose($fp);
}


?>