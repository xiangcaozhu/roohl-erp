<?php

class CenterProductDom
{
	var $id = 0;

	function CenterProductDom( $info )
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
			$CenterProductModel = Core::ImportModel( 'CenterProduct' );
			$productInfo = $CenterProductModel->Get( $this->id );

			$productInfo ? $this->Init( $productInfo ) : null;
		}

		return true;
	}

	function GetAttributeList()
	{
		if ( $this->attributeList )
			return $this->attributeList;
		
		$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );

		$buyAttributeList = $CenterBuyAttributeExtra->GetGroup( $this->id );

		/*
		if ( $this->info['buy_attribute_template_id'] > 0 )
			$buyAttributeList = $CenterBuyAttributeExtra->GetGroup( 0, $this->info['buy_attribute_template_id'] );
		elseif ( $this->info['buy_attribute_template_id'] == -1 )
			$buyAttributeList = $CenterBuyAttributeExtra->GetGroup( $this->id );
		else
			$buyAttributeList = array();
		*/

		if ( !$buyAttributeList )
			$buyAttributeList = array();

		$this->attributeList = $buyAttributeList;

		return $this->attributeList;
	}

	function GetBaseSku()
	{
		$CenterProductModel = Core::ImportModel( 'CenterProduct' );
		$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

		$skuInfo = $CenterProductModel->GetBaseSku( $this->id );

		$productId = $this->id;

		if ( !$skuInfo )
		{
			$hash = "{$productId}_" . md5( '' );
			
			$data = array();
			$data['pid'] = $productId;
			$data['hash_key'] = $hash;
			$data['content'] = '';
			$data['is_base'] = 1;
			$data['add_time'] = time;

			$CenterProductModel->AddSku( $data );

			$skuInfo = $CenterProductModel->GetSkuByHash( $hash );
		}

		return $CenterProductExtra->Id2Sku( $skuInfo['id'] );
	}

	function GetSku1012( $attr_store,$attr_switch )
	{
		$CenterProductModel = Core::ImportModel( 'CenterProduct' );
		$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

		$productId = $this->id;
		$content = 'a:1:{i:'.$attr_store.';a:2:{s:5:"input";s:'.strlen($attr_switch).':"'.$attr_switch.'";s:3:"vid";s:'.strlen($attr_switch).':"'.$attr_switch.'";}}';
		$hash = $productId."_" . md5( $content );
		$skuInfo = $CenterProductModel->GetSkuByHash( $hash );


		if ( !$skuInfo )
		{
			$data = array();
			$data['pid'] = $productId;
			$data['hash_key'] = $hash;
			$data['content'] = $content;
			$data['is_base'] = $content == '' ? 1 : 0;
			$data['add_time'] = time;
			$CenterProductModel->AddSku( $data );

			$skuInfo = $CenterProductModel->GetSkuByHash( $hash );
			//$skuInfo = 0;
		}

		return $CenterProductExtra->Id2Sku( $skuInfo['id'] );
	}



	function GetSku( $attributePost )
	{
		$CenterProductModel = Core::ImportModel( 'CenterProduct' );
		$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );

		list( $hash, $content ) = $this->GetSkuHash( $productId, $attributePost );

		$skuInfo = $CenterProductModel->GetSkuByHash( $hash );

		$productId = $this->id;

		if ( !$skuInfo )
		{
			$data = array();
			$data['pid'] = $productId;
			$data['hash_key'] = $hash;
			$data['content'] = $content;
			$data['is_base'] = $content == '' ? 1 : 0;
			$data['add_time'] = time;
			$CenterProductModel->AddSku( $data );

			$skuInfo = $CenterProductModel->GetSkuByHash( $hash );
		}

		return $CenterProductExtra->Id2Sku( $skuInfo['id'] );
	}

	function GetSkuHash( $attributePost )
	{
		$CenterProductModel = Core::ImportModel( 'CenterProduct' );
		
		$attributeInputList = $this->GetSkuAttributeStore( $_POST['attr_store'], $_POST['attr_switch'] );

		if ( !$attributeInputList )
			$content = '';
		else
			$content = serialize( $attributeInputList );

		$productId = $this->id;

		$hash = "{$productId}_" . md5( $content );

		return array( $hash, $content );
	}

	function GetSkuAttributeStore( $select = array(), $switch = array() )
	{
		if ( !is_array( $select ) )
			$select = array();

		if ( !is_array( $switch ) )
			$switch = array();

		$attributeList = $this->GetAttributeList();

		$switchIndex = array();
		foreach ( $switch as $val )
		{
			$switchIndex = @array_merge( $switchIndex, @explode( ',', $val ) );
		}

		$append = 0;
		$attributeInputList = array();
		foreach ( $attributeList as $attr )
		{
			$input = trim( $select[$attr['id']] );

			if ( $attr['type'] != 'textgroup' )
			{
				if ( $input )
				{
					$valueSaveInfo = array();
					$valueSaveInfo['input'] = $input;

					if ( $attr['type'] == 'text' )
					{
						$valueSaveInfo['vid'] = 0;
					}
					else
					{
						$valueSaveInfo['vid'] = $attr['value_list'][$input]['id'];
					}

					$attributeInputList[$attr['id']] = $valueSaveInfo;
				}
			}
			else
			{
				if ( is_array( $attr['value_list'] ) )
				{
					$inputList = array();
					foreach ( $attr['value_list'] as $value )
					{
						$in = trim( $select[$attr['id']][$value['id']] );

						if ( $in )
						{
							$valueSaveInfo = array();
							$valueSaveInfo['input'] = $in;
							$valueSaveInfo['vid'] = $value['id'];

							$inputList[$value['id']] = $valueSaveInfo;
						}
					}

					ksort( $inputList );

					$attributeInputList[$attr['id']] = $inputList;
				}
			}
		}

		ksort( $attributeInputList );

		return $attributeInputList;
	}
}

?>