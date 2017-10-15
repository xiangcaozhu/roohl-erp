<?php

class msn
{
	var $server	=	'messenger.hotmail.com';
	var $port		=	1863;
	var $nexus	=	'https://nexus.passport.com/rdr/pprdr.asp';
	var $ssh_login	=	'login.live.com/login2.srf';
	var $debug	=	1;

	function connect($passport, $password)
	{
		$this->trID = 1;

		if ($this->fp = @fsockopen($this->server, $this->port, $errno, $errstr, 2))
		{
			$this->_put("VER $this->trID MSNP9 CVR0\r\n");

			while (! feof($this->fp))
			{
				$data = $this->_get();

				switch ($code = substr($data, 0, 3))
				{
					default:
						echo $this->_get_error($code);

						return false;
					break;
					case 'VER':
						$this->_put("CVR $this->trID 0x0409 win 4.10 i386 MSNMSGR 7.0.0816 MSMSGS $passport\r\n");
					break;
					case 'CVR':
						$this->_put("USR $this->trID TWN I $passport\r\n");
					break;
					case 'XFR':
						list(, , , $ip)  = explode (' ', $data);
						list($ip, $port) = explode (':', $ip);

						if ($this->fp = @fsockopen($ip, $port, $errno, $errstr, 2))
						{
							$this->trID = 1;

							$this->_put("VER $this->trID MSNP9 CVR0\r\n");
						}
						else
						{
							if (! empty($this->debug)) echo 'Unable to connect to msn server (transfer)';

							return false;
						}
					break;
					case 'USR':
						if (isset($this->authed))
						{
							return true;
						}
						else
						{
							$this->passport = $passport;
							$this->password = urlencode($password);

							list(,,,, $code) = explode(' ', trim($data));

							if ($auth = $this->_ssl_auth($code))
							{
								$this->_put("USR $this->trID TWN S $auth\r\n");

								$this->authed = 1;
							}
							else
							{
								if (! empty($this->debug)) echo 'auth failed';

								return false;
							}
						}
					break;
				}
			}
		}
		else
		{
			return false;
		}
	}

	function get($email, $password)
	{
		$group = array();

		if ($this->connect($email, $password))
		{
			$info = $this->rx_data();

			if ($info['friend'])
			{
				if ( $info['group'] )
				{
					foreach ( $info['group'] as $val )
					{
						$group[trim($val[1])]['name'] = trim($val[2]);
					}
				}
				else
				{
					$group[0]['name'] = 'Individuals';
				}

				foreach ( $info['friend'] as $val )
				{
					$group[trim($val[4])]['friend'][] = array( 'email' => trim($val[1]), 'name' => trim($val[2]) );
				}
			}
		}

		return $group;
	}


	function rx_data()
	{
		$this->_put("SYN $this->trID 0\r\n");
		$this->_put("CHG $this->trID NLN\r\n");

		$time = time();
		$group = array();
		$friend = array();

		stream_set_timeout($this->fp, 2);

		while (! feof($this->fp))
		{
			$data = $this->_get();

			if ($data)
			{
				$code = substr($data, 0, 3);

				if ( $code == 'LST' )
				{
					$friend[] = explode( ' ', $data );
				}
				elseif ( $code == 'LSG' )
				{
					$group[] = explode( ' ', $data );
				}
			}

			if ( ( time() - $time ) > 8 )
				break;
		}

		return array( 'group' => $group, 'friend' => $friend );
	}

	function _ssl_auth($auth_string)
	{
		$slogin = $this->ssh_login;

		$ch = curl_init('https://'.$slogin);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Authorization: Passport1.4 OrgVerb=GET,OrgURL=http%3A%2F%2Fmessenger%2Emsn%2Ecom,sign-in='.$this->passport.',pwd='.$this->password.','.$auth_string,
					'Host: login.passport.com'
				));

		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$header = curl_exec($ch);

		curl_close($ch);

		preg_match ("/from-PP='(.*?)'/", $header, $out);

		return (isset($out[1])) ? $out[1] : false;
	}


	function _get()
	{
		if ($data = @fgets($this->fp, 4096))
		{
			return $data;
		}
		else
		{
			return false;
		}
	}


	function _put($data)
	{
		fwrite($this->fp, $data);

		$this->trID++;
	}

}


?>
