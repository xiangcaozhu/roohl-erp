<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-03-12 11:15:59
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">产品销量统计查询  (<?php echo $_POST['begin_date']; ?> - <?php echo $_POST['end_date']; ?>)</h3>
	<div class="right">
		<button type="button" onclick="$('#excel_form').submit();">导出Excel</button>
	</div>
	
</div>

<form method="post" id="excel_form">
	<input type="hidden" value="1" name="excel" />
	<input type="hidden" value="<?php echo $_POST['begin_date']; ?>" name="begin_date" />
	<input type="hidden" value="<?php echo $_POST['end_date']; ?>" name="end_date" />
</form>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		产品销量统计查询 (<?php echo $_POST['begin_date']; ?> - <?php echo $_POST['end_date']; ?> <?php
if ( $channel_name )
{
?> <?php echo $channel_name; ?> <?php
}
?><?php
if ( $channel_parent_name )
{
?> <?php echo $channel_parent_name; ?> <?php
}
?>)
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="80">商品ID</th>
				<th width="180">商品名称</th>
				<th width="180">销售数量</th>
				<th width="180">销售合计</th>
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
				<td align="center"><?php echo $val['product_id']; ?>&nbsp;</td>
				<td align="center"><?php echo $val['name']; ?>&nbsp;
				
				<?php
if ( $val['order_list'] )
{
foreach ( $val['order_list'] as $row )
{
?>
				<?php echo $row['get_order_idsss']; ?>
				<?php
}
}
?>
											
											
											</td>
				<td align="center"><?php echo $val['total_quantity']; ?>&nbsp;</td>
				<td align="center"><?php echo FormatMoney($val['total_price']); ?>&nbsp;</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>