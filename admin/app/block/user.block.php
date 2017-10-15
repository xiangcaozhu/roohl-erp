<?php


function ExportUser( $list )
{
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=user.csv");
	header("Content-Transfer-Encoding:binary");
	$fp = fopen('php://output', 'w');

	foreach ( $list as $val )
	{
		$line = array();
		$line[] = $val['user_id'];
		$line[] = $val['user_email'];
		$line[] = $val['user_name'];

		fputcsv( $fp, $line );
	}

	fclose($fp);
}


?>