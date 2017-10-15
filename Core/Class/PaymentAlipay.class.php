<?php


class PaymentAlipay
{
	function PaymentAlipay()
	{

	}

	function __construct()
	{
		$this->PaymentAlipay();
	}

	function GetCode( $OrderDom )
	{
		$orderInfo = $OrderDom->GetInfo();
		$totalMoney = FormatMoney( $OrderDom->moneySource );

		$config = Core::GetConfig( 'payment_config' );
		$config = $config['alipay'];
		
		$parameter = array(
			"service" => "create_direct_pay_by_user", //交易类型
			"partner" => $config['partner'], //合作商户号
			"return_url" => $config['return_url'], //同步返回
			"notify_url" => $config['notify_url'], //异步返回
			"_input_charset" => 'utf-8', //字符集，默认为GBK
			"subject" => $orderInfo['sn'], //商品名称，必填
			"body" => $orderInfo['sn'], //商品描述，必填
			"out_trade_no" => $orderInfo['sn'], //商品外部交易号，必填（保证唯一性）
			"total_fee" => $totalMoney, //商品单价，必填（价格不能为0）
			"payment_type" => "1", //默认为1,不需要修改
			"show_url" => 'http://www.kusell.cn', //商品相关网站
			"seller_email" => $config['seller_email'], //卖家邮箱，必填
		);

		$alipay = new alipay_service($parameter,$config['security_code'],$config['sign_type']);
		$link=$alipay->create_url();

		return "<script>window.location =\"$link\";</script>"; 
	}

	function Respond()
	{
		$config = Core::GetConfig( 'payment_config' );
		$config = $config['alipay'];
		
		$alipay = new alipay_notify($config['partner'],$config['security_code'],$config['sign_type'],'utf-8','http');
		$verify_result = $alipay->notify_verify();
		if($verify_result)
		{
			$OrderModel = Core::ImportModel( 'Order' );

			Core::LoadDom( 'Order' );
			
			//认证合格
			//获取支付宝的反馈参数
			$orderId	= OrderDom::GetId( $_POST['out_trade_no'] );    //获取支付宝传递过来的订单号
			$total	= $_POST['total_fee'];					 //获取支付宝传递过来的总价格

			$orderInfo = $OrderModel->Get( $orderId );

			if ( !$orderInfo )
			{
				$this->DoLog( 2, 1, $orderInfo );
				return false;
			}

			$OrderDom = new OrderDom( $orderInfo );

			if ( FormatMoney( $OrderDom->moneySource ) != $total )
			{
				$this->DoLog( 2, 4, $orderInfo );
				return false;
			}

			$receive_name		=$_POST['receive_name'];    //获取收货人姓名
			$receive_address	=$_POST['receive_address']; //获取收货人地址
			$receive_zip		=$_POST['receive_zip'];     //获取收货人邮编
			$receive_phone		=$_POST['receive_phone'];   //获取收货人电话
			$receive_mobile		=$_POST['receive_mobile'];  //获取收货人手机
			
			/*
			获取支付宝反馈过来的状态,根据不同的状态来更新数据库 
			WAIT_BUYER_PAY(表示等待买家付款);
			TRADE_FINISHED(表示交易已经成功结束);
			*/

			
			if($_POST['trade_status'] == 'WAIT_BUYER_PAY')
			{
				//等待买家付款
				//这里放入你自定义代码,比如根据不同的trade_status进行不同操作

				$this->DoLog( 2, 3, $orderInfo );
				return false;
			}
			else if($_POST['trade_status'] == 'TRADE_FINISHED' ||$_POST['trade_status'] == 'TRADE_SUCCESS')
			{
				//交易成功结束
				//这里放入你自定义代码,比如根据不同的trade_status进行不同操作

				$OrderDom->SetPayment();
				$this->DoLog( 1, 8, $orderInfo );
				return true;

				//如果您申请了支付宝的购物卷功能，请在返回的信息里面不要做金额的判断，否则会出现校验通不过，出现调单。如果您需要获取买家所使用购物卷的金额,
				//请获取返回信息的这个字段discount的值，取绝对值，就是买家付款优惠的金额。即 原订单的总金额=买家付款返回的金额total_fee +|discount|.
			}	
			else
			{
				$this->DoLog( 2, 7, $orderInfo );
				return false;
			}
		}
		else
		{
			//认证不合格
			$this->DoLog( 2, 7, $orderInfo );
			return false;
		}
	}

	function DoLog( $statusType = 2, $infoType = 0, $orderInfo = array() )
	{
		$ShopPaymentModel = Core::ImportModel( 'ShopPayment' );
		
		$logData = array();
		$logData['payment_type'] ='alipay'; // alipay
		$logData['log_type'] = 2; // response log
		$logData['add_time'] = time();
		$logData['order_info'] = serialize( $orderInfo );
		$logData['request_info'] = serialize( $_POST );
		$logData['request_ip'] = GetUserIp();
		$logData['add_time'] = time();
		$logData['status_type'] = $statusType; // error log
		$logData['info_type'] = $infoType;

		$ShopPaymentModel->AddLog( $logData );
	}
}

class alipay_service {

	var $gateway = "https://www.alipay.com/cooperate/gateway.do?";         //支付接口
	var $parameter;       //全部需要传递的参数
	var $security_code;   //安全校验码
	var $mysign;          //签名

	//构造支付宝外部服务接口控制
	function alipay_service($parameter,$security_code,$sign_type = "MD5",$transport= "https") {
		$this->parameter      = $this->para_filter($parameter);
		$this->security_code  = $security_code;
		$this->sign_type      = $sign_type;
		$this->mysign         = '';
		$this->transport      = $transport;
		if($parameter['_input_charset'] == "")
		$this->parameter['_input_charset']='GBK';
		if($this->transport == "https") {
			$this->gateway = "https://www.alipay.com/cooperate/gateway.do?";
		} else $this->gateway = "http://www.alipay.com/cooperate/gateway.do?";
		$sort_array  = array();
		$arg         = "";
		$sort_array  = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".$this->charset_encode($val,$this->parameter['_input_charset'])."&";
		}
		$prestr = substr($arg,0,count($arg)-2);  //去掉最后一个问号
		$this->mysign = $this->sign($prestr.$this->security_code);
	}

	function create_url() {
		$url         = $this->gateway;
		$sort_array  = array();
		$arg         = "";
		$sort_array  = $this->arg_sort($this->parameter);
		while (list ($key, $val) = each ($sort_array)) {
			$arg.=$key."=".urlencode($this->charset_encode($val,$this->parameter['_input_charset']))."&";
		}
		$url.= $arg."sign=" .$this->mysign ."&sign_type=".$this->sign_type;
		return $url;
	}

	function arg_sort($array) {
		ksort($array);
		reset($array);
		return $array;
	}

	function sign($prestr) {
		$mysign = "";
		if($this->sign_type == 'MD5') {
			$mysign = md5($prestr);
		}elseif($this->sign_type =='DSA') {
			//DSA 签名方法待后续开发
			die("DSA 签名方法待后续开发，请先使用MD5签名方式");
		}else {
			die("支付宝暂不支持".$this->sign_type."类型的签名方式");
		}
		return $mysign;
	}
	function para_filter($parameter) { //除去数组中的空值和签名模式
		$para = array();
		while (list ($key, $val) = each ($parameter)) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para[$key] = $parameter[$key];
		}
		return $para;
	}
	//实现多种字符编码方式
	function charset_encode($input,$_output_charset ,$_input_charset ="GBK" ) {
		$output = "";
		if(!isset($_output_charset) )$_output_charset  = $this->parameter['_input_charset '];
		if($_input_charset == $_output_charset || $input ==null) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")){
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset change.");
		return $output;
	}
}


class alipay_notify {
	var $gateway;           //支付接口
	var $security_code;  	//安全校验码
	var $partner;           //合作伙伴ID
	var $sign_type;         //加密方式 系统默认
	var $mysign;            //签名     
	var $_input_charset;    //字符编码格式
	var $transport;         //访问模式
	function alipay_notify($partner,$security_code,$sign_type = "MD5",$_input_charset = "GBK",$transport= "https") {
		$this->partner        = $partner;
		$this->security_code  = $security_code;
		$this->sign_type      = $sign_type;
		$this->mysign         = "";
		$this->_input_charset = $_input_charset ;
		$this->transport      = $transport;
		if($this->transport == "https") {
			$this->gateway = "https://www.alipay.com/cooperate/gateway.do?";
		}else $this->gateway = "http://notify.alipay.com/trade/notify_query.do?";
	}
/****************************************对notify_url的认证*********************************/
	function notify_verify() {   
		if($this->transport == "https") {
			$veryfy_url = $this->gateway. "service=notify_verify" ."&partner=" .$this->partner. "&notify_id=".$_POST["notify_id"];
		} else {
			$veryfy_url = $this->gateway. "partner=".$this->partner."&notify_id=".$_POST["notify_id"];
		}
		$veryfy_result = $this->get_verify($veryfy_url);
		$post          = $this->para_filter($_POST);
		$sort_post     = $this->arg_sort($post);
		while (list ($key, $val) = each ($sort_post)) {
			$arg.=$key."=".$val."&";
		}
		$prestr = substr($arg,0,count($arg)-2);  //去掉最后一个&号
		$this->mysign = $this->sign($prestr.$this->security_code);
		//log_result("notify_url_log:sign=".$_POST["sign"]."&mysign=".$this->mysign."&".$this->charset_decode(implode(",",$_POST),$this->_input_charset ));
		if (eregi("true$",$veryfy_result) && $this->mysign == $_POST["sign"])  {
			return true;
		} else return false;
	}
/*******************************************************************************************/

/**********************************对return_url的认证***************************************/	
	function return_verify() {  
		$sort_get= $this->arg_sort($_GET);
		while (list ($key, $val) = each ($sort_get)) {
			if($key != "sign" && $key != "sign_type")
			$arg.=$key."=".$val."&";
		}
		$prestr = substr($arg,0,count($arg)-2);  //去掉最后一个&号
		$this->mysign = $this->sign($prestr.$this->security_code);
		/*while (list ($key, $val) = each ($_GET)) {
		$arg_get.=$key."=".$val."&";
		}*/
		//log_result("return_url_log=".$_GET["sign"]."&".$this->mysign."&".$this->charset_decode(implode(",",$_GET),$this->_input_charset ));
		if ($this->mysign == $_GET["sign"])  return true;
		else return false;
	}
/*******************************************************************************************/

	function get_verify($url,$time_out = "60") {
		$urlarr     = parse_url($url);
		$errno      = "";
		$errstr     = "";
		$transports = "";
		if($urlarr["scheme"] == "https") {
			$transports = "ssl://";
			$urlarr["port"] = "443";
		} else {
			$transports = "tcp://";
			$urlarr["port"] = "80";
		}
		$fp=@fsockopen($transports . $urlarr['host'],$urlarr['port'],$errno,$errstr,$time_out);
		if(!$fp) {
			die("ERROR: $errno - $errstr<br />\n");
		} else {
			fputs($fp, "POST ".$urlarr["path"]." HTTP/1.1\r\n");
			fputs($fp, "Host: ".$urlarr["host"]."\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ".strlen($urlarr["query"])."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $urlarr["query"] . "\r\n\r\n");
			while(!feof($fp)) {
				$info[]=@fgets($fp, 1024);
			}
			fclose($fp);
			$info = implode(",",$info);
			while (list ($key, $val) = each ($_POST)) {
				$arg.=$key."=".$val."&";
			}
			//log_result("notify_url_log=".$url.$this->charset_decode($info,$this->_input_charset));
			//log_result("notify_url_log=".$this->charset_decode($arg,$this->_input_charset));
			return $info;
		}
	}

	function arg_sort($array) {
		ksort($array);
		reset($array);
		return $array;
	}

	function sign($prestr) {
		$sign='';
		if($this->sign_type == 'MD5') {
			$sign = md5($prestr);
		}elseif($this->sign_type =='DSA') {
			//DSA 签名方法待后续开发
			die("DSA 签名方法待后续开发，请先使用MD5签名方式");
		}else {
			die("支付宝暂不支持".$this->sign_type."类型的签名方式");
		}
		return $sign;
	}
/***********************除去数组中的空值和签名模式*****************************/
	function para_filter($parameter) { 
		$para = array();
		while (list ($key, $val) = each ($parameter)) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para[$key] = $parameter[$key];
		}
		return $para;
	}
/********************************************************************************/

/******************************实现多种字符编码方式*****************************/
	function charset_encode($input,$_output_charset ,$_input_charset ="utf-8" ) {
		$output = "";
		if(!isset($_output_charset) )$_output_charset  = $this->parameter['_input_charset '];
		if($_input_charset == $_output_charset || $input ==null ) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")){
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset change.");
		return $output;
	}
/********************************************************************************/

/******************************实现多种字符解码方式******************************/
	function charset_decode($input,$_input_charset ,$_output_charset="utf-8"  ) {
		$output = "";
		if(!isset($_input_charset) )$_input_charset  = $this->_input_charset ;
		if($_input_charset == $_output_charset || $input ==null ) {
			$output = $input;
		} elseif (function_exists("mb_convert_encoding")){
			$output = mb_convert_encoding($input,$_output_charset,$_input_charset);
		} elseif(function_exists("iconv")) {
			$output = iconv($_input_charset,$_output_charset,$input);
		} else die("sorry, you have no libs support for charset changes.");
		return $output;
	}
/*********************************************************************************/
}

?>