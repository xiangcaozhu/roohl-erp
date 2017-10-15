<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-08 01:06:35
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>



<div class="HY-content-header clearfix">
	<h3>管理组列表 </h3>
</div>
<div class="HY-content-header clearfix">
<a href='/shop_center/admin/index.php?mod=system.administrator.group.add'>添加管理组</a>
</div>
<div class="HY-grid">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th>ID</th>
				<th>用户组名称</th>
				<th>添加日期</th>
				<th>修改日期</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php
if ( $list )
{
foreach ( $list as $group )
{
?>
			<tr>
				<td><?php echo $group['id']; ?></td>
				<td><?php echo $group['name']; ?></td>
				<td><?php echo $group['add_time']; ?></td>
				<td><?php echo $group['update_time']; ?></td>
				<td>
					<a href="?mod=system.administrator.group.edit&id=<?php echo $group['id']; ?>">编辑</a>
					<a href="?mod=system.administrator.group.del&id=<?php echo $group['id']; ?>" onclick="return confirm('确定删除?');">删除</a>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>