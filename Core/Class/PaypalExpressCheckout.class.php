<?php


class PaypalExpressCheckout
{
	function PaypalExpressCheckout()
	{

	}

	function __construct()
	{
		$this->PaypalExpressCheckout();
	}

	function CallExpressCheckout( $paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL )
	{
		$nvpstr="&Amt=". $paymentAmount;
		$nvpstr = $nvpstr . "&PAYMENTACTION=" . $paymentType;
		$nvpstr = $nvpstr . "&ReturnUrl=" . $returnURL;
		$nvpstr = $nvpstr . "&CANCELURL=" . $cancelURL;
		$nvpstr = $nvpstr . "&CURRENCYCODE=" . $currencyCodeType;

		$_SESSION["currencyCodeType"] = $currencyCodeType;	  
		$_SESSION["PaymentType"] = $paymentType;

		$resArray= $this->Call( "SetExpressCheckout", $nvpstr );

		return $resArray;
	}

	function GetShippingDetails( $token )
	{
		$nvpstr = "&TOKEN=" . $token;
		$resArray = $this->Call( "GetExpressCheckoutDetails", $nvpstr );
		return $resArray;
	}

	function Call( $methodName, $nvpStr )
	{
		$cfg = Core::GetConfig( 'paypal_express_checkout' );

		$API_Endpoint		= $cfg['api_url'];
		$API_UserName		= $cfg['api_username'];
		$API_Password		= $cfg['api_password'];
		$API_Signature		= $cfg['api_sign'];
		$sBNCode			= $cfg['bncode'];
		$version			= $cfg['version'];

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $API_Endpoint );
		curl_setopt( $ch, CURLOPT_VERBOSE, 1 );

		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POST, 1 );

		$nvpreq = "METHOD=" . urlencode( $methodName ) . "&VERSION=" . urlencode( $version ) . "&PWD=" . urlencode( $API_Password ) . "&USER=" . urlencode( $API_UserName ) . "&SIGNATURE=" . urlencode( $API_Signature ) . $nvpStr . "&BUTTONSOURCE=" . urlencode( $sBNCode );

		curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq );

		$response = curl_exec( $ch );

		$nvpResArray = $this->FormatNVP( $response );

		@curl_close( $ch );

		return $nvpResArray;
	}

	function FormatNVP( $nvpstr )
	{
		$intial=0;
	 	$nvpArray = array();

		while( strlen( $nvpstr ) )
		{
			$keypos= strpos($nvpstr,'=');
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);

			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);

			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
		}

		return $nvpArray;
	}
}

?>