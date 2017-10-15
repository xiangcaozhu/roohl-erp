<?php

class UserModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function GetUserBase( $id )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_base';
		$cfg['condition'] = array( 'user_id' => $id );
		return $this->Model->Get( $cfg );
	}

	function GetUserBaseTotal( $cfgExt = array() )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_base';
		$cfg['select'] = 'COUNT(*) AS total';
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function NameCheck( $name )
	{
		$ban = array( '|', '.', "'", '"', '/', '*', ',', '~', ';', '$', '\\', '<', '>' );

		if ( str_replace( $ban, '', $name ) != $name )
			return false;
		else
			return true;
	}

	function GetUserBaseByCode( $code )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_base';
		$cfg['condition'] = array( 'user_register_code' => $code );
		return $this->Model->Get( $cfg );
	}

	function GetUserInfoByEmail( $email )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_info';
		$cfg['condition'] = array( 'user_email' => $email );
		return $this->Model->Get( $cfg );
	}

	function GetUserInfoByName( $userName )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_info';
		$cfg['condition'] = array( 'user_name' => $userName );
		return $this->Model->Get( $cfg );
	}

	function GetUserInfo( $id )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_info';
		$cfg['condition'] = array( 'user_id' => $id );
		return $this->Model->Get( $cfg );
	}

	function GetTotal( $status )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_base';
		$cfg['select'] = 'COUNT(*) as total';
		$cfg['key'] = 'total';
		return $this->Model->Get( $cfg );
	}

	function AddUserBase( $data )
	{
		$this->Model->Add( array( 'table' => 'core_user_base', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function AddUserInfo( $data )
	{
		$this->Model->Add( array( 'table' => 'core_user_info', 'data' => $data ) );
	}

	function GetUserInfoList( $offset = 0, $limit = 0, $condition = array(), $conditionExt = '' )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_info';
		$cfg['condition'] = $condition;
		$cfg['conditionExt'] = $conditionExt;
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['order'] = 'user_id DESC';
		return $this->Model->GetList( $cfg );
	}

	function GetUserInfoListByIds( $ids )
	{
		if ( is_array( $ids ) )
			$ids = implode( ',', $ids );

		if ( !$ids )
			return array();
		
		$cfg = array();
		$cfg['table'] = 'core_user_info';
		$cfg['conditionExt'] = "user_id IN({$ids})";
		$cfg['key'] = 'user_id';
		return $this->Model->GetList( $cfg );
	}

	function UpdateUserBase( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'core_user_base', 'data' => $data, 'condition' => array( 'user_id' => $id ) ) );
	}

	function UpdateUserInfo( $id, $data, $dataExt = '' )
	{
		return $this->Model->Update( array( 'table' => 'core_user_info', 'data' => $data, 'condition' => array( 'user_id' => $id ), 'dataExt' => $dataExt ) );
	}

	function DelUser( $id )
	{
		$this->Model->Del( array( 'table' => 'core_user_base', 'condition' => array( 'user_id' => $id ) ) );
		$this->Model->Del( array( 'table' => 'core_user_info', 'condition' => array( 'user_id' => $id ) ) );
	}

	/******** Address ********/

	function GetAddressList( $userId )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_address';
		$cfg['condition'] = array( 'user_id' => $userId );
		return $this->Model->GetList( $cfg );
	}

	function CheckAddress( $condition )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_address';
		$cfg['condition'] = $condition;
		return $this->Model->Get( $cfg );
	}

	function GetAddress( $id )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_address';
		$cfg['condition'] = array( 'id' => $id );
		return $this->Model->Get( $cfg );
	}

	function AddAddress( $data )
	{
		$this->Model->Add( array( 'table' => 'core_user_address', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function DelAddress( $id )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_address';
		$cfg['condition'] = array( 'id' => $id );
		return $this->Model->Del( $cfg );
	}

	function UpdateAddress( $id, $data )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_address';
		$cfg['condition'] = array( 'id' => $id );
		$cfg['data'] = $data;
		return $this->Model->Update( $cfg );
	}

	/******** Billing Address ********/

	function GetBillingAddress( $userId )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_billing_address';
		$cfg['condition'] = array( 'user_id' => $userId );
		return $this->Model->Get( $cfg );
	}

	function ReplaceBillingAddress( $data )
	{
		$this->Model->Replace( array( 'table' => 'core_user_billing_address', 'data' => $data ) );
	}

	function DelBillingAddress( $id )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_billing_address';
		$cfg['condition'] = array( 'id' => $id );
		return $this->Model->Del( $cfg );
	}

	function UpdateBillingAddress( $id, $data )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_billing_address';
		$cfg['condition'] = array( 'id' => $id );
		$cfg['data'] = $data;
		return $this->Model->Update( $cfg );
	}

	/******** GetCountry  ********/
	function GetCountry( $id = 0, $name = '', $code = '' )
	{
		$condition = array();
		$id		? $condition['id'] = $id : null; 
		$name	? $condition['name'] = $name : null; 
		$code	? $condition['iso_code_2'] = $code : null; 
		
		$cfg = array();
		return $this->Model->Get( array(
			'table' => 'shop_country',
			'condition' => $condition,
		) );
	}

	/******** GetCountryZone  ********/
	function GetCountryZone( $id = 0, $name = '', $code = '', $countryId = 0 )
	{
		$condition = array();
		$id		? $condition['id'] = $id : null; 
		$name	? $condition['name'] = $name : null; 
		$code	? $condition['code'] = $code : null; 
		$countryId	? $condition['country_id'] = $countryId : null; 
		
		$cfg = array();
		return $this->Model->Get( array(
			'table' => 'shop_country_zone',
			'condition' => $condition,
		) );
	}

	/******** GetChinaCity  ********/
	function GetChinaCity( $id )
	{
		$condition = array();
		$id		? $condition['id'] = $id : null; 
		
		$cfg = array();
		return $this->Model->Get( array(
			'table' => 'shop_china_city',
			'condition' => $condition,
		) );
	}

	/******** Point ********/
	function GetPointLogList( $userId, $type = '' )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_point_log';
		$cfg['condition'] = array( 'user_id' => $userId );

		if ( $type )
			$cfg['conditionExt'] = "type IN ({$type})";

		$cfg['order'] = 'id DESC';
		return $this->Model->GetList( $cfg );
	}

	function GetPointLog( $id )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_point_log';
		$cfg['condition'] = array( 'id' => $id );
		$cfg['order'] = 'id DESC';
		return $this->Model->Get( $cfg );
	}

	function AddPointLog( $data )
	{
		return $this->Model->Add( array( 'table' => 'core_user_point_log', 'data' => $data ) );
	}

	function DelPointLog( $id )
	{
		$cfg = array();
		$cfg['table'] = 'core_user_point_log';
		$cfg['condition'] = array( 'id' => $id );
		return $this->Model->Del( $cfg );
	}

	function AddFavorite( $data )
	{
		return $this->Model->Add( array( 'table' => 'shop_favorite', 'data' => $data ) );
	}

	function DelFavorite( $id, $userId )
	{
		return $this->Model->Del( array( 'table' => 'shop_favorite', 'condition' => array( 'id' => $id, 'user_id' => $userId ) ) );
	}

	function GetFavorite( $userId, $pid )
	{
		return $this->Model->Get( array( 'table' => 'shop_favorite', 'condition' => array( 'user_id' => $userId, 'pid' => $pid ) ) );
	}

	function GetFavoriteList( $userId, $offset, $limit )
	{
		$cfg = array();
		$cfg['table'] = 'shop_favorite';
		$cfg['condition'] = array( 'user_id' => $userId );
		$cfg['order'] = 'id DESC';
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;

		return $this->Model->GetList( $cfg );
	}

	function GetFavoriteTotal( $userId )
	{
		$cfg = array();
		$cfg['table'] = 'shop_favorite';
		$cfg['select'] = 'COUNT(*) AS total';
		$cfg['condition'] = array( 'user_id' => $userId );
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}
}

?>