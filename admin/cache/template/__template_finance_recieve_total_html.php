<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2017-11-18 00:09:02
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<link href="css/cal/zpcal.css" rel="stylesheet" type="text/css">
<link href="css/cal/template.css" rel="stylesheet" type="text/css">
<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>

<div class="HY-content-header clearfix">
	<h3>渠道回款汇总</h3>
	<div class="right">
		<button type="button" onclick="$('#excel').val(1);$('#search_form').submit();$('#excel').val(0);">导出Excel</button>
		<button type="button" onclick="$('#main_form').submit();">打印</button>
	</div>
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		渠道回款汇总 (<?php echo $_GET['begin_date']; ?> - <?php echo $_GET['end_date']; ?>)
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table" style="table-layout: fixed;">
		<thead>
			<tr class="header">
				<th width="100" style="width: 100px;">父渠33道</th>
				<th width="220">回款日期</th>
				<th width="100">销售合计</th>
				<th width="100">手续费</th>
				<th width="100">结算金额</th>
				<th width="60">操作</th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
				<th>
					<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
					<input type="hidden" name="excel" id="excel" value="0">
					<div class="input-field">
						<select name="channel_parent_id">
							<option value=""></option>
							<?php
if ( $channel_parent_list )
{
foreach ( $channel_parent_list as $val )
{
?>
							<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $_GET['channel_parent_id'] )
{
?>selected<?php
}
?>><?php echo $val['name']; ?></option>
							<?php
}
}
?>
						</select>
					</div>
				</th>
				<th>
					<div class="input-from">
						<div class="clearfix" style="float: left;">
							<div class="left" style="width: 60px;font-size: 14px;margin-top: 4px;">开始:</div>
							<input type="text" name="begin_date" id="begin_date" value="<?php echo $_GET['begin_date']; ?>">
							<img src="image/grid-cal.gif" alt="" class="v-middle" id="begin_date_btn" />
						</div>
						<div class="clearfix" style="float: left;">
							<div class="left" style="width: 60px;font-size: 14px;margin-top: 4px;">结束:</div>
							<input type="text" name="end_date" id="end_date" value="<?php echo $_GET['end_date']; ?>">
							<img src="image/grid-cal.gif" alt="" class="v-middle" id="end_date_btn" />
						</div>
					</div>
				</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th><button type="button" onclick="$('#search_form').submit();">过滤</button></th>
				</form>
			</tr>
		</thead>
		<tbody>
			<form method="post" action="?mod=finance.recieve.total.print&channel_parent_id=<?php echo $_GET['channel_parent_id']; ?>&begin_date=<?php echo $_GET['begin_date']; ?>&end_date=<?php echo $_GET['end_date']; ?>" id="main_form">
			<?php
if ( $list )
{
foreach ( $list as $info )
{
?>
			<tr>
				<td align="center"><?php echo $info['channel_parent_name']; ?></td>
				<td align="center"><?php echo DateFormat($info['finance_recieve_time'], 'Y-m-d'); ?></td>
				<td align="right"><?php echo FormatMoney($info['total_sales_price']); ?></td>
				<td align="right"><?php echo FormatMoney($info['total_payout']); ?></td>
				<td align="right"><?php echo FormatMoney($info['total_balance']); ?></td>
				<td>&nbsp;</td>
			</tr>
			<?php
}
}
?>
			</form>
		</tbody>
	</table>
</div>


<script type="text/javascript">

var cal = new Zapatec.Calendar.setup({
	inputField     :    "begin_date",     // id of the input field
	ifFormat       :    "%Y-%m-%d",     // format of the input field
	showsTime      :     false,
	button         :    "begin_date_btn",  // trigger button (well, IMG in our case)
	weekNumbers    :    false,  // allows user to change first day of week
	firstDay       :    1, // first day of week will be Monday
	align          :    "Bl"           // alignment (defaults to "Bl")
});

var cal = new Zapatec.Calendar.setup({
	inputField     :    "end_date",     // id of the input field
	ifFormat       :    "%Y-%m-%d",     // format of the input field
	showsTime      :     false,
	button         :    "end_date_btn",  // trigger button (well, IMG in our case)
	weekNumbers    :    false,  // allows user to change first day of week
	firstDay       :    1, // first day of week will be Monday
	align          :    "Bl"           // alignment (defaults to "Bl")
});

</script>