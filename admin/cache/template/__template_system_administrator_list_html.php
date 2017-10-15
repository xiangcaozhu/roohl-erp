<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-08 01:05:51
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix">
	<h3>管理员列表 </h3>
</div>
<div class="HY-content-header clearfix">
	<a href='/shop_center/admin/index.php?mod=system.administrator.add'>添加新帐号</a>　　　
	<a href='/shop_center/admin/index.php?mod=system.administrator.group.list'>管理组列表</a>
</div>
<div class="HY-grid">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th>ID</th>
				<th>用户名</th>
				<th>组</th>
				<th>真实姓名</th>
				<th>添加日期</th>
				<th>修改日期</th>
				<th>最后登录日期</th>
				<th>最后登录IP</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			<?php
if ( $list )
{
foreach ( $list as $user )
{
?>
			<tr>
				<td><?php echo $user['user_id']; ?></td>
				<td><?php echo $user['user_name']; ?></td>
				<td><?php echo $user['user_group']['name']; ?></td>
				<td><?php echo $user['user_real_name']; ?></td>
				<td><?php echo $user['user_add_time']; ?></td>
				<td><?php echo $user['user_update_time']; ?></td>
				<td><?php echo $user['user_login_time']; ?></td>
				<td><?php echo $user['user_login_ip']; ?></td>
				<td>
					<a href="?mod=system.administrator.edit&id=<?php echo $user['user_id']; ?>">编辑</a>
					<a href="?mod=system.administrator.del&id=<?php echo $user['user_id']; ?>" onclick="return confirm('确定删除?');">删除</a>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>