<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-05 08:59:02
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">货位列表 </h3>
	
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		分页:<?php echo $page_bar; ?> 每页20条记录 总共<?php echo $total; ?>条记录 <?php echo $page; ?>/<?php echo $page_num; ?>　　<a href="?mod=warehouse.place.add">新建货位</a>
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="50">ID</th>
				<th width="150">库房名称</th>
				<th width="150">货位名称</th>
				<th width="150">别名</th>
				<th width="150">不参与发货</th>
				<th width="">操作</th>
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
				<td >&nbsp;<?php echo $val['id']; ?></td>
				<td >&nbsp;<?php echo $val['warehouse_name']; ?></td>
				<td >&nbsp;<?php echo $val['name']; ?></td>
				<td >&nbsp;<?php echo $val['nick_name']; ?></td>
				<td ><?php
if ( $val['no_delivery'] )
{
?><font size="" color="red">是</font><?php
}
else
{
?>否<?php
}
?></td>
				<td >
					<a href="?mod=warehouse.place.edit&id=<?php echo $val['id']; ?>">修改</a>
					<a href="?mod=warehouse.place.del&id=<?php echo $val['id']; ?>" onclick="return confirm('确定删除吗?');">删除</a>
					<a href="?mod=warehouse.account.detail&warehouse_id=<?php echo $val['warehouse_id']; ?>&place_id=<?php echo $val['id']; ?>">商品帐</a>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>

