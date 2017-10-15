<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-08 17:03:37
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3><?php echo $warehouse_info['name']; ?> 查看出库单</h3>
	<div class="right">
		
	</div>
</div>

<form method="post" id="main_form">

<div class="clearfix">
	<div class="left">
		<b>出库人：</b><?php echo $info['user_name']; ?>&nbsp;&nbsp;
		<b>日期：</b><?php echo DateFormat($info['add_time']); ?>&nbsp;&nbsp;
		<b>类型：</b><?php echo $info['type_name']; ?>&nbsp;&nbsp;
		<b>订单号：</b><?php echo $info['order_id']; ?>&nbsp;&nbsp;
	</div>
	<div class="right">
		
	</div>
</div>
<div class="block5"></div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		出库商品列表
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="100">商品ID</th>
				<th width="120">SKU</th>
				<th width=""><nobr>商品名称<nobr></th>
				<th width="100">出库数量</th>
				<th width="100">货位</th>
			</tr>
		</thead>
		<tbody id="purchase_row">
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr id="row_{1}">
				<td><small><?php echo $val['product_id']; ?></small></td>
				<td><small><?php echo $val['sku']; ?></small></td>
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
				<td align="center"><?php echo $val['quantity']; ?></td>
				<td align="center"><?php echo $val['place_name']; ?></td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>

<div class="HY-form-table" id="base_tab">
	<div class="HY-form-table-header">
		其他
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>备注</label></td>
					<td class="value">
						<?php echo $info['comment']; ?>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>