<?php

class CenterWarehousePlaceDom
{
	var $id = 0;

	function CenterWarehousePlaceDom( $info )
	{
		if ( is_array( $info ) )
		{
			$this->Init( $info );
		}
		else
		{
			$this->id = $info;
			$this->Init();
		}
	}

	function Init( $array = array() )
	{
		if ( is_array( $array ) && $array )
		{
			$this->id = $array['id'];

			foreach ( $array as $key => $val )
			{
				$this->info[$key] = $val;
			}
		}
		elseif ( $this->id )
		{
			$CenterWarehousePlaceModel = Core::ImportModel( 'CenterWarehousePlace' );
			$info = $CenterWarehousePlaceModel->Get( $this->id );

			$info ? $this->Init( $info ) : null;
		}

		return true;
	}

	function AddLog( $info )
	{
		$CenterWarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );
		
		global $__UserAuth;
		
		$data = $info;
		$data['warehouse_id'] = $this->info['warehouse_id'];
		$data['place_id'] = $this->id;
		$data['add_time'] = time();
		$data['user_id'] = $__UserAuth['user_id'];
		$data['user_name'] = $__UserAuth['user_name'];

		$CenterWarehouseLogModel->Add( $data );
	}

	function Store( $sku, $num, $price )
	{
		if ( !$num )
			return false;

		$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

		Core::LoadDom( 'CenterSku' );
		$SkuDom = new CenterSkuDom( $sku );

		$skuId = $SkuDom->id;
		$productId = $SkuDom->GetProductId();

		$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

		$stockInfo = $CenterWarehouseStockModel->GetUnique( $this->info['warehouse_id'], $this->id, $skuId );

		if ( $stockInfo )
		{
			$price = ( $stockInfo['quantity'] * $stockInfo['price'] + $num * $price ) / ( $stockInfo['quantity'] + $num );
			
			$CenterWarehouseStockModel->UpdateUnique(
				$this->info['warehouse_id'],
				$this->id,
				$skuId,
				array( 'price' => $price ),
				"quantity = quantity + {$num}"
			);
		}
		else
		{
			$data = array();
			$data['sku'] = $sku;
			$data['sku_id'] = $skuId;
			$data['product_id'] = $productId;
			$data['quantity'] = $num;
			$data['lock_quantity'] = 0;
			$data['place_id'] = $this->id;
			$data['no_delivery'] = $this->info['no_delivery'];
			$data['price'] = $price;
			$data['warehouse_id'] = $this->info['warehouse_id'];

			$CenterWarehouseStockModel->Add( $data );
		}

		return true;
	}

	function LockForPurchaseRelation( $purchaseProductId )
	{
		if ( $this->info['no_delivery'] )
			return false;
		
		$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

		$list = $CenterPurchaseModel->GetRelationListByPurchaseProduct( $purchaseProductId );

		foreach ( $list as $key => $val )
		{
			$maxLockNum = $val['quantity'] - $val['lock_quantity'];
			$lockNum = $this->LockForOrder( $val['order_product_id'], $maxLockNum );

			if ( $lockNum > 0 )
			{
				$CenterPurchaseModel->UpdateRelation( $val['id'], false, "lock_quantity = lock_quantity + {$lockNum}" );
			}
		}

		return false;
	}

	function LockFlow( $skuId, $orderProductId = false )
	{
		if ( $this->info['no_delivery'] )
			return false;
		
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

		$stockInfo = $CenterWarehouseStockModel->GetUnique( $this->info['warehouse_id'], $this->id, $skuId );

		if ( !$stockInfo )
			return false;

		$liveQuantity = $stockInfo['quantity'] - $stockInfo['lock_quantity'];

		if ( $liveQuantity <= 0 )
			return false;

		while ( $liveQuantity > 0 )
		{
			$orderProductInfo = $CenterOrderModel->GetProductFlowBySkuId( $skuId, $orderProductId );

			if ( !$orderProductInfo )
				break;

			$lockNum = $this->LockForOrder( $orderProductInfo['id'] );

			if ( $lockNum == 0 )
				break;

			$liveQuantity = $liveQuantity - $lockNum;
		}
	}

	function LockForOrder( $orderProductId, $maxLockNum = 0 )
	{
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
		$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

		$orderProductInfo = $CenterOrderModel->GetProduct( $orderProductId );

		if ( !$orderProductInfo )
			return 0;

		Core::LoadDom( 'CenterOrder' );
		$OrderDom = new CenterOrderDom( array( 'id' => $orderProductInfo['order_id'] ) );

		$waitQuantity = $orderProductInfo['quantity'] - $orderProductInfo['lock_quantity'];

		// 尚未绑定数
		if ( $waitQuantity <= 0 )
			return 0;

		$skuId = $orderProductInfo['sku_id'];

		$stockInfo = $CenterWarehouseStockModel->GetUnique( $this->info['warehouse_id'], $this->id, $skuId );

		if ( !$stockInfo )
			return 0;

		$liveQuantity = $stockInfo['quantity'] - $stockInfo['lock_quantity'];

		if ( $liveQuantity <= 0 )
			return 0;

		if ( $liveQuantity < $waitQuantity )
			$lockNum = $liveQuantity;
		else
			$lockNum = $waitQuantity;

		if ( $lockNum <= 0 )
			return 0;

		// 为按需采购设定的数量卡
		if ( $maxLockNum > 0 && $lockNum > $maxLockNum )
			$lockNum = $maxLockNum;

		$lockInfo = $CenterWarehouseLockModel->GetUnique( $this->info['warehouse_id'], $this->id, $skuId, $orderProductId );

		if ( $lockInfo )
		{
			$CenterWarehouseLockModel->Update( $lockInfo['id'], false, "quantity = quantity + {$lockNum}" );
		}
		else
		{
			$data = array();
			$data['quantity'] = $lockNum;
			$data['place_id'] = $this->id;
			$data['warehouse_id'] = $this->info['warehouse_id'];
			$data['sku'] = $orderProductInfo['sku'];
			$data['sku_id'] = $orderProductInfo['sku_id'];
			$data['order_id'] = $orderProductInfo['order_id'];
			$data['product_id'] = $orderProductInfo['product_id'];
			$data['order_product_id'] = $orderProductInfo['id'];
			$data['type'] = 1;
			$data['add_time'] = time();

			$CenterWarehouseLockModel->Add( $data );
		}

		$CenterOrderModel->UpdateProduct( $orderProductId, false, "lock_quantity = lock_quantity + {$lockNum}" );
		$CenterWarehouseStockModel->UpdateUnique( $this->info['warehouse_id'], $this->id, $skuId, false, "lock_quantity = lock_quantity + {$lockNum}" );

		// 更新配货状态
		$OrderDom->UpdateStatus();

		return $lockNum;
	}

	function DeliverLock( $lockId, $stockInfo = array() )
	{
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
		$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

		$lockInfo = $CenterWarehouseLockModel->Get( $lockId );

		if ( !$lockInfo )
			return false;

		$num = $lockInfo['quantity'];

		if ( $num <= 0 )
			return false;

		if ( $lockInfo['order_product_id'] )
		{
			$CenterOrderModel->UpdateProduct( 
				$lockInfo['order_product_id'], 
				array( 'stock_price' => $stockInfo['price'] ),
				"delivery_quantity = delivery_quantity + {$num}"
			);
		}

		$CenterWarehouseStockModel->UpdateUnique(
			$this->info['warehouse_id'],
			$this->id,
			$lockInfo['sku_id'],
			false,
			"quantity = quantity - {$num}, lock_quantity = lock_quantity - {$num}"
		);

		if ( $lockInfo['order_id'] )
		{
			Core::LoadDom( 'CenterOrder' );
			$OrderDom = new CenterOrderDom( array( 'id' => $lockInfo['order_id'] ) );

			// 更新订单状态
			$OrderDom->UpdateStatus();
		}

		$CenterWarehouseLockModel->Del( $lockId );

		return true;
	}

	function DeliverLockCheck( $lockId )
	{
		$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
		$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

		$lockInfo = $CenterWarehouseLockModel->Get( $lockId );

		if ( !$lockInfo )
			return false;

		$num = $lockInfo['quantity'];

		$stockInfo = $CenterWarehouseStockModel->GetUnique(
			$this->info['warehouse_id'],
			$this->id,
			$lockInfo['sku_id']
		);

		if ( $stockInfo['quantity'] < $num )
			return false;

		return $stockInfo;
	}

	function Deliver( $skuId,$num )
	{
		$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

		$CenterWarehouseStockModel->UpdateUnique(
			$this->info['warehouse_id'],
			$this->id,
			$skuId,
			false,
			"quantity = quantity - {$num}"
		);

		return true;
	}

	function DeliverCheck( $skuId, $num )
	{
		$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

		$stockInfo = $CenterWarehouseStockModel->GetUnique(
			$this->info['warehouse_id'],
			$this->id,
			$skuId
		);

		if ( !$stockInfo )
			return false;

		if ( ( $stockInfo['quantity'] - $stockInfo['lock_quantity'] ) < $num )
			return false;

		return $stockInfo;
	}

	function UnLock( $lockId )
	{
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );
		$CenterWarehouseStockModel = Core::ImportModel( 'CenterWarehouseStock' );

		$lockInfo = $CenterWarehouseLockModel->Get( $lockId );

		if ( !$lockInfo )
			return false;

		$num = $lockInfo['quantity'];

		if ( $num <= 0 )
			return false;

		$CenterWarehouseLockModel->Del( $lockId );

		if ( $lockInfo['order_product_id'] )
		{
			$CenterOrderModel->UpdateProduct( $lockInfo['order_product_id'], false, "lock_quantity = lock_quantity - {$num}" );
		}

		$CenterWarehouseStockModel->UpdateUnique(
			$this->info['warehouse_id'],
			$this->id,
			$lockInfo['sku_id'],
			false,
			"lock_quantity = lock_quantity - {$num}"
		);

		if ( $lockInfo['order_id'] )
		{
			Core::LoadDom( 'CenterOrder' );
			$OrderDom = new CenterOrderDom( array( 'id' => $lockInfo['order_id'] ) );

			// 更新订单状态
			$OrderDom->UpdateStatus();
		}

		return true;
	}
}

?>