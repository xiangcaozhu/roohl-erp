<?php
/*
@@acc_title="出库单列表 list"
*/
$CenterDeliveryModel = Core::ImportModel( 'CenterDelivery' );
$CenterWarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );
$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$CenterDeliveryExtra = Core::ImportExtra( 'CenterDelivery' );

$channelList = $CenterChannelModel->GetList();


include( Core::Block( 'warehouse' ) );

$deliveryTypeList = Core::GetConfig( 'delivery_type' );

list( $page, $offset, $onePage ) = Common::PageArg( 10 );

if ( $_GET['excel'] )
{
	$offset = 0;
	$onePage = 0;
}

$search = array(
	'warehouse_id' => $warehouseId,
	'begin_time' => $_GET['begin_date'] ? strtotime( $_GET['begin_date'] . ' 00:00:00' ) : false,
	'end_time' => $_GET['end_date'] ? strtotime( $_GET['end_date'] . ' 23:59:59' ) : false,
	'order_id' => $_GET['order_id'],
	//'is_print' => 1,
	//'is_logistics' => 1,
);

$list = $CenterDeliveryModel->GetList( $search, $offset, $onePage );
$total = $CenterDeliveryModel->GetTotal( $search );

foreach ( $list as $key => $val )
{
	$list[$key]['add_time'] = DateFormat( $val['add_time'] );
	$list[$key]['is_print_time'] = DateFormat( $val['is_print_time'],'Y-m-d' ) . "<br>" .DateFormat( $val['is_print_time'], 'H:m:s' );
	$list[$key]['is_logistics_time'] = DateFormat( $val['is_logistics_time'],'Y-m-d' ) . "<br>" .DateFormat( $val['is_logistics_time'], 'H:m:s' );
	$list[$key]['warehouse_name'] = $warehouseList[$val['warehouse_id']]['name'];

	$list[$key]['type_name'] = $deliveryTypeList[$val['type']];

	$CenterDeliveryModel->StatTotal( $val['id'] );

	$deliveryProductList = $CenterWarehouseLogModel->GetList( $val['id'], 2 );
	$deliveryProductList = $CenterDeliveryExtra->ExplainProduct( $deliveryProductList );
	
	$AdminArray =  Core::ImportModel( 'Admin' ) -> GetAdministrator( $val['user_id'] );
	$list[$key]['user_name_zh'] = $AdminArray['user_real_name'] ;

	$list[$key]['list'] = $deliveryProductList;
}

if ( $_GET['excel'] )
{
	Core::LoadDom( 'CenterSku' );

	$excelList = array();
	foreach ( $list as $val )
	{
		$orderInfo = $CenterOrderModel->Get( $val['order_id'] );

		$orderInfo['channel_name'] = $channelList[$orderInfo['channel_id']]['name'];

		$tmp = $val;

		$t = array();

		if ( $val['list'] )
		{
			foreach ( $val['list'] as $inf )
			{
				$t[] = $inf['sku_info']['product']['name'];
				$t2[] = $inf['price'];
				$t3[] = $inf['comment'];
				//$t4[] = $inf['sku_id'];
			}
		}

	//	$tmp['product_sku_id'] = implode( "\n", $t4 );
		$tmp['product_name'] = implode( "\n", $t );
		$tmp['product_price'] = implode( "\n", $t2 );
		$tmp['product_comment'] = implode( "\n", $t3 );
		$tmp['channel_name'] = $orderInfo['channel_name'];
		$tmp['order_id'] = $orderInfo['id'];
		$tmp['order_shipping_address'] = $orderInfo['order_shipping_address'];
		$tmp['order_shipping_phone'] = $orderInfo['order_shipping_phone'];
		$tmp['order_shipping_mobile'] = $orderInfo['order_shipping_mobile'];
		$tmp['order_customer_card'] = $orderInfo['order_customer_card'];
		$tmp['order_shipping_name'] = $orderInfo['order_shipping_name'];
		$tmp['product_price'] = $orderInfo['product_price'];
		$tmp['product_comment'] = $orderInfo['product_comment'];


		$excelList[] = $tmp;
	}
	
	$header = array(
		'订单号' => 'order_id',
		'渠道' => 'channel_name',
		'全称' => 'product_name',
		'地址' => 'order_shipping_address',
		'收货人固定电话' => 'order_shipping_phone',
		'收货人手机' => 'order_shipping_mobile',
		'收货人证件号码' => 'order_customer_card',
		'收货人' => 'order_shipping_name',
		
	);


	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=\"" . DateFormat(time(), 'Y-m-d_H-i-s') . ".xls\"");
	header("Content-Transfer-Encoding:binary");
	echo ExcelXml( $header, $excelList );
	exit;
}

$tpl['list'] = $list;
$tpl['page'] = $page;
$tpl['total'] = $total;
$tpl['page_num'] = ceil( $total / $onePage );
$tpl['page_bar'] = Common::PageBar( $total, $onePage, $page );


Common::PageOut( 'delivery/list.html', $tpl );

?>