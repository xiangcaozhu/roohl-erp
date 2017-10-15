<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2016-12-20 15:33:44
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">整理待发订单 → <?php echo $warehouse_info['name']; ?>　　　<a href="?mod=purchase.gomast">调库过账</a></h3>
	<div class="right">
		<button type="button" class="scalable save" onclick="SubmitForm();"><span>保存数据</span></button>
	</div>
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		整理待发订单 总共<?php echo $total; ?>条记录
	<span style="float:right;">
<script>
function DoPLP(key){
$("input.ISD_"+key).click();

}

function Doselectw(key){
$("#product_nameaa").val(key)

}

</script>	
<a style="float:left;margin-right:15px; cursor:pointer;" onclick="DoPLP('未指定');">未指定</a>
	<?php
if ( $logistics_list )
{
foreach ( $logistics_list as $num => $logisticsVal )
{
?>
	<a style="float:left;margin-right:15px; cursor:pointer;" onclick="DoPLP('<?php echo $logisticsVal; ?>');"><?php echo $logisticsVal; ?></a>
<?php
}
}
?>


</span>
</div>
	</div>

<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="60">订单号</th>
				<th width="150">渠道信息</th>
				<th width="">订单信息</th>
				<th width="300">发货信息</th>
				<th width="100">物流公司</th>
				<th width="70">操作</th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
				<th>
					<div class="input-field">
						<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
						<input type="hidden" name="warehouse_id" value="<?php echo $_GET['warehouse_id']; ?>">
						<input type="text" name="id" id="id" value="<?php echo $_GET['id']; ?>">
					</div>
				</th>
				<th>
				<select name="channel_id"  style="height:22px;line-height:22px;width:96px;">
<option value="">全部渠道</option>
<?php
if ( $channelList )
{
foreach ( $channelList as $channel )
{
?>
<option value="<?php echo $channel['id']; ?>" <?php
if ( $_GET['channel_id'] == $channel['id'] )
{
?>selected<?php
}
?>><?php echo $channel['name']; ?></option>
<?php
}
}
?>
</select>
</th>
				<th><div style="float:left; padding-top:3px;">产品名称:</div><div style="float:left;width:250px;" class="input-field"><input type="text" id="product_nameaa" name="product_name" value="<?php echo $_GET['product_name']; ?>"></div><a style="float:left; margin:0px 10px 0px 2px;" onclick="Doselectw('')">X</a>
	<div style="float:left; padding-left:20px;" >			
		<select name="logistics_companyssaa"  style="height:22px;line-height:22px;width:300px;" onchange="Doselectw(this.options[this.selectedIndex].value);">
<option value="">全部</option>
<?php
if ( $ppList )
{
foreach ( $ppList as $key => $val )
{
?>
<option value="<?php echo $val['productName']; ?>" <?php
if ( $_GET['logistics_company'] == $logisticsVal )
{
?>selected<?php
}
?>>[<?php echo $val['productQuantity']; ?>] <?php echo $val['productName']; ?></option>
<?php
}
}
?>
</select>
	</div>	
				
				</th>
				<th>&nbsp;</th>
				<th>
<select name="logistics_companyaa"  style="height:22px;line-height:22px;width:96px;">
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
				<th><button type="button" onclick="$('#search_form').submit();">过滤</button></th>
				</form>	
			</tr>
		</thead>
		<tbody>
			<form method="post" id="main_form" onsubmit="return false;">
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr>
				<td align="center"><small><?php echo $val['id']; ?></small></td>
				<td align="left"><?php echo $val['channel_name']; ?><br><?php echo $val['target_id']; ?><br><?php echo $val['add_time']; ?></td>
				<td >
				<div class="clearfix">
						<span style="float:left; padding:3px 0px;">
						
					</div>

					<div class="HY-grid">
						<table cellspacing="0" class="data" id="grid_table">
							<thead>
								<tr class="header">
									<th width="40"><div align="center">SKU</div></th>
									<th width="">产品信息</th>
									<th width="40"><div align="center">数量</div></th>
									<th width="50"><div align="center">价格</div></th>
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
									<td align="center"><?php echo $row['sku']; ?></td>
									<td align=""><?php echo $row['sku_info']['product']['name']; ?>
									<?php
if ( $row['sku_info']['attribute'] )
{
?> ← <font color="#66CC00"><b><?php echo $row['sku_info']['attribute']; ?></b></font><?php
}
?></td>
									<td align="center"><?php echo $row['quantity']; ?></td>
									<td align="center"><?php echo $row['price']; ?></td>
								</tr>
								<?php
}
}
?>
							</tbody>
						</table>
					</div>
				</td>
<td>
<b>收货人：</b><?php echo $val['order_shipping_name']; ?><br />
<b>电　话：</b>
<?php
if ( trim($val['order_shipping_phone']) )
{
?><?php echo $val['order_shipping_phone']; ?>　<?php
}
?>
<?php
if ( trim($val['order_shipping_mobile']) )
{
?><?php echo $val['order_shipping_mobile']; ?><?php
}
?>
<br />
<b>地　址：</b><?php echo $val['order_shipping_address']; ?><br />
</td>
<td align="left" style="line-height:2">
　　　<input class="ISD_未指定" name="logistics_company[<?php echo $val['id']; ?>]" id="L_A_C_<?php echo $val['id']; ?>" type="radio" value=""  <?php
if ( !$val['logistics_company'] )
{
?>checked="checked"<?php
}
?>  />
<label style="cursor:pointer;" for="L_A_C_<?php echo $val['id']; ?>">未指定</label>
<?php
if ( $logistics_list )
{
foreach ( $logistics_list as $num => $logisticsVal )
{
?>
<br />　<input class="ISD_<?php echo $logisticsVal; ?>" type="radio" id="L_<?php echo $num; ?>_C_<?php echo $val['id']; ?>" <?php
if ( $val['logistics_company'] == $logisticsVal )
{
?>checked="checked"<?php
}
?>  name="logistics_company[<?php echo $val['id']; ?>]" value="<?php echo $logisticsVal; ?>" />
<label style="cursor:pointer;" for="L_<?php echo $num; ?>_C_<?php echo $val['id']; ?>"><?php echo $logisticsVal; ?></label>
<?php
}
}
?>

				</td>
<td>
<b>发票：</b><br />
<?php
if ( $val['order_invoice'] )
{
?><font color="red">需要</font><?php
}
else
{
?>不需要<?php
}
?><br />
<b>抬头：</b><br />
<?php echo $val['order_invoice_header']; ?>
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

function SubmitForm(){
	var post = $('#main_form').serialize();
	Loading();
	$.ajax({
		url: '?mod=delivery.order.pack.save&rand=' + Math.random(),
		type:'POST',
		data:post,
		success: function(info){
			if (info=='200' || info==200){
				Loading('处理成功', '正在跳转到列表页面...');
				window.location='?mod=delivery.pack&warehouse_id=<?php echo $_GET['warehouse_id']; ?>';
			}else{
				alert(info);
				UnLoading();
			}
		},
		error:function(info){
			alert('网络错误,请重试');
			UnLoading();
		}
	});
}


</script>