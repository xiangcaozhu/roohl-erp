<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-04-01 14:24:22
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3>配货详细</h3>
	<div class="right">
		<!-- <button type="button" class="scalable back" onclick="$('#main_form').submit();" style=""><span>保存采购单</span></button> -->
	</div>
</div>

<form method="post" id="main_form">

<div class="clearfix">
	<div class="left">
		订单号：<?php echo $order['id']; ?>&nbsp;&nbsp;
		渠道订单号：<?php echo $order['target_id']; ?>&nbsp;&nbsp;
		配货状态：<?php echo $order['lock_status_name']; ?>&nbsp;&nbsp;
		满足情况：<?php echo $order['delivery_type_name']; ?>&nbsp;&nbsp;
		发货状态：<?php echo $order['delivery_status_name']; ?>&nbsp;&nbsp;
	</div>
	<div class="right">
	</div>
</div>
<div class="block5"></div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		商品列表
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="120">SKU</th>
				<th width="100">商品ID</th>
				<th width="100">渠道产品ID</th>
				<th width=""><nobr>商品名称<nobr></th>
				<th width="80">价格</th>
				<th width="80">需求数量</th>
				<th width="80">已配货数量</th>
				<th width="80">待配货数量</th>
			</tr>
		</thead>
		<tbody id="purchase_row">
			<?php
if ( $product_list )
{
foreach ( $product_list as $val )
{
?>
			<tr id="row_{1}">
				<td><small><?php echo $val['sku']; ?></small></td>
				<td><small><?php echo $val['product_id']; ?></small></td>
				<td><small><?php echo $val['target_id']; ?></small></td>
				<td>
					<b>名称：</b><?php echo $val['sku_info']['product']['name']; ?>
					<br>
					<span><?php
if ( $val['sku_info']['attribute'] )
{
?><b>属性：</b><?php echo $val['sku_info']['attribute']; ?><?php
}
?></span>
				</td>
				<td><?php echo $val['price']; ?></td>
				<td><?php echo $val['quantity']; ?></td>
				<td align="center">
					<?php echo $val['lock_quantity']; ?>
					<?php
if ( $val['lock_list'] )
{
?>
					<div class="HY-grid">
						<table cellspacing="0" class="data" style="margin-top:5px;">
							<thead>
								<tr class="header">
									<th width="">仓库</th>
									<th width="90">货位</th>
									<th width="50">配货数</th>
									<th width="100">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php
if ( $val['lock_list'] )
{
foreach ( $val['lock_list'] as $row )
{
?>
								<tr>
									<td align="center"><?php echo $row['warehouse_name']; ?></td>
									<td align="center"><?php echo $row['place_name']; ?></td>
									<td align="center"><?php echo $row['quantity']; ?></td>
									<td align="center"><a href="?mod=order.lock.cancel&id=<?php echo $row['id']; ?>" onclick="return confirm('确定取消配货吗?');">取消配货</a></td>
								</tr>
								<?php
}
}
?>
							</tbody>
						</table>
					</div>
					<?php
}
?>
				</td>
				<td align="center">
					<?php echo $val['wait_quantity']; ?>
					<?php
if ( $val['stock_list'] )
{
?>
					<div class="HY-grid">
						<table cellspacing="0" class="data" style="margin-top:5px;">
							<thead>
								<tr class="header">
									<th width="">仓库</th>
									<th width="50">货位</th>
									<th width="50">库存数</th>
									<th width="50">锁定数</th>
									<th width="50">可用数</th>
									<th width="50">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php
if ( $val['stock_list'] )
{
foreach ( $val['stock_list'] as $row )
{
?>
								<tr>
									<td align="center"><?php echo $row['warehouse_name']; ?></td>
									<td align="center"><?php echo $row['place_name']; ?></td>
									<td align="center"><?php echo $row['quantity']; ?></td>
									<td align="center"><?php echo $row['lock_quantity']; ?></td>
									<td align="center"><?php echo $row['live_quantity']; ?></td>
									<td align="center">&nbsp;
									<?php
if ( $val['wait_quantity'] > 0 )
{
?>
										<a href="?mod=order.lock.put&order_product_id=<?php echo $val['id']; ?>&place_id=<?php echo $row['place_id']; ?>" onclick="return confirm('确定配货吗?');">配货</a>
									<?php
}
?>
									</td>
								</tr>
								<?php
}
}
?>
							</tbody>
						</table>
					</div>
					<?php
}
?>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>

<table width="100%">
	<tr>
		<td width="30%">
			<div class="HY-form-table">
				<div class="HY-form-table">
				<div class="HY-form-table-header">
					基本信息
				</div>
				<div class="HY-form-table-main clearfix-overflow;" style="height:160px;">
					<table width="100%" border="0">
						<tr>
							<td align="" width="100"><strong>订单号：</strong></td>
							<td><?php echo $order['id']; ?>&nbsp;</td>
						</tr>
						<tr>
							<td align=""><strong>渠道订单号：</strong></td>
							<td><?php echo $order['target_id']; ?> &nbsp;[渠道：<?php echo $order['channel_name']; ?>]</td>
						</tr>
						<tr>
							<td align=""><strong>备注:</strong></td>
							<td><?php echo $order['order_comment']; ?>&nbsp;</td>
						</tr>
						<tr>
							<td align=""><strong>条形码：</strong></td>
							<td><?php echo $order['order_shipping_barcode']; ?></td>
						</tr>
						<tr>
							<td><strong>优先发货：</strong></td>
							<td>
								<?php
if ( $order['delivery_first'] )
{
?>是<?php
}
else
{
?>否<?php
}
?>
							</td>
						</tr>
						<tr>
							<td><strong>付款方式：</strong></td>
							<td>
								<?php
if ( $order['payment_type'] == 2 )
{
?>
									先款后货
								<?php
}
elseif ( $order['payment_type'] == 1 )
{
?>
									货到付款
								<?php
}
else
{
?>
									未知
								<?php
}
?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</td>
		
		<td width="30%">
			<div class="HY-form-table">
				<div class="HY-form-table-header">
					收货信息
				</div>
				<div class="HY-form-table-main clearfix-overflow;" style="height:160px;">
					<table width="100%">
						<tr>
							<td align="" width="90"><strong>收货人：</strong></td>
							<td><?php echo $order['order_shipping_name']; ?></td>
						</tr>
						<tr>
							<td align="" width=""><strong>身份证：</strong></td>
							<td><?php echo $order['order_shipping_card']; ?></td>
						</tr>
						<tr>
							<td align=""><strong>地址：</strong></td>
							<td><?php echo $order['order_shipping_address']; ?></td>
						</tr>
						<tr>
							<td align=""><strong>邮编：</strong></td>
							<td><?php echo $order['order_shipping_zip']; ?></td>
						</tr>
						<tr>
							<td align=""><strong>固定电话：</strong></td>
							<td><?php echo $order['order_shipping_phone']; ?></td>
						</tr>
						<tr>
							<td align=""><strong>移动电话：</strong></td>
							<td><?php echo $order['order_shipping_mobile']; ?></td>
						</tr>
						<tr>
							<td align=""><strong>快递单号:</strong></td>
							<td><?php echo ArrayJoin($delivery_list, '-', 'express_id'); ?></td>
						</tr>
					</table>
				</div>
			</div>
		</td>
		<td width="30%">
			<div class="HY-form-table">
				<div class="HY-form-table-header">
					财务信息
				</div>
				<div class="HY-form-table-main clearfix-overflow;" style="height:160px;">
					<table width="100%">
						<tr>
							<td align="" width="90"><strong>发票：</strong></td>
							<td>
								<?php
if ( $order['order_invoice'] )
{
?>需要<?php
}
else
{
?>不需要<?php
}
?>
							</td>
						</tr>
						<tr>
							<td align="" width="90"><strong>发票抬头：</strong></td>
							<td><?php echo $order['order_invoice_header']; ?></td>
						</tr>
						<tr>
							<td align="" width="90"><strong>实开金额：</strong></td>
							<td><?php echo $order['total_pay_money']; ?></td>
						</tr>
						<tr>
							<td align="" width="90"><strong>已开发票：</strong></td>
							<td>
								<?php
if ( $order['order_invoice_status'] )
{
?>是(<?php echo DateFormat($order['order_invoice_time']); ?>)<?php
}
else
{
?>否<?php
}
?>
							</td>
						</tr>
						<tr>
							<td align=""><strong>发票号：</strong></td>
							<td><?php echo $order['order_invoice_number']; ?></td>
						</tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
</table>
