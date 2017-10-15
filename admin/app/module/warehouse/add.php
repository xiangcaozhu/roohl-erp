<?php
/*
@@acc_freet
*/	
	if( !$_POST )
	{
		Common::PageOut( 'warehouse/add.html', $tpl );
	}
	else
	{
		$CenterWarehouseModel = Core::ImportModel( 'CenterWarehouse' );

		$data = array();
		
		$data['name'] = $_POST['name'];

		$warehouseInfo = $CenterWarehouseModel->Add($data);
		if( !$warehouseInfo )
			Common::Alert('���ʧ�ܣ�����ϵ����Ա��');

		else
			Redirect( '?mod=warehouse.add' );
		
	}

?>