<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-08 01:15:01
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


<table border="0" width="850" align="center" style="margin:10px auto 18px;">
	<tr>
		<td width="850" align="center">
			<h1 style="font-size:18px;" align="center">订单销售报表</h1>
		</td>
	</tr>
	<tr>
		<td width="200">
			北京科润迪科技发展有限公司
		</td>
		<td width="100" align="right">
			制表人：<?php echo $creator; ?>
		</td>
	</tr>
	<tr>
		<td width="200">
			日期区间：<?php echo $begin_date; ?> - <?php echo $end_date; ?>  总共<?php echo $total; ?>条记录
		</td>
		<td width="300" align="right">
			制表时间：<?php echo $current_time; ?>
		</td>
	</tr>
</table>
<table  border="1" width="850" align="center" style="margin:0 auto 0px;">
	<thead>
		<tr>
				<th width="40">订单号</th>
				<th width="80">父渠道</th>
				<th width="100">渠道</th>
				<th width="140">出库时间</th>
				<th width="30">是否<BR>开票</th>
				<th width="">商品名称</th>
				<th width="60">单价</th>
				<th width="30">数量</th>
				<th width="60">销售合计</th>
				<th width="60">成本<BR>(不含税)</th>
				<th width="30">数量</th>
				<th width="60">成本合计</th>
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
			<td align="center"><?php echo $info['id']; ?></td>
			<td align="center"><?php echo $info['channel_parent_name']; ?></td>
			<td align="center"><?php echo $info['channel_name']; ?></td>
			<td align="center"><?php echo DateFormat($info['delivery_time']); ?></td>
			<td align="center"><?php
if ( $info['order_invoice_status'] )
{
?><font color="blue">已开发票</font><?php
}
else
{
?><font color="red">未开发票</font><?php
}
?></td>
			<td align="center"><?php echo $info['product_name']; ?></td>
			<td align="right"><?php echo $info['sales_price']; ?></td>
			<td align="center"><?php echo $info['sales_quantity']; ?></td>
			<td align="right"><?php echo $info['total_sales_price']; ?></td>
			<td align="right"><?php echo $info['stock_price']; ?></td>
			<td align="center"><?php echo $info['stock_quantity']; ?></td>
			<td align="right"><?php echo $info['total_stock_price']; ?></td>
		</tr>
		<?php
}
}
?>
	</table>
</table>


</body>
</html>