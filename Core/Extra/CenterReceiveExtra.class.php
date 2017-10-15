<?php

class CenterReceiveExtra
{
	function CenterReceiveExtra()
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
		
		$info['sku_info'] = $skuInfo;
		return $info;
	}

	function Add( $data )
	{
		global $__UserAuth;
		
		$data['add_time'] = time();
		$data['user_id'] = $__UserAuth['user_id'];
		$data['user_name'] = $__UserAuth['user_name'];
		$data['status'] = 1;
		$data['into_status'] = 1;
		
		$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );

		return $CenterReceiveModel->Add( $data );
	}

	function AddProduct( $data )
	{
		global $__UserAuth;
		
		$data['into_quantity'] = 0;
		$data['add_time'] = time();
		
		$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );

		return $CenterReceiveModel->AddProduct( $data );
	}
}

?>