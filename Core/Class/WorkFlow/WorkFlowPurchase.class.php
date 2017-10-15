<?php

class WorkFlowPurchase
{
	var $flowName = 'Purchase';
/*
	var $flow = array(
		1 => array( 'name' => '待3C产品经理审核', 'group' => '14' ),
		2 => array( 'name' => '待非3C产品经理审核', 'group' => '15' ),
		3 => array( 'name' => '待业务总监审核', 'group' => '13' ),
		4 => array( 'name' => '待业务副总审核', 'group' => '16' ),
		5 => array( 'name' => '审核完成', 'group' => '' ),
	);
*/
	var $flow = array(
		0 => array( 'name' => '助理', 'group' => '12' ),
		1 => array( 'name' => '经理', 'group' => '13' ),
		2 => array( 'name' => '总监', 'group' => '14' ),
		3 => array( 'name' => '副总', 'group' => '15' ),
		4 => array( 'name' => '财务', 'group' => '16' ),
	);

	function WorkFlowPurchase( $userId, $groupId, $userName = '', $userJL = 0, $userZJ = 0 )
	{
		$this->userId = $userId;
		$this->groupId = $groupId;
		$this->userName = $userName;
		$this->userJL = $userJL;
		$this->userZJ = $userZJ;
	}

	function SetInfo( $purchaseInfo )
	{
		$this->info = $purchaseInfo;
	}

	function GetStatus()
	{
		return $this->flow[$this->info['workflow_status']]['name'];
	}

	function AllowDo()
	{
		$cfg = $this->flow[$this->info['workflow_status']];

		if ( $cfg['group'] )
			return true;
		else
			return false;
	}

	function GetFlowMoney( $Moneys )
	{
		$cfg = $this->flow[$this->info['workflow_status']];

		if ( $cfg['group'] )
			return true;
		else
			return false;
	}


	function GetFlowInfo()
	{
		$flowKey = false;
/*
		$newstatus = false;
		switch ( $this->info['workflow_status'] )
		{
			case 1:
				if ( $this->info['total_money'] >= $__Config['purchase_money'][0] )
					$flowKey = 2; // 产品总监
				else
					$flowKey = 5;

			break;

			case 2:
				if ( $this->info['total_money'] >= $__Config['purchase_money'][1] )
					$flowKey = 3; // 产品副总
				else
					$flowKey = 5;
			break;
			case 2:
				if ( $this->info['total_money'] >= ( 30 * 10000 ) )
					$flowKey = 4; // 业务副总
				elseif ( $this->info['total_money'] >= ( 6 * 10000 ) )
					$flowKey = 3; // 业务总监
				else
					$flowKey = 2;
			break;
			case 3:
				if ( $this->info['total_money'] >= $__Config['purchase_money'][1] )
					$flowKey = 4; // 产品副总
				else
					$flowKey = 5;
			break;
			case 4:
				$flowKey = 5;
			break;

			default:
			    $flowKey = 1;
			break;
		}

		if ( $flowKey == $this->info['workflow_status'] )
			$flowKey = false;
*/

		$data = array();
		global $__Config;

		switch (  $this->info['workflow_status'] )
		{
			case -1:
			    $data['status'] = 2;
				$data['user_group'] = $this->groupId;
				$data['sign_top_jl'] = $this->userJL;
				$data['sign_top_zj'] = $this->userZJ;

				//需要经理审核
				$data['sign_pro_mg'] = -1;

				//需要总监审核
				if ( $this->info['total_money'] >= $__Config['purchase_money'][0] )
				$data['sign_ope_mj'] = -1;
				
				if( $this->groupId == 14 )
				$data['sign_ope_mj'] = -1;
				
				//需要副总审核
				if ( $this->info['total_money'] >= $__Config['purchase_money'][1] )
				$data['sign_ope_vc'] = -1;

				if( $this->groupId == 15 )
				{
				$data['sign_ope_vc'] = -1;
				$data['sign_ope_mj'] = 0;
				}


				$flowKey = 1;
				
				
				
				
				//if( $this->groupId == 14 )
				//{
				//$flowKey = 2;
				//$data['sign_pro_mg'] = 0;
				//}
				
			break;
			case 1://产品经理确认
				$data['sign_pro_mg'] = $this->userId;
				$data['sign_pro_mg_name'] = $this->userName;
				$data['sign_pro_mg_time'] = time();
				
				$flowKey = 5;
				//$data['status'] = 3;
				
				if ( $this->info['sign_ope_vc'] < 0 )//需要副总审核
					{
					$flowKey = 3; // 流转至产品副总
					//$data['status'] = 2;
					}
				
				if ( $this->info['sign_ope_mj'] < 0 )//需要总监审核
					{
					$flowKey = 2; // 流转至产品总监
					//$data['status'] = 2;
					}
				
			break;

			case 2://产品总监确认
				$data['sign_ope_mj'] = $this->userId;
				$data['sign_ope_mj_name'] = $this->userName;
				$data['sign_ope_mj_time'] = time();
				
				if ( $this->info['sign_ope_vc'] < 0 )//需要副总审核
					{
					$flowKey = 3; // 流转至产品副总
					}
				else
					{
					$flowKey = 5;
					//$data['status'] = 3;
					}
					
			break;

			case 3://产品副总确认
				$data['sign_ope_vc'] = $this->userId;
				$data['sign_ope_vc_name'] = $this->userName;
				$data['sign_ope_vc_time'] = time();
				
				//$data['status'] = 3;
			    $flowKey = 5;
			break;
			default:
			    //$flowKey = 1;
			break;
		}

		$data['workflow_status'] = $flowKey;

		return array(
			'to' => $flowKey,
			'data' => $data,
		);
	}

	function NextFlow()
	{
		$toFlow = $this->GetFlowInfo();

		if ( $toFlow['to'] === false )
			return false;

		$toUserId = 0;
		$toGroupId = $this->flow[$toFlow['to']]['group'];
		$toGroupId = $toGroupId > 0 ? $toGroupId : 0;
		
		
		$CenterPurchaseModel = Core::ImportModel( 'CenterPurchase' );
		$CenterPurchaseModel->Update( $this->info['id'], $toFlow['data'] );

		$CenterWorkflowModel = Core::ImportModel( 'CenterWorkflow' );
		$CenterWorkflowModel->SetDel( $this->flowName, $this->info['id'], $this->info['workflow_status'] );

		global $__UserAuth;

		$data = array();
		$data['flow_name'] = $this->flowName;
		$data['flow_status'] = $toFlow['to'];
		$data['target_id'] = $this->info['id'];
		$data['user_id'] = $toUserId;
		$data['group_id'] = $toGroupId;
		$data['add_user_id'] = $this->userId;
		$data['add_time'] = time();
		$data['is_delete'] = 0;

		$CenterWorkflowModel->Add( $data );
	}

	function GetIntroTitle( $id )
	{
		return "<a href=\"?mod=purchase.view&id={$id}\">等待您审核的采购单</a>";
	}
}


?>