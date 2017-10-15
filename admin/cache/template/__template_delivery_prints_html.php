<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-15 11:16:36
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">打印出库单，安排出库 → <?php echo $warehouse_info['name']; ?></h3>
	<p class="right">
		已选订单:
		<button type="button" onclick="if (confirm('确定打印出库单，安排出库?')){$('#mainform').submit();}">打印出库单，安排出库</button>
	</p>
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		待发货订单 总共<?php echo $total; ?>条记录
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="30">选择</th>
				<th width="60">订单号</th>
				<th width="60">渠道订单号</th>
				<th width="100">订单日期</th>
				<th width="100">打印发货单</th>
				<th width="60">品种数</th>
				<th width="60">商品数</th>
				<th width="100">所在仓库</th>
				<th width="150">发票</th>
				<th width="">订单信息</th>
				<th width="125">物流公司</th>
				<th width="125">物流单号</th>
				<th width="100">操作</th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
				<th>
					<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>"><input type="hidden" name="warehouse_id" value="<?php echo $_GET['warehouse_id']; ?>">
					<input type="checkbox" onclick="if (this.checked){$('input[name^=order_id]').attr('checked', true);}else{$('input[name^=order_id]').attr('checked', false);}">
				</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>
<select name="logistics_company"  style="height:22px;line-height:22px;width:96px;">
<option value="">全部</option>
<?php
if ( $logistics_list )
{
foreach ( $logistics_list as $num => $logisticsVal )
{
?>
<option value="<?php echo $logisticsVal; ?>" <?php
if ( $_GET['logistics_company'] == $logisticsVal )
{
?>selected<?php
}
?>><?php echo $logisticsVal; ?></option>
<?php
}
}
?>
</select>
                </th>
				<th>
					<div class="input-field">
						<input type="text" name="logistics_sn" value="<?php echo $_GET['logistics_sn']; ?>">
					</div>
				</th>
				<th><button type="button" onclick="$('#search_form').submit();">过滤</button></th>
				</form>	
			</tr>
		</thead>
		<tbody>
			<form method="post" action="?mod=delivery.print.output<?php echo $warehouse_uri; ?>" id="mainform">
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr>
				<td>
					<input type="checkbox" name="order_id[]" value="<?php echo $val['id']; ?>">
				</td>
				<td align="center"><small><?php echo $val['id']; ?></small></td>
				<td align="center"><small><?php echo $val['target_id']; ?></small><br><?php echo $val['channel_name']; ?></td>
				<td align="center"><small><?php echo $val['add_time']; ?></small></td>
				<td align="center"><?php echo $val['print_status_name']; ?></td>
				<td align="center"><font color="#FF0099"><b><?php echo $val['total_breed']; ?></b></font></td>
				<td align="center"><font color="#6633FF"><b><?php echo $val['total_quantity']; ?></b></font></td>
				<td align="center"><?php echo $warehouse_info['name']; ?></td>
				<td align="">
					<p><?php
if ( $val['order_invoice'] )
{
?>需要<?php
}
else
{
?>不需要<?php
}
?></p>
					<p><?php
if ( $val['order_invoice_status'] )
{
?><font color="green">已开</font><?php
}
else
{
?><font color="red">未开</font><?php
}
?></p>
					<p>抬头:<?php echo $val['order_invoice_header']; ?></p>
				</td>
				<td >
					<div class="clearfix">
						<span style="float:left;">共<?php echo $val['total_breed']; ?>个产品</span>
						<span style="float:right;"><a href="javascript:void(0);" ctype="expand">展开/收起</a></span>
					</div>
					<div class="HY-grid" style="">
						<table cellspacing="0" class="data" id="grid_table">
							<thead>
								<tr class="header">
									<th width="">SKU</th>
									<th width="40">需求数</th>
									<th width="40">配货数</th>
								</tr>
							</thead>
							<tbody>
								<?php
if ( $val['list'] )
{
foreach ( $val['list'] as $row )
{
?>
								<tr>
									<td align=""><small><?php echo $row['sku']; ?></small> <?php echo $row['sku_info']['product']['name']; ?><br><b><?php echo $row['sku_info']['attribute']; ?></b></td>
									<td align="center"><?php echo $row['quantity']; ?></td>
									<td align="center"><font color="#66CC00"><b><?php echo $row['lock_quantity']; ?></b></font></td>
								</tr>
								<?php
}
}
?>
							</tbody>
						</table>
						<b>客户名：</b><?php echo $val['order_customer_name']; ?><br />
						<b>收货人：</b><?php echo $val['order_shipping_name']; ?><br />
						<b>地址：</b><?php echo $val['order_shipping_address']; ?><br />
						<b>邮编：</b><?php echo $val['order_shipping_zip']; ?><br />
						<?php
if ( trim($val['order_shipping_phone']) )
{
?><b>电话：</b><?php echo $val['order_shipping_phone']; ?><br /><?php
}
?>
						<?php
if ( trim($val['order_shipping_mobile']) )
{
?><b>电话：</b><?php echo $val['order_shipping_mobile']; ?><br /><?php
}
?>
					</div>
				</td>
				<td align="">
					<?php echo $val['logistics_company']; ?>&nbsp;
				</td>
				<td align="">
					<?php echo $val['logistics_sn']; ?>&nbsp;
				</td>
				<td align="center">
					<a href="?mod=order.detail&id=<?php echo $val['id']; ?>">查看详细</a>
				</td>
			</tr>
			<?php
}
}
?>
			</form>
		</tbody>
	</table>
</div>

<script language="JavaScript">
$(document).ready(function(){
	$('a[ctype=expand]').click(function(){
		$(this).parents('td').eq(0).find('.HY-grid').toggle();
	});
});

</script>