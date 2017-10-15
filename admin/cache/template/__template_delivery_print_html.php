<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2014-08-05 11:36:27
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">创建出库单，安排出库 → <?php echo $warehouse_info['name']; ?></h3>
	<p class="right">
		<button type="button" onclick="if (confirm('确定创建出库单，安排出库?')){$('#mainform').submit();}">创建出库单，安排出库</button>
	</p>
</div>


<style>
.ckd_xiaofw td{ padding:2px 5px;}

</style>
<?php $timer = 1; ?>
<?php $total = count($list); ?>
<form method="post" action="?mod=delivery.print.output<?php echo $warehouse_uri; ?>" id="mainform">
<?php
if ( $list )
{
foreach ( $list as $val )
{
?>



<input type="hidden" name="delivery_new[]" value="<?php echo $timer; ?>">

<input type="hidden" name="logistics_company_<?php echo $timer; ?>" value="<?php echo $val['logistics_company']; ?>">
<input type="hidden" name="warehouse_id_<?php echo $timer; ?>" value="<?php echo $warehouse_info['id']; ?>">
<input type="hidden" name="channel_id_<?php echo $timer; ?>" value="<?php echo $val['channel_id']; ?>">
<input type="hidden" name="channel_name_<?php echo $timer; ?>" value="<?php echo $val['channel_name']; ?>">


<?php
if ( $val['orderList'] )
{
foreach ( $val['orderList'] as $row )
{
?>
<input type="hidden" name="order_id_<?php echo $timer; ?>[]" value="<?php echo $row['id']; ?>">
<?php
}
}
?>
				
				
<table width="100%" border="0" height="400" cellpadding="0" cellspacing="0">
<tr>
<td height="" valign="top" align="center">

<table border="0" width="800" align="center" style="margin:10px auto 18px;">
	<tr>
		<td colspan="2" align="center" style="font-size:16px;padding:12px 0px;">出库单</td>
	</tr>
	<tr>
		<td align="left" style="font-size:12px;" title="<?php
if ( $val['orderList'] )
{
foreach ( $val['orderList'] as $row )
{
?><?php echo $row['id']; ?>/<?php
}
}
?>">订单编号</td>
	    <td align="left" style="font-size:12px;">出货仓库：<?php echo $warehouse_info['name']; ?></td>
	</tr>
	<tr>
		<td align="left" style="font-size:12px;">销售渠道：<?php echo $val['channel_name']; ?></td>
	    <td align="left" style="font-size:12px;">物流公司：<?php echo $val['logistics_company']; ?></td>
	</tr>
</table>
<table width="800"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#000000" style="margin:0 auto 0px;" class="ckd_xiaofw">
		<tr>
			<td width="40" align="center" bgcolor="#FFFFFF">商品ID</td>
			<td width="70" align="center" bgcolor="#FFFFFF">商品SKU</td>
			<td align="left" bgcolor="#FFFFFF">商品名称</td>
			<td align="center" bgcolor="#FFFFFF">属性</td>
			<td width="50" align="center" bgcolor="#FFFFFF">数量</td>
		</tr>
		<?php
if ( $val['skuList'] )
{
foreach ( $val['skuList'] as $v )
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

</form>
