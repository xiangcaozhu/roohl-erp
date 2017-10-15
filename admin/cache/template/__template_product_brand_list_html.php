<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-08 15:20:51
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">品牌列表 </h3>
	<p class="right">
		<button  id="" type="button" class="scalable back" onclick="window.location='?mod=product.brand.add';" style=""><span>添加新的品牌</span></button>
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
				<th width="40">ID</th>
				<th width="120">Logo</th>
				<th width="150"><nobr>名称<nobr></th>
				<th width="150" align="center">添加时间</th>
				<th width="90" align="center">操作</th>
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
				<td><small><?php echo $info['id']; ?></small></td>
				<td>
					<?php
if ( $info['logo'] )
{
?>
						<img src="<?php echo $info['logo']; ?>" class="img" width="84" />
					<?php
}
?>
					&nbsp;
				</td>
				<td><?php echo $info['name']; ?></td>
				<td align="center"><small><?php echo $info['add_time']; ?></small></td>
				<td align="center">
					<a href="?mod=product.brand.edit&id=<?php echo $info['id']; ?>">编辑</a>
					<!-- <a href="?mod=product.brand.del&id=<?php echo $info['id']; ?>" onclick="return confirm('确定删除吗?');">删除</a> -->
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>

