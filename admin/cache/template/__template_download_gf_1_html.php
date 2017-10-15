<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2014-01-03 11:16:08
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">广发销售报表（孙江琳） </h3>
</div>


<form method="POST" id="main_form">
<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>"><input type="hidden" name="excel" id="excel" value="0">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td width="100" align="right">订单日期开始：</td>
					<td align="left" width="180">
						<input name="begin_date" id="begin_date" value="<?php echo $_POST['begin_date']; ?>" class="input-text" type="text" style="width:150px;"/> <img src="image/grid-cal.gif" id="begin_date_btn" align="absmiddle"/>
					</td>
					<td width="120" align="right">订单期单结束：</td>
					<td align="left" width="180">
						<input name="end_date" id="end_date" value="<?php echo $_POST['end_date']; ?>" class="input-text" type="text" style="width:150px;"/> <img src="image/grid-cal.gif" id="end_date_btn" align="absmiddle"/>
					</td>
					<td width="80" align="right" style="display:none">父渠道：</td>
					<td align="left" width="80"  style="display:none">
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
					</td>
					<td width="150" align="right">
						<button type="button" onclick="$('#main_form').submit();">确定查询</button>
						
					</td>
					<td><button style="float:right;" type="button" onclick="$('#excel').val(1);$('#main_form').submit();$('#excel').val(0);">导出</button></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>

<link href="css/cal/zpcal.css" rel="stylesheet" type="text/css">
<link href="css/cal/template.css" rel="stylesheet" type="text/css">
<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>

<script language="JavaScript">

$(document).ready(function(){
	$('#add-btn').click(function(){
		AddProductToRow();
	});
});




</script>


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



<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<td align="center" width="30" >序号</td>

				<td align="center" width="100">商品编号</td>
				<td align="left" >商品名称</td>
				<td align="center" width="60">销售数量</td>
				<td align="center" width="80">销售单价</td>
				<td align="center" width="80">订单状态</td>
				<td align="center" width="50">订单数</td>
				<td align="center" width="200">订单号</td>
			</tr>
		</thead>
<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
<tr>
<td align="center"><?php echo $val['list']; ?></td>
<td align="center"><?php echo $val['targetID']; ?></td>
<td align="left"><?php echo $val['productName']; ?></td>
<td align="center"><?php echo $val['totalQuantity']; ?></td>
<td align="center"><?php echo $val['productMoney']; ?></td>
<td align="center"><?php echo $val['statusInfo']; ?></td>
<td align="center"><?php echo $val['orderListCount']; ?></td>
<td align="left">
<?php
if ( $val['orderList'] )
{
foreach ( $val['orderList'] as $row )
{
?>
<span style="float:left; padding-right:15px;"><a href="?mod=order.list_all&id=<?php echo $row['orderID']; ?>" target="_blank"><?php echo $row['orderID']; ?></a></span>
<?php
}
}
?>
</td>
</tr>
<?php
}
}
?>

	</table>
</div>

