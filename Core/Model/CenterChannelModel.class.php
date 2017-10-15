<?php

class CenterChannelModel
{
	function Init()
	{
		$this->Model = Core::ImportBaseClass( 'Model' );
	}

	function Add( $data )
	{
		$this->Model->Add( array( 'table' => 'shopcenter_channel', 'data' => $data ) );
		return $this->Model->DB->LastID();
	}

	function Get( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_channel';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Get( $cfg );
	}

	function Update( $id, $data )
	{
		return $this->Model->Update( array( 'table' => 'shopcenter_channel', 'data' => $data, 'condition' => array( 'id' => $id ) ) );
	}

	function GetList( $offset = 0, $limit = 0 )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_channel';
		$cfg['order'] = "name ASC";
		$cfg['offset'] = $offset;
		$cfg['limit'] = $limit;
		$cfg['key'] = 'id';
		$cfg['order'] = 'px';
		$cfg['conditionExt'] =  'id>0 AND parent_id > 0';

		return $this->Model->GetList( $cfg );
	}

	function GetTotal()
	{
		$condition = array();

		$cfg = array();
		$cfg['table'] = 'shopcenter_channel';
		$cfg['select'] = "COUNT(*) AS total";
		$cfg['key'] = 'total';
		$cfg['conditionExt'] =  'id>0 AND parent_id > 0';

		return $this->Model->Get( $cfg );
	}

	function Del( $id )
	{
		$cfg = array();
		$cfg['table'] = 'shopcenter_channel';
		$cfg['condition'] = array( 'id' => $id );

		return $this->Model->Del( $cfg );
	}
}

?>