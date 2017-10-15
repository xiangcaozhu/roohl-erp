<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2014-04-22 11:03:32
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
				<th width=""><nobr>商品名称<nobr></th>
				<th width="80">需求数量</th>
				<th width="">已配货数量</th>
				<th width="">待配货数量</th>
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