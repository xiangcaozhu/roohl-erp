<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2014-07-24 09:36:50
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule"><?php echo $warehouse_info['name']; ?> 待打印出库单列表 </h3>
	<div class="right">
		<button type="button" onclick="$('#main_form').submit();">打印出库单</button>&nbsp;
		<button type="button" onclick="$('#excel').val(1);$('#main_form').submit();">导出Excel</button>
	</div>
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		分页:<?php echo $page_bar; ?> 每页20条记录 总共<?php echo $total; ?>条记录 <?php echo $page; ?>/<?php echo $page_num; ?>
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="30">选择</th>
				<th width="40"><div align="center">单号</div></th>
				<th width="80"><div align="center">制单人/时间</div></th>
				<th width="70"><div align="center">出库类型</div></th>
				<th width="60"><div align="center">销售渠道</div></th>
				<th width="60"><div align="center">物流公司</div></th>
				<th width="">出库商品详情</th>
				<th width="80"><div align="center">操作状态</div></th>
				<th width="80"><div align="center">操作状态</div></th>
			</tr>
			<tr class="filter">
				<th>
					<input type="checkbox" onclick="if (this.checked){$('input[name^=delivery_id]').attr('checked', true);}else{$('input[name^=delivery_id]').attr('checked', false);}">
				</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<form method="post" target="_blank" action="?mod=delivery.print.delivery<?php echo $warehouse_uri; ?>" id="main_form">
			<input type="hidden" name="excel" id="excel" value="0">
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr>
				<td align="center">
					<input type="checkbox" name="delivery_id[]" value="<?php echo $val['id']; ?>">
				</td>
				<td align="center"><?php echo $val['id']; ?></td>
				<td align="center"><?php echo $val['user_name_zh']; ?><?php echo $val['add_time']; ?></td>
				<td align="center">
				<?php echo $val['type_name']; ?>
				<?php
if ( $val['type'] == 1 )
{
?><br /><b>订单号↓</b><br />
				<?php
if ( $val['list'] )
{
foreach ( $val['list'] as $v )
{
?><?php echo $v['target_id2']; ?><br /><?php
}
}
?>
				<?php
}
?>
				</td>
				<td align="center"><?php echo $val['channel_name']; ?></td>
				<td align="center"><?php echo $val['logistics_company']; ?></td>
				<td align="center">
					<div class="HY-grid">
						<table cellspacing="0">
							<thead>
								<tr class="header">
									<th width="40"><div align="right">商品ID</div></th>
									<th width="80"><div align="left">SKU</div></th>
									<th width="">商品名称</th>
									<th width="80"><div align="center">属性</div></th>
									<th width="80"><div align="center">货位</div></th>
									<th width="60"><div align="center">出库数量</div></th>
								</tr>
							</thead>
							<tbody id="purchase_row">
								<?php
if ( $val['list'] )
{
foreach ( $val['list'] as $v )
{
?>
								<tr id="row_{1}">
									<td align="right"><?php echo $v['product_id']; ?></td>
									<td><?php echo $v['sku']; ?></td>
									<td><?php echo $v['sku_info']['product']['name']; ?>[<b><?php echo $v['price']; ?></b>]</td>
									<td align="center"><?php echo $v['sku_info']['attribute']; ?></td>
									<td align="center"><?php echo $v['place_name']; ?></td>
									<td align="center" title="<?php echo $v['comment']; ?>"><?php echo $v['quantity']; ?><br /><?php echo $v['target_id2']; ?></td>
								</tr>
								<?php
}
}
?>
							</tbody>
						</table>
					</div>
				</td>
				<td align="center"><?php
if ( $val['is_logistics'] == 1 )
{
?>已发送给<br />快递公司<br /><?php echo $val['is_logistics_time']; ?><?php
}
else
{
?><font color="#FF0000"><b>未发送</b></font><?php
}
?></td>
				<td align="center"><?php
if ( $val['is_print'] == 1 )
{
?>库房已打印<br /><?php echo $val['is_print_time']; ?><?php
}
else
{
?><font color="#FF0000"><b>库房未打印</b></font><?php
}
?></td>

			</tr>
			<?php
}
}
?>
			</form>
		</tbody>
	</table>
</div>
