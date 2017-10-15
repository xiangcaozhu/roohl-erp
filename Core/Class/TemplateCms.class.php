<?php

class TemplateCms
{
	function TemplateCms()
	{

	}

	function Parse( $content, $compiler )
	{
		$content = $this->ProcessPattern( $content, $compiler );

		return $content;
	}

	function ProcessPattern( $content, $compiler )
	{
		$patternList = array(
			array(
				'find' => '/<!--(?:\s+)CategoryAroundProduct(?:\s*)\((.+?)\)(?:\s+)AS(?:\s+)([a-zA-Z_0-9]+)(?:\s+)-->/',
				'replace' => 'SetAroundProductList',
			),
			array(
				'find' => '/<!--(?:\s+)CmsChildCategoryList(?:\s*)\((.+?)\)(?:\s+)AS(?:\s+)([a-zA-Z_0-9]+)(?:\s+)-->/',
				'replace' => 'SetChildCategoryList',
			),
			array(
				'find' => '/<!--(?:\s+)CmsSiblingCategoryList(?:\s*)\((.+?)\)(?:\s+)AS(?:\s+)([a-zA-Z_0-9]+)(?:\s+)-->/',
				'replace' => 'SetSiblingCategoryList',
			),
			array(
				'find' => '/<!--(?:\s+)CmsCategoryMenuList(?:\s*)\((.+?)\)(?:\s+)AS(?:\s+)([a-zA-Z_0-9]+)(?:\s+)-->/',
				'replace' => 'SetCategoryMenuList',
			),
			array(
				'find' => '/<!--(?:\s+)ProductList(?:\s*)\((.+?)\)(?:\s+)AS(?:\s+)([a-zA-Z_0-9]+)(?:\s+)-->/',
				'replace' => 'SetProductList',
			),
		);

		foreach ( $patternList as $pattern )
		{
			if ( preg_match_all( $pattern['find'], $content, $rs ) )
			{
				foreach ( $rs[1] as $key => $val )
				{
					$argList = explode( ',', $val );

					foreach ( $argList as $k => $arg )
					{
						$arg = trim( $arg );
						if ( $arg[0] == "'" || $arg[0] == '"' || is_numeric( $arg ) )
						{
							$argList[$k] = $arg;
						}
						else
						{
							$argList[$k] = $compiler->ProccessVARS( $arg );
						}
					}

					$var = $compiler->ProccessVARS( $rs[2][$key] );

					$phpCode = "<?p" . "hp {$var} = TemplateCms::" . $pattern['replace'] . "( ". implode( $argList, ',' ) ." );?" . ">";

					$content = str_replace( $rs[0][$key], $phpCode, $content );
				}
			}
		}

		return $content;
	}

	function SetAroundProductList( $categoryId, $productId, $num )
	{
		$categoryId	= intval( $categoryId );
		$productId		= intval( $productId );
		$num		= intval( $num );

		if ( !$categoryId || !$productId || !$num )
			return array();
		
		$CmsProductModel = Core::ImportModel( 'CmsProduct' );

		$list = $CmsProductModel->GetAboutProduct( $categoryId, $productId, $num );

		$list =  ArraySlice( $list, 10 );

		$ProductExtra = Core::ImportExtra( 'Product' );

		return $ProductExtra->Explain( $list );
	}

	function SetChildCategoryList( $categoryId, $type = 1 )
	{
		$CmsCategoryExtra = Core::ImportExtra( 'CmsCategory' );
		$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );

		return $CmsCategoryExtra->Explain( $CmsCategoryModel->GetOneChildList( $categoryId ) );
	}

	function SetSiblingCategoryList( $categoryId, $type = 1 )
	{
		$CmsCategoryExtra = Core::ImportExtra( 'CmsCategory' );
		$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );

		$info = $CmsCategoryModel->Get( $categoryId );

		if ( !$info )
			return array();
		else
			return $CmsCategoryExtra->Explain( $CmsCategoryModel->GetOneChildList( $info['pid'] ) );
	}

	function SetCategoryMenuList()
	{
		$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );
		$CmsCategoryExtra = Core::ImportExtra( 'CmsCategory' );

		$list = $CmsCategoryModel->GetTwoLevelList( 1 );

		foreach ( $list as $key => $val )
		{
			$list[$key] = $CmsCategoryExtra->ExplainOne( $val );

			if ( $val['child_list'] )
			{
				foreach ( $val['child_list'] as $k => $v )
				{
					$list[$key]['child_list'][$k] = $CmsCategoryExtra->ExplainOne( $v );
				}
			}
		}

		return $list;
	}

	function SetProductList( $categoryId, $num = 10 )
	{
		$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );
		$CmsCategoryModel->BuildTree( 1 );

		$categoryIdList = $CmsCategoryModel->GetChildID( $categoryId );
		@array_unshift( $categoryIdList, $categoryId );

		if ( !$categoryIdList )
			return array();

		$CmsProductModel = Core::ImportModel( 'CmsProduct' );
		$list = $CmsProductModel->GetSearchList( implode( ',', $categoryIdList ), 0, array(), '', 3, 0, 0, 0, 0, $num );

		$ProductExtra = Core::ImportExtra( 'Product' );
		return $ProductExtra->Explain( $list );
	}
}

?>