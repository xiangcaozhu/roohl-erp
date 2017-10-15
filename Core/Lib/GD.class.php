<?php

class GD
{
	function IsImage( $imageFile )
	{
		if ( !$imageFile )
			return false;

		/*
		$pathInfo = pathinfo( $imageFile );

		if ( !in_array( strtolower( $pathInfo['extension'] ), array( 'jpg', 'jpeg', 'gif', 'bmp', 'png' ) ) )
			return false;
		*/

		if ( !@getimagesize( $imageFile ) )
			return false;

		return true;
	}

	function GetInfo( $imageFile )
	{
		$type[1] = 'gif';
		$type[2] = 'jpg';
		$type[3] = 'png';
		$type[6] = 'bmp';
		
		$imgData = getimagesize($imageFile);
		
		$pos	= strrpos( $imageFile, "." );
		$ext	= strtolower( substr( $imageFile, $pos + 1 ) );
		$name = substr( $imageFile, 0, $pos );

		$imageInfo["name"]		= $name;
		$imageInfo["ext"]		= $ext;
		$imageInfo["typeID"]		= $imgData[2];
		$imageInfo["type"]		= $type[$imgData[2]];
		$imageInfo["file"]		= basename($imageFile);
		$imageInfo["size"]		= filesize($imageFile);
		$imageInfo["width"]		= $imgData[0];
		$imageInfo["height"]	= $imgData[1];

		return $imageInfo;
	}

	function Out( $imageResource, $savePath = '' , $type = '' )
	{
		if ( !$savePath )
			header( "Content-type: image/{$type}" );

		if ( in_array( $type, array( 'jpg', 'jpeg' ) ) )
		{
			imagejpeg( $imageResource, $savePath, 90 );
		}
		elseif ( in_array( $type, array( 'png' ) ) )
		{
			if ( $savePath )
				imagepng( $imageResource, $savePath );
			else
				imagepng( $imageResource );
		}
		elseif ( in_array( $type, array( 'gif' ) ) )
		{
			if ( $savePath )
				imagegif( $imageResource, $savePath );
			else
				imagegif( $imageResource );
		}
		else
		{
			imagejpeg( $imageResource, $savePath, 90 );
		}
	}

	function CreateObjFormImage( $imageFile, $type )
	{
		if ( in_array( $type, array( 'jpg', 'jpeg' ) ) )
			return imagecreatefromjpeg($imageFile);
		elseif ( in_array( $type, array( 'png' ) ) )
			return imagecreatefrompng($imageFile);
		elseif ( in_array( $type, array( 'gif' ) ) )
			return imagecreatefromgif($imageFile);
		elseif ( in_array( $type, array( 'bmp' ) ) )
			return imagecreatefrombmp( ( $imageFile ) );
		else
			return imagecreatefromjpeg($imageFile);
	}

	function Thumb( $imageFile, $width = '36', $height = '36', $outFile = '', $ext = '' )
	{
		$imageInfo = $this->GetInfo( $imageFile );

		$imageObj = $this->CreateObjFormImage( $imageFile, $imageInfo['type'] );

		if ( !$width || !$height )
		{
			$this->Out( $imageObj, $outFile, $ext );
			return;
		}

		//$width  = ($width > $imageInfo["width"]) ? $imageInfo["width"] : $width;
		//$height = ($height > $imageInfo["height"]) ? $imageInfo["height"] : $height;
		
		$srcWidth = $imageInfo["width"];
		$srcHeight = $imageInfo["height"];

		$scale = min( $width / $srcWidth, $height / $srcHeight );

		if ( $scale < 1 ) {
			$width = floor( $scale * $srcWidth );
			$height = floor( $scale * $srcHeight );
		}
		else
		{
			$width = $srcWidth;
			$height = $srcHeight;
		}
		
		//( $srcWidth * $width > $srcHeight * $height ) ? $height = round( $srcHeight * $width / $srcWidth ) : $width = round( $srcWidth * $height / $srcHeight );
		
		$newImageObj = imagecreatetruecolor( $width, $height );
		imagecopyresampled( $newImageObj, $imageObj, 0, 0, 0, 0, $width, $height, $imageInfo["width"], $imageInfo["height"] );

		if ( !$ext )
			$ext = $imageInfo['type'];
		
		$this->Out( $newImageObj, $outFile, $ext );

		imagedestroy( $imageObj );
		imagedestroy( $newImageObj );
	}

	function ThumbAutoCut( $imageFile, $width = '64', $height = '64', $outFile = '', $ext = '' )
	{
		$imageInfo = $this->GetInfo( $imageFile );

		$srcWidth = $imageInfo["width"];
		$srcHeight = $imageInfo["height"];

		if ( !$ext )
			$ext = $imageInfo['type'];

		$imageObj = $this->CreateObjFormImage( $imageFile, $imageInfo['type'] );

		if ( $srcWidth / $srcHeight > $width / $height )
		{
			// width over
			$srcCutWidth = round( ( $width / $height ) * $srcHeight );
			$srcCutHeight = $srcHeight;

			$x = round( ( $srcWidth - $srcCutWidth ) / 2 );
			$y = 0;
		}
		else
		{
			// height over
			$srcCutWidth = $srcWidth;
			$srcCutHeight = round( ( $height / $width ) * $srcWidth );

			$x = 0;
			$y = round( ( $srcHeight - $srcCutHeight ) / 2 );
		}
		

		$newImageObj = imagecreatetruecolor( $width, $height );
		imagecopyresampled( $newImageObj, $imageObj, 0, 0, $x, $y, $width, $height, $srcCutWidth, $srcCutHeight );

		$this->Out( $newImageObj, $outFile, $ext );

		imagedestroy( $imageObj );
		imagedestroy( $newImageObj );

	}

	function TextMark( $imageFile, $text, $size,$outFile )
	{
		$imageInfo = $this->GetInfo($imageFile);

		if ($imageInfo['type'] != 'jpg')
			return;
		
		$imageObj = $this->CreateObjFormImage( $imageFile, $imageInfo['type'] );

		$width = $imageInfo["width"];
		$height = $imageInfo["height"];

		$white = imagecolorallocate( $imageObj, 255, 255, 255 );
		$black = imagecolorallocate( $imageObj, 0, 0, 0 );

		$alpha = imagecolorallocatealpha( $imageObj, 230, 230, 230, 100 );
		
		imagefilledrectangle( $imageObj, 0, $height-60, $width, $height-20, $alpha );

		imageline( $imageObj, 0, $height-60, $width, $height-60, $black );
		imageline( $imageObj, 0, $height-20, $width, $height-20, $black );
		
		$fontWidth = imagettfbbox($size, 0, 'simsun.ttc', $text);
		$fontWidthFinal = $fontWidth[2] - $fontWidth[6];
		
		$text = $text;

		imagettftext( $imageObj, $size, 0, ($width - $fontWidthFinal - 30), $height-35, $black, 'simsun.ttc', $text );
		
		$this->Out( $imageObj, $outFile, $imageInfo['type'] );
		
		imagedestroy( $imageObj );
	}

	function ImageMark( $imageFile, $markFile, $outFile )
	{
		$imageInfo = $this->GetInfo($imageFile);
		$imageMarkInfo = $this->GetInfo($markFile);

		if ($imageInfo['type'] != 'jpg')
			return;
		
		$imageObj = $this->CreateObjFormImage( $imageFile, $imageInfo['type'] );
		$markImageObj = $this->CreateObjFormImage( $markFile, $imageMarkInfo['type'] );

		imagecopymerge($imageObj, $markImageObj, ($imageInfo['width'] - $imageMarkInfo['width'] - 15), ($imageInfo['height'] - $imageMarkInfo['height'] - 15), 0, 0, $imageMarkInfo['width'], $imageMarkInfo['height'], 100 );  

		$this->Out($imageObj, $outFile, $imageInfo['type']);
		
		imagedestroy( $imageObj );
		imagedestroy( $markImageObj );
	}

	function Cut( $imageFile, $x, $y, $width, $height, $outFile )
	{
		$imageInfo = $this->GetInfo( $imageFile );
		$imageObj = $this->CreateObjFormImage( $imageFile, $imageInfo['type'] );

		$newImageObj = imagecreatetruecolor( $width, $height );
		imagecopy( $newImageObj, $imageObj, 0, 0, $x, $y, $width, $height );

		$this->Out( $newImageObj, $outFile, $imageInfo['type'] );
	}

	function Turn( $imageFile, $outFile, $type = 1 )
	{
		$imageInfo = $this->GetInfo( $imageFile );
		$imageObj = $this->CreateObjFormImage( $imageFile, $imageInfo['type'] );

		$newImageObj = imagecreatetruecolor( $imageInfo['width'], $imageInfo['height'] );

		for($x=0;$x<$imageInfo['width'];$x++)
		{
			for($y=0;$y<$imageInfo['height'];$y++)
			{
				if ( $type == 1 )
					imagecopyresized( $newImageObj, $imageObj, $imageInfo['width'] - $x - 1, $y, $x, $y, 1, 1, 1, 1 ); // 水平翻转 
				else
					imagecopyresized( $newImageObj, $imageObj, $x, $imageInfo['height'] - $y - 1, $x, $y, 1, 1, 1, 1 ); // 垂直翻转 
			}
		}

		$this->Out( $newImageObj, $outFile, $imageInfo['type'] );
	}

	function GoRound( $imageFile, $outFile, $deg  = 90 )
	{
		$imageInfo = $this->GetInfo( $imageFile );
		$imageObj = $this->CreateObjFormImage( $imageFile, $imageInfo['type'] );

		$newImageObj = imagerotate( $imageObj, $deg, 0 );

		$this->Out( $newImageObj, $outFile, $imageInfo['type'] );
	}
}

function ImageCreateFromBMP($filename)
{
if (! $f1 = fopen($filename,"rb")) return FALSE;

$FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
if ($FILE['file_type'] != 19778) return FALSE;

$BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
'/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
'/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
$BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
$BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
$BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
$BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
$BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
$BMP['decal'] = 4-(4*$BMP['decal']);
if ($BMP['decal'] == 4) $BMP['decal'] = 0;

$PALETTE = array();
if ($BMP['colors'] < 16777216)
{
$PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
}

$IMG = fread($f1,$BMP['size_bitmap']);
$VIDE = chr(0);

$res = imagecreatetruecolor($BMP['width'],$BMP['height']);
$P = 0;
$Y = $BMP['height']-1;
while ($Y >= 0)
{
$X=0;
while ($X < $BMP['width'])
{
if ($BMP['bits_per_pixel'] == 24)
$COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
elseif ($BMP['bits_per_pixel'] == 16)
{
$COLOR = unpack("n",substr($IMG,$P,2));
$COLOR[1] = $PALETTE[$COLOR[1]+1];
}
elseif ($BMP['bits_per_pixel'] == 8)
{
$COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
$COLOR[1] = $PALETTE[$COLOR[1]+1];
}
elseif ($BMP['bits_per_pixel'] == 4)
{
$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
$COLOR[1] = $PALETTE[$COLOR[1]+1];
}
elseif ($BMP['bits_per_pixel'] == 1)
{
$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
if (($P*8)%8 == 0) $COLOR[1] = $COLOR[1] >>7;
elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
$COLOR[1] = $PALETTE[$COLOR[1]+1];
}
else
return FALSE;
imagesetpixel($res,$X,$Y,$COLOR[1]);
$X++;
$P += $BMP['bytes_per_pixel'];
}
$Y--;
$P+=$BMP['decal'];
}

fclose($f1);

return $res;
}

//$gd = new GD();
//$gd->Thumb( 'bb.jpg', 100,100,'yy.jpg' );
//$gd->ThumbAutoCut( './desk_0703.jpg', 100,100,'yy.jpg' );
//$gd->ThumbAutoCut( 'bb.jpg', 100,280,'cc.jpg' );
//$gd->TextMark( './desk_0703.jpg', 'hello','20',  'gg.jpg' );
//$gd->ImageMark( './desk_0703.jpg', 'yy.jpg', 'gg.jpg' );
//$gd->Cut( './desk_0703.jpg', 200, 700, 40, 80, 'gg.jpg' );
//$gd->GoRound( './desk_0703.jpg', 'gg1.jpg', 90 );
//$gd->Turn( './desk_0703.jpg', 'gg2.jpg', 0 );
?>