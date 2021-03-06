<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-05 06:29:27
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
	font-size:14px;
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

<table border="0" width="690" align="center" style="margin:0px auto 18px;">
	<tr>
		<td align="center" style="font-size:20px;padding:12px 0px;">
			入库单
		</td>
	</tr>
	<tr>
		<td align="right" style="font-size:14px;">
			采购单号：<?php echo $val['purchase_id']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			入库单号：<?php echo $val['id']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			仓库：<?php echo $warehouse_info['name']; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			制单时间：<?php echo DateFormat($val['add_time']); ?>
		</td>
	</tr>
</table>
<table  border="1" width="690" align="center" style="margin:0 auto 0px;">
	<thead>
		<tr>
			<th width="120">商品SKU</th>
			<th width=""><nobr>商品名称<nobr></th>
			<th width="100">属性</th>
			<th width="60">数量</th>
			<th width="60">入库价格</th>
			<th width="60">合计</th>
			<th width="80">货位</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$allTotal = 0;
		?>
		<?php
if ( $val['list'] )
{
foreach ( $val['list'] as $v )
{
?>
		
		<tr>
			<td><?php echo $v['sku']; ?></td>
			<td align="center">
				<?php echo $v['sku_info']['product']['name']; ?>&nbsp;
			</td>
			<td align="center">
				<?php echo $v['product']['sku_info']['attribute']; ?>&nbsp;
			</td>
			<td align="center">
				<?php echo $v['quantity']; ?>&nbsp;
			</td>
			<td align="center">
				<?php echo $v['price']; ?>&nbsp;
			</td>
			<td align="center">
				<?php
				$total = FormatMoney( $v['price'] * $v['quantity'] );
				$allTotal += $total;
				?>
				<?php echo $total; ?>&nbsp;
			</td>
			<td align="center">
				<?php echo $v['place_name']; ?>&nbsp;
			</td>
		</tr>
		<?php
}
}
?>
	</tbody>
</table>

<table border="0" width="690" align="center" style="margin:10px auto 18px;">
	<tr>
		<td align="left" width="40%">
			保管员：
		</td>
		<td align="left" width="40%">
			经办人：
		</td>
		<td align="right" width="20%">
			合计：&yen;<?php echo FormatMoney($allTotal); ?>
		</td>
	</tr>
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