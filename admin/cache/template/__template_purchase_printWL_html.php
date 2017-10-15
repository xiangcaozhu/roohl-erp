<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-11-16 09:32:31
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<style type="text/css">

body{
	padding:0px 0px;
}

*{
	padding:0px;
	margin:0px;
	font-family:tahoma,"Lucida Grande","Lucida Sans",sans,Hei;
	font-size:12px;
}

a{
	color:#0066CC;
	text-decoration:underline;
}

a:hover{
	color:#FF7031;
	text-decoration:none;
}

h3{
	font-size:14px;
	font-weight:bold;
	color:#444;
	margin-bottom:10px;
}

input {
	vertical-align:middle;
	padding:3px;
}

input.in{
	padding:2px;
	width:220px;
	border:0px solid #ccc;
	height:20px;
	padding-top:10px;
}

select{
	padding:3px;
	/*font-size:11px;*/
}

input.btn {
	cursor:pointer;
	height:28px;
}

.img{
	border:1px solid #ccc;
	padding:2px;
}

ul {list-style-image:none;list-style-position:none;list-style-type:none;}

#tab{
	width:960px;
}

#tab td{
	padding:4px;
}

#tab th{
	padding:2px;
}


</style>

</head>


<body>

<div style="margin:10px auto;width:750px;">
<table border="0" width="750" align="center" style="margin:10px auto 0px;">
	<tr>
		<td align="left">
采购单号：<?php echo $info['id']; ?><br />
下单日期：<?php echo DateFormat($info['add_time']); ?><br />
制单人员 ：<?php echo $info['user_name']; ?><br />
供货商：<?php echo $info['supplier_name']; ?>
</td>
		<td width="*" align="right"><h1 style="font-size:18px;"><?php echo $company_name; ?>发货单</h1></td>
	</tr>
</table>

<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
<table width="750" border="0" cellspacing="1" style="border-top:0px;margin:20px 0px 0px 0px;" bgcolor="#333333">
								<tr>
									<td colspan="4" bgcolor="#FFFFFF" style=" padding:5px 0px"><div style="float:left; padding-left:15px;">订 单 号：<?php echo $val['info']['id']; ?></div>
								    <div style="float:right; padding-right:15px;"><?php echo $val['info']['channel_name']; ?>　<?php echo DateFormat($val['info']['order_time'],'Y-m-d'); ?></div></td>
								</tr>


<tr><td colspan="4" bgcolor="#FFFFFF" style=" padding:5px 0px"><div style="float:left; padding-left:15px;">
客服备注：
<?php
if ( $val['serviceCheckList'] )
{
foreach ( $val['serviceCheckList'] as $row )
{
?>
<?php echo $row['comment']; ?> / 
<?php
}
}
?>
</div></td>
</tr>




								<tr class="header">
									<th width="100" bgcolor="#FFFFFF" style=" padding:5px 0px">收货人</th>
									<th width="150" bgcolor="#FFFFFF"  style=" padding:5px 0px">电话</th>
									<th bgcolor="#FFFFFF"  style=" padding:5px 0px">地址</th>
									<th width="70" bgcolor="#FFFFFF" style=" padding:5px 0px">邮编</th>
								</tr>
								<tr>
									<td align="center" bgcolor="#FFFFFF" style="padding:5px;"><?php echo $val['info']['order_shipping_name']; ?></td>
									<td align="center" bgcolor="#FFFFFF" style="padding:5px;">
									<?php echo $val['info']['order_shipping_phone']; ?>
									<?php
if ( $val['info']['order_shipping_phone'] && $val['info']['order_shipping_mobile'] )
{
?> / <?php
}
?>
									<?php echo $val['info']['order_shipping_mobile']; ?>									</td>
									<td bgcolor="#FFFFFF" style="padding:5px;" ><?php echo $val['info']['order_shipping_address']; ?></td>
									<td bgcolor="#FFFFFF" style="padding:5px;" align="center"><?php echo $val['info']['order_shipping_zip']; ?></td>
								</tr>
</table>
					  
<table width="750"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#333333">
<tr class="header">
									<th width="50" bgcolor="#FFFFFF"  style=" padding:5px 0px">ID</th>
									<th width="100" bgcolor="#FFFFFF" style=" padding:5px 0px">SKU</th>
									<th bgcolor="#FFFFFF"  style=" padding:5px 0px" align="left">&nbsp;名称</th>
									<th width="100" bgcolor="#FFFFFF"  style=" padding:5px 0px">属性</th>
									<th width="50" bgcolor="#FFFFFF" style=" padding:5px 0px">数量</th>
									<th width="80" bgcolor="#FFFFFF" style=" padding:5px 0px">零售价</th>
</tr>
<?php
if ( $val['ProductInfo'] )
{
foreach ( $val['ProductInfo'] as $row )
{
?>			  
								<tr>
									<td align="center" bgcolor="#FFFFFF" style="padding:5px;"><?php echo $row['product_id']; ?></td>
									<td align="center" bgcolor="#FFFFFF" style="padding:5px;"><?php echo $row['sku']; ?></td>
									<td align="left" bgcolor="#FFFFFF" style="padding:5px;"><?php echo $row['sku_info']['product']['name']; ?></td>
									<td bgcolor="#FFFFFF" style="padding:5px;" align="center">
									<?php
if ( $row['sku_info']['attribute'] )
{
?><font color="#006600"><?php echo $row['sku_info']['attribute']; ?></font><?php
}
?></td>
									<td bgcolor="#FFFFFF" style="padding:5px;" align="center"><font color="#CC0000"><b><?php echo $row['quantity']; ?></b></font></td>
									<td bgcolor="#FFFFFF" style="padding:5px;" align="center">￥<?php echo $row['price']; ?></td>
								</tr>
<?php
}
}
?>
</table>
<table width="750" border="0" cellspacing="1" style="border-top:0px;margin:0px 0px 0px 0px;" bgcolor="#333333">
<tr>
<td colspan="4" bgcolor="#FFFFFF" style=" padding:5px 0px"><div style="float:left; padding-left:15px;">银行销售单号：<?php echo $val['info']['target_id']; ?></div></td>
</tr>
</table>
<table border="0" width="800" align="center" style="margin:0px auto 0px;">
	<tr>
		<td width="" align="left">
		</td>
		<td width="" align="right">
		</td>
	</tr>
</table>



	<?php
}
}
?>

</div>
</body>
</html>