<?php

/*
+---------------------------------------------------+
| Name : NEATGD 图形处理类
+---------------------------------------------------+
| C / M : 2004-11-23 / -- --
+---------------------------------------------------+
| Version : 1.0.0
+---------------------------------------------------+
| Author : walkerlee
+---------------------------------------------------+
| Powered by NEATSTUDIO 2002 - 2004
+---------------------------------------------------+
| Email : neatstudio@yahoo.com.cn
| Homepge : http://www.neatstudio.com
| BBS : http://www.neatstudio.com/bbs/
+---------------------------------------------------+
| Note :
+---------------------------------------------------+
 1.0.0
 2004-11-23 (walker)
 GD函数雏形.
+---------------------------------------------------+
*/

class NEATGD
{
	var $ouputPath = './';		// 图片输出目录 (最后要加 / )

	var $thumbWidth		= 80;  // 缩图默认宽度
	var $thumbHeight		= 60;	// 缩图默认高度

	// 以上图片会按照比例自动处理高宽,不会出现比例失调的情况.

	var $thumbExt		= '_thumb';	// 缩图图片后缀
	var $markExt		= ''; //'_mark';	// 水印图片后缀

	var $fontSize		= 12;	// 字体大小
	var $font			= 'simsun.ttc';//04B_08__.TTF';	// 字体文件

	var $imageQuality				= 100;	// 图片质量 (百分比)
	var $textBackgroundTransition	= 80;	// 图片水印背景透明度 (百分比)
	var $imageTransition			= 60;	// 图片水印透明度 (百分比)

	// 对象
	
	var $sourceImageObject;
	var $newImageObject;
	var $waterImageObject;

	function NEAT_GD($path)
	{
	   $this->setOutputPath($path);
	}

	/*
	+---------------------------------------------------+
	| Function Name : setOutputPath
	+---------------------------------------------------+
	| Description : 设置图片输出路径
	+---------------------------------------------------+
	| Created / Modify : 2004-11-23 / 
	+---------------------------------------------------+
	 Note :
		$path : 图片输出路径
	+---------------------------------------------------+
	*/

	function setOutputPath($path)
	{
		$this->ouputPath = $path;
	}
	
	/*
	+---------------------------------------------------+
	| Function Name : thumb
	+---------------------------------------------------+
	| Description : 根据源图生存缩图
	+---------------------------------------------------+
	| Created / Modify : 2004-11-23 / 
	+---------------------------------------------------+
	 Note :
		$imageFile : 图片文件
	+---------------------------------------------------+
	*/

	function thumb($imageFile, $outPath = '')
	{
 		$imageInfo = $this->getInfo($imageFile);

		$outputThumbImageFile = $this->outputPath . $imageInfo['name'] . $this->thumbExt . ".jpg";

		if ( $outPath )
			$outputThumbImageFile = $outPath;
		
		$this->createSourceImageObject($imageFile, $imageInfo['typeID']);

		$width  = ($this->thumbWidth > $imageInfo["width"]) ? $imageInfo["width"] : $this->thumbWidth;
		$height = ($this->thumbHeight > $imageInfo["height"]) ? $imageInfo["height"] : $this->thumbHeight;
		
		$srcW	= $imageInfo["width"];
		$srcH	= $imageInfo["height"];
		
		($srcW * $width > $srcH * $height) ? $height = round($srcH * $width / $srcW) : $width = round($srcW * $height / $srcH);
		
		$this->createNewImageObject($width, $height, $imageInfo["width"], $imageInfo["height"]);
		
		ImageJPEG($this->newImageObject, $outputThumbImageFile, $this->imageQuality);

		$this->destroySourceImageObject();
		$this->destroyNewImageObject();
	}

	/*
	+---------------------------------------------------+
	| Function Name : textMark
	+---------------------------------------------------+
	| Description : 文字水印
	+---------------------------------------------------+
	| Created / Modify : 2004-11-23 / 
	+---------------------------------------------------+
	 Note :
		$imageFile : 图片文件
		$text : 水印文字
	+---------------------------------------------------+
	*/

	function textMark($imageFile, $text)
	{
		$imageInfo = $this->getInfo($imageFile);

		if ($imageInfo['type'] != 'jpg')
			return;

		$outputMarkImageFile = $this->outputPath . $imageInfo['name'] . $this->markExt . ".jpg";
		
		$this->createSourceImageObject($imageFile, $imageInfo['typeID']);

		$width = $imageInfo["width"];
		$height = $imageInfo["height"];

		$white = imageColorAllocate($this->sourceImageObject, 255, 255, 255);
		$black = imageColorAllocate($this->sourceImageObject, 0, 0, 0);

		$alpha = imageColorAllocateAlpha($this->sourceImageObject, 230, 230, 230, $this->textBackgroundTransition);
		
		ImageFilledRectangle($this->sourceImageObject, 0, $height-60, $width, $height-20, $alpha);

		imageline($this->sourceImageObject, 0, $height-60, $width, $height-60, $black);
		imageline($this->sourceImageObject, 0, $height-20, $width, $height-20, $black);
		
		$fontWidth = imagettfbbox($this->fontSize, 0, $this->font, $text);
		$fontWidthFinal = $fontWidth[2] - $fontWidth[6];
		
		$text = $text;

		ImageTTFText($this->sourceImageObject, $this->fontSize, 0, ($width - $fontWidthFinal - 30), $height-35, $black, $this->font, $text);
		
		ImageJPEG($this->sourceImageObject, $outputMarkImageFile, $this->imageQuality);
		
		$this->destroySourceImageObject();
	}

 	/*
	+---------------------------------------------------+
	| Function Name : imageMark
	+---------------------------------------------------+
	| Description : 图片水印
	+---------------------------------------------------+
	| Created / Modify : 2004-11-23 / 
	+---------------------------------------------------+
	 Note :
		$imageFile : 图片文件
		$markFile : 水印图片文件
	+---------------------------------------------------+
	*/

	function imageMark($imageFile, $markFile)
	{
		$imageInfo = $this->getInfo($imageFile);
		$imageWaterInfo = $this->getInfo($markFile);

		if ($imageInfo['type'] != 'jpg')
			return;

		$outputMarkImageFile = $this->outputPath . $imageInfo['name'] . $this->markExt . ".jpg";
		
		$this->createSourceImageObject($imageFile, $imageInfo['typeID']);
		$this->createWaterImageObject($markFile, $imageWaterInfo['typeID']);

		imageCopyMerge($this->sourceImageObject, $this->waterImageObject, ($imageInfo['width'] - $imageWaterInfo['width'] - 15), ($imageInfo['height'] - $imageWaterInfo['height'] - 15), 0, 0, $imageWaterInfo['width'], $imageWaterInfo['height'], $this->imageTransition);  

		ImageJPEG($this->sourceImageObject, $outputMarkImageFile, $this->imageQuality);
		
		$this->destroyWaterImageObject();
		$this->destroySourceImageObject();
	}

	/*
	+---------------------------------------------------+
	| Function Name : getInfo
	+---------------------------------------------------+
	| Description : 取得图片信息
	+---------------------------------------------------+
	| Created / Modify : 2004-11-23 / 
	+---------------------------------------------------+
	 Note :
		$imageFile : 图片文件
	+---------------------------------------------------+
	*/

	function getInfo($imageFile)
	{
		$type[1] = 'gif';
		$type[2] = 'jpg';
		$type[3] = 'png';
		
		$imgData = getimagesize($imageFile);
		
		$pos	= strrpos($imageFile, ".");
		$ext	= substr($imageFile, $pos + 1);
		$name	= substr($imageFile, 0, $pos);

		$imageInfo["name"]		= $name;
		$imageInfo["ext"]		= $ext;
		$imageInfo["typeID"]	= $imgData[2];
		$imageInfo["type"]		= $type[$imgData[2]];
		$imageInfo["file"]		= basename($imageFile);
		$imageInfo["size"]		= filesize($imageFile);
		$imageInfo["width"]		= $imgData[0];
		$imageInfo["height"]	= $imgData[1];
		
		return $imageInfo;	
	}

	//+-------------------------------------------------------------------------------------------------------------------------+

 	/*
	+---------------------------------------------------+
	| Function Name : createSourceImageObject
	+---------------------------------------------------+
	| Description : 实例化源图形对象
	+---------------------------------------------------+
	| Created / Modify : 2004-11-23 / 
	+---------------------------------------------------+
	 Note :
		$imageFile ： 图片文件
		$type : 图片类型 (通过getInfo函数获得)
	+---------------------------------------------------+
	*/

	function createSourceImageObject($imageFile, $type)
	{
	   	switch ($type)
		{
			case 1:	//gif
				$this->sourceImageObject = imagecreatefromgif($imageFile);
				break;
			case 2:	//jpg
				$this->sourceImageObject = imagecreatefromjpeg($imageFile);
				break;
			case 3:	//png
				$this->sourceImageObject = imagecreatefrompng($imageFile);
				break;
			default:
				return 0;
				break;
		}
	}

 	/*
	+---------------------------------------------------+
	| Function Name : createWaterImageObject
	+---------------------------------------------------+
	| Description : 实例化水印图形对象
	+---------------------------------------------------+
	| Created / Modify : 2004-11-23 / 
	+---------------------------------------------------+
	 Note :
		$imageFile ： 图片文件
		$type : 图片类型 (通过getInfo函数获得)
	+---------------------------------------------------+
	*/

	function createWaterImageObject($imageFile, $type)
	{
	   	switch ($type)
		{
			case 1:	//gif
				$this->waterImageObject = imagecreatefromgif($imageFile);
				break;
			case 2:	//jpg
				$this->waterImageObject = imagecreatefromjpeg($imageFile);
				break;
			case 3:	//png
				$this->waterImageObject = imagecreatefrompng($imageFile);
				break;
			default:
				return 0;
				break;
		}
	}
  	/*
	+---------------------------------------------------+
	| Function Name : createNewImageObject
	+---------------------------------------------------+
	| Description : 实例化目标对象
	+---------------------------------------------------+
	| Created / Modify : 2004-11-23 / 
	+---------------------------------------------------+
	 Note :

	+---------------------------------------------------+
	*/

	function createNewImageObject($width, $height, $f_width, $f_height)
	{
		if (function_exists("imagecreatetruecolor")) //version >= GD2.0.1
		{
			$this->newImageObject = imagecreatetruecolor($width, $height);
			ImageCopyResampled($this->newImageObject, $this->sourceImageObject, 0, 0, 0, 0, $width, $height, $f_width, $f_height);
		}
		else
		{
			$this->newImageObject = imagecreate($width, $height);
			ImageCopyResized($this->newImageObject, $this->sourceImageObject, 0, 0, 0, 0, $width, $height, $f_width, $f_height);
		}
	}

	/*
	+---------------------------------------------------+
	| Function Name : destroySourceImageObject
	+---------------------------------------------------+
	| Description : 销毁源图形对象
	+---------------------------------------------------+
	| Created / Modify : 2004-11-23 / 
	+---------------------------------------------------+
	 Note :
	+---------------------------------------------------+
	*/

	function destroySourceImageObject()
	{
	   ImageDestroy($this->sourceImageObject);
	}

 	/*
	+---------------------------------------------------+
	| Function Name : destroyNewImageObject
	+---------------------------------------------------+
	| Description : 销毁目标对象
	+---------------------------------------------------+
	| Created / Modify : 2004-11-23 / 
	+---------------------------------------------------+
	 Note :
	+---------------------------------------------------+
	*/

	function destroyNewImageObject()
	{
	   ImageDestroy($this->newImageObject);
	}

  	/*
	+---------------------------------------------------+
	| Function Name : destroyNewImageObject
	+---------------------------------------------------+
	| Description : 销毁水印目标对象
	+---------------------------------------------------+
	| Created / Modify : 2004-11-23 / 
	+---------------------------------------------------+
	 Note :
	+---------------------------------------------------+
	*/

 	function destroyWaterImageObject()
	{
	   ImageDestroy($this->waterImageObject);
	}

	//+-------------------------------------------------------------------------------------------------------------------------+

	function gb2utf8($gb) 
	{
		if(!trim($gb)) 
			return $gb; 

		$filename="gb2312.txt"; 
		$tmp=file($filename); 
		$codetable=array(); 

		while(list($key,$value)=each($tmp)) 
			$codetable[hexdec(substr($value,0,6))]=substr($value,7,6); 

		$ret=""; 
		$utf8=""; 

		while($gb) 
		{ 
			if (ord(substr($gb,0,1))>127) 
			{ 
				$thischr = substr($gb,0,2); 
				$gb=substr($gb,2,strlen($gb)); 
				$utf8 = $this->u2utf8(hexdec($codetable[hexdec(bin2hex($thischr))-0x8080])); 
				for($i=0;$i<strlen($utf8);$i+=3) 
				$ret.=chr(substr($utf8,$i,3)); 
			} 
			else 
			{ 
				$ret.=substr($gb,0,1); 
				$gb=substr($gb,1,strlen($gb)); 
			} 
		} 
		return $ret; 
	}
	
	function u2utf8($c) 
	{ 
		for($i=0;$i<count($c);$i++) 
			$str=""; 
		if ($c < 0x80)
		{ 
			$str.=$c; 
		} 
		else if ($c < 0x800)
		{
			$str.=(0xC0 | $c>>6); 
			$str.=(0x80 | $c & 0x3F); 
		} 
		else if ($c < 0x10000)
		{ 
			$str.=(0xE0 | $c>>12); 
			$str.=(0x80 | $c>>6 & 0x3F); 
			$str.=(0x80 | $c & 0x3F); 
		} 
		else if ($c < 0x200000)
		{ 
			$str.=(0xF0 | $c>>18); 
			$str.=(0x80 | $c>>12 & 0x3F); 
			$str.=(0x80 | $c>>6 & 0x3F); 
			$str.=(0x80 | $c & 0x3F); 
		} 
		return $str; 
	} 

}

?>