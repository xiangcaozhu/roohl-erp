<?php
	
	if( !$_POST )
	{
		Common::PageOut( 'system/channel/add.html', $tpl );
	}
	else
	{
		$CenterChannelModel = Core::ImportModel( 'CenterChannel' );

		$data = array();
		
		$data['name'] = $_POST['name'];

		$channelInfo = $CenterChannelModel->Add($data);
		if( !$channelInfo )
			Common::Alert('���ʧ�ܣ�����ϵ����Ա��');

		else
			Redirect( '?mod=system.channel' );
		
	}

?>