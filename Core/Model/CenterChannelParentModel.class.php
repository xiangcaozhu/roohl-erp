<?php

class CenterChannelParentModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_channel_parent', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_channel_parent';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_channel_parent', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function GetList( $offset = 0, $limit = 0 )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_channel_parent';
		//$cfg['order'] = "name ASC";
		$cfg['condition'] = array( 'display' => 1 );
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';

		return $this->Model->GetList( $cfg );
	}

	function GetTotal()
	{
		$condition = array();

		$cfg = array();
		$cfg['table'] = 'shopcenter_channel_parent';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['condition'] = array( 'display' => 1 );
		$cfg['key'] = 'total';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_channel_parent';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}
}

?>