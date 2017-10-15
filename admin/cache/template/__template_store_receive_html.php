<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-08 09:58:20
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule"><?php echo $warehouse_info['name']; ?> 收货入库 </h3>
	<p class="right">
		
	</p>
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		收货单列表 分页:<?php echo $page_bar; ?> 每页20条记录 总共<?php echo $total; ?>条记录 <?php echo $page; ?>/<?php echo $page_num; ?>
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="60">收货单号</th>
				<th width="80">收货类型</th>
				<th width="80">库房</th>
				<th width="80">入库状态</th>
				<th width="80">采购单</th>
				<th width="60">收货员</th>
				<th width="40">总件数</th>
				<th width="100">添加时间</th>
				<th width="100">操作</th>
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
				<td align="center"><small><?php echo $val['id']; ?></small></td>
				<td align="center"><?php echo $val['type_name']; ?></td>
				<td align="center"><?php echo $val['warehouse_name']; ?></td>
				<td align="center"><?php echo $val['into_status_name']; ?></td>
				<td align="center"><?php
if ( $val['purchase_id'] )
{
?><?php echo $val['purchase_id']; ?><?php
}
else
{
?>-<?php
}
?></td>
				<td ><?php echo $val['user_name']; ?></td>
				<td align="center"><?php echo $val['total_quantity']; ?></td>
				<td align="center"><small><?php echo $val['add_time']; ?></small></td>
				<td align="center">
					<a href="?mod=store.new.receive<?php echo $warehouse_uri; ?>&id=<?php echo $val['id']; ?>">开始入库</a>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>