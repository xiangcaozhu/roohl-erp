<?php

class Session
{
	var $prefix = '';
	var $sid = false;
	var $data = array();
	var $started = false;

	function Session( $prefix )
	{
		$this->prefix = $prefix;
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Start()
	{
		if ( $this->GetCookie( 'sid' ) )
			$this->sid = $this->GetCookie( 'sid' );
		else
			return false;

		$info = $this->Model->Get( array( 'table' => 'session', 'condition' => array( 'sid' => $this->sid ) ) );

		if ( $info && $info['ip'] == GetUserIp() )
		{
			$this->started = true;
			$this->data = unserialize( $info['data'] );
		}
		else
		{
			$this->started = false;
		}

		return true;
	}

	function Init()
	{
		while ( true )
		{
			$sid = $this->GetSid();

			if( !$this->Model->Get( array( 'table' => 'session', 'condition' => array( 'sid' => $sid ) ) ) )
				break;
		}

		$data = array();
		$data['sid'] = $sid;
		$data['data'] = '';
		$data['add_time'] = time();
		$data['update_time'] = time();
		$data['ip'] = GetUserIp();

		$this->Model->Get( array( 'table' => 'session', 'data' => $data ) );

		$this->SetCookie( 'sid', $sid );
		$this->sid = $sid;
	}

	function Add( $name, $value )
	{
		$this->data[$name] = $value;
	}

	function Get( $name )
	{
		return $this->data[$name];
	}

	function Update()
	{
		if ( !$this->started )
		{
			$this->Init();
		}

		$data = array();
		$data['update_time'] = time();
		$data['data'] = serialize( $this->data );

		$this->Model->Get( array( 'table' => 'session', 'condition' => array( 'sid' => $this->sid ), 'data' => $data ) );
	}

	function GetSid()
	{
		return md5( GetUserIp() . '_' . mt_rand( 0, 9999 ) . '_' . time() . '_' . mt_rand( 0, 9999 ) );
	}

	function Clean()
	{

	}

	function SetCookie( $name, $value )
	{
		setcookie( $this->prefix . $name, $value, 0, '/', '' );
	}

	function GetCookie( $name )
	{
		return $_COOKIE[$this->prefix . $name];
	}
}

?>