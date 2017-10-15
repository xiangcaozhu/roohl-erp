<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2014-07-11 16:46:05
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">渠道订单报表 </h3>
</div>


<form method="POST" id="main_form">
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
					<td width="80" align="right">渠道必选：</td>
					<td align="left" width="200">
						<select name="channel_id">
							<option value="0"></option>
							<?php
if ( $channel_list )
{
foreach ( $channel_list as $val )
{
?>
							<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $_POST['channel_id'] )
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
					<td width="150" align="left">
						<button type="button" onclick="$('#main_form').submit();">确定查询</button>
					</td>
					<td><input type="hidden" name="excel" id="excel" value="0">
					<button type="button" style="display:" onclick="$('#excel').val(1);$('#main_form').submit();">导出Excel</button></td>
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
				<td align="left" >渠道名称：<?php echo $list['channel_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日期：<?php echo $list['nowday']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;总销售额：<font color="#990000"><?php echo $list['all_total_price']; ?></font></td>
			</tr>
			</thead>
</table>
<?php
if ( $list['info'] )
{
foreach ( $list['info'] as $val )
{
?>
<table cellspacing="0" class="data" id="grid_table">
<?php
if ( $val['total_price'] > 0 )
{
?>
		<tbody>
			<tr>
				<td width="70" align="center" bgcolor="#FFFFFF">银行编号</td>
				<td width="30" align="center" bgcolor="#FFFFFF">ID</td>
				<td width="40" align="center" bgcolor="#FFFFFF"><div align="center">数量</div></td>
				<td width="80" align="center" bgcolor="#FFFFFF"><div align="center">单价</div></td>
				<td width="80" align="center" bgcolor="#FFFFFF"><div align="center">合计</div></td>
				<td align="left" bgcolor="#FFFFFF"><div align="left">商品名称</div></td>
				<td width="420" bgcolor="#FFFFFF"><div align="left">所属订单</div></td>
			</tr>
		</tbody>
		<tbody>
			<?php
if ( $val['product_data'] )
{
foreach ( $val['product_data'] as $product )
{
?>
			<tr>
				<td align="center"><?php echo $product['target_id']; ?></td>
				<td align="center"><?php echo $product['get_pid']; ?></td>
				<td align="center"><?php echo $product['total_quantity']; ?></td>
				<td align="center"><?php
if ( $product['get_price'] > 0 )
{
?><?php echo FormatMoney($product['get_price']); ?><?php
}
else
{
?>赠品<?php
}
?></td>
				<td align="center"><?php
if ( $product['total_price'] > 0 )
{
?><?php echo FormatMoney($product['total_price']); ?><?php
}
else
{
?>赠品<?php
}
?></td>
				<td align="left"><?php echo $product['p_name']; ?></td>
				<td align="left">
				<?php
if ( $product['orders'] )
{
foreach ( $product['orders'] as $orderslist )
{
?>
				<a href="?mod=order.list&id=<?php echo $orderslist['orderIDS']; ?>" target="_blank"><?php echo $orderslist['orderIDS']; ?></a>&nbsp;&nbsp;
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
		</tbody>
<?php
}
?>
	</table>
	

<?php
}
}
?>
	</div>
