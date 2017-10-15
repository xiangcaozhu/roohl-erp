<?php

/*
@@acc_free
@@acc_title="查看图片"

*/

$savePath = Core::GetConfig( 'file_upload_tmp_path' );
$fileName = $_GET['file'];
$filePath = $savePath . $fileName  . ".tmp";

if ( $_GET['path'] )
	$filePath = $_GET['path'];

Core::LoadLib( 'GD.class.php' );
$Gd = new GD();

if ( $_GET['width'] > 0 && $_GET['height'] > 0 )
{
	if ( $_GET['thumb'] == 'auto' )
		$Gd->ThumbAutoCut( $filePath, $_GET['width'], $_GET['height'], '' );
	else
		$Gd->Thumb( $filePath, $_GET['width'], $_GET['height'], '' );
}
else
{
	header( "Content-type: image/{$type}" );
	echo file_get_contents( $filePath );
}

exit();

?>