<?php

class CenterPurchaseExtra
{
	function CenterPurchaseExtra()
	{
		
	}

	function Explain( $list )
	{
		foreach ( $list as $key => $val )
		{
			$list[$key] = $this->ExplainOne( $val );
		}

		return $list;
	}

	function ExplainOne( $info )
	{
		return $info;
	}

	function ExplainProduct( $list )
	{
		foreach ( $list as $key => $val )
		{
			$list[$key] = $this->ExplainProductOne( $val );
		}

		return $list;
	}

	function ExplainProductOne( $info )
	{
		Core::LoadDom( 'CenterSku' );
		$CenterSkuDom = new CenterSkuDom( $info['sku'] );
		$skuInfo = $CenterSkuDom->InitProduct();

		$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
		
		$info['sku_info'] = $skuInfo;
		$info['relation_list'] = $CenterPurchaseModel->GetRelationListByPurchaseProduct_1( $info['id'] );
		$info['money'] = FormatMoney( $info['quantity'] * $info['price'] );

		if ( $info['relation_list'] )
		{
			foreach ( $info['relation_list'] as $key => $val )
			{
				$inf = $CenterOrderModel->GetProduct( $val['order_product_id'] );
				$info['relation_list'][$key]['payout_rate'] = $inf['payout_rate'];
				$info['relation_list'][$key]['price'] = $inf['price'];

                $orderInfo = $CenterOrderModel->Get($val['order_id'] );
				$channelInfo = $CenterChannelModel->Get($orderInfo['channel_id']);
				$info['relation_list'][$key]['channel_name'] = $channelInfo['print_name'];
				
				
				
				$info['relation_list'][$key]['my_name'] = $orderInfo['order_shipping_name'];
				if(($orderInfo['order_shipping_phone']) && ($orderInfo['order_shipping_mobile']))
				$lines = " / ";
				else
				$lines = "";
				
				$info['relation_list'][$key]['my_phone'] = $orderInfo['order_shipping_phone'].$lines.$orderInfo['order_shipping_mobile'];
				$info['relation_list'][$key]['my_add'] = $orderInfo['order_shipping_address'];
				$info['relation_list'][$key]['my_zip'] = $orderInfo['order_shipping_zip'];
			}
		}

		return $info;
	}

	function AllotOrderProduct( $skuId, $num )
	{
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		$orderProductList = $CenterOrderModel->GetNeedProductList( $skuId );

		foreach ( $orderProductList as $key => $val )
		{
			$needNum = $val['quantity'] - $val['purchase_quantity'];

			if ( $num <= 0 )
				break;
			if ( $needNum <= 0 )
				break;

			if ( $needNum <= $num )
				$appendNum = $needNum;
			elseif ( $needNum > $num )
				$appendNum = $num;

			$num = $num - $appendNum;

			$orderProductList[$key]['_num'] = $appendNum;
		}

		return $orderProductList;
	}

	function AllotOrderProduct0717( $skuId, $num,$orderIDS )
	{
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		$orderProductList = $CenterOrderModel->GetNeedProductList0717( $skuId,0,0,$orderIDS );

		foreach ( $orderProductList as $key => $val )
		{
			$needNum = $val['quantity'] - $val['purchase_quantity'];

			if ( $num <= 0 )
				break;
			if ( $needNum <= 0 )
				break;

			if ( $needNum <= $num )
				$appendNum = $needNum;
			elseif ( $needNum > $num )
				$appendNum = $num;

			$num = $num - $appendNum;

			$orderProductList[$key]['_num'] = $appendNum;
		}

		return $orderProductList;
	}



	function AllotOrderProductSupplier( $skuId, $num, $supplierId )
	{
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		$orderProductList = $CenterOrderModel->GetSupplierNeedProductList( $skuId, $supplierId );

		foreach ( $orderProductList as $key => $val )
		{
			$needNum = $val['quantity'] - $val['purchase_quantity'];

			if ( $num <= 0 )
				break;
			if ( $needNum <= 0 )
				break;

			if ( $needNum <= $num )
				$appendNum = $needNum;
			elseif ( $needNum > $num )
				$appendNum = $num;

			$num = $num - $appendNum;

			$orderProductList[$key]['_num'] = $appendNum;
		}

		return $orderProductList;
	}
















	function ExplainProduct_1( $list )
	{
		foreach ( $list as $key => $val )
		{
			$list[$key] = $this->ExplainProductOne_1( $val );
		}

		return $list;
	}

	function ExplainProductOne_1( $info )
	{
		Core::LoadDom( 'CenterSku' );
		$CenterSkuDom = new CenterSkuDom( $info['sku'] );
		$skuInfo = $CenterSkuDom->InitProduct();

		$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
		
		$info['sku_info'] = $skuInfo;
		$info['relation_list'] = $CenterPurchaseModel->GetRelationListByPurchaseProduct_9( $info['id'] );
		$info['money'] = FormatMoney( $info['quantity'] * $info['price'] );

		/*
		if ( $info['relation_list'] )
		{
			foreach ( $info['relation_list'] as $key => $val )
			{
				$inf = $CenterOrderModel->GetProduct( $val['order_product_id'] );
				$info['relation_list'][$key]['payout_rate'] = $inf['payout_rate'];
				$info['relation_list'][$key]['price'] = $inf['price'];

                $orderInfo = $CenterOrderModel->Get($val['order_id'] );
				$channelInfo = $CenterChannelModel->Get($orderInfo['channel_id']);
				$info['relation_list'][$key]['channel_name'] = $channelInfo['print_name'];
				
				
				
				$info['relation_list'][$key]['my_name'] = $orderInfo['order_shipping_name'];
				if(($orderInfo['order_shipping_phone']) && ($orderInfo['order_shipping_mobile']))
				$lines = " / ";
				else
				$lines = "";
				
				$info['relation_list'][$key]['my_phone'] = $orderInfo['order_shipping_phone'].$lines.$orderInfo['order_shipping_mobile'];
				$info['relation_list'][$key]['my_add'] = $orderInfo['order_shipping_address'];
				$info['relation_list'][$key]['my_zip'] = $orderInfo['order_shipping_zip'];
			}
		}
		*/

		return $info;
	}
}

?>