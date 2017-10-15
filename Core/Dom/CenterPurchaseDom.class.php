<?php

class CenterPurchaseDom
{
	var $id = 0;

	function CenterPurchaseDom( $info )
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
			$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
			$info = $CenterPurchaseModel->Get( $this->id );

			$info ? $this->Init( $info ) : null;
		}

		return true;
	}

	function UpdateStatus()
	{
		$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
		
		$statusNumInfo = $CenterPurchaseModel->GetProductStatusNum( $this->id );

		if ( $statusNumInfo['total_receive_quantity'] >= $this->info['total_quantity'] )
			$receiveStatus = 3;
		elseif ( $statusNumInfo['total_receive_quantity'] > 0 )
			$receiveStatus = 2;
		else
			$receiveStatus = 1;

		if ( $statusNumInfo['total_into_quantity'] >= $this->info['total_quantity'] )
			$intoStatus = 3;
		elseif ( $statusNumInfo['total_into_quantity'] > 0 )
			$intoStatus = 2;
		else
			$intoStatus = 1;
			
		
		if($intoStatus == 3)
		$CenterPurchaseModel->Update( $this->id, array( 'receive_status' => $receiveStatus, 'into_status' => $intoStatus, 'status' => 5 ) );
		else
		$CenterPurchaseModel->Update( $this->id, array( 'receive_status' => $receiveStatus, 'into_status' => $intoStatus ) );


	}

	function RelationStore( $purchaseProductId, $num )
	{
		$CenterOrderModel = Core::ImportModel( 'CenterOrder' );
		$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );

		$list = $CenterPurchaseModel->GetRelationListByPurchaseProduct( $purchaseProductId );

		foreach ( $list as $key => $val )
		{
			$needNum = $val['quantity'] - $val['into_quantity'];

			if ( $num <= 0 )
				break;
			if ( $needNum <= 0 )
				break;

			if ( $needNum <= $num )
				$appendNum = $needNum;
			elseif ( $needNum > $num )
				$appendNum = $num;

			$num = $num - $appendNum;

			$CenterPurchaseModel->UpdateRelation( $val['id'], false, "into_quantity = into_quantity + {$appendNum}" );
			$CenterOrderModel->UpdateProduct( $val['order_product_id'], false, "into_quantity = into_quantity + {$appendNum}" );
		}

		return false;
	}
}

?>