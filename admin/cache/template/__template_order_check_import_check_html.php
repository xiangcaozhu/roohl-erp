<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-08 02:26:03
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3>订单批量签收</h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="location='?mod=order.check.import.upload&file=<?php echo $file_name; ?>'" style=""><span>确定导入</span></button>
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
				<th width="150">签收时间</th>
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
				<td><small><?php echo $val['order_id']; ?></small></td>
				<td><small><?php echo $val['sign_time']; ?></small></td>
				<td><?php
if ( $val['error'] )
{
?><font color="red">订单已签收:<?php echo $val['error']; ?></font><?php
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