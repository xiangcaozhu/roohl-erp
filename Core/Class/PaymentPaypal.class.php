<?php


class PaymentPaypal
{
	function PaymentPaypal()
	{

	}

	function __construct()
	{
		$this->PaymentPaypal();
	}

	function GetCode( $orderInfo )
	{
		/******** Order Dom ********/
		Core::LoadDom( 'Order' );
		$OrderDom = new OrderDom();
		$OrderDom->Init( $orderInfo );
		$orderInfo = $OrderDom->GetInfo();

		// 货币
		$currency = Common::GetCurrency();

		$totalMoney = FormatMoney( $OrderDom->moneySource * $currency['scale'] );
		
		$config = Core::GetConfig( 'payment_config' );
		$config = $config['paypal'];

		$data_order_id = $orderInfo['sn'];
		$data_amount = $totalMoney;
		$data_return_url = $config['return_url'];
		$data_pay_account = $config['business_account'];
		$currency_code = $currency['currency_code'];
		$data_notify_url = $config['notify_url'];
		$cancel_return = $config['cancel_url'];

		$def_url  = '<br /><form style="text-align:center;" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank" id="paypal_form">' .   // 不能省略
		"<input type='hidden' name='cmd' value='_xclick'>" .                             // 不能省略
		"<input type='hidden' name='business' value='$data_pay_account'>" .                 // 贝宝帐号
		"<input type='hidden' name='item_name' value='wlivecn_order_{$data_order_id}'>" .                 // payment for
		"<input type='hidden' name='amount' value='$data_amount'>" .                        // 订单金额
		"<input type='hidden' name='currency_code' value='$currency_code'>" .            // 货币
		"<input type='hidden' name='return' value='$data_return_url'>" .                    // 付款后页面
		"<input type='hidden' name='invoice' value='$data_order_id'>" .                      // 订单号
		"<input type='hidden' name='charset' value='utf-8'>" .                              // 字符集
		"<input type='hidden' name='no_shipping' value='1'>" .                              // 不要求客户提供收货地址
		"<input type='hidden' name='no_note' value=''>" .                                  // 付款说明
		"<input type='hidden' name='notify_url' value='$data_notify_url'>" .
		"<input type='hidden' name='rm' value='2'>" .
		"<input type='hidden' name='cancel_return' value='$cancel_return'>" .
		"<!--<input type='image' value='http://www.paypal.com/zh_XC/i/btn/x-click-but01.gif'>-->" .                      // 按钮
		"</form><br />";

		$OrderDom->Update( array( 
			'currency_code' => $currency['code'],
			'currency_scale' => $currency['scale'],
		) );

		return $def_url;
	}

	function Respond()
	{
		Core::LoadDom( 'Order' );
		$OrderModel = Core::ImportModel( 'Order' );
		$ShopPaymentModel = Core::ImportModel( 'ShopPayment' );
		
		$config = Core::GetConfig( 'payment_config' );
		$config = $config['paypal'];
		
		$req = 'cmd=_notify-validate';

		foreach ( $_POST as $key => $value )
		{
			$value = urlencode( stripslashes( $value ) );
			$req .= "&$key=$value";
		}

		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen( $req ) ."\r\n\r\n";
		$fp = fsockopen ( 'www.paypal.com', 80, $errno, $errstr, 30 );

		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number'];
		$payment_status = $_POST['payment_status'];
		$payment_amount = $_POST['mc_gross'];
		$payment_currency = $_POST['mc_currency'];
		$receiver_email = $_POST['receiver_email'];
		$payer_email = $_POST['payer_email'];
		$orderId = OrderDom::GetId( $_POST['invoice'] );

		$logData = array();
		$logData['payment_type'] = 'paypal'; // paypal
		$logData['log_type'] = 2; // response log
		$logData['add_time'] = time();
		$logData['order_info'] = serialize( $orderInfo );
		$logData['request_info'] = serialize( $_POST );
		$logData['request_ip'] = GetUserIp();
		$logData['add_time'] = time();
		$logData['status_type'] = 2; // error log
		$logData['info_type'] = 0; // error type

		if ( !$orderId )
		{
			$logData['info_type'] = 1;
			$ShopPaymentModel->AddLog( $logData );

			return false;
		}

		$orderInfo = $OrderModel->Get( $orderId );

		if ( !$orderInfo )
		{
			$logData['info_type'] = 1;
			$ShopPaymentModel->AddLog( $logData );

			return false;
		}

		$OrderDom = new OrderDom( $orderInfo );
		$orderInfo = $OrderDom->GetInfo();


		if ( !$fp )
		{
			fclose( $fp );
			return false;
		}
		else
		{
			fputs( $fp, $header . $req );
			while ( !feof( $fp ) )
			{
				$res = fgets( $fp, 1024 );
				if ( strcmp( $res, 'VERIFIED' ) == 0 )
				{
					if ( $payment_status != 'Completed' && $payment_status != 'Pending' )
					{
						fclose( $fp );

						$logData['info_type'] = 2;
						$ShopPaymentModel->AddLog( $logData );

						return false;
					}

					if ( $receiver_email != $config['business_account'] )
					{
						fclose( $fp );

						$logData['info_type'] = 3;
						$ShopPaymentModel->AddLog( $logData );

						return false;
					}

					if ( FormatMoney( $OrderDom->moneySource * $orderInfo['currency_scale'] ) != $payment_amount )
					{
						fclose( $fp );

						$logData['info_type'] = 4;
						$ShopPaymentModel->AddLog( $logData );

						return false;
					}

					if ( $payment_currency != $orderInfo['currency_code'] )
					{
						fclose( $fp );

						$logData['info_type'] = 5;
						$ShopPaymentModel->AddLog( $logData );

						return false;
					}

					if ( $orderInfo['pay_status'] != PAY_STATUS_NORMAL )
					{
						$logData['info_type'] = 6;
						$ShopPaymentModel->AddLog( $logData );

						return false;
					}

					$data = array();
					$data['pay_status'] = PAY_STATUS_PAID;
					$data['pay_status_time'] = time();
					$data['global_status'] = 2;
					$data['global_status_time'] = time();
					$data['pay_data'] = serialize( $_POST );

					$OrderModel->Update( $orderId, $data );

					fclose($fp);

					$logData['status_type'] = 1; //success log
					$logData['info_type'] = 8;
					$ShopPaymentModel->AddLog( $logData );

					/******** Send Mail ********/
					$ShopCurrencyModel = Core::ImportModel( 'ShopCurrency' );
					$currencyInfo = $ShopCurrencyModel->Get( $orderInfo['currency_code'] );

					$mailContent = Common::PageCode(
						'mail/order_payment.html',
						array(
							'payer_account' => $payer_email,
							'money' => $payment_amount,
							'currency_symbol' => $currencyInfo['symbol'],
							'order' => $orderInfo,
							'product_list' => $OrderDom->productList,
						)
					);

					$userInfo = $OrderDom->GetUserInfo();

					Common::MailTo( $userInfo['user_email'], "Thanks for Your payment for Order#{$orderInfo['sn']} with Wlivecn.com", $mailContent );

					return true;
				}
				elseif (strcmp($res, 'INVALID') == 0)
				{
					fclose($fp);

					$logData['info_type'] = 7;
					$ShopPaymentModel->AddLog( $logData );

					return false;
				}
			}
		}
	}
}

?>