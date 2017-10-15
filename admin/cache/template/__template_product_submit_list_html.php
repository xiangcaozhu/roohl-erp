<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-08 15:01:23
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
	<h3 class="head-tax-rule">提报列表 </h3>

	<p class="right">
		<button  id="" type="button" class="scalable back" onclick="window.location='?mod=product.submit.add';" style=""><span>新建提报</span></button>
		<button type="button" onclick="$('#excel').val(1);$('#search_form').submit();$('#excel').val(0);">导出Excel</button>
	</p>
	
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
				<th width="100">产品编号</th>
				<th width="120">分类编号</th>
				<th width="150">类型</th>
				<th width="">名称</th>
				<th width="160">简单描述</th>
				<th width="160">银行成本</th>
				<th width="160">销售价格</th>
				<th width="160">费率</th>
				<th width="160">提报期次</th>
				<th width="160">添加时间</th>
				<th width="120">操作</th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
				<th>
					<div class="input-field">
						<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
						<input type="text" name="target_id" value="<?php echo $_GET['target_id']; ?>">
						<input type="hidden" name="excel" id="excel" value="0">
					</div>
				</th>
				<th>
					&nbsp;<!-- <input type="text" name="supplier_name" id="supplier_name" value="<?php echo $_GET['supplier_name']; ?>"> -->
				</th>
				<th>&nbsp;</th>
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
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr>
				<td ><?php echo $val['target_id']; ?></td>
				<td ><?php echo $val['target_category_id']; ?></td>
				<td ><?php echo $val['supply_type']; ?></td>
				<td ><?php echo $val['name']; ?></td>
				<td ><?php echo $val['summary']; ?></td>
				<td ><?php echo $val['supply_price']; ?></td>
				<td ><?php echo $val['price']; ?></td>
				<td ><?php echo $val['payout_rate']; ?></td>
				<td ><?php echo $val['submit_issue']; ?></td>
				<td ><?php echo $val['add_time']; ?></td>
				<td >
					<a href="?mod=product.submit.edit&id=<?php echo $val['id']; ?>">修改</a>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>


<script type="text/javascript">
/*
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
*/
</script>