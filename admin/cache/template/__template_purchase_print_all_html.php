<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-11-27 10:43:58
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
<?php $line = 0; ?>

<?php $timer = 1; ?>
<?php $total = count($purchase_all); ?>

<?php
if ( $purchase_all )
{
foreach ( $purchase_all as $purchase_val )
{
?>
<div style="margin:0px auto;width:800px;height:545px;border:#999999 1px solid;">
<table border="0" width="750" align="center" style="margin:10px auto 10px;">
	<tr>
		<td width="" style="line-height:1.6;">
采购单号：<?php echo $purchase_val['id']; ?><br />
制单日期：<?php echo DateFormat($purchase_val['info']['add_time']); ?><br />
制单人员：<?php echo $purchase_val['info']['user_name']; ?>
		</td>
		<td align="center">
			<h1 style="font-size:25px;"><?php echo $company_name; ?>采购单</h1>
		</td>
		<td width="" align="right" style="line-height:1.6;">
供应商：<?php echo $purchase_val['info']['supplier_name']; ?><br />
开户行：<?php echo $purchase_val['info']['supplier_account_bank']; ?><br />
帐号：<?php echo $purchase_val['info']['supplier_account_number']; ?></td>
	</tr>
</table>
<table width="750"  border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#333333" style="margin:0 auto 0px;">
	<thead>
		<tr>
			<th width="180" bgcolor="#FFFFFF">
		<table cellspacing="0" width="180" >
								<tr>
									<th width="80">销售渠道</th>
									<th width="30"><div align="center">数量</div></th>
									<th width="70"><div align="center">售价</div></th>
								</tr>
			</table>
		</th>
			<th width="" height="25" bgcolor="#FFFFFF"><nobr>名称<nobr></th>
			<th width="40" bgcolor="#FFFFFF">数量</th>
			<th width="70" bgcolor="#FFFFFF">采购单价</th>
			<th width="70" bgcolor="#FFFFFF">代发运费</th>
			<th width="70" bgcolor="#FFFFFF">合计/元</th>
		</tr>
	</thead>
		<?php
if ( $purchase_val['list'] )
{
foreach ( $purchase_val['list'] as $val )
{
?>
		<tr>
		<td align="center" bgcolor="#FFFFFF">

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
									<td align="center" width="30" ><?php echo $row['totalnum']; ?></td>
									<td align="center" width="70"><?php echo $row['price']; ?></td>
								</tr>
								<?php
}
}
?>
						</table>
					<?php
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
			<td align="center" bgcolor="#FFFFFF">
				&yen;<?php echo $val['help_cost']; ?>			</td>
			<td align="center" bgcolor="#FFFFFF">
				&yen;<?php echo $val['all_money']; ?>			</td>
		</tr>
		<?php
}
}
?>
		<tr>
			<td colspan="6" align="right" bgcolor="#FFFFFF" style="padding:5px;"><b>合计(人民币大写)：<?php echo CapsMoney($purchase_val['info']['all_money']); ?></b>　　　　<b>合计：￥<?php echo $purchase_val['info']['all_money']; ?></b></td>
		</tr>
		<?php
if ( $purchase_val['info']['comment'] )
{
?>
		<tr>
		  <td colspan="6" bgcolor="#FFFFFF" style="padding:5px;" align="left">
		  备注：<?php echo $purchase_val['info']['comment']; ?>
		  </td>
		</tr>
		<?php
}
?>
		<tr>
		  <td colspan="6" bgcolor="#FFFFFF" style="padding:5px;" align="LEFT">
		  采购审核<?php echo $purchase_val['workflow']['sign_pro_mg']; ?><?php echo $purchase_val['workflow']['sign_ope_mj']; ?><?php echo $purchase_val['workflow']['sign_ope_vc']; ?><?php echo $purchase_val['workflow']['pay_lock_user']; ?><?php echo $purchase_val['workflow']['pay_user']; ?>
		  </td>
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