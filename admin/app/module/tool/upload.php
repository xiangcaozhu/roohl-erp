<?php

/*
@@acc_free
@@acc_title="上传图片"

*/

$savePath = Core::GetConfig( 'file_upload_tmp_path' );
$fileName = md5( GetRand( 32 ) );
$saveFile = $savePath . $fileName  . ".tmp";

if ( @move_uploaded_file( $_FILES['file']['tmp_name'], $saveFile ) )
{
	$status = true;
}
else
{
	$status = false;
}

if ( $_POST['old'] )
{
	@unlink( $savePath . $_POST['old']  . ".tmp" );
}

// 删除超过一天的文件
DelOverdueFile( Core::GetConfig( 'file_upload_tmp_path' ) );

if ( $status )
	echo $fileName;
else
	echo "0";
?>