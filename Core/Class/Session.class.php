<?php

class Session
{
	var $prefix = '';
	var $sid = false;
	var $data = array();
	var $started = false;
	var $userId = 0;

	function Session( $prefix, $userId )
	{
		$this->prefix = $prefix;
		$this->userId = $userId;
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Start()
	{
		if ( $this->GetCookie( 'sid' ) )
			$this->sid = $this->GetCookie( 'sid' );

		$info = array();

		if ( $this->sid )
		{
			$info = $this->Model->Get( array( 'table' => 'core_session', 'condition' => array( 'sid' => $this->sid ) ) );
		}

		if ( $info && $info['ip'] == GetUserIp() )
		{
			$this->started = true;
			$this->data = unserialize( $info['data'] );
		}
		else
		{
			if ( $this->userId )
			{
				$existsInfo = array();
				$existsInfo = $this->Model->Get( array( 'table' => 'core_session', 'condition' => array( 'user_id' => $this->userId ) ) );

				if ( $existsInfo )
				{
					$sid = $this->GetAloneSid();

					$data = array();
					$data['sid'] = $sid;
					$data['update_time'] = time();
					$this->Model->Update( array( 'table' => 'core_session', 'condition' => array( 'sid' => $existsInfo['sid'] ), 'data' => $data ) );

					$this->started = true;
					$this->sid = $sid;
					$this->data = unserialize( $existsInfo['data'] );
				}
				else
				{
					$this->started = false;
				}
			}
			else
			{
				$this->started = false;
			}
		}

		return true;
	}

	function Init()
	{
		$sid = $this->GetAloneSid();

		$data = array();
		$data['sid'] = $sid;
		$data['user_id'] = $this->userId;
		$data['data'] = '';
		$data['add_time'] = time();
		$data['update_time'] = time();
		$data['ip'] = GetUserIp();

		$this->Model->Add( array( 'table' => 'core_session', 'data' => $data ) );

		$this->SetCookie( 'sid', $sid );
		$this->sid = $sid;
	}

	function Add( $name, $value )
	{
		$this->data[$name] = $value;
	}

	function Set( $name, $value )
	{
		$this->Add( $name, $value );
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
		$data['user_id'] = $this->userId;
		$data['data'] = serialize( $this->data );

		$this->Model->Update( array( 'table' => 'core_session', 'condition' => array( 'sid' => $this->sid ), 'data' => $data ) );
	}

	function TimeOut()
	{
		$this->Model->Del( array( 'table' => 'core_session', 'conditionExt' => 'update_time < ' . ( time() - 3600 ) ) );
	}

	function GetAloneSid()
	{
		while ( true )
		{
			$sid = $this->GetSid();

			if ( !$this->Model->Get( array( 'table' => 'core_session', 'condition' => array( 'sid' => $sid ) ) ) )
				break;
		}

		return $sid;
	}

	function GetSid()
	{
		return md5( GetUserIp() . '_' . mt_rand( 0, 9999 ) . '_' . time() . '_' . mt_rand( 0, 9999 ) );
	}

	function Clean()
	{
		setcookie( $this->prefix . 'sid', '', time() - 3600, '/', '' );

		//if ( $this->sid )
		//	$this->Model->Del( array( 'table' => 'session', 'condition' => array( 'sid' => $this->sid ) ) );
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