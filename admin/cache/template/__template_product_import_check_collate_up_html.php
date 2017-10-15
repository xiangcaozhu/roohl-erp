<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-12-23 14:02:11
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3>导入产品信息</h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="location='?mod=product.import.upload_collate_1&file=<?php echo $file_name; ?>'" style=""><span>确定导入</span></button>
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
				<th width="150">渠道名称-编号</th>
				<th width="100">渠道-SKU</th>
				<th width="">系统名称-银行名称</th>
				<th width="">价格-银行链接</th>
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
				<td><?php echo $val['channel_name']; ?><br /><?php echo $val['target_id']; ?></td>
				<td bgcolor="<?php echo $val['sku_err']; ?>">系统：<?php echo $val['collateOne']['sku']; ?><br />导入：<?php echo $val['sku']; ?></td>
				<td>产品：<?php echo $val['product_name']; ?><br />系统：<?php echo $val['collateOne']['bank_name']; ?><br />导入：<?php echo $val['bank_name']; ?><br />银行：<?php echo $val['bank_info']['Pname']; ?></td>
				<td align="left" bgcolor="<?php echo $val['sku_price']; ?>">系统：<?php echo $val['price']; ?><br />导入：<?php echo $val['AllMoney']; ?><br /><a href="<?php echo $val['bank_link']; ?>" target="_blank"><?php echo $val['bank_link']; ?></a></td>
				<td><?php
if ( $val['exists'] )
{
?><font color="#006600">记录已经存在，正确</font><?php
}
else
{
?><font color="red">无记录，错误！</font><?php
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