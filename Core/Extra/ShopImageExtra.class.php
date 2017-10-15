<?php

class ShopImageExtra
{
	// tlen = title length
	// slen = summary length
	function Explain( $list )
	{
		foreach ( $list as $key => $val )
		{
			$list[$key] = $this->ExplainOne( $val, $tlen, $slen );
		}

		return $list;
	}

	function ExplainOne( $info )
	{
		$root = Core::GetConfig( 'picture_url' );

		$info['url'] = $root . "{$info['save_path']}{$info['save_name']}.{$info['save_ext']}";
		$info['min_url'] = $root . "{$info['save_path']}{$info['save_name']}_min.{$info['save_ext']}";

		return $info;
	}
}

?>