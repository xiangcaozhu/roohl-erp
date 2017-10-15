<?php

class CartDom
{
	var $totalMoney = 0.00;
	var $totalMoneySource = 0.00;
	var $totalMarketMoney = 0.00;
	var $list = array();
	var $cart = array();
	var $total = 0;
	var $quantity = 0;

	var $priceGroup = array();
	var $appendShippingMoneyProduct = array();

	function CartDom( $cart = array() )
	{
		global $Session;

		if ( !$cart )
			$cart = $Session->Get( 'cart' );

		$this->Init( $cart );
	}

	function Init( $array )
	{
		if ( !$array )
			return false;

		foreach ( $array as $key => $val )
		{
			$this->cart[$key] = $val;
		}
	}

	function Del( $productId, $indexHash )
	{
		global $Session;

		if ( $this->cart['item'][$productId][$indexHash] )
		{
			unset( $this->cart['item'][$productId][$indexHash] );
		}

		$this->Stat();

		$Session->Set( 'cart', $this->cart );
		$Session->Update();

		return true;
	}

	function Update( $productId, $indexHash, $num )
	{
		global $Session;

		if ( !$this->cart['item'][$productId][$indexHash] )
			return false;

		if ( $num <= 0 )
			return false;

		$this->cart['item'][$productId][$indexHash]['num'] = $num;

		$this->Stat();

		$Session->Set( 'cart', $this->cart );
		$Session->Update();

		return true;
	}

	function Add( $productId, $attribute, $num, $appendPrice, $suitProductIdList )
	{
		global $Session;

		$attribute = serialize( $attribute );
		$indexHash = md5( $attribute . serialize( $suitProductIdList ) );

		if ( $this->cart['item'][$productId][$indexHash] )
		{
			$this->cart['item'][$productId][$indexHash]['num'] += $num;
		}
		else
		{
			$this->cart['item'][$productId][$indexHash] = array();
			$this->cart['item'][$productId][$indexHash]['num'] = $num;
			$this->cart['item'][$productId][$indexHash]['attribute'] = $attribute;
			$this->cart['item'][$productId][$indexHash]['append_price'] = $appendPrice;
			$this->cart['item'][$productId][$indexHash]['suit_product'] = $suitProductIdList;
		}

		$this->Stat();

		$Session->Set( 'cart', $this->cart );
		$Session->Update();

		return true;
	}

	function GetProductNum( $productId, $noSuit = false )
	{
		$num = 0;

		if ( is_array( $this->cart['item'][$productId] ) )
		{
			foreach ( $this->cart['item'][$productId] as $val )
			{
				if ( !$noSuit )
				{
					$num += $val['num'];
				}
				else
				{
					if ( !$val['suit_product'] )
						$num += $val['num'];
				}
			}
		}

		return $num;
	}

	function Stat()
	{
		if ( !$this->cart['item'] )
			return false;

		// 货币
		$currency = Common::GetCurrency();

		// Extra
		$ProductExtra = Core::ImportExtra( 'Product' );
		$OrderExtra = Core::ImportExtra( 'Order' );
		$BuyAttributeExtra = Core::ImportExtra( 'BuyAttribute' );

		// Model
		$ProductModel = Core::ImportModel( 'Product' );
		$ShopProductSuitModel = Core::ImportModel( 'ShopProductSuit' );

		// Collect product info
		$productIdList = array();
		$productIdList = @array_keys( $this->cart['item'] );
		$productList = $ProductModel->GetListById( $productIdList, 0 );

		$cartList = array();
		$allMoney = 0;
		$allMoneySource = 0;
		$allMarketMoney = 0;
		$allMarketMoneySource = 0;
		$allWeight = 0;
		$allShippingWeight = 0;
		$allPoint = 0;
		$total = 0;
		$quantity = 0;

		foreach ( $this->cart['item'] as $productId => $val )
		{
			foreach ( $val as $indexHash => $info )
			{
				$productInfo = $productList[$productId];

				if ( !$productInfo )
					continue;

				$productSellInfo = $OrderExtra->GetProductSellInfo( $productInfo, $this->GetProductNum( $productId, true ), $info['append_price'], $info['suit_product'] );

				$productInfo = $ProductExtra->ExplainOne( $productInfo );

				// 经过属性,组合销售,价格分组计算后的总价格
				$price = $productSellInfo['price'];
				$money = $price * $info['num'];
				$marketPrice = $productSellInfo['market_price'];
				$marketMoney = $marketPrice * $info['num'];

				// 是否免运费
				$isFreeShipping = $productSellInfo['is_free_shipping'];

				// 组合销售数据
				$suitInfoList = $productSellInfo['suit_info_list'];

				$cartList[$productId . '_' . $indexHash] = array(
					'product'					=> $productInfo,
					'num'						=> $info['num'],
					'attribute'					=> $info['attribute'],
					'attribute_detail'				=> $BuyAttributeExtra->Parse( $info['attribute'] ),
					'index_hash'				=> $indexHash,
					'append_price'				=> FormatMoney( $info['append_price'] * $currency['scale'] ),
					'append_price_s'			=> FormatMoney( $info['append_price'] ),
					'price'					=> FormatMoney( $price * $currency['scale'] ),
					'price_s'					=> FormatMoney( $price ),
					'money'					=> FormatMoney( $money * $currency['scale'] ),
					'money_s'					=> $money,
					'is_free_shipping'			=> $isFreeShipping,
					'suit_info_list'				=> $suitInfoList,
				);

				$allMoney += FormatMoney( $money * $currency['scale'] );
				$allMoneySource += $money;
				$allMarketMoney += FormatMoney( $marketMoney * $currency['scale'] );
				$allMarketMoneySource += $marketMoney;
				$allWeight += $productInfo['weight'] * $info['num'];
				$allShippingWeight += !$isFreeShipping ? $productInfo['weight'] * $info['num'] : 0;
				$total++;
				$quantity += $info['num'];
			}
		}

		$this->list = $cartList;
		$this->totalMoney = FormatMoney( $allMoney );
		$this->totalMoneySource = FormatMoney( $allMoneySource );
		$this->totalMarketMoney = FormatMoney( $allMarketMoney );
		$this->totalMarketMoneySource = FormatMoney( $allMarketMoneySource );
		$this->totalWeight = $allWeight;
		$this->totalShippingWeight = $allShippingWeight;
		$this->total = $total;
		$this->quantity = $quantity;

		$this->cart['total'] = $total;
		$this->cart['total_weight'] = $allWeight;
		$this->cart['total_money'] = FormatMoney( $allMoney );
		$this->cart['total_market_money'] = FormatMoney( $allMarketMoney );
	}

	function GetStatInfo( $productId, $attribute )
	{
		return $this->list[$productId . '_' . $attribute];
	}

	function Clean()
	{
		global $Session;

		$this->cart = array();
		$this->Stat();

		$Session->Set( 'cart', array() );
		$Session->Update();
	}
}

?>