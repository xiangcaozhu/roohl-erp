<?php

include_once( 'base/CategoryBaseModel.class.php' );

class CenterCategoryModel extends CategoryBaseModel
{
	var $table = 'shopcenter_category';
	var $extraTable = 'shopcenter_category_extra';

	var $hasExtra = true;

	function AddBrand( $data )
	{
		return $this->Model->Add( array( 'table' => 'shopcenter_category_brand', 'data' => $data ) );
	}

	function DelBrand( $cid, $bid = 0 )
	{
		return $this->Model->Del( array( 'table' => 'shopcenter_category_brand', 'data' => $data, 'condition' => array( 'cid' => $cid, 'bid' => $bid ) ) );
	}

	function GetBrandList( $cid = 0 )
	{		
		$cfg = array();
		$cfg['sql'] = 
			"SELECT shopcenter_category_brand.cid, shopcenter_brand.* FROM shopcenter_category_brand,shopcenter_brand WHERE " . 
			( $cid ? "shopcenter_category_brand.cid = {$cid} AND " : " " ) . 
			" shopcenter_category_brand.bid = shopcenter_brand.id ORDER BY shopcenter_category_brand.order_id DESC";

		if ( $cid )
			$cfg['key'] = 'id';

		$cfg['order'] = "order_id DESC";

		return $this->Model->GetList( $cfg );
	}
}

?>