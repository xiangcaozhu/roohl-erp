<?php

class TemplatePlugin
{	
	function TemplatePlugin()
	{
		
	}

	function Parse( $content, $compiler )
	{
		$this->compiler = $compiler;

		$content = $this->ProcessPattern( $content );

		return $content;
	}

	function ProcessPattern( $content )
	{
		$patternList = array(
			array(
				'find' => '/<!--(?:\s+)IMPORT(?:\s*)(.+?)(?:\s+)-->/',
				'replace' => 'ImportTemplate',
			)
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
							$argList[$k] = $this->compiler->ProccessVARS( $arg );
						}
					}

					$var = $this->compiler->ProccessVARS( $rs[2][$key] );

					$phpCode = "<?p" . "hp {$var} TemplatePlugin::" . $pattern['replace'] . "( ". implode( $argList, ',' ) ." );?" . ">";

					$content = str_replace( $rs[0][$key], $phpCode, $content );
				}
			}
		}

		return $content;
	}

	function ImportTemplate( $path )
	{
		$Template = Core::ImportBaseClass( "Template" );

		$tpl = $Template;
		$tpl->ST( Core::GetConfig( 'template_path' ) . $path);
		$tpl->OP();
	}
}

?>