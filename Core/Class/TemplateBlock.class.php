<?php

class TemplateBlock
{
	function TemplateBlock()
	{

	}

	function Parse( $content, $compiler )
	{
		$content = $this->ProcessCategoryBlock( $content, $compiler );
		$content = $this->ProcessProductBlock( $content, $compiler );
		$content = $this->ProcessBlock( $content, $compiler );

		return $content;
	}

	function ProcessCategoryBlock( $content, $compiler )
	{
		if ( preg_match_all( '/<!--(?:\s+)CategoryBlock(?:\s*)\((.+?)\)(?:\s+)AS(?:\s+)([a-zA-Z_0-9]+)(?:\s+)-->/', $content, $rs ) )
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

				$phpCode = "<?p" . "hp {$var} = TemplateBlock::SetBlockCategory( {$argList[0]}, {$argList[1]}" . ( $argList[2] ? ", {$argList[2]}" : '' ) . " );?" . ">";

				$content = str_replace( $rs[0][$key], $phpCode, $content );
			}
		}

		return $content;
	}

	function ProcessBlock( $content, $compiler )
	{
		if ( preg_match_all( '/<!--(?:\s+)Block(?:\s*)\((.+?)\)(?:\s+)AS(?:\s+)([a-zA-Z_0-9]+)(?:\s+)-->/', $content, $rs ) )
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

				$phpCode = "<?p" . "hp {$var} = TemplateBlock::SetBlock( {$argList[0]}" . ( $argList[1] ? ", {$argList[1]}" : '' ) . " );?" . ">";

				$content = str_replace( $rs[0][$key], $phpCode, $content );
			}
		}


		return $content;
	}

	function ProcessProductBlock( $content, $compiler )
	{
		if ( preg_match_all( '/<!--(?:\s+)ProductBlock(?:\s*)\((.+?)\)(?:\s+)AS(?:\s+)([a-zA-Z_0-9]+)(?:\s+)-->/', $content, $rs ) )
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

				$phpCode = "<?p" . "hp {$var} = TemplateBlock::SetBlockProduct( {$argList[0]}, {$argList[1]}" . ( $argList[2] ? ", {$argList[2]}" : '' ) . " );?" . ">";

				$content = str_replace( $rs[0][$key], $phpCode, $content );
			}
		}


		return $content;
	}

	function SetBlockCategory( $categoryId, $blockName, $num = 0 )
	{
		if ( !$categoryId )
			return array();
		
		$CmsCategoryModel = Core::ImportModel( 'CmsCategory' );
		$blockInfo = $CmsCategoryModel->GetBlockByName( $categoryId, $blockName );

		Core::LoadExtra( 'CmsBlock' );
		$CmsBlockExtra = new CmsBlockExtra();

		$list = $CmsBlockExtra->ParseContent( $blockInfo['content'], $blockInfo['pattern_id'] );

		if ( $num > 0 )
			return array_slice( $list, 0, $num, true );
		else
			return $list;
	}

	function SetBlockProduct( $cmsProductId, $blockName, $num = 0 )
	{
		if ( !$cmsProductId )
			return array();

		$CmsProductModel = Core::ImportModel( 'CmsProduct' );
		$blockInfo = $CmsProductModel->GetBlockByName( $cmsProductId, $blockName );

		Core::LoadExtra( 'CmsBlock' );
		$CmsBlockExtra = new CmsBlockExtra();

		$list = $CmsBlockExtra->ParseContent( $blockInfo['content'], $blockInfo['pattern_id'] );

		if ( $num > 0 )
			return array_slice( $list, 0, $num, true );
		else
			return $list;
	}

	function SetBlock( $blockName, $num = 0 )
	{
		$CmsBlockModel = Core::ImportModel( 'CmsBlock' );
		$blockInfo = $CmsBlockModel->GetByEnName( $blockName );

		Core::LoadExtra( 'CmsBlock' );
		$CmsBlockExtra = new CmsBlockExtra();

		$list = $CmsBlockExtra->ParseContent( $blockInfo['content'], $blockInfo['pattern_id'] );

		if ( $num > 0 )
			return array_slice( $list, 0, $num, true );
		else
			return $list;
	}
}

?>