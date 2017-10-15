<?php

$OrderControlFlow2 = array();

$OrderControlFlow2['order.allow.order.cancel'] = array(
	'text' => '设置:取消订单',
	'type' => 1,
	'allow' => 'order.allow.order.cancel',
	'condition' => array( 1 ),
	'data' => array(
		'order_status' => ORDER_STATUS_CANCELLED,
		'order_status_time' => time(),
	),
	'global_status' => 10,
);

$OrderControlFlow2['order.allow.order.uncancel'] = array(
	'text' => '取消:取消订单',
	'type' => 0,
	'allow' => 'order.allow.order.uncancel',
	'condition' => array( 10 ),
	'data' => array(
		'order_status' => ORDER_STATUS_NORMAL,
		'order_status_time' => time(),
	),
	'global_status' => 1,
);

$OrderControlFlow2['order.allow.order.processing'] = array(
	'text' => '设置:准备发货',
	'type' => 1,
	'allow' => 'order.allow.order.processing',
	'condition' => array( 1 ),
	'data' => array(
		'order_status' => ORDER_STATUS_PROCESSING,
		'order_status_time' => time(),
	),
	'global_status' => 5,
);

$OrderControlFlow2['order.allow.order.unprocessing'] = array(
	'text' => '取消:准备发货',
	'type' => 0,
	'allow' => 'order.allow.order.unprocessing',
	'condition' => array( 5 ),
	'data' => array(
		'order_status' => ORDER_STATUS_NORMAL,
		'order_status_time' => time(),
	),
	'global_status' => 1,
);

$OrderControlFlow2['order.allow.order.done'] = array(
	'text' => '设置:已经完成',
	'type' => 1,
	'allow' => 'order.allow.order.done',
	'condition' => array( 3 ),
	'data' => array(
		'order_status' => ORDER_STATUS_DONE,
		'order_status_time' => time(),
	),
	'global_status' => 8,
);

$OrderControlFlow2['order.allow.order.undone'] = array(
	'text' => '取消:已经完成',
	'type' => 0,
	'allow' => 'order.allow.order.undone',
	'condition' => array( 8 ),
	'data' => array(
		'order_status' => ORDER_STATUS_PROCESSING,
		'order_status_time' => time(),
	),
	'global_status' => 3,
);

$OrderControlFlow2['order.allow.pay.confirm'] = array(
	'text' => '设置:已经支付',
	'type' => 1,
	'allow' => 'order.allow.pay.confirm',
	'condition' => array( 7 ),
	'data' => array(
		'pay_status' => PAY_STATUS_PAID,
		'pay_status_time' => time(),
	),
	'global_status' => 2,
);

$OrderControlFlow2['order.allow.pay.unconfirm'] = array(
	'text' => '取消:已经支付',
	'type' => 0,
	'allow' => 'order.allow.pay.unconfirm',
	'condition' => array( 2 ),
	'data' => array(
		'pay_status' => PAY_STATUS_NORMAL,
		'pay_status_time' => time(),
	),
	'global_status' => 7,
);

$OrderControlFlow2['order.allow.paycheck.confirm'] = array(
	'text' => '设置:确认到账',
	'type' => 1,
	'allow' => 'order.allow.paycheck.confirm',
	'condition' => array( 2 ),
	'data' => array(
		'pay_check_status' => PAY_CHECK_STATUS_CHECKED,
		'pay_check_status_time' => time(),
	),
	'global_status' => 3,
);

$OrderControlFlow2['order.allow.paycheck.unconfirm'] = array(
	'text' => '取消:确认到账',
	'type' => 0,
	'allow' => 'order.allow.paycheck.unconfirm',
	'condition' => array( 3 ),
	'data' => array(
		'pay_check_status' => PAY_CHECK_STATUS_NORMAL,
		'pay_check_status_time' => time(),
	),
	'global_status' => 2,
);


$OrderControlFlow2['order.allow.paycheck.review'] = array(
	'text' => '设置:付款异常',
	'type' => 1,
	'allow' => 'order.allow.paycheck.review',
	'condition' => array( 2 ),
	'data' => array(
		'pay_check_status' => PAY_CHECK_STATUS_REVIEW,
		'pay_check_status_time' => time(),
	),
	'global_status' => 4,
);

$OrderControlFlow2['order.allow.paycheck.unreview'] = array(
	'text' => '取消:付款异常',
	'type' => 0,
	'allow' => 'order.allow.paycheck.unreview',
	'condition' => array( 4 ),
	'data' => array(
		'pay_check_status' => PAY_CHECK_STATUS_NORMAL,
		'pay_check_status_time' => time(),
	),
	'global_status' => 2,
);

/*
$OrderControlFlow2['order.allow.pay.back'] = array(
	'text' => '设置:已经退款',
	'condition' => array(
		array(
			'pay_status' => PAY_STATUS_PAID,
			'pay_check_status' => PAY_CHECK_STATUS_CHECKED,
			'ship_status' => SHIP_STATUS_NORMAL,
			'order_status' => ORDER_STATUS_NORMAL,
		)
	),
	'data' => array(
		'pay_status' => PAY_STATUS_BACK,
		'pay_status_time' => time(),
	),
	'global_status' => 9,
);

$OrderControlFlow2['order.allow.pay.unback'] = array(
	'text' => '取消:已经退款',
	'condition' => array(
		array(
			'pay_status' => PAY_STATUS_BACK,
			'pay_check_status' => PAY_CHECK_STATUS_CHECKED,
		)
	),
	'data' => array(
		'pay_status' => PAY_STATUS_PAID,
		'pay_status_time' => time(),
	),
	'global_status' => 3,
);
*/

$OrderControlFlow2['order.allow.ship.pack'] = array(
	'text' => '设置:正在打包',
	'type' => 1,
	'allow' => 'order.allow.ship.pack',
	'condition' => array( 5 ),
	'data' => array(
		'ship_status' => SHIP_STATUS_PACK,
		'ship_status_time' => time(),
	),
	'global_status' => 6,
);

$OrderControlFlow2['order.allow.ship.unpack'] = array(
	'text' => '取消:正在打包',
	'type' => 0,
	'allow' => 'order.allow.ship.unpack',
	'condition' => array( 6 ),
	'data' => array(
		'ship_status' => SHIP_STATUS_NORMAL,
		'ship_status_time' => time(),
	),
	'global_status' => 5,
);

$OrderControlFlow2['order.allow.ship.confirm'] = array(
	'text' => '设置:已经发货',
	'type' => 1,
	'allow' => 'order.allow.ship.confirm',
	'condition' => array( 6 ),
	'data' => array(
		'ship_status' => SHIP_STATUS_SHIPPED,
		'ship_status_time' => time(),
	),
	'global_status' => 7,
);

$OrderControlFlow2['order.allow.ship.unconfirm'] = array(
	'text' => '取消:已经发货',
	'type' => 0,
	'allow' => 'order.allow.ship.unconfirm',
	'condition' => array( 7 ),
	'data' => array(
		'ship_status' => SHIP_STATUS_PACK,
		'ship_status_time' => time(),
	),
	'global_status' => 6,
);

$GLOBALS['__Config']['order_control_flow_2'] = $OrderControlFlow2;

?>