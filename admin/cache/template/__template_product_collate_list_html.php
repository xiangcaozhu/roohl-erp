<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-12-30 16:13:34
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<link href="css/cal/zpcal.css" rel="stylesheet" type="text/css">
<link href="css/cal/template.css" rel="stylesheet" type="text/css">
<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>

<style type="text/css">
<!--
.STYLE1 {color: #CC0000}
-->
</style>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">渠道产品对照列表 </h3>
	<button style="float:right;" type="button" onclick="$('#excel').val(1);$('#search_form').submit();$('#excel').val(0);">导出</button>
	
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		分页:<?php echo $page_bar; ?> 每页20条记录 总共<?php echo $total; ?>条记录 <?php echo $page; ?>/<?php echo $page_num; ?>　　　<a href='/shop_center/admin/index.php?mod=product.collate.add'>新建对照表</a>
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
			<th width="50">ID</th>
				<th width="100">SKU</th>
				<th width="120">渠道</th>
				<th width="80">渠道产品编号</th>
				<th width="100">售价</th>
				<th width="120">供货商</th>
				<th width="">产品</th>
				<th width="160" style="display:">添加时间</th>
				<th width="120">操作</th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
				<th>&nbsp;</th>
				<th>
					<div class="input-field">
						<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
						<input type="text" name="sku" value="<?php echo $_GET['sku']; ?>">
						<input type="hidden" name="excel" id="excel" value="0">
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
					<div class="input-field">
						<input type="text" name="target_id" value="<?php echo $_GET['target_id']; ?>">
					</div>
				</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th  style="display:">
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
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr>
				<td ><?php echo $val['id']; ?></td>
				<td ><?php echo $val['sku']; ?></td>
				<td ><?php echo $val['channel_name']; ?><br /><img src="../GoodImg/<?php echo $val['sku_info']['product']['id']; ?>.jpg" width="150" height="150" /></td>
				<td >
				<?php
if ( $val['bank_link'] )
{
?>
				<a href="<?php echo $val['bank_link']; ?>" target="_blank"><?php echo $val['target_id']; ?></a>
				<?php
}
else
{
?>
				<?php echo $val['target_id']; ?>
				<?php
}
?>
				<?php
if ( $val['gift_sku'] )
{
?>
				<br />赠品：<?php echo $val['gift_sku']; ?>
				<?php
}
?>
				</td>
			    <td bgcolor="<?php echo $val['money_err']; ?>"><b>银行:</b><?php echo $val['bank_info']['Pmoney']; ?><br /><b>系统:</b><?php echo $val['one_money']; ?></td>
				<td ><?php echo $val['supplier_name']; ?></td>
				<td ><?php echo $val['bank_info']['Pname']; ?><br />
					<b>银行:</b><?php echo $val['bank_name']; ?><br />
					<b>名称:</b><?php echo $val['sku_info']['product']['name']; ?>
					<?php
if ( $val['sku_info']['attribute'] )
{
?>
					<span class="STYLE1"><br /><b>购买属性：</b><?php echo $val['sku_info']['attribute']; ?></span>	
					<?php
}
?>

					</td>
				<td  style="display:"><?php echo DateFormat($val['add_time']); ?></td>
				<td >
					<a href="?mod=product.collate.edit&id=<?php echo $val['id']; ?>">修改</a>
					<a onclick="return confirm('确定该对应关系吗?');" href="?mod=product.collate.del&id=<?php echo $val['id']; ?>">删除</a>
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