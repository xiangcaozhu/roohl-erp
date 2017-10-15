<?php


class ShipPay
{
	function GetShipPay( $first, $second, $third, $weight, $shipType = 1 )
	{
		$toType = Core::GetConfig( 'ship_type' );

		if ( $toType == 'foreign' )
		{
			if ( $shipType == 1 )
				return $this->GetShipPayExpress( $first, $second, $weight );
			elseif ( $shipType == 2 )
				return $this->GetShipPayEms( $first, $second, $weight );
		}
		elseif ( $toType == 'china' )
		{
			if ( $shipType == 1 )
				return $this->GetShipPayExpressChina( $first, $second, $weight );
			elseif ( $shipType == 2 )
				return $this->GetShipPayEmsChina( $weight );
		}
	}

	function GetShipPayExpressChina( $first, $second, $weight )
	{
		if ( $first == 1 )
		{
			$firstWeight = 5;
		}
		else
		{
			$firstWeight = 15;
		}

		$cost = 0;
		if ( $weight <= 0 )
			return $cost;
			
		$weight = round( $weight * 1000 , 9 ); // 克

		if ( $weight > 1000 )
			$cost = $firstWeight + ceil( ( $weight - 1000 ) / 1000 ) * 5;
		else
			$cost = $firstWeight;

		return FormatMoney( $cost );
	}

	function GetShipPayEmsChina( $weight )
	{
		$cost = 0;
		if ( $weight <= 0 )
			return $cost;
		
		$weight = round( $weight * 1000 , 9 ); // 克

		if ( $weight > 500 )
			$cost = 22 + ceil( ( $weight - 500 ) / 500 ) * 20;
		else
			$cost = 22;

		return FormatMoney( $cost );
	}

	function GetShipPayExpress( $first, $second, $weight )
	{
		$weight = $weight;

		$UserModel = Core::ImportModel( 'User' );

		$country = $UserModel->GetCountry( $first );
		$upsZone = $country['ups_zone'] ? $country['ups_zone'] : 9;

		$cost = 0;

		if ( $weight <= 0 )
			return $cost;

		if ( $weight > 70 )
		{
			$config = '1:61.00:4760.00;2:82.00:6370.00;3:85.00:6510.00;4:94.00:7000.00;5:120.00:8750.00;6:138.00:10150.00;7:143.00:10710.00;8:245.00:17360.00;9:247.00:17430.00;';

			$rateListTmp = explode( ';', $config );
			$rateList = array();

			foreach ( $rateListTmp as $val )
			{
				$rate = explode( ':', $val );

				if( count( $rate ) == 3 )
					$rateList[] = array( 'zone' => $rate[0], 'price_per_kg' => $rate[1], 'lowest_price' => $rate[2] );
			}

			foreach ( $rateList as $val )
			{
				if ( $upsZone == $val['zone'] )
				{
					$cost = $val['price_per_kg'] * $weight;
					$cost = $cost < $val['lowest_price'] ? $val['lowest_price'] : $cost;
					$cost = $cost * 0.648 /  6.8;
				}
			}
		}
		else
		{
			$ShipModel = Core::ImportModel( 'Ship' );

			$upsInfo = $ShipModel->GetUpsInfo( $weight );

			$pay = $upsInfo['dq' . $upsZone];

			$cost = $pay * 0.648 /  6.8;
		}

		return FormatMoney( $cost );
	}

	function GetShipPayEms( $first, $second, $weight )
	{
		$UserModel = Core::ImportModel( 'User' );

		$country = $UserModel->GetCountry( $first );
		$emsZone = $country['ems_zone'] ? $country['ems_zone'] : 10;
		
		$config = "1:150.00:30.00;2:180.00:40.00;3:190.00:45.00;4:210.00:55.00;5:280.00:75.00;6:240.00:75.00;7:325.00:90.00;8:335.00:100.00;9:445.00:120.00;10:445.00:120.00;11:130.00:40.00";
		$emsZoneRateTmp = explode( ';', $config );
		$emsZoneRate = array();

		foreach ( $emsZoneRateTmp as $val )
		{
			$rate = explode( ':', $val );

			if( count( $rate ) == 3 )
				$emsZoneRate[] = array( 'ems_zone' => $rate[0], 'first_500_g' => $rate[1], 'additional_per_500_g' => $rate[2] );
		}

		$cost = 0;
		if ( $weight <= 0 )
			return $cost;
		
		$weight = round( $weight * 1000 , 9 ); // 克
		
      		for ( $i = 0,$n = sizeof( $emsZoneRate ); $i < $n ; $i++ )
		{
			if( $emsZoneRate[$i]['ems_zone'] == $emsZone )
			{
				if ( $weight > 500 )
					$cost = $emsZoneRate[$i]['first_500_g'] + ceil( ( $weight - 500 ) / 500 ) * $emsZoneRate[$i]['additional_per_500_g'];
				else
					$cost = $emsZoneRate[$i]['first_500_g'];

				$cost = $cost * 0.648 /  6.8;

				break;
	          	}
		}

		return FormatMoney( $cost );
	}
}

?>