<?php
$CenterDeliveryExtra = Core::ImportExtra( 'CenterDelivery' );

$CenterDeliveryModel = Core::ImportModel( 'CenterDelivery' );
$CenterWarehouseLogModel = Core::ImportModel( 'CenterWarehouseLog' );

$CenterChannelModel = Core::ImportModel( 'CenterChannel' );
$channelList = $CenterChannelModel->GetList();

$CenterOrderExtra = Core::ImportExtra( 'CenterOrder' );
$CenterOrderModel = Core::ImportModel( 'CenterOrder' );

$ActionLogModel = Core::ImportModel( 'ActionLog' );

include( Core::Block( 'warehouse' ) );

if ( !is_array( $_POST['delivery_id'] ) )
	Alert( '请选择至少一个单据' );



if ( $_POST['excel']==1 )
{

$excelList = array();

foreach ( $_POST['delivery_id'] as $deliveryId )
{
	$deliveryInfo = $CenterDeliveryModel->Get( $deliveryId );

	if ( !$deliveryInfo )
		Alert( '没有找到出库单信息,出库单号:' . $deliveryId );

	$deliveryProductList = $CenterWarehouseLogModel->GetList( $deliveryId, 2 );

	if ( !$deliveryProductList )
		Alert( '没有找到出库单产品信息,订单号:' . $deliveryId );

//Core::LoadDom( 'CenterSku' );
$delivery_order_list = explode(',',$deliveryInfo['order_ids']);

foreach ( $delivery_order_list as $val ) 
	{
		$serviceCheckList = $ActionLogModel->GetList_98( $val, 'order_check_service' );
	
	$orderComment = '';
	foreach ( $serviceCheckList as $key_b => $val_b )
	{
	$orderComment .= $val_b['comment'].' / ';
	}

		
		
		$orderInfo = $CenterOrderModel->Get( $val );
		$channel_name = $channelList[$orderInfo['channel_id']]['print_name'];
		//$productList = $CenterOrderModel->GetProductList( $val );
		$productList = $CenterOrderModel->GetProductList( $val );
	    $productList = $CenterOrderExtra->ExplainProduct( $productList );
		foreach ( $productList as $v )
		{
			$Erp_S = $CenterOrderModel->GetErpSKU($v['sku_id'] );
			$excelList_one = array(
				'delivery_id' => $deliveryId,	
				'order_id' => $val,	
				'channel_name' => $channel_name,
				'channel_sn' => $orderInfo['target_id'],
				'channel_product_id' => $v['target_id'],	
				//'product_id' => $v['sku_info']['product']['id'],	
				'product_sku' => $v['sku'],	
				'product_name' => $v['sku_info']['product']['name'],	
				'product_attribute' => $v['sku_info']['attribute'],	
				'product_quantity' => $v['quantity'],
				'product_price' => $v['price']* $v['quantity'],	
				'order_shipping_name' => $orderInfo['order_shipping_name'],	
				'order_shipping_phone' => $orderInfo['order_shipping_phone'],
				'order_shipping_mobile' => $orderInfo['order_shipping_mobile'],
				'order_shipping_address' => $orderInfo['order_shipping_address'],
				
				'order_shipping_pssj' => $orderInfo['order_shipping_pssj'],
				'order_shipping_bj' => $orderInfo['order_shipping_bj'],
				//'order_invoice_header' => $orderInfo['order_invoice_header'],
				'logistics_sn' => $orderInfo['logistics_sn'],
				'status' => $orderInfo['status'],
				//'order_sj_header' => $orderInfo['order_sj_status'],
				'order_comment' => $orderComment,
			'product_payout_rate' => $v['payout_rate'],
			'product_coupon_price' => $v['coupon_price'],
			'product_payout' => FormatMoney( $v['price'] * $v['payout_rate'] ),
			'product_pay' => FormatMoney( $v['price'] - ( $v['price'] * $v['payout_rate'] ) ),
			'erp_sku' => $Erp_S,	

			);
			if( (int)$orderInfo['order_sj']>0)
			    $excelList_one['order_sj_header'] = $orderInfo['order_invoice_header'] ;
			else
			    $excelList_one['order_sj_header'] = '' ;
			
			if( (int)$orderInfo['order_invoice']>0)
			    $excelList_one['order_invoice_header'] = $orderInfo['order_invoice_header'] ;
			else
			    $excelList_one['order_invoice_header'] = '' ;
				
			$excelList[] = $excelList_one ;
			
			
			
			
		}
		
/*				
		foreach ( $order_productList as $val ) 
	    {

		$tmp = array();

		$t = array();
		if ( $val['list'] )
		{
			foreach ( $val['list'] as $inf )
			{
				$t[] = $inf['sku_info']['product']['name'];
				$t2[] = $inf['price'];
				$t3[] = $inf['comment'];
			}
		}
		//$tmp['product_name'] = implode( "\n", $t );
		//$tmp['product_price'] = implode( "\n", $t2 );
		//$tmp['product_comment'] = implode( "\n", $t3 );
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

*/




	
	}
















	//$deliveryProductList = $CenterDeliveryExtra->ExplainProduct( $deliveryProductList );

	//$deliveryInfo['list'] = $deliveryProductList;
	
	//$list[] = $deliveryInfo;
	
	// 更新导出状态
	$upData = array(
	'is_logistics' => 1,
	'is_logistics_time' => time(),
	);
	$CenterDeliveryModel->Update( $deliveryId, $upData );

}

	

	$header = array(
		'出库单号' => 'delivery_id',
		'订单号' => 'order_id',
		'银行单号' => 'channel_sn',
		'商户' => 'channel_name',
		'银行编号' => 'channel_product_id',
		'商品SKU' => 'product_sku',
		'商品名称' => 'product_name',
		'属性' => 'product_attribute',
		'数量' => 'product_quantity',
		'收货人' => 'order_shipping_name',
		'收货人固定电话' => 'order_shipping_phone',
		'收货人手机' => 'order_shipping_mobile',
		'地址' => 'order_shipping_address',
		
		'配送时间要求' => 'order_shipping_pssj',
		'发票抬头' => 'order_invoice_header',
		'收据抬头' => 'order_sj_header',
		'商品价格' => 'product_price',
		'商品价值' => 'order_shipping_bj',
		'快递单号' => 'logistics_sn',
		'状态' => 'status',
		'客服备注' => 'order_comment',
		'费率' => 'product_payout_rate',
		'手续费' => 'product_payout',
		'优惠券' => 'product_coupon_price',
		'结算金额' => 'product_pay',
		'ERP_SKU' => 'erp_sku',

	);

$fileName = DateFormat(time(), 'Y-m-d_H-i-s') . ".xls";
/*

outExcel($header=array(), $excelList=array(), $fileName, $mergeList = array(),1);
*/
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type:application/force-download");
	header("Content-Type:application/vnd.ms-execl");
	header("Content-Type:application/octet-stream");
	header("Content-Type:application/download");
	header("Content-Disposition:attachment;filename=\"" . DateFormat(time(), 'Y-m-d_H-i-s') . ".xls\"");
	header("Content-Transfer-Encoding:binary");
	echo ExcelXml( $header, $excelList, 'order_id', array() );
	exit;

}
else
{

$list = array();

foreach ( $_POST['delivery_id'] as $deliveryId )
{
	$deliveryInfo = $CenterDeliveryModel->Get( $deliveryId );

	if ( !$deliveryInfo )
		Alert( '没有找到出库单信息,出库单号:' . $deliveryId );

	$deliveryProductList = $CenterWarehouseLogModel->GetListGroup( $deliveryId, 2 );

	if ( !$deliveryProductList )
		Alert( '没有找到出库单产品信息,订单号:' . $deliveryId );

	$deliveryProductList = $CenterDeliveryExtra->ExplainProduct( $deliveryProductList );

	$deliveryInfo['list'] = $deliveryProductList;
	
	$list[] = $deliveryInfo;
	
	// 更新打印状态
	$upData = array(
	'is_print' => 1,
	'is_print_time' => time(),
	);

		$CenterDeliveryModel->Update( $deliveryId, $upData);


}

$tpl['list'] = $list;
Common::PageOut( 'delivery/print/delivery.html', $tpl, false, false );
exit();
}
?>