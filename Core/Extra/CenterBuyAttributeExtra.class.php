<?php

class CenterBuyAttributeExtra
{
	var $productCollector = array();
	var $PackageSetting = array();
	var $PackageIndex = array();

	function CenterBuyAttributeExtra()
	{
		
	}

	function Parse( $attribute )
	{
		$attribute = unserialize( $attribute );

		if ( !is_array( $attribute ) )
			return '';

		$parseList = array();
		foreach ( $attribute as $aid => $val )
		{
			$aInfo = $this->GetAttribute( $aid );

			if ( $aInfo['type'] == 'text' )
			{
				$parseList[] = "{$val['name']}:{$val['value']['input']}";
			}
			elseif ( $aInfo['type'] == 'textgroup' && is_array( $val['value'] ) )
			{
				
				$p = array();
				foreach ( $val['value'] as $v )
				{
					$p[] = "{$v['name']}:" . $v['input'];
				}

				$parseList[] = "{$val['name']}:(" . implode( ',', $p ) . ')';
			}
			else
			{
				$parseList[] = "{$val['name']}:{$val['value']['name']}";
			}
		}

		return implode( ',', $parseList );
	}

	function ParseSkuAttribute( $attribute )
	{
		$attribute = unserialize( $attribute );

		if ( !is_array( $attribute ) )
			return '';

		$parseList = array();
		foreach ( $attribute as $aid => $val )
		{
			$aInfo = $this->GetAttribute( $aid );

			if ( $aInfo['type'] == 'text' )
			{
				$parseList[] = "{$aInfo['name']}:{$val['input']}";
			}
			elseif ( $aInfo['type'] == 'textgroup' && is_array( $val ) )
			{
				
				$p = array();
				foreach ( $val['value'] as $v )
				{
					$p[] = "{$v['name']}:{$val['input']}";
				}

				$parseList[] = "{$aInfo['name']}:(" . implode( ',', $p ) . ')';
			}
			else
			{
				$vInfo = $this->GetValue( $val['vid'] );

				$parseList[] = "{$aInfo['name']}:{$vInfo['name']}";
			}
		}

		return implode( ',', $parseList );
	}


	function ParseSkuAttribute_toID( $attribute )
	{
		$attribute = unserialize( $attribute );

		if ( !is_array( $attribute ) )
			return '';

		$parseList = array();
		foreach ( $attribute as $aid => $val )
		{
			$aInfo = $this->GetAttribute( $aid );

			if ( $aInfo['type'] == 'text' )
			{
				$parseList[] = "{$aInfo['name']}:{$val['input']}";
			}
			elseif ( $aInfo['type'] == 'textgroup' && is_array( $val ) )
			{
				
				$p = array();
				foreach ( $val['value'] as $v )
				{
					$p[] = "{$v['name']}:{$val['input']}";
				}

				$parseList[] = "{$aInfo['name']}:(" . implode( ',', $p ) . ')';
			}
			else
			{
				$vInfo = $this->GetValue( $val['vid'] );

				$parseList[] = "{$vInfo['service']}";
			}
		}

		return implode( ',', $parseList );
	}
	

	function ParseSkuAttribute_1( $attribute )
	{
		$attribute = unserialize( $attribute );

		if ( !is_array( $attribute ) )
			return '';

		$parseList = array();
		foreach ( $attribute as $aid => $val )
		{
			$aInfo = $this->GetAttribute( $aid );

			if ( $aInfo['type'] == 'text' )
			{
				$parseList[] = "{$val['input']}";
			}
			elseif ( $aInfo['type'] == 'textgroup' && is_array( $val ) )
			{
				
				$p = array();
				foreach ( $val['value'] as $v )
				{
					$p[] = "{$val['input']}";
				}

				$parseList[] = "(" . implode( ',', $p ) . ')';
			}
			else
			{
				$vInfo = $this->GetValue( $val['vid'] );

				$parseList[] = "{$vInfo['name']}";
			}
		}

		return implode( ',', $parseList );
	}
	


	function ParseSkuAttribute_2( $attribute )
	{
		$attribute = unserialize( $attribute );

		if ( !is_array( $attribute ) )
			return '';

		$parseList = array();
		foreach ( $attribute as $aid => $val )
		{
			$aInfo = $this->GetAttribute( $aid );

			if ( $aInfo['type'] == 'text' )
			{
				$parseList[] = "{$val['input']}";
			}
			elseif ( $aInfo['type'] == 'textgroup' && is_array( $val ) )
			{
				
				$p = array();
				foreach ( $val['value'] as $v )
				{
					$p[] = "{$val['input']}";
				}

				$parseList[] = "(" . implode( ',', $p ) . ')';
			}
			else
			{
				$vInfo = $this->GetValue( $val['vid'] );

				$parseList[] = "{$vInfo['service']}";
			}
		}

		return implode( ',', $parseList );
	}
	
	
	function ParseSkuAttribute_3( $attribute )
	{
		$attribute = unserialize( $attribute );

		if ( !is_array( $attribute ) )
			return '';

		//$parseList = array();
		foreach ( $attribute as $aid => $val )
		{
		$parseList = '';
		$parseList = $val['vid'];
		}
		//echo $parseList . 'kkkkkkkkkkkkk';

		return $parseList;
	}		
	
	function GetAttribute( $id )
	{
		$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );

		if ( $this->attributeList[$id] )
			return $this->attributeList[$id];

		$info = $CenterBuyAttributeModel->Get( $id );

		if ( $info )
		{
			$this->attributeList[$id] = $info;
			return $info;
		}

		return array();
	}

	function GetValue( $id )
	{
		$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );

		if ( $this->valueList[$id] )
			return $this->valueList[$id];

		$info = $CenterBuyAttributeModel->GetValue( $id );

		if ( $info )
		{
			$this->valueList[$id] = $info;
			return $info;
		}

		return array();
	}

	function GetValueList( $aid )
	{
		$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );

		if ( $this->attributeValueList[$aid] )
			return $this->attributeValueList[$aid];

		$list = $CenterBuyAttributeModel->GetValueListByAid( $aid );

		if ( $list )
		{
			$this->attributeValueList[$aid] = $list;
			return $list;
		}

		return array();
	}

	function ListProcess( $frontAttributeList, $frontAttributeValueList )
	{
		$buyAttributeList = array();

		if ( $frontAttributeList )
		{
			foreach ( $frontAttributeList as $key => $val )
			{
				$buyAttributeList[$key] = $val;
				$buyAttributeList[$key]['id'] = $key;
				
				if ( $attributeValueList = $frontAttributeValueList[$key] )
				{
					foreach ( $attributeValueList as $k => $v )
					{
						$buyAttributeList[$key]['value_list'][$k] = $v;
						$buyAttributeList[$key]['value_list'][$k]['id'] = $k;
						$buyAttributeList[$key]['value_list'][$k]['about_disabled'] = $v['about'];

						if ( $val['type'] == 'color' )
							$buyAttributeList[$key]['value_list'][$k]['content'] = $v['color'];
						elseif ( $val['type'] == 'image' )
							$buyAttributeList[$key]['value_list'][$k]['content'] = 'image';

						// 处理图片...移至前端
					}
				}

				if ( $val['type'] != 'text' && !count( $buyAttributeList[$key]['value_list'] ) )
				{
					unset( $buyAttributeList[$key] );
				}
			}
		}

		return $buyAttributeList;
	}

	function ListUpdate( $buyAttributeList, $pid = 0, $tid = 0 )
	{
		$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );

		/******** 加入购买属性 ********/
		$valueIndexList = array();
		$attributeIndexList = array();
		foreach ( $buyAttributeList as $index => $val )
		{
			$data = array();
			$data['pid'] = $pid;
			$data['name'] = NoHtml( $val['name'] );
			$data['type'] = NoHtml( $val['type'] );
			$data['order_id'] = intval( $val['order'] );
			$data['hidden'] = intval( $val['hidden'] );
			$data['required'] = intval( $val['required'] );
			$data['disable'] = intval( $val['disable'] );
			$data['description'] = NoHtml( $val['description'] );
			$data['switch_title'] = NoHtml( $val['switch_title'] );
			$data['tid'] = $tid;
			
			//$data['service'] = intval( $val['service'] );

			if ( $val['type'] == 'text' )
			{
				$data['length'] = $val['length'];
				$data['append_price'] = $val['append_price'];
			}

			// 负数的index表示为新加的属性
			if ( $index < 0 )
			{
				$aid = $CenterBuyAttributeModel->Add( $data );
				$attributeIndexList[$index] = $aid;
			}
			else
			{
				$aid = $index;
				$CenterBuyAttributeModel->Update( $aid, $data );
			}

			if ( $val['type'] == 'text' )
				continue;
			
			foreach ( $val['value_list'] as $idx => $v )
			{
				$data = array();
				$data['pid'] = $pid;
				$data['aid'] = $aid;
				$data['name'] = NoHtml( $v['name'] );
				$data['order_id'] = intval( $val['order'] );
				$data['append_price'] = $v['append_price'];
				$data['hidden'] = intval( $v['hidden'] );
				$data['length'] = intval( $v['length'] );
				$data['required'] = intval( $v['required'] );
				
				$data['service'] =  $v['service'] ;

				if ( $val['type'] == 'color' )
					$data['content'] = $v['color'];
				elseif ( $val['type'] == 'image' )
					$data['content'] = 'image';

				// 负数表示新加属性值
				if ( $idx < 0 )
				{
					$vid = $CenterBuyAttributeModel->AddValue( $data );
					$valueIndexList[$idx] = $vid;
				}
				else
				{
					$vid = $idx;
					$CenterBuyAttributeModel->UpdateValue( $vid, $data );
				}

				// 处理图片...移至前端
			}
		}

		/******** 更新购买属性 ********/
		// 更新about...switch...移至前端
	}

	function GetGroup( $pid, $tid = 0, $templateOffset = 0 )
	{
		$CenterBuyAttributeModel = Core::ImportModel( 'CenterBuyAttribute' );
		
		if ( $pid )
			$buyAttributeList = $CenterBuyAttributeModel->GetList( $pid );
		else
			$buyAttributeList = $CenterBuyAttributeModel->GetList( 0, $tid );

		$buyAttributeList = ArrayIndex( $buyAttributeList, 'id' );

		$buyAttributeValueGroup = array();

		if ( $pid )
		{
			$buyAttributeValueList = $CenterBuyAttributeModel->GetValueListByPid( $pid );
			$buyAttributeValueGroup = ArrayGroup( $buyAttributeValueList, 'aid' );
		}
		else
		{
			foreach ( $buyAttributeList as $val )
			{
				$buyAttributeValueGroup[$val['id']] = $CenterBuyAttributeModel->GetValueListByAid( $val['id'] );
			}
		}

		// 货币
		//$currency = Common::GetCurrency();
		$currency = array();
		$currency['scale']  = 1;

		foreach ( $buyAttributeList as $key => $val )
		{
			$buyAttributeList[$key]['id'] = $templateOffset == 0 ? $val['id'] : $templateOffset - $val['id'];

			if ( $val['switch'] )
			{
				$switchIdList = explode( ',', $val['switch'] );
				$switchIndexList = array();
				$switchNameList = array();

				foreach ( $switchIdList as $switchId )
				{
					$switchIndex = $templateOffset == 0 ? $switchId : $templateOffset - $switchId;
					$switchIndexList[] = $switchIndex;
					$switchNameList[] = array( 'id' => $switchIndex , 'name' => $buyAttributeList[$switchId]['name'] );
				}

				$buyAttributeList[$key]['switch'] = implode( ',', $switchIndexList );
				$buyAttributeList[$key]['switch_list'] = $switchNameList;
				$buyAttributeList[$key]['append_price_s'] = $val['append_price'];
				$buyAttributeList[$key]['append_price'] = FormatMoney( $val['append_price'] * $currency['scale'] );
			}

			if ( !$buyAttributeValueGroup[$val['id']] )
				continue;

			foreach ( $buyAttributeValueGroup[$val['id']] as $v )
			{
				$tmp = $v;

				$tmp['id'] = $templateOffset == 0 ? $v['id'] : $templateOffset - $v['id'];

				if ( $templateOffset !=0 )
				{
					if ( $v['about_disabled'] )
					{
						$aboutList = explode( ',', $v['about_disabled'] );
						for ( $i = 0, $len = count( $aboutList ); $i < $len; $i++ )
						{
							$aboutList[$i] = $templateOffset - $aboutList[$i];
						}

						$tmp['about_disabled'] = implode( ',', $aboutList );
					}

					if ( $val['type'] == 'image' )
						$tmp['file_path'] = Common::GetAttributeImagePath( $v['id'], 2 );
				}

				if ( $val['type'] == 'image' )
					$tmp['list_url'] = Common::GetAttributeImageUrl( $v['id'], 1 );

				$tmp['append_price_s'] = $v['append_price'];
				$tmp['append_price'] = FormatMoney( $v['append_price'] * $currency['scale'] );

				$buyAttributeList[$key]['value_list'][$tmp['id']] = $tmp;
			}
		}

		return $buyAttributeList;
	}
}

?>