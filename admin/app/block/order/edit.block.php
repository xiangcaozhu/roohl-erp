<?php


if ( $orderInfo['order_status'] != 1 )
	Common::Error( '只有未确认的订单才能编辑' );


?>