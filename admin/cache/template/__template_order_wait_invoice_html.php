<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-08-26 16:13:40
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



.xiaofw_1 td{padding:2px;}
.xiaofw_2 td{padding:2px;border-left:0px;border-top:0px;}
</style>

</head>


<body>
<?php $line = 0; ?>

<?php $timer = 1; ?>
<?php $total = count($list); ?>

<?php
if ( $list )
{
foreach ( $list as $info )
{
?>
<div style="margin:0px auto;width:800px;height:540px;border:#999999 1px solid;">
<table border="0" width="750" align="center" style="margin:10px auto 10px;"><tr><td width="" style="line-height:1.6;font-size:18px;" align="center">开票审核单
<font>（<?php
if ( $info['order_invoice'] == 1 )
{
?>发票<?php
}
else
{
?>收据<?php
}
?>）</font>
</td></tr></table>
<div style="height:420px;">
<table width="750"  border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#333333" style="margin:0 auto 0px;" class="xiaofw_1">
  <tr>
    <td bgcolor="#FFFFFF" width="100"><div align="center">申请日期</div></td>
    <td bgcolor="#FFFFFF"><span style="float:left;">　<?php echo DateFormat(time(),'Y-m-d H:i'); ?></span><span style="float:right;">订单号：<?php echo $info['id']; ?>　</span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center">单位名称</div></td>
    <td bgcolor="#FFFFFF">　<?php echo $info['order_invoice_header']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center">所属项目</div></td>
    <td bgcolor="#FFFFFF">　<?php echo $info['channel_name']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center">开票内容</div></td>
    <td bgcolor="#FFFFFF" style="padding:0px;border-right:0px;border-bottom:0px;">
<table width="650"  border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#333333" style="margin:0 auto 0px;border:0px;" class="xiaofw_2">
  <tr  style="border:0px;">
    <td bgcolor="#FFFFFF" width="30"><div align="center">序号</div></td>
    <td bgcolor="#FFFFFF"><div align="left">　名称</div></td>
    <td bgcolor="#FFFFFF" width="30"><div align="center">数量</div></td>
    <td bgcolor="#FFFFFF" width="70"><div align="center">单价</div></td>
    <td bgcolor="#FFFFFF" width="70"><div align="center">总金额</div></td>
	<td bgcolor="#FFFFFF" width="70"><div align="center">优惠券</div></td>
	 <td bgcolor="#FFFFFF" width="70"><div align="center">实开</div></td>
  </tr>
  <?php $timer_p = 1; ?>
  <?php
if ( $info['list'] )
{
foreach ( $info['list'] as $row )
{
?>
<?php
if ( $row['price'] > 0 )
{
?>
  <tr>
    <td bgcolor="#FFFFFF" align="center"><?php echo $timer_p; ?></td>
    <td bgcolor="#FFFFFF" align="left">　<?php echo $row['out_name']; ?></td>
    <td bgcolor="#FFFFFF" align="center"><?php echo $row['quantity']; ?></td>
    <td bgcolor="#FFFFFF" align="center"><?php echo $row['price']; ?></td>
    <td bgcolor="#FFFFFF" align="center"><?php echo $row['total_price']; ?></td>
	 <td bgcolor="#FFFFFF" align="center"><?php echo $row['coupon_price']; ?></td>
	  <td bgcolor="#FFFFFF" align="center"><?php echo FormatMoney($row['okMoney']); ?></td>
  </tr>
  <?php $timer_p = $timer_p+1; ?>
<?php
}
?>
  <?php
}
}
?>
  <tr>
    <td bgcolor="#FFFFFF" align="center"><?php echo $timer_p; ?></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
	 <td bgcolor="#FFFFFF">&nbsp;</td>
	  <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>

	
	
	</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center">开票明细<br />（货物明细）</div></td>
    <td bgcolor="#FFFFFF" style="padding:0px;border-right:0px;border-bottom:0px;">
<table width="650"  border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#333333" style="margin:0 auto 0px;border:0px;" class="xiaofw_2">
  <tr  style="border:0px;">
    <td bgcolor="#FFFFFF" width="30"><div align="center">序号</div></td>
    <td bgcolor="#FFFFFF" width="50"><div align="center">商品ID</div></td>
    <td bgcolor="#FFFFFF" width="70"><div align="center">银行编号</div></td>
    <td bgcolor="#FFFFFF"><div align="left">　银行销售名称</div></td>
    <td bgcolor="#FFFFFF" width="70"><div align="center">销售属性</div></td>
  </tr>
  <?php $timer_p = 1; ?>
  <?php
if ( $info['list'] )
{
foreach ( $info['list'] as $row )
{
?>
  <?php
if ( $row['price'] > 0 )
{
?>
  <tr>
    <td bgcolor="#FFFFFF" align="center"><?php echo $timer_p; ?></td>
    <td bgcolor="#FFFFFF" align="center"><?php echo $row['sku_info']['product']['id']; ?></td>
    <td bgcolor="#FFFFFF" align="center"><?php echo $row['target_id']; ?></td>
    <td bgcolor="#FFFFFF" align="left">　<?php echo $row['extra_name']; ?></td>
    <td bgcolor="#FFFFFF" align="center"><?php echo $row['sku_info']['attribute']; ?></td>
  </tr>
  <?php $timer_p = $timer_p+1; ?>
  <?php
}
?>
  <?php
}
}
?>
  <tr>
    <td bgcolor="#FFFFFF" align="center"><?php echo $timer_p; ?></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>

</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center">开票类别</div></td>
    <td bgcolor="#FFFFFF">　普通机打（　）　　增票（　）　　地税票（　）　　普票手写（　）</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center">发票号码<br />（财务填写）</div></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center">预计回款日</div></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center">备注</div></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</div>

<table border="0" width="750" align="center" style="margin:0px auto 10px;"><tr>
<td width="250" align="left">　总经理：</td>
<td width="250" align="left">财务主管：</td>
<td align="left">销售人员：</td>
</tr></table>

<table border="0" width="800" align="center" style="margin:0px auto 0px;">
	<tr>
		<td width="" align="left">
		</td>
		<td width="" align="right">
		</td>
	</tr>
</table>
</div>
<?php $timer = $timer+1; ?>
<?php $line = $line+1; ?>


<?php
if ( $timer <= $total && $line == 2 )
{
?>
<hr style="page-break-after:always;"/>
<?php
}
?>

<?php
if ( $timer <= $total && $line == 1 )
{
?>
<BR /><BR /><BR />
<?php
}
?>

<?php
if ( $line == 2 )
{
?>
<?php $line = 0; ?>
<?php
}
?>

<?php
}
}
?>
</body>
</html>