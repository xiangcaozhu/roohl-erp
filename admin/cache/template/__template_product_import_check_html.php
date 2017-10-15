<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-22 10:48:06
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3>导入产品信息</h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="location='?mod=product.import.upload&file=<?php echo $file_name; ?>'" style=""><span>确定导入</span></button>
	</div>
</div>

<form method="post" id="main_form">

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		列表
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="40">商品分类ID</th>
				<th width="80">商品分类</th>
				<th width=""><nobr>商品名称<nobr></th>
				<th width="40">规格</th>
				<th width="40">供货商ID</th>
				<th width="80"><nobr>产品经理<nobr></th>
				<th width="40">类型(3C/非3C)</th>
				<th width="40">成本价</th>
				<th width="200">简介</th>
			</tr>
		</thead>
		<tbody id="purchase_row">
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr>
				<td><?php
if ( !$val['cid'] )
{
?><font color="red">不能为空</font><?php
}
else
{
?><small><?php echo $val['cid']; ?></small><?php
}
?></td>
				<td><?php echo $val['cname']; ?></td>
				<td><?php
if ( $val['exists'] )
{
?><font color="red"><?php echo $val['name']; ?> 产品已存在</font><?php
}
else
{
?><font color="green"><?php echo $val['name']; ?></font><?php
}
?></td>
				<td><small><?php
if ( !$val['weight'] )
{
?>-<?php
}
else
{
?><?php echo $val['weight']; ?></small><?php
}
?></small></td>
				<td><?php
if ( !$val['supplier_now'] )
{
?><font color="red">供货商不存在</font><?php
}
else
{
?><small><?php echo $val['supplier_now']; ?></small><?php
}
?></td>
				<td><?php echo $val['supplier_name']; ?></td>
				<td><?php
if ( $val['board'] == 1 )
{
?>3C<?php
}
elseif ( $val['board'] == 2 )
{
?>非3C<?php
}
else
{
?><font color="red">类型错误<?php
}
?></font></td>
				<td><?php
if ( !$val['cost_price'] )
{
?><font color="red">不能为空</font><?php
}
else
{
?><small><?php echo $val['cost_price']; ?></small><?php
}
?></td>
				<td><?php echo $val['summary']; ?></td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>