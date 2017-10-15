<?php


$path = urldecode( $_POST['path'] );
$name = trim( urldecode( $_POST['name'] ) );

if ( !FileExists( $path ) ){
	exit( '上级路径不存在' );
}

if ( !is_dir( $path ) ){
	exit( '上级路径不是文件夹' );
}

if ( !$name) {
	exit( '文件夹名称为空' );
}

$full = UnifySeparator( $path . '/' . $name );

if ( !FileExists( $full ) )
	MakeDir( $full );

echo '1';

exit();


?>