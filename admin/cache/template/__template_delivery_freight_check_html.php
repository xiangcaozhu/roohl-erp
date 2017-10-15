<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-08-23 16:48:03
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3>导入订单运费</h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="location='?mod=delivery.freightload&file=<?php echo $file_name; ?>'" style=""><span>确定导入</span></button>
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
				<th width="80">订单号</th>
				<th width="80">物流公司</th>
				<th width="150">订单运费</th>
				<th width="100">状态</th>
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
				<td><?php echo $val['order']['id']; ?></td>
				<td><?php echo $val['order']['logistics_company']; ?></td>
				<td><?php echo $val['order_shipping_cost']; ?></td>
				<td><?php
if ( $val['error'] )
{
?><font color="red">此订单已有运费</font><?php
}
elseif ( $val['notexist'] )
{
?><font color="red">订单不存在</font><?php
}
else
{
?><font color="green">正确</font><?php
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