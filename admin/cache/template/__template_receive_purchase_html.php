<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-15 03:31:02
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule"><?php echo $warehouse_info['name']; ?> 采购收货</h3>
	<p class="right">
		
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
				<th width="60">采购单号</th>
				<th>供应商</th>
				<th width="80">库房</th>
				<th width="40">状态</th>
				<th width="60">收货状态</th>
				<th width="60">类型</th>
				<th width="60">产品类型</th>
				<th width="60">采购员</th>
				<th width="40">品种</th>
				<th width="40">件数</th>
				<th width="80">总金额</th>
				<th width="100">添加时间</th>
				<th width="100">操作</th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
				<th>
					<div class="input-field">
						<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
						<input type="hidden" name="warehouse_id" value="<?php echo $_GET['warehouse_id']; ?>">
						<input type="text" name="id" id="id" value="<?php echo $_GET['id']; ?>">
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
				<td ><small><?php echo $val['id']; ?></small></td>
				<td ><?php echo $val['supplier_name']; ?></td>
				<td align="center"><?php echo $val['warehouse_name']; ?></td>
				<td align="center"><?php echo $val['status_name']; ?></td>
				<td align="center"><?php echo $val['receive_status_name']; ?></td>
				<td align="center"><?php echo $val['type_name']; ?></td>
				<td align="center"><?php echo $val['product_type_name']; ?></td>
				<td ><?php echo $val['user_name_zh']; ?></td>
				<td align="center"><?php echo $val['total_breed']; ?></td>
				<td align="center"><?php echo $val['total_quantity']; ?></td>
				<td align="right">&yen;<?php echo $val['total_money']; ?></td>
				<td align="center"><small><?php echo $val['add_time']; ?></small></td>
				<td align="center">
					<a href="?mod=store.new.purchase<?php echo $warehouse_uri; ?>&id=<?php echo $val['id']; ?>">开始收货</a>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>