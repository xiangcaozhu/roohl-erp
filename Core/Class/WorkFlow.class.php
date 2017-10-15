<?php

class WorkFlow
{
	var $Object;
	
	function WorkFlow( $name = '' )
	{
		global $__UserAuth;
		

		$this->userId = $__UserAuth['user_id'];
		$this->userName = $__UserAuth['user_real_name'];

		$AdminModel = Core::ImportModel( 'Admin' );
		$adminInfo = $AdminModel->GetAdministrator( $__UserAuth['user_id'] );
		$this->groupId = $adminInfo['user_group'];
		
		if( $adminInfo['user_group'] == 13 )
		{
		$this->userJL = $__UserAuth['user_id'];
		$this->userZJ = $adminInfo['user_product'];
		}
		elseif( $adminInfo['user_group'] == 14 )
		{
		$this->userJL = 0;
		$this->userZJ = $__UserAuth['user_id'];
		}
		else
		{
		$this->userJL = $adminInfo['user_product_1'];
		$this->userZJ = $adminInfo['user_product'];
		}
		

		if ( $name )
		{
			$className = "WorkFlow{$name}";
			include_once( "WorkFlow/{$className}.class.php" );

			$this->Object = new $className( $this->userId, $this->groupId, $this->userName, $this->userJL, $this->userZJ );
		}
	}

	function SetInfo($info)
	{
		return $this->Object->SetInfo( $info );
	}

	function NextFlow()
	{
		return $this->Object->NextFlow();
	}

	function GetStatus()
	{
		return $this->Object->GetStatus();
	}

	function AllowDo()
	{
		return $this->Object->AllowDo();
	}

	function GetList()
	{
		$AdminModel = Core::ImportModel( 'Admin' );
		$CenterWorkflowModel = Core::ImportModel( 'CenterWorkflow' );

		$list = $CenterWorkflowModel->GetList( $this->userId, $this->groupId );

		foreach ( $list as $key => $val )
		{
			$className = "WorkFlow{$val['flow_name']}";
			include_once( "WorkFlow/{$className}.class.php" );

			$object = new $className( false, false );

			$list[$key]['intro_title'] = $object->GetIntroTitle( $val['target_id'] );

			$adminInfo = $AdminModel->GetAdministrator( $val['add_user_id'] );
			$list[$key]['add_user'] = $adminInfo;
		}

		return $list;
	}
}


?>