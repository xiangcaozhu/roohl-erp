<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-08 17:01:17
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
	border:1px solid #ccc;
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

<?php $timer = 1; ?>
<?php $total = count($list); ?>

<?php
if ( $list )
{
foreach ( $list as $val )
{
?>

<table width="100%" border="0">
<tr>
<td height="" valign="top" align="center">

<table border="0" width="800" align="center" style="margin:10px auto 18px;">
	<tr>
		<td align="center" style="font-size:16px;padding:12px 0px;">
			北京志祥创付商贸有限公司
		</td>
	</tr>
	<tr>
		<td align="left" style="font-size:12px;">
			渠道:<?php echo $val['name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			流水号:KRD<?php echo $val['id']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			下单时间:<?php echo DateFormat($val['add_time']); ?>
		</td>
	</tr>
	<tr>
		<td align="left" style="font-size:12px;">
			客户名称:<?php echo $val['order_customer_name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			发票抬头:<?php echo $val['order_invoice_header']; ?>
		</td>
	</tr>
</table>
<table  border="0" width="800" align="center" style="margin:0 auto 0px;">
	<thead>
		<tr>
			<th width="100" align="left">商品编号</th>
			<th width="300" align="left"><nobr>商品名称<nobr></th>
			<th width="50">数量</th>
			<th width="50">单价</th>
			<th width="50">小计</th>
			<th width="150" align="left">属性</th>
		</tr>
	</thead>
	<tbody>
		<?php
if ( $val['product_list'] )
{
foreach ( $val['product_list'] as $v )
{
?>
		<tr>
			<td align="left">
				<?php echo $v['target_id']; ?>
			</td>
			<td align="left">
				<?php echo $v['sku_info']['product']['name']; ?>
			</td>
			<td align="center">
				<?php echo $v['quantity']; ?>
			</td>
			<td align="center">
				<?php echo $v['price']; ?>
			</td>
			<td align="center">
				<?php
				echo $v['price'] * $v['quantity'];
				?>
			</td>
			<td align="left">
				<?php echo $v['sku_info']['attribute']; ?>
			</td>
		</tr>
		<?php
}
}
?>
	</tbody>
</table>

</td>
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