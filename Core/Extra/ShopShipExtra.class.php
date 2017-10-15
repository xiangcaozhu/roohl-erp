<?php

class ShopShipExtra
{
	function GetAreaName( $firstArea = '', $secondArea = '', $thirdArea = '' )
	{
		$shipType = Core::GetConfig( 'ship_type' );

		$firstAreaName = '';
		$secondAreaName = '';
		$thirdAreaName = '';

		$UserModel = Core::ImportModel( 'User' );

		if ( $shipType == 'china' )
		{
			if ( $firstArea )
			{
				$info = $UserModel->GetChinaCity( $firstArea );
				$firstAreaName = $info['name'];
			}

			if ( $secondArea )
			{
				$info = $UserModel->GetChinaCity( $secondArea );
				$secondAreaName = $info['name'];
			}

			if ( $thirdArea )
			{
				$info = $UserModel->GetChinaCity( $thirdArea );
				$thirdAreaName = $info['name'];
			}
		}
		else
		{
			if ( $firstArea )
			{
				$info = $UserModel->GetCountry( $firstArea );
				$firstAreaName = $info['name'];
			}

			if ( $secondArea )
			{
				$info = $UserModel->GetCountryZone( $secondArea );
				$secondAreaName = $info['name'];
			}
		}

		return array( $firstAreaName, $secondAreaName, $thirdAreaName );
	}
}

?>