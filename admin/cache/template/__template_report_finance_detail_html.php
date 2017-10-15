<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-02-21 17:18:29
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">财务到账统计查询  (<?php echo $_POST['begin_date']; ?> - <?php echo $_POST['end_date']; ?>)</h3>
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
		财务到账统计查询 (<?php echo $_POST['begin_date']; ?> - <?php echo $_POST['end_date']; ?>)
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="">业务分类</th>
				<th width="180">到账金额</th>
				<th width="180">手续费</th>
				<th width="180">销售合计</th>
				<th width="180">产品类别</th>
				<th width="180">成本</th>
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
				<td align="center" rowspan="2"><?php echo $val['channel']; ?>&nbsp;</td>
				<td align="center" rowspan="2"><?php echo FormatMoney($val['money']); ?>&nbsp;</td>
				<td align="center" rowspan="2"><?php echo FormatMoney($val['payout']); ?>&nbsp;</td>
				<td align="center" rowspan="2"><?php echo FormatMoney($val['money']); ?>&nbsp;</td>
				<td align="center">3C</td>
				<td align="center"><?php echo FormatMoney($val['3c_stock_cost']); ?></td>
				<td align="center" rowspan="2"><?php echo FormatMoney($val['profit']); ?>&nbsp;</td>
			</tr>
			<tr>
				<td align="center">非3C</td>
				<td align="center"><?php echo FormatMoney($val['no3c_stock_cost']); ?></td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>