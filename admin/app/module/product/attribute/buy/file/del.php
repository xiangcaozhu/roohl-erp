<?php

/*
@@acc_free
@@acc_title="删除上传图片"

*/

$file = $_POST['file'] ? $_POST['file'] : $_GET['file'];

if ( $file )
{
	@unlink( Core::GetConfig( 'attribute_image_tmp_path' ) . $file );
}


?>