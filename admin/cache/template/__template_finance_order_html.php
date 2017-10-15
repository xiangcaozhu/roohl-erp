<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-07 18:03:16
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
	<h3>订单销售报表</h3>
	<div class="right">
		<button type="button" onclick="$('#excel').val(1);$('#search_form').submit();$('#excel').val(0);">导出Excel</button>
		<button type="button" onclick="$('#main_form').submit();">打印</button>
	</div>
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		订单销售报表 (<?php echo $_GET['begin_date']; ?> - <?php echo $_GET['end_date']; ?>) 总共<?php echo $total; ?>条记录
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="30">订单号</th>
				<th width="80">父渠道</th>
				<th width="100">渠道</th>
				<th width="140">出库时间</th>
				<th width="30">是否开票</th>
				<th width="">商品名称</th>
				<th width="60">单价</th>
				<th width="30">数量</th>
				<th width="60">销售合计</th>
				<th width="60">成本(不含税)</th>
				<th width="30">数量</th>
				<th width="60">成本合计</th>
				<th width="60">操作</th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
				<th>
					<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
					<input type="hidden" name="excel" id="excel" value="0">
				</th>
				<th>
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
					<div class="input-field">
						<select name="channel_id">
							<option value=""></option>
							<?php
if ( $channel_list )
{
foreach ( $channel_list as $val )
{
?>
							<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $_GET['channel_id'] )
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
						<div class="clearfix">
							<div class="left">开始:</div>
							<input type="text" name="begin_date" id="begin_date" value="<?php echo $_GET['begin_date']; ?>">
							<img src="image/grid-cal.gif" alt="" class="v-middle" id="begin_date_btn" />
						</div>
						<div class="clearfix">
							<div class="left">结束:</div>
							<input type="text" name="end_date" id="end_date" value="<?php echo $_GET['end_date']; ?>">
							<img src="image/grid-cal.gif" alt="" class="v-middle" id="end_date_btn" />
						</div>
					</div>
				</th>
				<th>
					<div class="input-field">
						<select name="order_invoice_status">
							<option value=""></option>
							<option value="1" <?php
if ( 1 == $_GET['order_invoice_status'] && $_GET['order_invoice_status'] != '' )
{
?>selected<?php
}
?>>已开发票</option>
							<option value="0" <?php
if ( 0 == $_GET['order_invoice_status'] && $_GET['order_invoice_status'] != '' )
{
?>selected<?php
}
?>>未开发票</option>
						</select>
					</div>
				</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th><button type="button" onclick="$('#search_form').submit();">过滤</button></th>
				</form>
			</tr>
		</thead>
		<tbody>
			<form method="post" action="?mod=finance.order.print&channel_id=<?php echo $_GET['channel_id']; ?>&begin_date=<?php echo $_GET['begin_date']; ?>&end_date=<?php echo $_GET['end_date']; ?>&order_invoice_status=<?php echo $_GET['order_invoice_status']; ?>&channel_parent_id=<?php echo $_GET['channel_parent_id']; ?>" id="main_form">
			<?php
if ( $list )
{
foreach ( $list as $info )
{
?>
			<tr>
				<td align="center"><?php echo $info['id']; ?></td>
				<td align="center"><?php echo $info['channel_parent_name']; ?></td>
				<td align="center"><?php echo $info['channel_name']; ?></td>
				<td align="center"><?php echo DateFormat($info['delivery_time']); ?></td>
				<td align="center"><?php
if ( $info['order_invoice_status'] )
{
?><font color="blue">已开发票</font><?php
}
else
{
?><font color="red">未开发票</font><?php
}
?></td>
				<td align="center"><?php echo $info['product_name']; ?></td>
				<td align="right"><?php echo $info['sales_price']; ?></td>
				<td align="center"><?php echo $info['sales_quantity']; ?></td>
				<td align="right"><?php echo $info['total_sales_price']; ?></td>
				<td align="right"><?php echo $info['stock_price']; ?></td>
				<td align="center"><?php echo $info['stock_quantity']; ?></td>
				<td align="right"><?php echo $info['total_stock_price']; ?></td>
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