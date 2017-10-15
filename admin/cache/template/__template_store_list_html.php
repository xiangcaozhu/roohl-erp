<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-15 07:36:34
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule"><?php echo $warehouse_info['name']; ?> 入库单列表 </h3>
	<div class="right">
		<button type="button" onclick="$('#main_form').submit();">打印入库单</button>
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
				<th width="60">入库单号</th>
				<th width="60">入库类型</th>
				<th width="80">库房</th>
				<th width="40">采购单</th>
				<th width="60">入库员</th>
				<th width="40">总件数</th>
				<th width="100">入库时间</th>
				<th width="100">操作</th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
				<th>
					<input type="checkbox" onclick="if (this.checked){$('input[name^=store_id]').attr('checked', true);}else{$('input[name^=store_id]').attr('checked', false);}">
				</th>
				<th>
					<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
					<input type="hidden" name="warehouse_id" value="<?php echo $_GET['warehouse_id']; ?>">
				</th>
				<th>
					<div class="input-field">
						<select name="store_type">
							<option value=""></option>
							<?php
if ( $store_type_list )
{
foreach ( $store_type_list as $key => $val )
{
?>
							<option value="<?php echo $key; ?>" <?php
if ( $key == $_GET['store_type'] )
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
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
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
				<th><button type="button" onclick="$('#search_form').submit();">过滤</button></th>
				</form>
			</tr>
		</thead>
		<tbody>
			<form method="post" target="_blank" action="?mod=store.print<?php echo $warehouse_uri; ?>" id="main_form">
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr>
				<td align="center">
					<input type="checkbox" name="store_id[]" value="<?php echo $val['id']; ?>">
				</td>
				<td ><small><?php echo $val['id']; ?></small></td>
				<td align="center"><?php echo $val['type_name']; ?></td>
				<td align="center"><?php echo $val['warehouse_name']; ?></td>
				<td align="center"><?php echo $val['purchase_id']; ?></td>
				<td ><?php echo $val['user_name_zh']; ?></td>
				<td align="center"><?php echo $val['total_quantity']; ?></td>
				<td align="center"><small><?php echo $val['add_time']; ?></small></td>
				<td >
					<a href="?mod=store.view<?php echo $warehouse_uri; ?>&id=<?php echo $val['id']; ?>">查看</a>
				</td>
			</tr>
			<?php
}
}
?>
			</form>
		</tbody>
	</table>
</div>


<link href="css/cal/zpcal.css" rel="stylesheet" type="text/css">
<link href="css/cal/template.css" rel="stylesheet" type="text/css">
<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>


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