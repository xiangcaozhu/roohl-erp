<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-08-01 16:19:50
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<style type="text/css">
<style>
html,body{ padding:0px; margin:0px; }
.ckd_xiaofw td{ padding:3px 5px;font-size:13px;}
</style>

</head>


<body>

<?php $timer = 1; ?>
<?php $total = count($list); ?>

<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td height="" valign="top" align="center">

<table border="0" width="800" align="center" style="margin:10px auto 2px;">
	<tr>
		<td colspan="3" align="right" style="font-size:13px;">单号：<b><?php echo $val['id']; ?></b>　制单时间：<b><?php echo DateFormat($val['add_time']); ?></b></td>
	    </tr>
	<tr>
		<td colspan="3" align="center" style="font-size:20px;padding:16px 0px;">出库单 <font style="font-size:12px;"></font></td>
	</tr>
	<tr style="font-size:13px;">
		<td align="left">销售渠道：<b><?php echo $val['channel_name']; ?></b></td>
	    <td align="left" width="10"></td>
	    <td align="right">出货仓库：<b><?php echo $warehouse_info['name']; ?></b>　　物流公司：<b><?php echo $val['logistics_company']; ?></b></td>
	</tr>
</table>
<table width="800"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#000000" style="margin:0 auto 0px;" class="ckd_xiaofw">
		<tr>
			<td width="50" align="center" bgcolor="#FFFFFF">商品ID</td>
			<td width="80" align="center" bgcolor="#FFFFFF">商品SKU</td>
			<td align="left" bgcolor="#FFFFFF">商品名称</td>
			<td align="center" bgcolor="#FFFFFF">属性</td>
			<td width="50" align="center" bgcolor="#FFFFFF">数量</td>
		</tr>
		<?php
if ( $val['list'] )
{
foreach ( $val['list'] as $v )
{
?>
		<tr>
			<td align="center" bgcolor="#FFFFFF"><?php echo $v['sku_info']['product']['id']; ?></td>
			<td align="center" bgcolor="#FFFFFF"><?php echo $v['sku']; ?></td>
			<td align="left" bgcolor="#FFFFFF"><?php echo $v['sku_info']['product']['name']; ?></td>
			<td align="center" bgcolor="#FFFFFF"><?php echo $v['sku_info']['attribute']; ?></td>
			<td align="center" bgcolor="#FFFFFF"><?php echo $v['total_quantity']; ?></td>
		</tr>
		<?php
}
}
?>
</table>

</td>
</tr>
</table>

<table border="0" height="60" width="800" align="center" style="margin:10px auto 18px;font-size:13px;">
	<tr>
		<td width="200" align="left" >制单人：<?php echo $val['user_name']; ?></td>
	    <td width="200" align="left" >出货人：</td>
	    <td width="200" align="left" >主管人：</td>
		<td width="200" align="left" >收货人：</td>
	</tr>
</table>

<?php $timer = $timer+1; ?>
<?php
if ( $timer <= $total )
{
?>
<hr style="page-break-after:always;"/>
<?php
}
?>

<?php
}
}
?>

</body>
</html>