<?php

class OrderExtra
{
	function OrderExtra()
	{
		
	}

	function GetStatus( $order )
	{
		$orderGlobalStatusList = Core::GetConfig( 'order_global_status' );

		return $orderGlobalStatusList[$order['global_status']]['name'];
	}

	function GetProductSellInfo( $productInfo, $num, $appendPrice, $suitProductIdList )
	{
		$ProductModel = Core::ImportModel( 'Product' );
		$ShopProductSuitModel = Core::ImportModel( 'ShopProductSuit' );
		
		$ProductExtra = Core::ImportExtra( 'Product' );
	
		$productId = $productInfo['id'];
		$productInfo = $ProductExtra->ExplainOne( $productInfo );

		$price = 0;

		// 组合销售
		$suitTotalPrice = 0;
		$suitTotalMarketPrice = 0;
		$suitInfoList = array();
		if ( is_array( $suitProductIdList ) )
		{
			$productList = $ProductModel->GetListById( $suitProductIdList, 0 );

			$suitProductList = $ShopProductSuitModel->GetList( $productId );
			$suitProductList = ArrayIndex( $suitProductList, 'product_id' );

			foreach ( $suitProductIdList as $suitProductId )
			{
				if ( $suitProductList[$suitProductId] && $productList[$suitProductId] )
				{
					$suitTotalPrice += $productList[$suitProductId]['suit_price'];
					$suitTotalMarketPrice += $productList[$suitProductId]['market_price'];
					$suitInfoList[] = array(
						'name' => $productList[$suitProductId]['name'],
						'alias_name' => $suitProductList[$suitProductId]['alias_name'],
						'price' => $productList[$suitProductId]['price'],
						'market_price' => $productList[$suitProductId]['market_price'],
						'suit_price' => $productList[$suitProductId]['suit_price'],
						'product_id' => $suitProductId,
					);
				}
			}
		}

		// 加上属性后的产品价格
		$price = $productInfo['price_s'] + $appendPrice + $suitTotalPrice;
		$marketPrice = $productInfo['market_price_s'] + $appendPrice + $suitTotalMarketPrice;

		// 计算分组计价,取得计算后数据
		// 组合销售不参与分组计价
		if ( !$suitProductIdList )
		{
			$priceGroupInfo = $this->GetProductPriceGroupInfo( $price, $num, $productInfo );

			// 折扣后的价格
			$price = $priceGroupInfo['price'];
		}

		// 是否免运费
		$isFreeShipping = max( intval( $priceGroupInfo['is_free_shipping'] ), intval( $productInfo['is_free_shipping'] ) );

		$info = array();
		$info['price'] = $price;
		$info['is_free_shipping'] = $isFreeShipping;
		$info['suit_info_list'] = $suitInfoList;
		$info['market_price'] = $marketPrice;

		return $info;
	}

	function GetProductPriceGroupInfo( $price, $allNum, $productInfo )
	{
		$priceGroupItem = $this->GetProductPriceGroupItem( $allNum, $productInfo['price_group'] );

		$info = array( 'price' => $price, 'is_free_shipping' => 0 );

		if ( !$priceGroupItem )
			return $info;

		$info['price'] = FormatMoney( $info['price'] * ( $priceGroupItem['discount'] / 100 ) );
		$info['is_free_shipping'] = $priceGroupItem['is_free_shipping'];

		return $info;
	}

	function GetProductPriceGroupItem( $num, $priceGroupId )
	{
		$list = $this->GetProductPriceGroup( $priceGroupId );

		if ( !$list || count( $list ) == 0 )
			return array();

		$pre = array();
		foreach ( $list as $val )
		{
			if ( $val['min_num'] <= $num )
				$pre = $val;
			else
				return $pre;
		}

		return $pre;
	}

	function GetProductPriceGroup( $priceGroupId )
	{
		if ( !$priceGroupId )
			return array();

		if ( $this->priceGroup[$priceGroupId] )
			return $this->priceGroup[$priceGroupId];

		$ShopPriceGroupModel = Core::ImportModel( 'ShopPriceGroup' );

		$list = $ShopPriceGroupModel->GetItemList( $priceGroupId );
		$list ? $this->priceGroup[$priceGroupId] = $list : null;

		return $list;
	}

	function AddWholeOrder( $orderInfo, $productInfoList, $shippingAddressInfo, $billingAddressInfo )
	{
		$OrderModel = Core::ImportModel( 'Order' );

		$time = time();

		$orderInfo['global_status'] = ORDER_GLOBAL_STATUS_DEFAULT;
		$orderInfo['order_status'] = ORDER_STATUS_NORMAL;
		$orderInfo['pay_status'] = PAY_STATUS_NORMAL;
		$orderInfo['pay_check_status'] = PAY_CHECK_STATUS_NORMAL;
		$orderInfo['ship_status'] = SHIP_STATUS_NORMAL;
		$orderInfo['add_time'] = $time;
		$orderInfo['global_status_time'] = $time;
		$orderInfo['order_status_time'] = $time;
		$orderInfo['pay_status_time'] = $time;
		$orderInfo['pay_check_status_time'] = $time;
		$orderInfo['ship_status_time'] = $time;
		$orderInfo['addd_ip'] = GetUserIp();

		$orderInfo['shipping_first_area'] = $shippingAddressInfo['first_area'];
		$orderInfo['shipping_second_area'] = $shippingAddressInfo['second_area'];
		$orderInfo['shipping_third_area'] = $shippingAddressInfo['third_area'];
		$orderInfo['shipping_city'] = $shippingAddressInfo['city'];
		$orderInfo['shipping_address'] = $shippingAddressInfo['address'];
		$orderInfo['shipping_address_line1'] = $shippingAddressInfo['address_line1'];
		$orderInfo['shipping_address_line2'] = $shippingAddressInfo['address_line2'];
		$orderInfo['shipping_first_name'] = $shippingAddressInfo['first_name'];
		$orderInfo['shipping_last_name'] = $shippingAddressInfo['last_name'];
		$orderInfo['shipping_gender'] = $shippingAddressInfo['gender'];
		$orderInfo['shipping_zip_code'] = $shippingAddressInfo['zip_code'];
		$orderInfo['shipping_phone'] = $shippingAddressInfo['phone'];

		$orderInfo['billing_first_area'] = $shippingAddressInfo['first_area'];
		$orderInfo['billing_second_area'] = $shippingAddressInfo['second_area'];
		$orderInfo['billing_third_area'] = $shippingAddressInfo['third_area'];
		$orderInfo['billing_city'] = $shippingAddressInfo['city'];
		$orderInfo['billing_address'] = $shippingAddressInfo['address'];
		$orderInfo['billing_address_line1'] = $shippingAddressInfo['address_line1'];
		$orderInfo['billing_address_line2'] = $shippingAddressInfo['address_line2'];
		$orderInfo['billing_first_name'] = $shippingAddressInfo['first_name'];
		$orderInfo['billing_last_name'] = $shippingAddressInfo['last_name'];
		$orderInfo['billing_gender'] = $shippingAddressInfo['gender'];
		$orderInfo['billing_zip_code'] = $shippingAddressInfo['zip_code'];
		$orderInfo['billing_phone'] = $shippingAddressInfo['phone'];


		// Begin
		$OrderModel->Model->DB->Begin();

		$orderId = $OrderModel->Add( $orderInfo );

		if ( !$orderId )
			Common::Alert( 'Insert data error' );

		foreach ( $productInfoList as $data )
		{
			$data['oid'] = $orderId;

			$lastId = $OrderModel->AddProduct( $data );

			if ( !$lastId )
				Common::Alert( 'Insert data error' );
		}

		// Commint
		$OrderModel->Model->DB->Commit();

		return $orderId;
	}
}

?>