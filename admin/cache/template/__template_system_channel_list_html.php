<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-08 09:40:21
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">渠道列表 </h3>
	<p class="right">
		<button  id="" type="button" class="scalable back" onclick="window.location='?mod=system.channel.add';" style=""><span>添加渠道</span></button>
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
				<th width="5%">ID</th>
				<th width="80%">渠道名称</th>
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
					<a href="?mod=system.channel.edit&id=<?php echo $info['id']; ?>" onclick="return confirm('确定修改吗？')">修改</a>
					<a href="?mod=system.channel.del&id=<?php echo $info['id']; ?>" onclick="return confirm('确定删除吗?');">删除</a>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>

