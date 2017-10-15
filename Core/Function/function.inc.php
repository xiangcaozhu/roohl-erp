<?php
function TestArray($str){
echo "<br><br><br<br><br><br<br><br><br<br><br><br>";
echo "<br><br>数据查询<br>";
echo '<pre>';
print_r($str);
echo '</pre>';
echo "<br>数据查询<br><br>";
}

function GetPic($url,$filename="") { 
$ext=strrchr($url,"."); 
if($ext!=".gif" && $ext!=".jpg" && $ext!=".png") return false; 
$filename='../GoodImg/'.$filename.$ext; 


ob_start(); 
readfile($url); 
$img = ob_get_contents(); 
ob_end_clean(); 
$size = strlen($img); 

$fp2=@fopen($filename, "a"); 
fwrite($fp2,$img); 
fclose($fp2); 
//return $filename; 
} 



function ToLower( $str )
{
	if($str)
	return strtolower($str);
}
function ToUpper( $str )
{
	if($str)
	return strtoupper($str);
}


function CheckExcelDate($val){
	$SignInDate = strtotime($val);
	if($SignInDate<999999){
		$SignInDate = strtotime(excelTime($val));
	}
	return DateFormat($SignInDate,'Y-m-d H:i:s');
}

function excelTime($val){
$n = intval(($val - 25569) * 3600 * 24); //转换成1970年以来的秒数
return gmdate('Y-m-d H:i:s', $n);//格式化时间
}


function GetHtm_jh( $url )
{
$str_html = file_get_contents($url); 

preg_match_all("/<div id=\"mainId\">(.*?)<\/div>/si", $str_html, $match);
$Pname = trim($match[1][0]); 

preg_match_all("/<span class=\"show_l\">商品编号：<\/span>(.*?)<ul class=\"renzheng\">/si", $str_html, $match);
$Pno = trim($match[1][0]);

preg_match_all("/<strong id=\"price\">¥(.*?)<\/strong>/si", $str_html, $match);
$Pmoney = trim($match[1][0]);

preg_match_all("/<dt class=\"pro_pic\">(.*?)<div id=\"idList\" class=\"list\">/si", $str_html, $matchs);
preg_match_all("/\"\/>(.*?)<pp>/si", $matchs[1][0].'<pp>', $match);
$matchImg = str_replace(' class="cloud-zoom" id="productPicZoom" rel="adjustX: 10, adjustY:-1"',"",$match[1][0]);
$Pimg = str_replace(' class="izImage" width="350px" height="350"',' width="150" height="150" ',$matchImg);


preg_match_all("/<img src=\"(.*?)\"/si", $Pimg, $matcha);
$Ppic = trim($matcha[1][0]);

$GetInfo=array (
  'Pname' => $Pname,
  'Pno' => $Pno,
  'Pmoney' => $Pmoney,
  'Pimg' => $Pimg,
  'Ppic' => $Ppic,
);

	return $GetInfo;


}

function GetHtm_gf( $url )
{
if (!@fopen($url, "r"))
{
$Pname = '无页面'; 
$Pno='无页面';
$Pmoney='无页面';
$Pimg='无页面';
$Ppic='无页面';
}
else
{
$str_html = file_get_contents($url); 

preg_match_all("/<h1 class='products_h1'>(.*?)<\/h1>/si", $str_html, $match);
$Pname = trim($match[1][0]); 
$Pname = str_replace('&nbsp;','',$Pname);
//echo $Pname;

preg_match_all("/hid_goods_mid(.*?)hid_goods_oid/si", $str_html, $match);
$Pnos = trim($match[1][0]);
$Pnos = preg_match_all("/value=\"(.*?)\" id=/si", $Pnos, $match);
$Pno = trim($match[1][0]);
//echo '<br>'.$Pno;

preg_match_all("/<dd>&nbsp;￥(.*?)<\/dd>/si", $str_html, $match);
$Pmoney = trim($match[1][0]);
//echo '<br>'.$Pmoney;

//id='pro_img_big' src='/eshop/goods/01130716103836066634/images/01130716103836066634_1.jpg' width='305'  height='305' />
preg_match_all("/id='pro_img_big' src='(.*?)' width=/si", $str_html, $matchs);
//preg_match_all("/\"\/>(.*?)<pp>/si", $matchs[1][0].'<pp>', $match);
//$matchImg = str_replace(' class="cloud-zoom" id="productPicZoom" rel="adjustX: 10, adjustY:-1"',"",$match[1][0]);
//$Pimg = str_replace(' class="izImage" width="350px" height="350"',' width="150" height="150" ',$matchImg);


//preg_match_all("/<img src=\"(.*?)\"/si", $Pimg, $matcha);
$Ppic = 'https://shop.cgbchina.com.cn/'.trim($matchs[1][0]);
//echo '<br>'.$Ppic;

}
$GetInfo=array (
  'Pname' => $Pname,
  'Pno' => $Pno,
  'Pmoney' => $Pmoney,
  'Pimg' => $Pimg,
  'Ppic' => $Ppic,
);

	return $GetInfo;


}




function GetFeiLv( $a, $s )
{
	$payout = Core::GetConfig( $a );
	$str = $payout[$s];
	return $str;
}

function GetExpress_1( $comCN, $nu )
{
$expresses=array (
  'aae' => 'AAE快递',
  'anjie' => '安捷快递',
  'anxinda' => '安信达快递',
  'aramex' => 'Aramex国际快递',
  'balunzhi' => '巴伦支',
  'baotongda' => '宝通达',
  'benteng' => '成都奔腾国际快递',
  'cces' => 'CCES快递',
  'changtong' => '长通物流',
  'chengguang' => '程光快递',
  'chengji' => '城际快递',
  'chengshi100' => '城市100',
  'chuanxi' => '传喜快递',
  'chuanzhi' => '传志快递',
  'chukouyi' => '出口易物流',
  'citylink' => 'CityLinkExpress',
  'coe' => '东方快递',
  'cszx' => '城市之星',
  'datian' => '大田物流',
  'dayang' => '大洋物流快递',
  'debang' => '德邦物流',
  'dechuang' => '德创物流',
  'dhl' => 'DHL快递',
  'diantong' => '店通快递',
  'dida' => '递达快递',
  'dingdong' => '叮咚快递',
  'disifang' => '递四方速递',
  'dpex' => 'DPEX快递',
  'dsu' => 'D速快递',
  'ees' => '百福东方物流',
  'ems' => 'EMS快递',
  'fanyu' => '凡宇快递',
  'fardar' => 'Fardar',
  'fedex' => '国际Fedex',
  'fedexcn' => 'Fedex国内',
  'feibang' => '飞邦物流',
  'feibao' => '飞豹快递',
  'feihang' => '原飞航物流',
  'feihu' => '飞狐快递',
  'feite' => '飞特物流',
  'feiyuan' => '飞远物流',
  'fengda' => '丰达快递',
  'fkd' => '飞康达快递',
  'gdyz' => '广东邮政物流',
  'gnxb' => '邮政国内小包',
  'gongsuda' => '共速达物流|快递',
  'guotong' => '国通快递',
  'haihong' => '山东海红快递',
  'haimeng' => '海盟速递',
  'haosheng' => '昊盛物流',
  'hebeijianhua' => '河北建华快递',
  'henglu' => '恒路物流',
  'huacheng' => '华诚物流',
  'huahan' => '华翰物流',
  'huaqi' => '华企快递',
  'huaxialong' => '华夏龙物流',
  'huayu' => '天地华宇物流',
  'huiqiang' => '汇强快递',
  'huitong' => '汇通快递',
  'hwhq' => '海外环球快递',
  'jiaji' => '佳吉快运',
  'jiayi' => '佳怡物流',
  'jiayunmei' => '加运美快递',
  'jinda' => '金大物流',
  'jingguang' => '京广快递',
  'jinyue' => '晋越快递',
  'jixianda' => '急先达物流',
  'jldt' => '嘉里大通物流',
  'kangli' => '康力物流',
  'kcs' => '顺鑫(KCS)快递',
  'kuaijie' => '快捷快递',
  'kuanrong' => '宽容物流',
  'kuayue' => '跨越快递',
  'lejiedi' => '乐捷递快递',
  'lianhaotong' => '联昊通快递',
  'lijisong' => '成都立即送快递',
  'longbang' => '龙邦快递',
  'minbang' => '民邦快递',
  'mingliang' => '明亮物流',
  'minsheng' => '闽盛快递',
  'nell' => '尼尔快递',
  'nengda' => '港中能达快递',
  'ocs' => 'OCS快递',
  'pinganda' => '平安达',
  'pingyou' => '中国邮政平邮',
  'pinsu' => '品速心达快递',
  'quanchen' => '全晨快递',
  'quanfeng' => '全峰快递',
  'quanjitong' => '全际通快递',
  'quanritong' => '全日通快递',
  'quanyi' => '全一快递',
  'rpx' => 'RPX保时达',
  'rufeng' => '如风达快递',
  'saiaodi' => '赛澳递',
  'santai' => '三态速递',
  'scs' => '伟邦(SCS)快递',
  'shengan' => '圣安物流',
  'shengfeng' => '盛丰物流',
  'shenghui' => '盛辉物流',
  'shentong' => '申通快递（可能存在延迟）',
  'shunfeng' => '顺丰快递',
  'suijia' => '穗佳物流',
  'sure' => '速尔快递',
  'tiantian' => '天天快递',
  'tnt' => 'TNT快递',
  'tongcheng' => '通成物流',
  'tonghe' => '通和天下物流',
  'ups' => 'UPS快递',
  'usps' => 'USPS快递',
  'wanbo' => '万博快递',
  'wanjia' => '万家物流',
  'weitepai' => '微特派',
  'xianglong' => '祥龙运通快递',
  'xinbang' => '新邦物流',
  'xinfeng' => '信丰快递',
  'xiyoute' => '希优特快递',
  'yad' => '源安达快递',
  'yafeng' => '亚风快递',
  'yibang' => '一邦快递',
  'yinjie' => '银捷快递',
  'yinsu' => '音素快运',
  'yishunhang' => '亿顺航快递',
  'yousu' => '优速快递',
  'ytfh' => '北京一统飞鸿快递',
  'yuancheng' => '远成物流',
  'yuantong' => '圆通快递',
  'yuanzhi' => '元智捷诚',
  'yuefeng' => '越丰快递',
  'yumeijie' => '誉美捷快递',
  'yunda' => '韵达快递',
  'yuntong' => '运通中港快递',
  'yuxin' => '宇鑫物流',
  'ywfex' => '源伟丰',
  'zhaijisong' => '宅急送快递',
  'zhengzhoujianhua' => '郑州建华快递',
  'zhima' => '芝麻开门快递',
  'zhongtian' => '济南中天万运',
  'zhongtong' => '中通快递',
  'zhongxinda' => '忠信达快递',
  'zhongyou' => '中邮物流',
);

$com = 'other';
foreach ( $expresses as $key => $val )
{
	if(strpos($val,$comCN)===false){
	}
	else
	{
	$com = $key;
	}
}


  $gateway=sprintf('http://api.ickd.cn/?id=%s&secret=%s&com=%s&nu=%s&encode=%s&type=%s','102459','8a4dd0e999551f9d62e127af9508c3f8',$com,$nu,'utf8','json');
  $ch=curl_init($gateway);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch,CURLOPT_HEADER,false);
  $resp=curl_exec($ch);
  $errmsg=curl_error($ch);
  if($errmsg){
      exit($errmsg);
  }
  curl_close($ch);
  //echo $resp;
  return $resp;
}


function DeBug( $value )
{
	echo "<pre>";
	print_r( $value );
	echo "</pre>";
}

function MTime()
{
	list($usec, $sec) = explode(" ", microtime());
	return ((float)$usec + (float)$sec);
}

function GetUserIp()
{
	if ( $_SERVER['HTTP_CLIENT_IP'] )
		return$_SERVER['HTTP_CLIENT_IP'];
	elseif ( $_SERVER['HTTP_X_FORWARDED_FOR'] )
		return $_SERVER['HTTP_X_FORWARDED_FOR'];
	else
		return $_SERVER['REMOTE_ADDR'];
}

function Html2Text( $string )
{
	$string = str_replace( '&', '&amp;', $string );
	$string = str_replace( '"', '&quot;', $string );
	$string = str_replace( '<', '&lt;', $string );
	$string = str_replace( '>', '&gt;', $string );

	return $string;
}

function Alert( $msg, $url = '' )
{
	header("Content-type: text/html; charset=utf-8");
	echo "<script language=javascript>";
	echo "window.alert('$msg');";
	
	if ( $url )
		echo "window.location = '{$url}';";
	else
		echo "history.go(-1);";
	
	echo "</script>";
	exit;
}

function SizeFormat( $filesize )
{
	if ( $filesize >= 1073741824 )
		$filesize = round( $filesize / 1073741824 * 100 ) / 100 . ' G';
	elseif ( $filesize >= 1048576 )
		$filesize = round( $filesize / 1048576 * 100 ) / 100 . ' M';
	elseif ( $filesize >= 1024 )
		$filesize = round( $filesize / 1024 * 100 ) / 100 . ' K';
	else
		$filesize = $filesize . ' B';

	return $filesize;
}

function DateFormat( $time, $format = 'Y-m-d H:i' )
{
	//$time = $time - 8 * 3600;
	
	if ( $format == 'auto' )
	{
		if ( date( 'Ymd' ) == date( 'Ymd', $time ) )
			return date( "H:i", $time );
		else
			return date( "y-m-d H:i", $time );
	}
	else
	{
		return date( $format, $time );
	}
}

function WriteFile( $path, $content )
{
	$fp = @fopen( $path, "w+" );
	if ( $fp )
	{
		@fwrite( $fp, $content );
		@fclose( $fp );
		return true;
	}
	else
	{
		return false;
	}
}

function GetFile( $path )
{
	$fp = @fopen( $path, "rb" );
	return @fread( $fp, @filesize( $path ) );
}

function MakeDir( $path )
{
	if ( !@mkdir( $path, 0755 ) )
		return false;
	else
		return true;
}

function MakeDirTree( $path )
{
	$pathList = explode( '/', UnifySeparator( $path ) );

	$p = '';
	if ( $pathList )
	{
		foreach ( $pathList as $val )
		{
			$p .= $val . '/';

			if ( !FileExists( $p ) )
			{
				if ( !MakeDir( $p ) )
				{
					return false;
				}
			}
		}
	}

	return true;
}

function GetHashPath( $string )
{
	$hash = md5( $string );

	return implode( '/', array( substr( $hash, 0, 2 ), substr( $hash, 2, 2), substr( $hash, 4 ) ) );
}

function FileExists( $path )
{
	return file_exists( $path );
}

function GetFileExt( $fileName )
{
	return strtolower( end( explode( '.', $fileName) ) );
}

function GetRand( $length = 5 )
{
	$string = "qwertyuiopasdfghjklzxcvbnm";
	$strLen = strlen( $string ) - 1;

	for ( $i = 0; $i < $length; $i++ )
	{
		$seek = mt_rand( 0, $strLen );

		$rand .= $string[$seek];
	}

	return $rand;
}

// only utf8
function CutStr( $string, $sublen, $end = '...', $start = 0 )
{
	if ( strlen( $string ) <= $sublen )
		return $string;

	if ( preg_match( '/^[^\x{2E80}-\x{9FFF}]+$/u', $string ) )
	{
		return SingleByteCut( $string, $sublen, $end = '...' );
	}

	$string = str_replace( array( '&amp;', '&quot;', '&lt;', '&gt;' ), array( '&', '"', '<', '>' ), $string );
	
	$pa = "/[\x01-\x7f]{1,2}|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
	preg_match_all( $pa, $string, $t_string );

	if( count($t_string[0]) - $start > $sublen )
		$sctString =  join( '', array_slice( $t_string[0], $start, $sublen ) )."{$end}";
	else
		$sctString =  join( '', array_slice( $t_string[0], $start, $sublen ) );
	
	return str_replace( array( '&', '"', '<', '>' ), array( '&amp;', '&quot;', '&lt;', '&gt;' ), $sctString );
}

function SingleByteCut( $string, $sublen, $end = '...' )
{
	$length = strlen( $string );
	if ($length > $sublen){
		$sub_string = substr( $string, $start, $sublen );
		$space_position = strrpos( $sub_string, ' ' );
		if($space_position != FALSE){
			$sub_string = substr( $sub_string, 0, $space_position+1 );
		} else {
			if($space_position = strpos($string,' '))
				$sub_string = substr($string,0, $space_position+1);
		}
		return $sub_string.$end;
	}else{
		return $string;
	}
}

function RemoveQuotes( $string )
{
	if( is_array( $string) )
	{
		foreach( $string as $key => $val )
		{
			$string[$key] = RemoveQuotes( $val );
		}
	}
	else
	{
		$string = stripslashes( $string );
	}

	return $string;
}

function EnCode( $string, $key )
{
	return str_replace( '=', '', base64_encode( xxtea_encrypt( $string, $key ) ) );
}

function DeCode( $string, $key )
{
	$string = ( base64_decode( $string ) );

	return xxtea_decrypt( $string, $key );
}

function SearchEnCode( $string )
{
	return str_replace( array( '=', '+', '/' ), array( '', '13@', '14@' ), base64_encode( xxtea_encrypt( $string, 'search' ) ) );
}

function SearchDeCode( $string )
{
	$string = base64_decode( str_replace( array( '13@', '14@' ), array( '+', '/' ), $string ) );
	return xxtea_decrypt( $string, 'search' );
}

function UnifySeparator( $path )
{
	preg_match( '/((?:https?:\/\/|ftp:\/\/|mms:\/\/|))(.+?)$/', $path, $result );

	$pathPart = $result[2];
	$pathPart = str_replace( '\\', '/', $pathPart );
	$pathPart = preg_replace( '/(\/+)/', '/', $pathPart );

	return $result[1] . $pathPart;
}

function GetDirFile( $dirPath )
{
	$dirList = array();
	$fileInfo = array();
	$dirList[] = $dirPath;

	while ( count( $dirList ) > 0 )
	{
		unset( $tmp );

		foreach ( $dirList as $path )
		{
			$res = @opendir( $path );

			while ( false !== ( $fileName = @readdir( $res ) ) )
			{
				if ($fileName != '.' && $fileName != '..')
				{
					$filePath = $path . "/" . $fileName;

					if ( is_dir( $filePath ) )
						$tmp[] = UnifySeparator( $filePath );
					elseif ( is_file( $filePath ) )
						$fileInfo[] = UnifySeparator( $filePath );
				}
			}
		}

		unset( $dirList );
		$dirList = $tmp;
	}

	return $fileInfo;
}

function DelOverdueFile( $folder, $time = 86400 )
{
	clearstatcache();

	$fileList = GetDirFile( $folder );
	
	$overdueTime = time() - $time;
	
	foreach( $fileList as $path )
	{
		if ( @filemtime( $path ) < $overdueTime )
			@unlink( $path );
	}
}

function PHP2JSON($a)
{
	if ( is_null( $a ) )
		return 'null';
	if ( $a === false )
		return 'false';
	if ( $a === true )
		return 'true';

	if ( is_scalar( $a ) )
	{
		$a = addslashes( $a );
		$a = str_replace( "\n", '\n', $a );
		$a = str_replace( "\r", '\r', $a );
		$a = preg_replace( '{(</)(script)}i', "$1'+'$2", $a );

		return "'$a'";
	}

	$isList = true;
	for ( $i=0, reset( $a ); $i < count( $a ); $i++, next( $a ) )
	{
		if ( key( $a ) !== $i )
		{
			$isList = false;
			break;
		}
	}

	$result = array();

	if ( $isList )
	{
		foreach ( $a as $v )
		{
			$result[] = PHP2JSON( $v );
		}

		return '[' . join( ', ', $result ) . ']';
	}
	else
	{
		foreach ( $a as $k => $v )
		{
			$result[] = PHP2JSON( $k ) . ':' . PHP2JSON( $v );
		}

		return '{' . join( ', ', $result ) . '}';
	}
}

function GetExplode( $a, $s )
{
	return array_filter( explode( $a, $s ) );
}


function HeaderNoCache()
{
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
}

function Redirect( $url = '' )
{
	if ( !$url )
		$url = $_SERVER['HTTP_REFERER'];
	
	if ( !headers_sent() )
	{
		header( "Location:{$url}" );
	}
	else
	{
		echo "<script>";
		echo "window.location='{$url}';";
		echo "</script>";
	}

	exit();
}

function Nothing( $str )
{
	if ( strlen( trim( $str ) ) > 0 )
		return false;
	else
		return true;
}

function NoHtml( $str )
{
	return htmlspecialchars( trim( $str ) );
}

function GetFileName( $fileName )
{
	$name = strtolower( current( explode( '.', $fileName, 2 ) ) );

	$name = str_replace( array( '"', "'", '/', '\\' ), '', $name );

	return $name;
}

function IsEmail( $email )
{
	if ( Nothing( $email ) )
		return false;

	if( !preg_match('/^([a-zA-Z0-9_\.\-\+])+@([-0-9A-Z]+\.)+([0-9A-Z]){2,4}$/i', $email ) )
		return false;
	else
		return true;
}

function CapsMoney($RMB)
{
	if(eregi("[^0-9.]",$RMB))
		return "非法金额";
	if($RMB==0)
		return "零元整";
	elseif($RMB>pow(10,12))
		return "金额必须小于千亿";
	$re   = '';
	$arr1 = array('零','壹','贰','叁','肆','伍','陆','柒','捌','玖');
	$arr2 = array('元','拾','佰','仟','万','拾','佰','仟','亿','拾','佰','仟');
	$arr3 = array('角','分','厘','毫');
	$pre1 = count($arr2);  //单位精确度 precision
	$pre2 = count($arr3);  //小数位精确度 precision
	$arr  = @explode(".",$RMB);//按小数点切割金额
	$len1 = @strlen($arr[0]);  //整数位长度
	if ($arr[1] > 0)
	$len2 = @strlen($arr[1]);  //小数位长度
	for($i= 0; $i < $len1 && $i < $pre1; $i ++)
	{
		$bit = $arr[0][$len1-$i-1];     //当前位小写金额
		$cn = $arr1[$bit];             //当前位大写金额
		$unit = $arr2[$i];                           //当前位金额单位
		//小写金额为零的情况
		if($bit==0)
		{
			if(ereg('元|万|亿',$unit))
				$re=$unit.$re;
			else
				$re=$cn.$re;
		}
		else
		{        //小写金额非零的情况
			$re=$cn.$unit.$re;
		}
	}
	for($i=0; $i < count($arr3) && $i<$len2; $i++)
	{
		$bit = $arr[1][$i];    //当前位小写金额
		$cn = $arr1[$bit];    //当前位大写金额
		$unit = $arr3[$i];      //当前位金额单位
		if($bit!=0)
			$re .= $cn.$unit;
		elseif($i < 2)
			$re .= "零";
	}
	$re=preg_replace(array("/亿万/","/(零)$/" , "/(零){2,}/") , array("亿","","零") , $re);  //正则替换
	//if(!$len2)
		$re.="整";  //当没有小数位时加上“整”
	return $re;
}

function markMoney( $RMB,$num=0 )
{
$arr  = @explode(".",$RMB);//按小数点切割金额
$len1 = @strlen($arr[0]);  //整数位长度
if ($arr[1] > 0)
$len2 = @strlen($arr[1]);  //小数位长度

$re=0;
if($num<9)
{

if($num>$len1+1)
$re='&nbsp;';
elseif($num>$len1)
$re='￥';
else
$re=$arr[0][$len1-$num];

}
elseif($num==9)
{
$re=(int)$arr[1][0]; 
}
elseif($num==10)
{
$re=(int)$arr[1][1]; 
}

return $re;
}

function ToStr( $str )
{
	if($str)
	return implode(",",$str);
}

function ToArray( $str )
{
	if($str)
	return explode(",",$str);
	else
	return array();
}

function ArrayVals( $list,$v)
{
	if ( !is_array( $list ) )
		return array();
	
	$temp = array();
	foreach ( $list as $keys => $val )
	{
		if($val){$temp[] = $val[$v];}
	}

	$temp = array_unique($temp);

	$new = array();
	foreach ( $temp as $vals )
	{
		if($vals){$new[] = $vals;}
	}
	return $new;
}


function StrVals( $list,$v)
{
	if ( !is_array( $list ) )
		return array();
	
	$new = ',';
	foreach ( $list as $val ){$new .= ','.$val[$v];}
	$new = str_replace(',,','',$new);
	$new = ToArray($new);
	$new = array_unique($new);
	$new = ToStr($new);
	return $new;
}

function ArrayIndex( $list, $key )
{
	if ( !is_array( $list ) )
		return array();
	
	$new = array();
	foreach ( $list as $val )
	{
		$new[$val[$key]] = $val;
	}

	return $new;
}

function ArraySlice( $list, $num, $start = 0 )
{
	if ( !is_array( $list ) )
		return array();

	$i = 0;
	$newList = array();
	foreach ( $list as $key => $val )
	{
		if ( $newList )
			$newList[$key] = $val;

		if ( $i == $start )
			$newList[$key] = $val;

		if ( count( $newList ) >= $num  )
			break;

		$i++;
	}
	
	return $newList;
}

function ArrayJoin( $list, $string, $key = '' )
{
	$new = array();

	if ( $key )
	{
		foreach ( $list as $val )
		{
			$new[] = $val[$key];
		}
	}
	else
	{
		$new = $list;
	}

	return implode( $new, $string );
}

function ArrayOnly( $list, $key )
{
	if ( !is_array( $list ) )
		return array();
	
	$new = array();

	foreach ( $list as $val )
	{
		$new[$val[$key]] = $val;
	}

	return array_values( $new );
}

function ArrayFilter( $list, $key )
{
	if ( !is_array( $list ) )
		return array();

	$new = array();

	foreach ( $list as $val )
	{
		if ( $val[$key] )
			$new[] = $val;
	}

	return $new;
}

function ArrayKey( $list )
{
	if ( !is_array( $list ) )
		return array();

	$argList = func_get_args();
	
	$value = array();
	foreach ( $list as $val )
	{
		for ( $i = 1,$l = count( $argList ); $i < $l; $i++ )
		{
			$value[$val[$argList[$i]]] = 1;
		}
	}

	return $value ? @array_keys( $value ) : array();
}

function ArraySort( $list, $key )
{
	if ( !is_array( $list ) || !$list )
		return array();
	
	foreach ( $list as $k => $v )
	{
		$edition[$k] = $v[$key];
	}

	array_multisort( $edition, SORT_DESC, $list );

	return $list;
}

function ArrayOrder( $list, $sort )
{
	if ( !is_array( $list ) || !$list )
		return array();

	if ( !is_array( $sort ) || !$sort )
		return array();
	
	$new = array();
	foreach ( $sort as $val )
	{
		$new[$val] = $list[$val];
	}

	return $new;
}

function ArrayGroup( $list, $key, $preserve = false )
{
	if ( !$list )
		return array();

	$new = array();
	foreach ( $list as $k => $val )
	{
		if ( !$preserve )
			$new[$val[$key]][] = $val;
		else
			$new[$val[$key]][$k] = $val;
	}

	return $new;
}

function ArrayPage( $list, $num = 10, $maxPage = 0, $fill = 0 )
{
	$total = count( $list );
	$page = ceil( $total / $num );
	$maxPage = $maxPage > 0 ? $maxPage : $page;
	$newList = array();

	$i = 1;
	foreach ( $list as $val )
	{
		$p = ceil( $i / $num );
		if ( $p > $maxPage )
		{
			break;
		}

		$newList[$p][] = $val;
		$i++;
	}

	if ( $fill )
	{
		$missNum = $num - count( $newList[$maxPage] );
		if ( $missNum > 0 )
		{
			for ( $i = 0; $i < $missNum; $i++ )
			{
				$newList[$maxPage][] = array();
			}
		}
	}

	return $newList;
}

function ArrayBlock( $list, $perNum = 4, $fill = false )
{
	$new = array();
	$len = count( $list );
	$num = ceil( $len / $perNum );

	for ( $i = 1; $i <= $num; $i++  )
	{
		$new[] = array_slice( $list, ( $i - 1 ) * $perNum, $perNum, true );
	}

	return $new;
}

function RandColor( $colorStart = 0, $colorEnd = 3 )
{
	$color = array( 0 => '0', 1 => '3', 2 => '6', 3 => '9', 4 => 'C', 5 => 'F' );

	while ( ( $o ='#' . $color[rand( $colorStart, $colorEnd )] . $color[rand( $colorStart, $colorEnd )] . $color[rand( $colorStart, $colorEnd )] ) != '#FFF' )
	{
		return $o;
	}
}

function FormatMoney( $money)
{
	return sprintf( '%.2f', $money );
}

function _HD( $s )
{
	return htmlspecialchars_decode( $s );
}

function _HS( $s )
{
	return htmlspecialchars( $s );
}

function Cut( $string, $len )
{
	return CutStr( $string, $len );
}




function long2str($v, $w) { 
    $len = count($v); 
    $n = ($len - 1) << 2; 
    if ($w) { 
        $m = $v[$len - 1]; 
        if (($m < $n - 3) || ($m > $n)) return false; 
        $n = $m; 
    } 
    $s = array(); 
    for ($i = 0; $i < $len; $i++) { 
        $s[$i] = pack("V", $v[$i]); 
    } 
    if ($w) { 
        return substr(join('', $s), 0, $n); 
    } 
    else { 
        return join('', $s); 
    } 
} 
  
function str2long($s, $w) { 
    $v = unpack("V*", $s. str_repeat("\0", (4 - strlen($s) % 4) & 3)); 
    $v = array_values($v); 
    if ($w) { 
        $v[count($v)] = strlen($s); 
    } 
    return $v; 
} 
  
function int32($n) { 
    while ($n >= 2147483648) $n -= 4294967296; 
    while ($n <= -2147483649) $n += 4294967296; 
    return (int)$n; 
} 
  
function xxtea_encrypt($str, $key) { 
    if ($str == "") { 
        return ""; 
    } 
    $v = str2long($str, true); 
    $k = str2long($key, false); 
    if (count($k) < 4) { 
        for ($i = count($k); $i < 4; $i++) { 
            $k[$i] = 0; 
        } 
    } 
    $n = count($v) - 1; 
  
    $z = $v[$n]; 
    $y = $v[0]; 
    $delta = 0x9E3779B9; 
    $q = floor(6 + 52 / ($n + 1)); 
    $sum = 0; 
    while (0 < $q--) { 
        $sum = int32($sum + $delta); 
        $e = $sum >> 2 & 3; 
        for ($p = 0; $p < $n; $p++) { 
            $y = $v[$p + 1]; 
            $mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z)); 
            $z = $v[$p] = int32($v[$p] + $mx); 
        } 
        $y = $v[0]; 
        $mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z)); 
        $z = $v[$n] = int32($v[$n] + $mx); 
    } 
    return long2str($v, false); 
} 
  
function xxtea_decrypt($str, $key) { 
    if ($str == "") { 
        return ""; 
    } 
    $v = str2long($str, false); 
    $k = str2long($key, false); 
    if (count($k) < 4) { 
        for ($i = count($k); $i < 4; $i++) { 
            $k[$i] = 0; 
        } 
    } 
    $n = count($v) - 1; 
  
    $z = $v[$n]; 
    $y = $v[0]; 
    $delta = 0x9E3779B9; 
    $q = floor(6 + 52 / ($n + 1)); 
    $sum = int32($q * $delta); 
    while ($sum != 0) { 
        $e = $sum >> 2 & 3; 
        for ($p = $n; $p > 0; $p--) { 
            $z = $v[$p - 1]; 
            $mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z)); 
            $y = $v[$p] = int32($v[$p] - $mx); 
        } 
        $z = $v[$n]; 
        $mx = int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z)); 
        $y = $v[0] = int32($v[0] - $mx); 
        $sum = int32($sum - $delta); 
    } 
    return long2str($v, true); 
}

function outExcel($header=array(), $excelList=array(), $fileName, $mergeList = array(),$outMode=0){
if($fileName){
$Cell=array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
Core::LoadLibs( 'PHPExcel' );
$objPHPExcel = new PHPExcel();
$objPHPExcel->getDefaultStyle()->getFont()->setName( '宋体');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);

/*
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("你好");

$msgWorkSheet = new PHPExcel_Worksheet($objPHPExcel, 'card_message'); //创建一个工作表
$objPHPExcel->addSheet($msgWorkSheet); //插入工作表
$objPHPExcel->setActiveSheetIndex(1); //切换到新创建的工作表
$objPHPExcel->getActiveSheet()->setTitle("天气不错");
*/

	$x=0;
	foreach ( $header as $key => $val )
	{
	$objPHPExcel->getActiveSheet()->setCellValue($Cell[$x].'1',$key);
	$x++;
 	}
     
	$mergeIndex='';
	$m=1;
	foreach ( $excelList as $k => $v )
	{
	$m++;
	     $n=0;
		 foreach ( $header as $key => $val )
		 {
         // $objPHPExcel->getActiveSheet()->setCellValue($Cell[$n].$m,$v[$val]);
		 $objPHPExcel->getActiveSheet()->setCellValueExplicit($Cell[$n].$m,$v[$val],PHPExcel_Cell_DataType::TYPE_STRING);
		 $objPHPExcel->getActiveSheet()->getStyle($Cell[$n].$m)->getNumberFormat()->setFormatCode("@");

		  $n++;
		 }

    if($mergeList){
	if($mergeIndex==''){
		 foreach ( $mergeList as $a )
		 {
		 $mergeIndex .= '|'.$v[$a];
		 }
	}else{
		 $mergeValue='';
		 foreach ( $mergeList as $a )
		 {
		 $mergeValue .= '|'.$v[$a];
		 }
		 if($mergeValue === $mergeIndex){
	     

	     	     foreach ( $mergeList as $a )
	     	     {       
	 	     	         		 $u=0;
	 	     	         		 foreach ( $header as $key => $val )
		     	     	     	 {
								      if($val===$a)
								      {
									  
									  $mm = $m-1;
									  $ceA=$Cell[$u].$mm;
									  $ceB=$Cell[$u].$m;
									  $objPHPExcel->getActiveSheet()->mergeCells($ceA.":".$ceB);
								      }
								 $u++;
	     	     	     		 }
	     	     }
		 
		 
		 
		 }else{
		 $mergeIndex=$mergeValue;
		 }
	
	}
	}
	}

    $fileName = iconv('utf-8', 'gbk', $fileName);

if($outMode<1){
	$objPHPExcel->saveServer5($fileName);
}else{
	$objPHPExcel->saveDown5($fileName);
}



}
}


function ExcelXml( $header, $body, $mergeField = '', $mergeList = array() )
{
	$mergeIndex = array();
	foreach ( $body as $key => $val )
	{
		if ( $mergeValue['val'] == $val[$mergeField] )
		{
			$body[$mergeValue['key']]['__down']++;
			$body[$key]['__merged'] = 1;
		}
		else
		{
			$mergeValue['val'] = $val[$mergeField];
			$mergeValue['key'] = $key;
		}
	}

	$table = '<Table ss:ExpandedColumnCount="' . count( $header ) . '" ss:ExpandedRowCount="' . ( count( $body ) + 1 ) . '" x:FullColumns="1" x:FullRows="1" ss:DefaultColumnWidth="54" ss:DefaultRowHeight="14.25">' . "\n";

	$table .= "\t<Row ss:AutoFitHeight=\"0\">\n";

	foreach ( $header as $k => $v )
	{
		$data = @htmlspecialchars( $k );
		$table .= "\t\t<Cell><Data ss:Type=\"String\">{$data}</Data></Cell>\n";
	}

	$table .= "\t</Row>\n";

	foreach ( $body as $val )
	{
		$row = "\t<Row ss:AutoFitHeight=\"0\">\n";
		$cellIndex = 1;
		foreach ( $header as $v )
		{
			$data = @htmlspecialchars( $val[$v] );

			if ( !$val['__merged'] || !in_array( $v, $mergeList ) )
			{
				$mergeDown = '';
				if ( $val['__down'] && in_array( $v, $mergeList ) )
				{
					$mergeDown = ' ss:MergeDown="' . $val['__down'] . '" ss:StyleID="s22"';
				}

				if ( is_numeric( $data ) )
					$dataType = 'Number';
				else
					$dataType = 'String';

				if ( strlen($data) > 10 )
					$dataType = 'String';
					
					$dataType = 'String';

				$row .= "\t\t<Cell ss:Index=\"{$cellIndex}\"{$mergeDown}><Data ss:Type=\"{$dataType}\">{$data}</Data></Cell>\n";
			}

			$cellIndex++;
		}

		$row .= "\t</Row>\n";

		$table .= $row;
	}

	$table .= "</Table>";

	$xml = <<<EOT
<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Created>1996-12-17T01:32:42Z</Created>
  <LastSaved>2009-04-08T03:25:24Z</LastSaved>
  <Version>11.9999</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
  <RemovePersonalInformation/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>4530</WindowHeight>
  <WindowWidth>8505</WindowWidth>
  <WindowTopX>480</WindowTopX>
  <WindowTopY>120</WindowTopY>
  <AcceptLabelsInFormulas/>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="12"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s22">
   <Alignment ss:Vertical="Center"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Sheet1">
EOT;

	$xml .= $table;
	$xml .= <<<EOT
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>11</ActiveRow>
     <ActiveCol>4</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
EOT;

return $xml;
}

?>