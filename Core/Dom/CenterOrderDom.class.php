<?php

class CenterOrderDom
{
	var $id = 0;

	function CenterOrderDom( $info )
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
			$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
			$info = $CenterOrderModel->Get( $this->id );

			$info ? $this->Init( $info ) : null;
		}

		return true;
	}

	function SetPrint()
	{
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		$CenterOrderModel->Update( $this->id, array(
			'print_status' => 1
		) );
	}

	function UpdateStatus()
	{
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );

		$deliveryTypeList = $CenterWarehouseLockModel->GetOrderDeliveryTypeList( $this->id );

		// 多地发货或者一地发货
		if ( count( $deliveryTypeList )  > 1 )
			$deliveryType = 2;
		else
			$deliveryType = 1;

		// 具体仓库
		if ( count( $deliveryTypeList )  == 1 )
			$warehouseId = $deliveryTypeList[0]['warehouse_id'];
		else
			$warehouseId = 0;
		
		// 统计信息
		$statInfo = $CenterOrderModel->GetProductStat( $this->id );

		// 配货状态
		if ( $statInfo['total_lock_quantity'] >= $statInfo['total_quantity'] )
			$lockStatus = 2;
		elseif ( $statInfo['total_lock_quantity'] > 0 )
			$lockStatus = 1;
		else
			$lockStatus = 0;

		// 出库状态
		if ( $statInfo['total_delivery_quantity'] >= $statInfo['total_quantity'] )
			$deliveryStatus = 2;
		elseif ( $statInfo['total_delivery_quantity'] > 0 )
			$deliveryStatus = 1;
		else
			$deliveryStatus = 0;

		// 采购状态
		if ( $statInfo['total_purchase_quantity'] >= $statInfo['total_quantity'] )
			$purchaseStatus = 2;
		elseif ( $statInfo['total_purchase_quantity'] > 0 )
			$purchaseStatus = 1;
		else
			$purchaseStatus = 0;

		$data = array(
			'lock_status' => $lockStatus,
			'delivery_type' => $deliveryType,
			'delivery_status' => $deliveryStatus,
			'purchase_status' => $purchaseStatus,
			'warehouse_id' => $warehouseId
		);

		if ( !$warehouseId )
			unset( $data['warehouse_id'] );

		$CenterOrderModel->Update( $this->id, $data );
	}

















	function UpdateStatus_dfh()
	{
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		//$CenterWarehouseLockModel = Core::ImportModel( 'CenterWarehouseLock' );

		//$deliveryTypeList = $CenterWarehouseLockModel->GetOrderDeliveryTypeList( $this->id );

		// 多地发货或者一地发货
		//if ( count( $deliveryTypeList )  > 1 )
		//	$deliveryType = 2;
		//else
		//	$deliveryType = 1;

		// 具体仓库
			$warehouseId = 5;
		
		// 统计信息
		$statInfo = $CenterOrderModel->GetProductStat( $this->id );

		// 配货状态
		if ( $statInfo['total_lock_quantity'] >= $statInfo['total_quantity'] )
			$lockStatus = 2;
		elseif ( $statInfo['total_lock_quantity'] > 0 )
			$lockStatus = 1;
		else
			$lockStatus = 0;

		// 出库状态
		if ( $statInfo['total_delivery_quantity'] >= $statInfo['total_quantity'] )
			$deliveryStatus = 2;
		elseif ( $statInfo['total_delivery_quantity'] > 0 )
			$deliveryStatus = 1;
		else
			$deliveryStatus = 0;

		// 采购状态
		if ( $statInfo['total_purchase_quantity'] >= $statInfo['total_quantity'] )
			$purchaseStatus = 2;
		elseif ( $statInfo['total_purchase_quantity'] > 0 )
			$purchaseStatus = 1;
		else
			$purchaseStatus = 0;

		$data = array(
			'lock_status' => $lockStatus,
			'delivery_type' => 1,
			'delivery_status' => $deliveryStatus,
			'purchase_status' => $purchaseStatus,
			'warehouse_id' => $warehouseId
		);

		if ( !$warehouseId )
			unset( $data['warehouse_id'] );

		$CenterOrderModel->Update( $this->id, $data );
	}
	


	function UpdateStatus_del()
	{
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		
		// 统计信息
		$statInfo = $CenterOrderModel->GetProductStat( $this->id );

		// 配货状态
		if ( $statInfo['total_lock_quantity'] >= $statInfo['total_quantity'] )
			$lockStatus = 2;
		elseif ( $statInfo['total_lock_quantity'] > 0 )
			$lockStatus = 1;
		else
			$lockStatus = 0;

		// 出库状态
		if ( $statInfo['total_delivery_quantity'] >= $statInfo['total_quantity'] )
			$deliveryStatus = 2;
		elseif ( $statInfo['total_delivery_quantity'] > 0 )
			$deliveryStatus = 1;
		else
			$deliveryStatus = 0;

		// 采购状态
		if ( $statInfo['total_purchase_quantity'] >= $statInfo['total_quantity'] )
			$purchaseStatus = 2;
		elseif ( $statInfo['total_purchase_quantity'] > 0 )
			$purchaseStatus = 1;
		else
			$purchaseStatus = 0;

		$data = array(
			'lock_status' => $lockStatus,
			'delivery_type' => 1,
			'delivery_status' => $deliveryStatus,
		'purchase_status' => $purchaseStatus
		);


		$CenterOrderModel->Update( $this->id, $data );
	}


}

?>