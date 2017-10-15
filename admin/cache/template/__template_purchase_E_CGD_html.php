<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-12-03 16:11:25
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<link href="css/cal/zpcal.css" rel="stylesheet" type="text/css">
<link href="css/cal/template.css" rel="stylesheet" type="text/css">
<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>
<style>
.xiao_1 input{border:#999999 1px solid;height:16px;}
.xiao_1 select{border:#999999 1px solid;height:20px;}
.xiao_2{float:left;width:20px;height:20px; text-align:center;border:#666666 1px solid;margin-right:6px;}
.xiao_3{float:left;width:20px;height:20px; text-align:center;border:#666666 1px solid;margin-right:6px;color:#FFFFFF; background:#000000;}
.xiao_21{float:left;width:20px;height:20px; text-align:center;border:#666666 1px solid;margin-right:25px;}
.xiao_22{float:right;width:20px;height:20px; text-align:center;border:#666666 1px solid;}
a{ text-decoration:none}
a:hover{ text-decoration:underline}
</style>
<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
<div style="margin:0px auto;width:1220px; padding:0px;">
<ul style="float:left;width:950px;">
<dl style="float:left;width:928px;margin:0px;padding:10px;margin-bottom:20px;border:#999999 1px solid; background:#FFFFFF;">
<dt style="float:left;width:740px;">
<div style="float:left;width:740px; padding-bottom:5px;">
<span style="float:left;">采购单号：<b><font color="#0066CC"><?php echo $val['id']; ?></font></b>　　下单日期：<b><font color="#0066CC"><?php echo $val['add_time']; ?></font></b></span>
<span style="float:right;">供货商：<b><font color="#0066CC"><?php echo $val['supplier_name']; ?></font></b></span>
</div>
<div style="float:left;width:740px; padding-bottom:10px; padding-top:5px;">

<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
<?php
if ( $val['type'] == 1 )
{
?><tr>
<td colspan="5" bgcolor="#FFFFFF" style="padding:5px;" align="left">
采购项目：<?php echo $val['comment']; ?>
</td>
</tr>
<?php
}
?>
<tr style=" background:url(image/sort_row_bg.gif) repeat-x left top;line-height:25px; font-weight:bold;">
<th width="180">
<?php
if ( $val['type'] == 2 )
{
?>
<table cellspacing="0" width="180" >
<tr>
<th width="80"><div align="center">销售渠道</div></th>
<th width="30"><div align="center">数量</div></th>
<th width="70"><div align="center">售价</div></th>
</tr>
</table>
<?php
}
else
{
?>&nbsp;采购说明<?php
}
?>
</th>
<th width="" ><div align="left">&nbsp;名称</div></th>
<th width="40"><div align="center">数量</div></th>
<th width="70"><div align="center">采购单价</div></th>
<?php
if ( $val['type'] == 2 )
{
?><th width="70"><div align="center">代发运费</div></th><?php
}
?>
<th width="70"><div align="center">合计/元</div></th>
</tr>

<?php
if ( $val['productList'] )
{
foreach ( $val['productList'] as $row )
{
?>
<form method="get" action="?" name="CGD" id="CGD" enctype="multipart/form-data">
<input type="hidden" value="purchase.E_CGD" id="mod" name="mod" />
<input type="hidden" value="<?php echo $PurchaseID; ?>" id="id" name="id" />
<input type="hidden" value="<?php echo $row['id']; ?>" id="pid" name="pid" />
<input type="hidden" value="1" id="up" name="up" />

<tr>
<td align="left" bgcolor="#FFFFFF">
<input type="submit" value="确认" />
</td>
			<td bgcolor="#FFFFFF" style="padding:5px;line-height:1.3;" title="商品ID:<?php echo $row['product_id']; ?>　商品SKU：<?php echo $row['sku']; ?>"><?php echo $row['sku_info']['product']['name']; ?>
			<?php
if ( $row['sku_info']['attribute'] )
{
?>　<font color="#CC0000"><?php echo $row['sku_info']['attribute']; ?></font><?php
}
?>
			</td>
<td align="center" bgcolor="#FFFFFF"><input name="quantity" type="text" value="<?php echo $row['quantity']; ?>" /></td>
<td align="center" bgcolor="#FFFFFF"><input name="price" type="text" value="<?php echo $row['price']; ?>" /></td>
<?php
if ( $val['type'] == 2 )
{
?><td align="center" bgcolor="#FFFFFF"><input name="help_cost" type="text" value="<?php echo $row['help_cost']; ?>" /></td><?php
}
?>
<td align="center" bgcolor="#FFFFFF">&yen;<?php echo FormatMoney($row['all_money']); ?></td>
</tr>
</form>

<?php
}
}
?>
		<tr>
			<td colspan="<?php
if ( $val['type'] == 2 )
{
?>6<?php
}
else
{
?>5<?php
}
?>" align="right" bgcolor="#FFFFFF" style="padding:5px;">
			<b>合计：￥<?php echo $val['all_money']; ?></b></td>
		</tr>
	</tbody>
</table>
</div>


</dt>

		

</dl>
</ul>

</div>
<?php
}
}
?>
