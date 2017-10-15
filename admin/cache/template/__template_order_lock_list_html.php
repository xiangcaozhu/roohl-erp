<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-05 09:28:01
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">配货管理 </h3>
	<div class="right">
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
				<th width="120">订单编号</th>
				<th width="120">渠道订单号</th>
				<th width="120">下单时间</th>
				<th width="70">配货状态</th>
				<th width="70">满足情况</th>
				<th width="70">发货状态</th>
				<th width="">操作</th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
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
				<th>&nbsp;</th>
				<th>
					<div class="input-field">
						<select name="lock_status">
							<option value=""></option>
							<?php
if ( $lock_status_list )
{
foreach ( $lock_status_list as $key => $val )
{
?>
							<option value="<?php echo $key; ?>" <?php
if ( $key == $_GET['lock_status'] && $_GET['lock_status'] != '' )
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
						<select name="delivery_type">
							<option value=""></option>
							<?php
if ( $delivery_type_list )
{
foreach ( $delivery_type_list as $key => $val )
{
?>
							<option value="<?php echo $key; ?>" <?php
if ( $key == $_GET['delivery_type'] && $_GET['delivery_type'] != '' )
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
				<td >&nbsp;<?php echo $info['id']; ?></td>
				<td >&nbsp;<?php echo $info['target_id']; ?></td>
				<td >&nbsp;<?php echo $info['order_time']; ?></td>
				<td >&nbsp;<?php echo $info['lock_status_name']; ?></td>
				<td >&nbsp;<?php echo $info['delivery_type_name']; ?></td>
				<td >&nbsp;<?php echo $info['delivery_status_name']; ?></td>
				<td >
					<a  target="_blank" href="?mod=order.lock.detail&id=<?php echo $info['id']; ?>">配货详细</a>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>

