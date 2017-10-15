<?php

$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '系统首页',
	'path' => 'index',
	'end' => 1
);

$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '商品中心',
	'sub' => array(
		array( 
			'name' => '商品列表',
			'path' => 'product.list'
		),
		array( 
			'name' => '添加商品',
			'path' => 'product.add'
		),
		array( 
			'name' => '商品导入',
			'path' => 'product.import'
		),
		array( 
			'name' => '分类管理',
			'path' => 'product.category',
		),
		array(
			'name' => '品牌管理',
			'path' => 'product.brand.list'
		),
		array(
			'name' => '供应商管理',
			'path' => 'purchase.supplier'
		),

	)
);

$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '渠道销售',
	'sub' => array(
		array( 
			'name' => '渠道销售商品信息表',
			'path' => 'product.collate',
		),
		array(
			'name' => '渠道销售商品信息表导入',
			'path' => 'product.import_collate'
		),
		array(
			'name' => '渠道销售商品信息完善',
			'path' => 'product.up_collate'
		),
		array( 
			'name' => '建行销售商品信息表',
			'path' => 'product.bank&channel_id=60',
		),
	)
);
$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '采购管理',
	'sub' => array(
		array( 
			'name' => '常规采购',
			'path' => 'purchase.general'
		),
		array(
			'name' => '按需采购',
			'path' => 'purchase.need'
		),
		array( 
			'name' => '格兰仕独立采购',
			'path' => 'purchase.gls'
		),
/*
		array(
			'name' => '审核中采购单',
			'path' => 'purchase.check'
		),
		array( 
			'name' => '常规库房→未入库采购单',
			'path' => 'purchase.listreceive'
		),
		array( 
			'name' => '常规库房→已完成采购单',
			'path' => 'purchase.list'
		),
		*/
		array( 
			'name' => '常规库房→采购单列表',
			'path' => 'purchase.listreceive_m'
		),
		array( 
			'name' => '★代发货→采购单列表',
			'path' => 'purchase.listreceive_h'
		),
/*
		array( 
			'name' => '★代发货→已完成采购单',
			'path' => 'purchase.list_h'
		),
		array( 
			'name' => '未付款采购单→先货后款',
			'path' => 'purchase.nopay',
*/
			/*
			'sub' => array(
				array(
					'name' => '常规库房',
					'path' => 'purchase.nopay'
				),
				array(
					'name' => '代发货库房',
					'path' => 'purchase.nopay_h'
				),
			),
		),
		array( 
			'name' => '财务付款',
			'path' => 'purchase.pay'
		),
		array( 
			'name' => '供货商账目明细',
			'path' => 'purchase.supplier_money'
		),
			*/

	)
);

$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '采购付款',
	'sub' => array(
	/*
		array( 
			'name' => '未付款采购单→先货后款',
			'path' => 'purchase.nopay&paymentType=1',
		),
		array( 
			'name' => '未付款采购单→先款后货',
			'path' => 'purchase.nopay&paymentType=2',
		),
	*/
		array(
			'name' => '审核中采购单',
			'path' => 'purchase.check'
		),
		array( 
			'name' => '未付款采购单→创建支出单',
			'path' => 'purchase.nopay_creat',
		),
		array( 
			'name' => '支出单列表',
			'path' => 'purchase.paylist&status=1',
		),
		array( 
			'name' => '供货商账目明细',
			'path' => 'purchase.supplier_money'
		),

	)
);

$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '入库管理',
	'sub' => array(
		array(
			'name' => '待收货采购单',
			'path' => 'store.purchase&warehouse_id=6',
			//'warehouse' => 1,
		),
		array(
			'name' => '其他入库',
			'path' => 'store.other&warehouse_id=6',
			//'warehouse' => 1,
		),
		array( 
			'name' => '入库单列表',
			'path' => 'store.list&warehouse_id=6',
			//'warehouse' => 1,
		),
	)
);

$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '出库发货',
	'sub' => array(
		array(
			'name' => '整理待出库订单',
			'path' => 'delivery.pack&warehouse_id=6',
			//'warehouse' => 1,
		),
		array(
			'name' => '创建出库单',
			'path' => 'delivery.print&warehouse_id=6',
			//'warehouse' => 1,
		),
		array(
			'name' => '待给快递出库单',
			'path' => 'delivery.WL_no_excel&warehouse_id=6',
			//'warehouse' => 1,
		),
		array(
			'name' => '待打印出库单',
			'path' => 'delivery.readyprint&warehouse_id=6',
			//'warehouse' => 1,
		),
		array(
			'name' => '其他出库',
			'path' => 'delivery.other&warehouse_id=6',
			//'warehouse' => 1,
		),
		array(
			'name' => '出库单列表',
			'path' => 'delivery.list&warehouse_id=6',
			//'warehouse' => 1,
		)
	)
);


$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '库房管理',
	'sub' => array(
		array(
			'name' => '库存查询',
			'path' => 'warehouse.stock&warehouse_id=6',
			//'warehouse' => 1,
		),
		array(
			'name' => '库存商品帐',
			'path' => 'warehouse.account&warehouse_id=6',
			//'warehouse' => 1,
		),
		array( 
			'name' => '库房管理',
			'path' => 'warehouse.list',
		),
		array( 
			'name' => '货位管理',
			'path' => 'warehouse.place',
		),
	)
);

$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '订单中心',
	'sub' => array(
		array( 
			'name' => '产品经理确认',
			'path' => 'order.check.purchase&purchase_check=0'
		),
		array( 
			'name' => '客服确认',
			'path' => 'order.check.service_1&service_check=0'
		),
		array( 
			'name' => '财务确认',
			'path' => 'order.check.finance'
		),
		array( 
			'name' => '财务批量确认',
			'path' => 'order.check.check_f'
		),
		array(
			'name' => '订单签收',
			'path' => 'order.check.sign&id=&excel=0&target_id=&channel_name=&begin_date=&end_date=&order_customer_name=&order_shipping_name=&logistics_company=&logistics_sn=&sign_status=0&begin_sign_date=&end_sign_date=',
		),
		array(
			'name' => '订单批量签收',
			'path' => 'order.check.sign_f',
		),
		array( 
			'name' => '售后处理',
			'path' => 'order.service&order_service=1'
		),
		array( 
			'name' => '所有订单',
			'path' => 'order.list'
		),
		array( 
			'name' => '所有订单[客服]',
			'path' => 'order.list_all'
		),
		array( 
			'name' => '配货管理',
			'path' => 'order.lock',
		),
		array( 
			'name' => '导入订单',
			'path' => 'order.importcheck',
		),
		array( 
			'name' => '新建渠道订单',
			'path' => 'order.channel'
		),
		array(
			'name' => '导入物流单号',
			'path' => 'delivery.import',
			//'warehouse' => 1,
		),
		array(
			'name' => '导入物物流费',
			'path' => 'delivery.freight',
			//'warehouse' => 1,
		),
	)
);

$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '客服外呼',
	'path' => 'order.check.service_2'
	);



$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '销售报表',
	'sub' => array(
	/*
		array(
			'name' => '产品销量报表',
			'path' => 'report.sales'
		),
		array( 
			'name' => '业务部毛利报表',
			'path' => 'report.business'
		),
		array(
			'name' => '财务到账报表',
			'path' => 'report.finance'
		),
		array(
			'name' => '订单流水分类报表',
			'path' => 'report.order'
		),
	*/
		array(
			'name' => '每日销售明细',
			'path' => 'report.dataone'
		),
		array(
			'name' => '销售额汇总报表',
			'path' => 'report.channelone'
		),
		array(
			'name' => '产品销售明细',
			'path' => 'report.channelproduct'
		),
		array(
			'name' => '产品销售毛利报表',
			'path' => 'report.gross'
		),
	)
);

$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '财务报表',
	'sub' => array(
		array( 
			'name' => '订单销售报表',
			'path' => 'finance.order'
		),
		array(
			'name' => '订单回款明细',
			'path' => 'finance.detail'
		),
		array(
			'name' => '渠道回款汇总',
			'path' => 'finance.total'
		),
	)
);

$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '报表下载',
	'sub' => array(
		array( 
			'name' => '建行销售报表（刘丹）',
			'path' => 'download.jh_1'
		),
		array( 
			'name' => '交行销售报表（刘丹）',
			'path' => 'download.jh_2'
		),
		array( 
			'name' => '广发销售报表（孙江琳）',
			'path' => 'download.gf_1'
		),
		array( 
			'name' => '广发银行月报（孙江琳）',
			'path' => 'download.gf_2'
		),
	)
);

$GLOBALS['__Config']['menu_list'][] = array(
	'name' => '系统管理',
	'sub' => array(
		array( 
			'name' => '系统帐号管理',
			'path' => 'system.administrator',
		),
		array( 
			'name' => '渠道列表',
			'path' => 'system.channel',
		)
	)
);
?>