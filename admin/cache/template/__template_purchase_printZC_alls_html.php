<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-11-26 15:19:49
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
	font-family:"宋体";
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

.xiaofw_p1 td{font-size:16px;}
.xiaofw_p2 span{font-size:13px;float:left; padding:3px 10px;font-weight:normal;}
.xiaofw_p3 td{font-size:16px; font-weight:bold;}
.xiaofw_p3 td span{font-weight:normal;font-size:16px; }
</style>

</head>


<body>

<?php $line = 0; ?>
<?php $timer = 1; ?>
<?php $total = count($list); ?>

<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
<div style="margin:0px auto;width:870px; display:table;padding-left:30px;position:relative;">
<div style=" position:absolute;width:50px;left:0px;top:0px;height:600px;border-bottom:#000000 1px solid;"></div>
<div style=" position:absolute;width:50px;right:0px;top:0px;height:600px;border-bottom:#000000 1px solid;"></div>
<table border="0" width="750" align="center" style="margin:0px auto;">
	<tr>
<td align="center" style="height:40px;padding-top:5px;font-size:30px;letter-spacing:15px; font-weight:bold;"><?php echo $company_name; ?>支出证明单</td>
	</tr>
</table>
<table border="0" width="750" align="center" style="margin:0px auto 10px;">
	<tr>
		<td align="center" style="font-size:18px; text-align:right;" valign="top"><?php echo DateFormat(time(),'Y'); ?> 年 <?php echo DateFormat(time(),'m'); ?> 月 <?php echo DateFormat(time(),'d'); ?> 日　　　　　　　　　　</td>
	</tr>
</table>
<table border="0" width="750" align="center" style="margin:0px auto;">
	<tr>
		<td align="left" width="300" style="font-size:15px;">项目名称：<b style="font-size:15px;">
		<?php
if ( $val['channel_name'] )
{
?><?php echo $val['channel_name']; ?><?php
}
else
{
?><?php
}
?>
		</b></td>
		<td align="left" style="font-size:15px;">项目编号：</td>
		<td align="right" style="font-size:15px;">增票(&nbsp;&nbsp;)　普票(&nbsp;&nbsp;)　无票(&nbsp;&nbsp;)　税率(&nbsp;&nbsp;)</td>
	</tr>
</table>
<table width="750"  border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#333333" style="margin:0 auto 0px;">
<tr>
<td rowspan="2" align="center" bgcolor="#FFFFFF" height="40">摘　　　　要</td>
<td colspan="10" align="center" bgcolor="#FFFFFF" height="20">金　　额</td>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" height="20" width="20">千</td>
<td align="center" bgcolor="#FFFFFF" height="20" width="20">百</td>
<td align="center" bgcolor="#FFFFFF" height="20" width="20">十</td>
<td align="center" bgcolor="#FFFFFF" height="20" width="20">万</td>
<td align="center" bgcolor="#FFFFFF" height="20" width="20">千</td>
<td align="center" bgcolor="#FFFFFF" height="20" width="20">百</td>
<td align="center" bgcolor="#FFFFFF" height="20" width="20">十</td>
<td align="center" bgcolor="#FFFFFF" height="20" width="20">元</td>
<td align="center" bgcolor="#FFFFFF" height="20" width="20">角</td>
<td align="center" bgcolor="#FFFFFF" height="20" width="20">分</td>
</tr>

<?php $num = 0; ?>
<?php
if ( $val['product'] )
{
foreach ( $val['product'] as $row )
{
?>
<tr class="xiaofw_p1">
<td align="left" bgcolor="#FFFFFF" class="xiaofw_p2"><span><?php echo $row['productName']; ?>　*<?php echo $row['totalQuantity']; ?>　[单价：<?php echo $row['productPrice']; ?>]</span></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($row['totalPrice'],8); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($row['totalPrice'],7); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($row['totalPrice'],6); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($row['totalPrice'],5); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($row['totalPrice'],4); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($row['totalPrice'],3); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($row['totalPrice'],2); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($row['totalPrice'],1); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($row['totalPrice'],9); ?></td>
<td align="center" bgcolor="#FFFFFF" height="30"><?php echo markMoney($row['totalPrice'],10); ?></td>
</tr>
<?php $num = $num+1; ?>
<?php
}
}
?>

<?php
if ( $val['costPrice'] > 0 )
{
?>
<tr class="xiaofw_p1">
<td align="left" bgcolor="#FFFFFF" class="xiaofw_p2"><span>运费</span></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['costPrice'],8); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['costPrice'],7); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['costPrice'],6); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['costPrice'],5); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['costPrice'],4); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['costPrice'],3); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['costPrice'],2); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['costPrice'],1); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['costPrice'],9); ?></td>
<td align="center" bgcolor="#FFFFFF" height="30"><?php echo markMoney($val['costPrice'],10); ?></td>
</tr>
<?php $num = $num+1; ?>
<?php
}
?>

<?php
if ( $num < 5 )
{
?>
<tr class="xiaofw_p1">
<td align="left" bgcolor="#FFFFFF" class="xiaofw_p2">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF" height="30">&nbsp;</td>
</tr>
<?php $num = $num+1; ?>
<?php
}
?>
<?php
if ( $num < 5 )
{
?>
<tr class="xiaofw_p1">
<td align="left" bgcolor="#FFFFFF" class="xiaofw_p2">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF" height="30">&nbsp;</td>
</tr>
<?php $num = $num+1; ?>
<?php
}
?>
<?php
if ( $num < 5 )
{
?>
<tr class="xiaofw_p1">
<td align="left" bgcolor="#FFFFFF" class="xiaofw_p2">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF" height="30">&nbsp;</td>
</tr>
<?php $num = $num+1; ?>
<?php
}
?>
<?php
if ( $num < 5 )
{
?>
<tr class="xiaofw_p1">
<td align="left" bgcolor="#FFFFFF" class="xiaofw_p2">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF" height="30">&nbsp;</td>
</tr>
<?php $num = $num+1; ?>
<?php
}
?>

<tr class="xiaofw_p3">
<td align="left" bgcolor="#FFFFFF" width="550" style="font-size:14px;">&nbsp;<span>合计：(大写)　<?php echo CapsMoney($val['totalMoney']); ?></span></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['totalMoney'],8); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['totalMoney'],7); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['totalMoney'],6); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['totalMoney'],5); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['totalMoney'],4); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['totalMoney'],3); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['totalMoney'],2); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['totalMoney'],1); ?></td>
<td align="center" bgcolor="#FFFFFF"><?php echo markMoney($val['totalMoney'],9); ?></td>
<td align="center" bgcolor="#FFFFFF" height="40"><?php echo markMoney($val['totalMoney'],10); ?></td>

</tr>
<tr>
<td height="25" colspan="11" align="left" bgcolor="#FFFFFF" style="font-size:14px;">
&nbsp;付款种类：采购□　　　　　　　运费□　　　　　　　样品□　　　　　　　日常费用□　　　　　　　其他□</td>
</tr>
<tr>
<td height="25" colspan="11" align="left" bgcolor="#FFFFFF" style="font-size:14px;">
&nbsp;付款方式：现金□　　　　　　　　　　转账支票□　　　　　　　　　　转账汇款□　　　　　　　　　其他□</td>
</tr>
<tr>
<td height="25" colspan="11" align="left" bgcolor="#FFFFFF">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="2" align="left" style="font-size:14px;">&nbsp;收款公司：<?php echo $info['supplier_name']; ?></td>
    <td align="left" style="font-size:13px; padding-top:3px;">开户行：<?php echo $info['supplier_account_bank']; ?></td>
  </tr>
  <tr>
    <td align="left" style="font-size:13px; padding-bottom:3px; padding-top:2px;">帐　号：<?php echo $info['supplier_account_number']; ?></td>
  </tr>
</table>


</td>
</tr>
<tr>
<td height="25" colspan="11" align="left" bgcolor="#FFFFFF" style="font-size:14px;">&nbsp;结算方式：月结□　　　　　　　　　　　　　　　　　　现结□　　　　　　　　　　　　　　　　　　其他□</td>
</tr>
</table>
<table border="0" width="750" align="center" style="margin:5px auto 0px;">
<tr>
<td align="left" style="font-size:14px;">总经理：</td>
<td align="left" style="font-size:14px;">经理：　</td>
<td align="left" style="font-size:14px;">财务主管：</td>
<td align="left" style="font-size:14px;">出纳：　</td>
<td align="left" style="font-size:14px;">经办人：</td>
<td align="left" style="font-size:14px;">领款人：</td>
</tr>
</table>
</div>


<?php $timer = $timer+1; ?>
<?php $line = $line+1; ?>

<?php
if ( $timer <= $total )
{
?>
<hr style="page-break-after:always;color:#FFFFFF;border:#FFFFFF; background:#FFFFFF;"/>
<?php
}
?>

<?php
if ( $timer <= $total && $line == 1 )
{
?>


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