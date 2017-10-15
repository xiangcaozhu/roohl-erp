<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-08 17:08:13
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">业务部毛利统计查询 (<?php echo $_POST['begin_date']; ?> - <?php echo $_POST['end_date']; ?>)</h3>
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
		业务部毛利统计查询 (<?php echo $_POST['begin_date']; ?> - <?php echo $_POST['end_date']; ?>)
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="">姓名</th>
				<th width="200">销售收入</th>
				<th width="180">成本</th>
				<th width="180">手续费</th>
				<th width="240">销售收入 - 手续费</th>
				<th width="180">物流费</th>
				<th width="180">毛利</th>
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
				<td align="center"><?php echo $val['manager_user_name']; ?>&nbsp;</td>
				<td align="center"><?php echo FormatMoney($val['total_price']); ?>&nbsp;</td>
				<td align="center"><?php echo FormatMoney($val['total_stock_price']); ?>&nbsp;</td>
				<td align="center"><?php echo FormatMoney($val['total_payout']); ?>&nbsp;</td>
				<td align="center"><?php echo FormatMoney($val['total_payout_lost']); ?>&nbsp;</td>
				<td align="center">-</td>
				<td align="center"><?php echo FormatMoney($val['profit']); ?>&nbsp;</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>