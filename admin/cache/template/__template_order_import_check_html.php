<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-08-01 14:19:04
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3>导入订单</h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="location='?mod=order.import&file=<?php echo $file_name; ?>&channel_parent_id=<?php echo $_POST['channel_parent_id']; ?>'" style=""><span>确定导入</span></button>
	</div>
</div>

<form method="post" id="main_form">

<div class="clearfix">
	<div class="input-field">
		<select name="channel_parent_id">
			<?php
if ( $channel_parent_list )
{
foreach ( $channel_parent_list as $val )
{
?>
			<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $_POST['channel_parent_id'] )
{
?>selected<?php
}
?>><?php echo $val['name']; ?></option>
			<?php
}
}
?>
		</select>
	</div>
	<div class="right">
	</div>
</div>
<div class="block5"></div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		列表
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="120">渠道订单号</th>
				<th width="80">销售对应关系</th>
				<th width="40"><div align="center">分期数</div></th>
				<th width=""><nobr>商品名称<nobr></th>
				<th width="100">价格</th>
				<th width="40"><div align="center">优惠券</div></th>
				<th width="40"><div align="center">数量</div></th>
				<th width="200">配送</th>
				<th width="100">备注</th>
				<th width="40"><div align="center">状态</div></th>
			</tr>
		</thead>
		<tbody id="purchase_row">
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr>
				<td><?php echo $val['data']['target_id']; ?><br><br />下单时间：<br><?php echo $val['timeing']; ?></td>
			<td><?php echo $val['product_data']['target_id']; ?><br />
			<?php
if ( $val['product_data']['collate_error'] )
{
?>
			<font color="#FF0000"><?php echo $val['product_data']['collate_error']; ?></font>
			<?php
}
else
{
?>
			↓<br />ID:<?php echo $val['sku_info']['product']['id']; ?><br /><?php echo $val['sku_info']['sku']; ?>
			<?php
}
?>
			</td>
				<td align="center"><?php echo $val['data']['order_instalment_times']; ?><br /><br />费率<br /><?php echo $val['product_data']['payout_rate']; ?></td>
				<td>
					<?php
if ( $val['sku_info'] )
{
?>
					<?php echo $val['sku_info']['product']['name']; ?><br>
					<?php
if ( $val['sku_info']['attribute'] )
{
?><b>属性：</b><?php echo $val['sku_info']['attribute']; ?><br><?php
}
?>
					<?php
}
?>
					<font color="#999999"><b>银行名称：</b><?php echo $val['product_data']['extra_name']; ?></font>
					
				</td>
				<td>提报：<?php echo $val['product_data']['price']; ?><br />销售：<?php echo $val['product_data']['sale_price']; ?><br />支付：<?php echo $val['product_data']['total_pay_money_one']; ?>
				<?php
if ( !$val['product_data']['collate_error'] )
{
?>
				<br /><font color="#FF0000"><?php echo $val['product_data']['price_error']; ?></font>
				<?php
}
?>
				</td>
				<td align="center"><?php echo $val['product_data']['coupon_price']; ?></td>
				<td align="center"><?php echo $val['product_data']['quantity']; ?></td>
				<td>
					<b>收货人：</b><?php echo $val['data']['order_shipping_name']; ?><br />
					<b>电　话：</b><?php echo $val['data']['order_shipping_phone']; ?>
					<?php
if ( $val['data']['order_shipping_phone'] && $val['data']['order_shipping_mobile'] )
{
?> / <?php
}
?>
					<?php echo $val['data']['order_shipping_mobile']; ?><br />
					<b>邮　编：</b><?php echo $val['data']['order_shipping_zip']; ?><br />
					<b>地　址：</b><?php echo $val['data']['order_shipping_address']; ?><br />
				</td>
				<td><?php echo $val['product_data']['comment']; ?></td>
				<td align="center">
				<?php
if ( $val['error'] )
{
?>
				<font color="red">错误</font>
				<?php
}
elseif ( !$val['product_data']['price'] )
{
?>
				<font color="red">错误</font>
				<?php
}
elseif ( $val['product_data']['price_error'] )
{
?>
				<font color="red">错误</font>
				<?php
}
elseif ( $val['exists'] )
{
?>
				<font color="pink">已经<br />导入</font>
				<?php
}
else
{
?>
				<font color="green">正确</font>
				<?php
}
?>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>