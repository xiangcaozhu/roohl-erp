<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-03-11 13:31:39
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
	<h3>订单-财务确认</h3>
	<div class="right">
		已选订单:
		时间
		<input type="text" class="input-text" name="" id="finance_date"><img src="image/grid-cal.gif" alt="" align="absmiddle" id="finance_date_btn" />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button type="button" onclick="if (confirm('确定要设置已到款?')){SubmitForm(1);}">设置已到款</button> |
		<button type="button" onclick="if (confirm('确定要设置已退款?')){SubmitForm(2);}">设置已退款</button> |
		<button type="button" onclick="$('#excel').val(1);$('#search_form').submit();$('#excel').val(0);">导出Excel</button>
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
				<th width="60">订单号</th>
				<th width="70">渠道订单号</th>
				<th width="120">渠道</th>
				<th width="140">下单时间</th>
				<th width="60">总金额</th>
				<th width="140">到款状态</th>
				<th width="60">发票</th>
				<th width="70">发货状态</th>
				<th width="100">操作</th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
				<th>
					<input type="checkbox" onclick="if (this.checked){$('input[name^=order_id]').attr('checked', true);}else{$('input[name^=order_id]').attr('checked', false);}">
				</th>
				<th>
					<div class="input-field">
						<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
						<input type="text" name="id" id="id" value="<?php echo $_GET['id']; ?>">
						<input type="hidden" name="excel" id="excel" value="0">
					</div>
				</th>
				<th>
					<div class="input-field">
						<input type="text" name="target_id" value="<?php echo $_GET['target_id']; ?>">
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
				<th><div class="clearfix">
							<div class="left2">客服确认:</div>
							<select name="service_check">
								<option value=""></option>
								<option value="1" <?php
if ( 1 == $_GET['service_check'] && $_GET['service_check'] != '' )
{
?>selected<?php
}
?>>已经确认</option>
								<option value="2" <?php
if ( 2 == $_GET['service_check'] && $_GET['service_check'] != '' )
{
?>selected<?php
}
?>>已经取消</option>
								<option value="0" <?php
if ( 0 == $_GET['service_check'] && $_GET['service_check'] != '' )
{
?>selected<?php
}
?>>未操作</option>
							</select>
						</div></th>
				<th>
					<div class="input-field">
						<select name="finance_recieve">
							<option value=""></option>
							<?php
if ( $finance_recieve_status_list )
{
foreach ( $finance_recieve_status_list as $key => $val )
{
?>
							<option value="<?php echo $key; ?>" <?php
if ( $key == $_GET['finance_recieve'] && $_GET['finance_recieve'] != '' )
{
?>selected<?php
}
?>><?php echo $val; ?></option>
							<?php
}
}
?>
						</select>
					</div>
				</th>
				<th>
					<div class="input-field">
						<select name="order_invoice">
							<option value=""></option>
							<option value="1" <?php
if ( 1 == $_GET['order_invoice'] && $_GET['order_invoice'] != '' )
{
?>selected<?php
}
?>>需要</option>
							<option value="0" <?php
if ( 0 == $_GET['order_invoice'] && $_GET['order_invoice'] != '' )
{
?>selected<?php
}
?>>不需要</option>
						</select>
					</div>
				</th>
				<th>
					<div class="input-field">
						<select name="delivery_status">
							<option value=""></option>
							<?php
if ( $delivery_status_list )
{
foreach ( $delivery_status_list as $key => $val )
{
?>
							<option value="<?php echo $key; ?>" <?php
if ( $key == $_GET['delivery_status'] && $_GET['delivery_status'] != '' )
{
?>selected<?php
}
?>><?php echo $val; ?></option>
							<?php
}
}
?>
						</select>
					</div>
				</th>
				<th><button type="button" onclick="$('#search_form').submit();">过滤</button></th>
				</form>
			</tr>
		</thead>
		<tbody>
			<?php
if ( $list )
{
foreach ( $list as $info )
{
?>
			<tr>
				<td>
					<input type="checkbox" name="order_id[]" value="<?php echo $info['id']; ?>">
				</td>
				<td ><small><?php echo $info['id']; ?></small></td>
				<td ><small><?php echo $info['target_id']; ?></small></td>
				<td >&nbsp;<?php echo $info['channel_name']; ?></td>
				<td><small><?php echo $info['order_time']; ?></small></td>
				<td><small><?php echo $info['total_money']; ?></small><br /><br /><?php echo $info['service_check_name']; ?></td>
				<td><?php echo $info['finance_recieve_name']; ?> <?php
if ( $info['finance_recieve'] )
{
?><small>(<?php echo $info['finance_recieve_time']; ?>)</small><?php
}
?></td>
				<td>
					<p><?php
if ( $info['order_invoice'] )
{
?>需要<?php
}
else
{
?>不需要<?php
}
?></p>
					<p><?php
if ( $info['order_invoice_status'] )
{
?><font color="green">已开</font><?php
}
else
{
?><font color="red">未开</font><?php
}
?></p>
					<p>抬头:<?php echo $info['order_invoice_header']; ?></p>
					<p>发票号:<?php echo $info['order_invoice_number']; ?></p>
				</td>
				<td >&nbsp;<?php echo $info['delivery_status_name']; ?></td>
				<td >
					<a href="?mod=order.detail&id=<?php echo $info['id']; ?>">详情</a>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>

<form method="post" action="?mod=order.edit.finance" id="mainform">
	<input type="hidden" name="finance_date">
	<input type="hidden" name="finance_recieve" id="finance_recieve" value="">
	<div>

	</div>
</form>


<script type="text/javascript">

function SubmitForm(financeRecieve){
	$('input[name=finance_date]').val($('#finance_date').val());
	$('input[name=finance_recieve]').val(financeRecieve);

	$('#mainform div').empty();

	$(':checkbox[name^=order_id]:checked').each(function(){
		$('#mainform div').append('<input type="hidden" name="order_id[]" value="'+$(this).val()+'">');
	});

	$('#mainform').submit();
}

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


var cal = new Zapatec.Calendar.setup({
	inputField     :    "finance_date",     // id of the input field
	ifFormat       :    "%Y-%m-%d",     // format of the input field
	showsTime      :     false,
	button         :    "finance_date_btn",  // trigger button (well, IMG in our case)
	weekNumbers    :    false,  // allows user to change first day of week
	firstDay       :    1, // first day of week will be Monday
	align          :    "Bl"           // alignment (defaults to "Bl")
});
</script>