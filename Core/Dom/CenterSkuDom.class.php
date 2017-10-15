<?php

class CenterSkuDom
{
	var $id = 0;

	function CenterSkuDom( $info )
	{
		if ( is_array( $info ) )
		{
			$this->Init( $info );
		}
		else
		{
			$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
			$this->id = $CenterProductExtra->Sku2Id( $info );
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
			$CenterProductModel = Core::ImportModel( 'CenterProduct' );
			$skuInfo = $CenterProductModel->GetSku( $this->id );

			$skuInfo ? $this->Init( $skuInfo ) : null;
		}

		return true;
	}

	function GetProductId()
	{
		return $this->info['pid'];
	}

	function InitProduct()
	{
		$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );
		$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
		
		Core::LoadDom( 'CenterProduct' );
		$CenterProductDom = new CenterProductDom( $this->info['pid'] );

		$this->info['sku'] = $CenterProductExtra->Id2Sku( $this->id );

		$this->info['product'] = $CenterProductDom->info;
		$attribute = $CenterBuyAttributeExtra->ParseSkuAttribute( $this->info['content'] );
		$this->info['attribute'] = $attribute;
		$ha = explode(":",$attribute);
		$this->info['attributetTT'] = $ha[0].":";
		$this->info['attributetKK'] = $ha[1];

		return $this->info;
	}


	function InitProduct_1()
	{
		$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );
		$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
		
		Core::LoadDom( 'CenterProduct' );
		$CenterProductDom = new CenterProductDom( $this->info['pid'] );

		$this->info['sku'] = $CenterProductExtra->Id2Sku( $this->id );

		$this->info['product'] = $CenterProductDom->info;
		$this->info['attribute'] = $CenterBuyAttributeExtra->ParseSkuAttribute_1( $this->info['content'] );
		$this->info['service'] = $CenterBuyAttributeExtra->ParseSkuAttribute_2( $this->info['content'] );
		
		//echo $this->info['attribute'] . "_______________________<br>" ;

		return $this->info;
	}


	function InitProduct_2()
	{
		$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );
		$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
		
		Core::LoadDom( 'CenterProduct' );
		$CenterProductDom = new CenterProductDom( $this->info['pid'] );

		$this->info['sku'] = $CenterProductExtra->Id2Sku( $this->id );

		$this->info['product'] = $CenterProductDom->info;
		$this->info['attribute'] = $CenterBuyAttributeExtra->ParseSkuAttribute_2( $this->info['content'] );
		
		//echo $this->info['attribute'] . "_______________________<br>" ;

		return $this->info;
	}
	
		function InitProduct_3()
	{
		$CenterBuyAttributeExtra = Core::ImportExtra( 'CenterBuyAttribute' );
		//$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );
		
		//Core::LoadDom( 'CenterProduct' );
		//$CenterProductDom = new CenterProductDom( $this->info['pid'] );

		//$this->info['sku'] = $CenterProductExtra->Id2Sku( $this->id );

		//$this->info['product'] = $CenterProductDom->info;
		//$this->info['attribute'] = $CenterBuyAttributeExtra->ParseSkuAttribute_3( $this->info['content'] );
		
		//echo $this->info['attribute'] . "_______________________<br>" ;
		$get_id = $CenterBuyAttributeExtra->ParseSkuAttribute_3( $this->info['content'] );

		//return $this->info;
		return $get_id;
	}

}

?>