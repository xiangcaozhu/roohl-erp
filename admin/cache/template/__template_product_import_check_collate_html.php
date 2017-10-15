<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-25 10:04:40
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3>导入产品信息</h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="location='?mod=product.import.upload_collate&file=<?php echo $file_name; ?>'" style=""><span>确定导入</span></button>
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
				<th width="40">渠道ID</th>
				<th width="150">渠道名称</th>
				<th width="60">渠道编号</th>
				<th width="">商品ID-SKU-名称</th>
				<th width="60"><div align="center">一期</div></th>
				<th width="60"><div align="center">三期</div></th>
				<th width="60"><div align="center">六期</div></th>
				<th width="60"><div align="center">十二期</div></th>
				<th width="60"><div align="center">十五期</div></th>
				<th width="60"><div align="center">十八期</div></th>
				<th width="60"><div align="center">二十四</div></th>
				<th width="120">状态</th>
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
if ( !$val['channel_id'] )
{
?><font color="red">渠道ID不能为空</font><?php
}
else
{
?><small><?php echo $val['channel_id']; ?></small><?php
}
?></td>
				<td><?php echo $val['channel_name']; ?></td>
				<td><?php echo $val['target_id']; ?></td>
				<td><?php echo $val['product_id']; ?>-<?php echo $val['sku']; ?>→<?php echo $val['product_name']; ?><br /><?php echo $val['bank_link']; ?></td>
				<td align="center">￥<?php echo $val['M1']; ?><br />（<?php echo $val['C1']; ?>)</td>
				<td align="center">￥<?php echo $val['M3']; ?><br />（<?php echo $val['C3']; ?>)</td>
				<td align="center">￥<?php echo $val['M6']; ?><br />（<?php echo $val['C6']; ?>)</td>
				<td align="center">￥<?php echo $val['M12']; ?><br />（<?php echo $val['C12']; ?>)</td>
				<td align="center">￥<?php echo $val['M15']; ?><br />（<?php echo $val['C15']; ?>)</td>
				<td align="center">￥<?php echo $val['M18']; ?><br />（<?php echo $val['C18']; ?>)</td>
				<td align="center">￥<?php echo $val['M24']; ?><br />（<?php echo $val['C24']; ?>)</td>
				<td><?php
if ( $val['exists'] )
{
?><font color="red">记录已经存在，错误！</font><?php
}
else
{
?><font color="#006600">正确</font><?php
}
?></td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>