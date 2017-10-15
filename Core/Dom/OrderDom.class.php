<?php

class OrderDom
{
	var $id = 0;
	var $productList = array();

	function OrderDom( $info = array() )
	{
		if ( is_numeric( $info ) )
		{
			$this->id = $info;
			$this->Init();
		}
		else
		{
			$this->Init( $info );
		}
	}

	function Init( $array = array() )
	{
		$OrderModel = Core::ImportModel( 'Order' );

		if ( is_array( $array ) && $array )
		{
			$this->id = $array['id'];

			foreach ( $array as $key => $val )
			{
				$this->info[$key] = $val;
			}

			// 货币
			$currency = Common::GetCurrency();

			$this->moneySource		= FormatMoney( $array['product_money'] + $array['ship_money'] + $array['ship_insurance'] );
			$this->money			= FormatMoney( $this->moneySource * $currency['scale'] );

			$this->productMoney			= FormatMoney( $array['product_money'] * $currency['scale'] );
			$this->shipMoney			= FormatMoney( $array['ship_money'] * $currency['scale'] );
			$this->shipInsuranceMoney		= FormatMoney( $array['ship_insurance'] * $currency['scale'] );

			$this->sn = $this->GetSn( $array );
		}
		elseif ( $this->id )
		{
			$orderInfo = $OrderModel->Get( $this->id );

			$orderInfo ? $this->Init( $orderInfo ) : null;
		}

		return true;
	}

	function GetUserInfo()
	{
		$UserModel = Core::ImportModel( 'User' );

		return $UserModel->GetUserInfo( $this->info['add_user_id'] );
	}

	function WaitPayFor()
	{
		if ( $this->info['pay_type'] == 1 )
		{
			if ( $this->info['pay_status'] == PAY_STATUS_NORMAL )
				return true;
		}

		return false;
	}

	function GetStatus()
	{
		$OrderExtra = Core::ImportExtra( 'Order' );
		
		return $OrderExtra->GetStatus( $this->info );
	}

	function GetId( $sn = '' )
	{
		if ( $sn )
			return intval( substr( $sn, 6 ) );
		else
			return $this->id;
	}

	function GetSn( $info )
	{
		return DateFormat( $info['add_time'], 'ymd' ) . sprintf( '%08d', $info['id'] );
	}

	function GetInfo()
	{
		$orderInfo = $this->info;

		$orderInfo['sn'] = $this->sn;
		$orderInfo['total_money'] = $this->moneySource;
		$orderInfo['wait_payfor'] = $this->WaitPayFor();

		return $orderInfo;
	}

	function InitProduct()
	{
		$OrderModel = Core::ImportModel( 'Order' );

		// 货币
		$currency = Common::GetCurrency();

		// 订单产品
		$productList = $OrderModel->GetProductList( $this->id );

		$BuyAttributeExtra = Core::ImportExtra( 'BuyAttribute' );

		$allProductMoney = 0;
		$allProductMarketMoney = 0;
		foreach ( $productList as $key => $val )
		{
			// 产品价格 (已经加上了属性附加价格)
			$productList[$key]['product_price_s'] = FormatMoney( $val['product_price'] );
			$productList[$key]['product_price'] = FormatMoney( $val['product_price'] * $currency['scale'] );
			$allProductMoney = $productList[$key]['product_price'];

			// 市场价
			$productList[$key]['product_market_price_s'] = FormatMoney( $val['product_market_price'] + $val['append_price'] );
			$productList[$key]['product_market_price'] = FormatMoney( ( $val['product_market_price'] + $val['append_price'] ) * $currency['scale'] );
			$allProductMarketMoney = $productList[$key]['product_market_price'];

			// 属性显示
			$productList[$key]['attribute_detail'] = $BuyAttributeExtra->Parse( $val['attribute'] );
			$productList[$key]['suit_info_list'] = unserialize( $val['suit_info'] );

			// link
			$seoUri = preg_replace( '/[^0-9a-zA-Z]+/is', '-', htmlspecialchars_decode( $val['product_name'] ) ) . '_';
			$productList[$key]['seo_uri'] = $seoUri;
			$productList[$key]['detail_link'] = "/product/detail-{$val['pid']}.html";
			$productList[$key]['detail_link_seo'] = "/product/{$seoUri}detail-{$val['pid']}.html";
		}

		$this->productList = $productList;

		$this->saveMoney = FormatMoney($allProductMarketMoney - $allProductMoney );
	}

	function Update( $data )
	{
		$OrderModel = Core::ImportModel( 'Order' );
		$OrderModel->Update( $this->id, $data );
	}

	function SetPayment()
	{
		Core::LoadConfig( 'orderControl' );

		$OrderControlFlow = array();
		$OrderControlFlow = Core::GetConfig( 'order_control_flow' );
		
		$data = array();
		$data = $OrderControlFlow['order.allow.pay.confirm']['data'];
		$data['global_status'] = 2;
		$data['global_status_time'] = time();

		$this->Update( $data );
	}
}

?>