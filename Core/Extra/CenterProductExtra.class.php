<?php

class CenterProductExtra
{
	function CenterProductExtra()
	{
		
	}

	// tlen = title length
	// slen = summary length
	function Explain( $list, $tlen = 20, $slen = 40 )
	{
		foreach ( $list as $key => $val )
		{
			$list[$key] = $this->ExplainOne( $val, $tlen, $slen );
		}

		return $list;
	}

	function ExplainOne( $info, $tlen = 20, $slen = 40 )
	{
		// 图片
		$pictureSizeList = Core::GetConfig( 'product_picture_size' );

		foreach ( $pictureSizeList as $imgType => $_s )
		{
			$info["image_{$imgType}_url"] = Common::GetProductPictureUrl( $info['id'], $imgType );
		}

		// 名称
		$info['sort_name'] = CutStr( $info['name'], $tlen );
		$info['sort_summary'] = CutStr( $info['summary'], $slen );

		// 链接
		$seoUri = preg_replace( '/[^0-9a-zA-Z]+/is', '-', htmlspecialchars_decode( $info['name'] ) ) . '_';
		$info['seo_uri'] = $seoUri;
		$info['detail_link'] = "/product/detail-{$info['id']}.html";
		$info['detail_link_seo'] = "/product/{$seoUri}detail-{$info['id']}.html";

		return $info;
	}
	
	function Id2Sku( $id )
	{
		return 'S' . sprintf( '%09d', $id );
	}

	function Sku2Id( $sku )
	{
		return intval( substr( $sku, 1 ) );
	}
}

?>