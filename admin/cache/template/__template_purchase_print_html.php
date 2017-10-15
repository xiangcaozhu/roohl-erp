<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-07-10 09:50:49
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


<table border="0" width="750" align="center" style="margin:10px auto 10px;">
	<tr>
		<td width="" style="line-height:1.6;">
采购单号：<?php echo $info['id']; ?><br />
制单日期：<?php echo DateFormat($info['add_time']); ?><br />
制单人员：<?php echo $info['user_name']; ?>
		</td>
		<td align="center">
			<h1 style="font-size:18px;"><?php echo $company_name; ?>采购单</h1>
		</td>
		<td width="" align="right" style="line-height:1.6;">
供应商：<?php echo $info['supplier_name']; ?><br />
开户行：<?php echo $info['supplier_account_bank']; ?><br />
帐号：<?php echo $info['supplier_account_number']; ?></td>
	</tr>
</table>
<table width="750"  border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#333333" style="margin:0 auto 0px;">
	<thead>
		<tr>
			<th width="180" bgcolor="#FFFFFF">
			<?php
if ( $info['type'] == 2 )
{
?>
		<table cellspacing="0" width="180" >
								<tr>
									<th width="80">销售渠道</th>
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
			<th width="" height="25" bgcolor="#FFFFFF"><nobr>名称<nobr></th>
			<th width="40" bgcolor="#FFFFFF">数量</th>
			<th width="70" bgcolor="#FFFFFF">采购单价</th>
			<?php
if ( $info['type'] == 2 )
{
?><th width="70" bgcolor="#FFFFFF">代发运费</th><?php
}
?>
			<th width="70" bgcolor="#FFFFFF">合计/元</th>
		</tr>
	</thead>
	<tbody>
		<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
		<tr>
			<td align="center" bgcolor="#FFFFFF">
<?php
if ( $info['type'] == 2 )
{
?>
<?php
if ( $val['relation_list'] )
{
?>
						<table cellspacing="0" width="180" >
								<?php
if ( $val['relation_list'] )
{
foreach ( $val['relation_list'] as $row )
{
?>
								<tr>
									<td align="center"  width="80" height="22"><?php echo $row['channel_name']; ?></td>
									<td align="center" width="30" ><?php echo $row['total_quantity']; ?></td>
									<td align="center" width="70">
									<?php
if ( $row['channel_id'] == 75 )
{
?>
									<?php echo FormatMoney($row['bj_price']/$row['total_quantity']); ?>
									<?php
}
else
{
?>
									<?php echo FormatMoney($row['xs_price']); ?>
									<?php
}
?></td>
								</tr>
								<?php
}
}
?>
						</table>
<?php
}
?>
<?php
}
else
{
?>&nbsp;<?php echo $val['comment']; ?><?php
}
?>

</td>
			<td bgcolor="#FFFFFF" style="padding:5px;line-height:1.6;"><?php echo $val['product_id']; ?> / <?php echo $val['sku']; ?> / <?php echo $val['sku_info']['product']['name']; ?>
			<?php
if ( $val['sku_info']['attribute'] )
{
?> / <?php echo $val['sku_info']['attribute']; ?><?php
}
?>
			<?php
if ( $val['comment'] )
{
?><br />备注：<?php echo $val['comment']; ?><?php
}
?>
			</td>
			<td align="center" bgcolor="#FFFFFF">
				<?php echo $val['quantity']; ?>&nbsp;			</td>
			<td align="center" bgcolor="#FFFFFF">
				&yen;<?php echo $val['price']; ?>			</td>
			<?php
if ( $info['type'] == 2 )
{
?><td align="center" bgcolor="#FFFFFF">&yen;<?php echo $val['help_cost']; ?></td><?php
}
?>
			<td align="center" bgcolor="#FFFFFF">
				&yen;<?php echo FormatMoney($val['all_money']); ?>			</td>
		</tr>
		<?php
}
}
?>
		<tr>
			<td colspan="<?php
if ( $info['type'] == 2 )
{
?>6<?php
}
else
{
?>5<?php
}
?>" align="right" bgcolor="#FFFFFF" style="padding:5px;"><b>合计(人民币大写)：<?php echo CapsMoney($info['all_money']); ?></b>　　　　<b>合计：￥<?php echo $info['all_money']; ?></b></td>
		</tr>
		<?php
if ( $info['comment'] && $info['type'] == 2 )
{
?>
		<tr>
		  <td colspan="6" bgcolor="#FFFFFF" style="padding:5px;" align="left">
		  备注：<?php echo $info['comment']; ?>
		  </td>
		</tr>
		<?php
}
?>
		<tr>
		  <td colspan="<?php
if ( $info['type'] == 2 )
{
?>6<?php
}
else
{
?>5<?php
}
?>" bgcolor="#FFFFFF" style="padding:5px;" align="right">
		  采购审核<?php echo $workflow['sign_pro_mg']; ?><?php echo $workflow['sign_ope_mj']; ?><?php echo $workflow['sign_ope_vc']; ?><?php echo $workflow['pay_lock_user']; ?><?php echo $workflow['pay_user']; ?>
		  </td>
		</tr>
	</tbody>
</table>
<table border="0" width="800" align="center" style="margin:0px auto 0px;">
	<tr>
		<td width="" align="left">
		</td>
		<td width="" align="right">
		</td>
	</tr>
</table>

</body>
</html>