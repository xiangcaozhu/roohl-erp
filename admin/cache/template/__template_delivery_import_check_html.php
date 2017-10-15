<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-08-23 16:31:07
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3>导入物流单号</h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="location='?mod=delivery.importload&file=<?php echo $file_name; ?>'" style=""><span>确定导入</span></button>
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
				<th width="60"><div align="center">订单号</div></th>
				<th>物流公司</th>
				<th>物流单号</th>
				<th width="60"><div align="center">状态</div></th>
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
				<td align="center"><?php echo $val['order_id']; ?></td>
				<td><?php echo $val['ThisLogistics']; ?> / <font color="#3399FF"><?php echo $val['logistics_company']; ?></font>
				<?php
if ( $val['company_error'] )
{
?><font color="red"><?php echo $val['company_error']; ?></font><?php
}
?></td>
				<td><?php echo $val['ThisSN']; ?> / <font color="#3399FF"><?php echo $val['logistics_sn']; ?></font>
				<?php
if ( $val['sn_error'] )
{
?><font color="red"><?php echo $val['sn_error']; ?></font><?php
}
?></td>
				<td align="center"><?php
if ( $val['error'] )
{
?><font color="red">错误</font><?php
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