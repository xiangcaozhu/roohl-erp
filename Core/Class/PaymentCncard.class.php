<?php


class PaymentCncard
{
	function PaymentCncard()
	{

	}

	function __construct()
	{
		$this->PaymentCncard();
	}

	function GetCode( $OrderDom )
	{
		$orderInfo = $OrderDom->GetInfo();
		$totalMoney = FormatMoney( $OrderDom->moneySource );

		$config = Core::GetConfig( 'payment_config' );
		$config = $config['cncard'];

		$c_mid			= $config['mid'];			//商户编号，在申请商户成功后即可获得，可以在申请商户成功的邮件中获取该编号
		$c_order			= $orderInfo['sn'];			//商户网站依照订单号规则生成的订单号，不能重复
		$c_name			= "";						//商户订单中的收货人姓名
		$c_address		= "";						//商户订单中的收货人地址
		$c_tel			= "";						//商户订单中的收货人电话
		$c_post			= "";					//商户订单中的收货人邮编
		$c_email			= "";					//商户订单中的收货人Email
		$c_orderamount		= $totalMoney;					//商户订单总金额
		$c_ymd			= date( 'Ymd', $orderInfo['add_time'] );					//商户订单的产生日期，格式为"yyyymmdd"，如20050102
		$c_moneytype		= "0";							//支付币种，0为人民币
		$c_retflag			= "1";							//商户订单支付成功后是否需要返回商户指定的文件，0：不用返回 1：需要返回
		$c_paygate		= "";							//如果在商户网站选择银行则设置该值，具体值可参见《云网支付@网技术接口手册》附录一；如果来云网支付@网选择银行此项为空值。
		$c_returl			= $config['notify_url'];			//如果c_retflag为1时，该地址代表商户接收云网支付结果通知的页面，请提交完整文件名(对应范例文件：GetPayNotify.php)
		$c_memo1			= $orderInfo['sn'];						//商户需要在支付结果通知中转发的商户参数一
		$c_memo2			= $orderInfo['sn'];						//商户需要在支付结果通知中转发的商户参数二
		$c_pass			= $config['pass'];						//支付密钥，请登录商户管理后台，在帐户信息-基本信息-安全信息中的支付密钥项
		$notifytype		= "1";							//0普通通知方式/1服务器通知方式，空值为普通通知方式
		$c_language		= "0";							//对启用了国际卡支付时，可使用该值定义消费者在银行支付时的页面语种，值为：0银行页面显示为中文/1银行页面显示为英文

		$srcStr = $c_mid . $c_order . $c_orderamount . $c_ymd . $c_moneytype . $c_retflag . $c_returl . $c_paygate . $c_memo1 . $c_memo2 . $notifytype . $c_language . $c_pass;
		//说明：如果您想指定支付方式(c_paygate)的值时，需要先让用户选择支付方式，然后再根据用户选择的结果在这里进行MD5加密，也就是说，此时，本页面应该拆分为两个页面，分为两个步骤完成。
		
		//--对订单信息进行MD5加密
		//商户对订单信息进行MD5签名后的字符串
		$c_signstr	= md5($srcStr);

		$code  = '<script type="text/javascript" src="/script/jquery.js"></script>';
		$code .= "<form name='payForm1' action='https://www.cncard.net/purchase/getorder.asp' method='POST'><input type='hidden' name='c_mid' value='{$c_mid}'><input type='hidden' name='c_order' value='{$c_order}'><input type='hidden' name='c_name' value='{$c_name}'><input type='hidden' name='c_address' value='{$c_address}'><input type='hidden' name='c_tel' value='{$c_tel}'><input type='hidden' name='c_post' value='{$c_post}'><input type='hidden' name='c_email' value='{$c_email}'><input type='hidden' name='c_orderamount' value='{$c_orderamount}'><input type='hidden' name='c_ymd' value='{$c_ymd}'><input type='hidden' name='c_moneytype' value='{$c_moneytype}'><input type='hidden' name='c_retflag' value='{$c_retflag}'><input type='hidden' name='c_paygate' value='{$c_paygate}'><input type='hidden' name='c_returl' value='{$c_returl}'><input type='hidden' name='c_memo1' value='{$c_memo1}'><input type='hidden' name='c_memo2' value='{$c_memo2}'><input type='hidden' name='c_language' value='{$c_language}'><input type='hidden' name='notifytype' value='{$notifytype}'><input type='hidden' name='c_signstr' value='{$c_signstr}'></form>";
		$code .= "<script>\$(document).ready(function(){\$('form').submit();});</script>";

		return $code;
	}

	function Respond()
	{
		$config = Core::GetConfig( 'payment_config' );
		$config = $config['cncard'];

		$c_mid			= $_REQUEST['c_mid'];			//商户编号，在申请商户成功后即可获得，可以在申请商户成功的邮件中获取该编号
		$c_order			= $_REQUEST['c_order'];			//商户提供的订单号
		$c_orderamount		= $_REQUEST['c_orderamount'];	//商户提供的订单总金额，以元为单位，小数点后保留两位，如：13.05
		$c_ymd			= $_REQUEST['c_ymd'];			//商户传输过来的订单产生日期，格式为"yyyymmdd"，如20050102
		$c_transnum		= $_REQUEST['c_transnum'];		//云网支付网关提供的该笔订单的交易流水号，供日后查询、核对使用；
		$c_succmark		= $_REQUEST['c_succmark'];		//交易成功标志，Y-成功 N-失败			
		$c_moneytype	= $_REQUEST['c_moneytype'];		//支付币种，0为人民币
		$c_cause		= $_REQUEST['c_cause'];			//如果订单支付失败，则该值代表失败原因		
		$c_memo1		= $_REQUEST['c_memo1'];			//商户提供的需要在支付结果通知中转发的商户参数一
		$c_memo2		= $_REQUEST['c_memo2'];			//商户提供的需要在支付结果通知中转发的商户参数二
		$c_signstr		= $_REQUEST['c_signstr'];		//云网支付网关对已上信息进行MD5加密后的字符串

		//--校验信息完整性---
		if($c_mid=="" || $c_order=="" || $c_orderamount=="" || $c_ymd=="" || $c_moneytype=="" || $c_transnum=="" || $c_succmark=="" || $c_signstr=="")
		{
			$this->DoLog( 2, 7, $orderInfo );
			echo "支付信息有误!";
			return false;
		}

		//--将获得的通知信息拼成字符串，作为准备进行MD5加密的源串，需要注意的是，在拼串时，先后顺序不能改变
		//商户的支付密钥，登录商户管理后台(https://www.cncard.net/admin/)，在管理首页可找到该值
		$c_pass = $config['pass'];
		
		$srcStr = $c_mid . $c_order . $c_orderamount . $c_ymd . $c_transnum . $c_succmark . $c_moneytype . $c_memo1 . $c_memo2 . $c_pass;

		//--对支付通知信息进行MD5加密
		$r_signstr	= md5($srcStr);

		//--校验商户网站对通知信息的MD5加密的结果和云网支付网关提供的MD5加密结果是否一致
		if($r_signstr!=$c_signstr){
			$this->DoLog( 2, 7, $orderInfo );
			echo "签名验证失败";
			return false;
		}

		$MerchantID=$config['mid'];	//商户自己的编号
		if($MerchantID!=$c_mid){
			$this->DoLog( 2, 3, $orderInfo );
			
			echo "提交的商户编号有误";
			return false;
		}

		Core::LoadDom( 'Order' );

		$orderId = OrderDom::GetId( $c_order );

		$OrderModel = Core::ImportModel( 'Order' );
		$orderInfo = $OrderModel->Get( $orderId );

		$OrderDom = new OrderDom( $orderInfo );

		if ( !$orderInfo )
		{
			$this->DoLog( 2, 1, $orderInfo );
			return false;
		}

		if ( FormatMoney( $OrderDom->moneySource ) != $c_orderamount )
		{
			$this->DoLog( 2, 4, $orderInfo );
			return false;
		}

		if($c_succmark="Y")
		{
			//根据商户自己商务规则，进行发货等系列操作

			$OrderDom->SetPayment();
			$this->DoLog( 1, 8, $orderInfo );

			echo "<result>1</result><reURL>" . $config['return_url'] . "</reURL>";
			return true;
		}
		else
		{
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

?>