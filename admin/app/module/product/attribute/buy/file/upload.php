<?php

/*
@@acc_free
@@acc_title="上传图片"

*/

do
{
	$data = array();
	$error = null;

	if ( !$_FILES['attr_file']['tmp_name'] )
	{
		$error['fail'] = 1;
		break;
	}

	if ( $_POST['old'] )
	{
		@unlink( Core::GetConfig( 'attribute_image_tmp_path' ) . $_POST['old'] );
	}

	$time = time();
	$ext = GetFileExt( $_FILES['attr_file']['name'] );
	$fileName = $time . '_' . GetRand( 8 );

	$tmpFile = Core::GetConfig( 'attribute_image_tmp_path' ) . $fileName . '.' . $ext;
	$tmpFileUrl = Core::GetConfig( 'attribute_image_tmp_url' ) . $fileName . '.' . $ext;

	$data['ext'] = $ext;
	$data['file_name'] = $fileName;
	$data['file_url'] = $tmpFileUrl;

	if ( !@move_uploaded_file( $_FILES['attr_file']['tmp_name'], $tmpFile ) )
	{
		$error['fail'] = 1;
		break;
	}
}
while (false);

// 删除超过一天的文件
DelOverdueFile( Core::GetConfig( 'attribute_image_tmp_path' ) );

echo PHP2JSON( array( 'error' => $error, 'data' => $data ) );
exit();

if ( $_GET['call'] )
{
	$data = PHP2JSON( $data );
	$error = PHP2JSON( $error );
	echo "<script>";
	echo "window.parent.{$_GET['call']}({$error}, {$data});";
	echo "</script>";
	exit();
}


?>