<?php

class CenterBuyAttributeModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_buy_attribute', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_buy_attribute', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function Get( $id )
	{
		return $this->Model->Get( array( 'table' => 'shopcenter_buy_attribute', 'condition' => array( 'id' => $id ) ) );
	}

	function GetList( $productId, $templateId = 0 )
	{
		$condition = array();

		if ( $productId  )
			$condition['pid'] = $productId;
		if ( $templateId  )
			$condition['tid'] = $templateId;
		
		return $this->Model->GetList( array( 
			'table' => 'shopcenter_buy_attribute', 
			'condition' => $condition, 'order' => 
			'order_id DESC' 
		) );
	}

	function Del( $id )
	{
		return $this->Model->Del( array( 
			'table' => 'shopcenter_buy_attribute', 
			'condition' => array( 'id' => $id )
		) );
	}

	function AddValue( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_buy_attribute_value', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function UpdateValue( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_buy_attribute_value', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function GetValue( $id )
	{
		return $this->Model->Get( array( 
			'table' => 'shopcenter_buy_attribute_value', 
			'condition' => array( 'id' => $id )
		) );
	}

	function GetValueListByPid( $productId )
	{
		return $this->Model->GetList( array( 
			'table' => 'shopcenter_buy_attribute_value', 
			'condition' => array( 'pid' => $productId ), 
			'order' => 'service DESC' 
		) );
	}

	function GetValueListByAid( $attributeId )
	{
		return $this->Model->GetList( array( 
			'table' => 'shopcenter_buy_attribute_value',
			'condition' => array( 'aid' => $attributeId ),
			'order' => 'order_id DESC'
		) );
	}

	function DelValueByAid( $attributeId )
	{
		return $this->Model->Del( array( 
			'table' => 'shopcenter_buy_attribute_value', 
			'condition' => array( 'aid' => $attributeId )
		) );
	}

	function GetTemplateList( $offset = 0, $limit = 0 )
	{
		return $this->Model->GetList( array( 
			'table' => 'shopcenter_buy_attribute_template', 
			'order' => 'id DESC',
			'offset' => $offset,
			'limit' => $limit
		) );
	}

	function GetTemplateTotal()
	{
		return $this->Model->Get( array( 
			'table' => 'shopcenter_buy_attribute_template', 
			'select' => 'COUNT(*) AS total',
			'key' => 'total'
		) );
	}

	function AddTemplate( $data )
	{
		$this->Model->Add( array( 
			'table' => 'shopcenter_buy_attribute_template', 
			'data' => $data
		) );
		return $this->Model->DB->LastID();
	}

	function GetTemplate( $id )
	{
		return $this->Model->Get( array( 
			'table' => 'shopcenter_buy_attribute_template', 
			'condition' => array( 'id' => $id ) 
		) );
	}

	function UpdateTemplate( $id, $data )
	{
		return $this->Model->Update( array( 
			'table' => 'shopcenter_buy_attribute_template', 
			'condition' => array( 'id' => $id ),
			'data' => $data,
		) );
	}

	function DelTemplate( $id )
	{
		return $this->Model->Del( array( 
			'table' => 'shopcenter_buy_attribute_template', 
			'condition' => array( 'id' => $id )
		) );
	}
}

?>