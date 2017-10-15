<?php

class CenterCategoryExtra
{
	function PositionMove( $pid, $cid, $nid, $newParent = false )
	{
		$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );

		if ( $nid > 0 )
		{
			$nextCategoryInfo = $CenterCategoryModel->Get( $nid );
			$orderId = $nextCategoryInfo['order_id'];
			$CenterCategoryModel->UpdateOrderId( $pid, $orderId );
		}
		else
		{
			$orderId = $CenterCategoryModel->GetMinOrderId( $pid ) - 1;
		}

		$data = array();
		$data['order_id'] = $orderId;

		// 移动到新的分类
		if ( $newParent )
			$data['pid'] = $pid;

		$CenterCategoryModel->Update( $cid, $data );
		$CenterCategoryModel->BuildTree();
		$CenterCategoryModel->UpdateParentIdList();
	}
}

?>