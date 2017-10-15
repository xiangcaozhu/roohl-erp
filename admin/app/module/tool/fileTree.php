<?php


$path = urldecode( $_POST['dir'] );
$onlyDir = urldecode( $_POST['only_dir'] );

$dir = array();
$file = array();
$res = @opendir( $path );

$scanList = scandir($path);

foreach ( $scanList as $fileName )
{
	if ( $fileName != '..' && $fileName != '.' )
	{
		$filePath = $path . $fileName;

		if ( is_dir( $filePath ) )
			$dir[] = array( 'path' => $filePath . '/', 'name' => $fileName );
		elseif ( is_file( $filePath ) )
			$file[] = array( 'path' => $filePath, 'name' => $fileName );
	}
}

if ( $onlyDir )
	$file = array();


if ( $dir || $file )
{
	echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";

	foreach( $dir as $val )
	{
		echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities( $val['path'] ) . "\">" . htmlentities( $val['name'] ) . "</a></li>";
	}

	foreach( $file as $val )
	{
		$ext = preg_replace( '/^.*\./', '', $val['name'] );
		echo "<li class=\"file ext_{$ext}\"><a href=\"#\" rel=\"" . htmlentities( $val['path'] ) . "\">" . htmlentities( $val['name'] ) . "</a></li>";
	}

	echo "</ul>";	
}

exit();


?>