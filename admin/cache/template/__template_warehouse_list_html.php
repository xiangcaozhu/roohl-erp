<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-15 01:25:48
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">库房列表 </h3>
	
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		分页:<?php echo $page_bar; ?> 每页20条记录 总共<?php echo $total; ?>条记录 <?php echo $page; ?>/<?php echo $page_num; ?>　　<a href="?mod=warehouse.add">新建库房</a>
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="5%">ID</th>
				<th width="80%">库房名称</th>
				<th width="15%">操作</th>
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
				<td >&nbsp;<?php echo $info['name']; ?></td>
				<td >
					<a href="?mod=warehouse.edit&id=<?php echo $info['id']; ?>" onclick="return confirm('确定修改吗？')">修改</a>
					<a style="display:none" href="?mod=warehouse.del&id=<?php echo $info['id']; ?>" onclick="return confirm('确定删除吗?');">删除</a>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>

