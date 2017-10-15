<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-02-26 11:34:33
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule"><?php echo $warehouse_info['name']; ?> 库存商品帐 </h3>
	<p class="right">
		<button type="button" onclick="$('#excel_form').submit();">导出Excel</button>
	</p>
</div>

<form method="post" id="excel_form">
	<input type="hidden" name="excel" value="1">
</form>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		<?php echo $warehouse_info['name']; ?> 库存商品帐
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="100">SKU</th>
				<th width="100">产品ID</th>
				<th width="">产品名称</th>
				<th width="100">库房名称</th>
				<th width="100">货位</th>
				<th width="150">时间</th>
				<th width="60">类型</th>
				<th width="60">业务</th>
				<th width="60">操作人</th>
				<th width="60">数量</th>
				<th width="60">价格</th>
			</tr>
		</thead>
		<tbody>
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr>
				<td align="center"><?php echo $val['sku']; ?></td>
				<td align="center"><?php echo $val['product_id']; ?></td>
				<td>
					<b>名称：</b><?php echo $val['sku_info']['product']['name']; ?>
					<?php
if ( $val['sku_info']['attribute'] )
{
?><b>属性：</b><?php echo $val['sku_info']['attribute']; ?><?php
}
?>
				</td>
				<td align="center"><?php echo $val['warehouse_name']; ?></td>
				<td align="center"><?php echo $val['place_name']; ?></td>
				<td align="center"><?php echo $val['add_time']; ?></td>
				<td align="center"><?php
if ( $val['type'] == 1 )
{
?><font color="green"><b>入库</b></font><?php
}
else
{
?><font color="red"><b>出库</b></font><?php
}
?></td>
				<td align="center"><?php
if ( $val['type'] == 1 )
{
?><font color="green"><?php echo $val['type2_name']; ?></font><?php
}
else
{
?><font color="red"><?php echo $val['type2_name']; ?></font><?php
}
?></td>
				<td align="center">
					<?php echo $val['user_name_zh']; ?>
				</td>
				<td align="center">
					<?php
if ( $val['type'] == 1 )
{
?>
					<font color="green"><b>+<?php echo $val['quantity']; ?></b></font>
					<?php
}
else
{
?>
					<font color="red"><b>-<?php echo $val['quantity']; ?></b></font>
					<?php
}
?>
				</td>
				<td align="center">
					&yen; <?php echo $val['price']; ?>
				</td>
			</tr>
			<?php
}
}
?>
			<tr>
				<td align="right" colspan="8"><b>结存：</b></td>
				<td align="center"><b><?php echo $leave; ?></b></td>
				<td align="center">&nbsp;</td>
			</tr>
		</tbody>
	</table>
</div>

