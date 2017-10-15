<?php

class CenterReceiveDom
{
	var $id = 0;

	function CenterReceiveDom( $info )
	{
		if ( is_array( $info ) )
		{
			$this->Init( $info );
		}
		else
		{
			$this->id = $info;
			$this->Init();
		}
	}

	function Init( $array = array() )
	{
		if ( is_array( $array ) && $array )
		{
			$this->id = $array['id'];

			foreach ( $array as $key => $val )
			{
				$this->info[$key] = $val;
			}
		}
		elseif ( $this->id )
		{
			$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );
			$info = $CenterReceiveModel->Get( $this->id );

			$info ? $this->Init( $info ) : null;
		}

		return true;
	}

	function UpdateStatus()
	{
		$CenterReceiveModel = Core::ImportModel( 'CenterReceive' );
		
		$statusNumInfo = $CenterReceiveModel->GetProductStatusNum( $this->id );

		if ( $statusNumInfo['total_into_quantity'] >= $this->info['total_quantity'] )
			$intoStatus = 3;
		elseif ( $statusNumInfo['total_into_quantity'] > 0 )
			$intoStatus = 2;
		else
			$intoStatus = 1;

		$CenterReceiveModel->Update( $this->id, array( 'into_status' => $intoStatus ) );
	}
}

?>