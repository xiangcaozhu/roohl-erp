<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-08-14 15:37:38
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3>编辑订单</h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="SubmitForm();" style=""><span>保存订单</span></button>
	</div>
</div>

<form method="post" id="main_form" onsubmit="return false;">

<div class="clearfix">
	<div class="left">
		<button type="button" id="add-btn">添加订单商品</button>
	</div>
	<div class="right">
		
	</div>
</div>
<div class="block5"></div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		订单商品列表
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="100">商品ID</th>
				<th width="120">SKU</th>
				<th width=""><nobr>商品名称<nobr></th>
				<th width="100">数量</th>
				<th width="220">备注</th>
				<th width="120">操作</th>
			</tr>
		</thead>
		<tbody id="product_row">
			<?php
if ( $product_list )
{
foreach ( $product_list as $val )
{
?>
			<tr id="row_<?php echo $val['sku']; ?>">
				<td><small><?php echo $val['product_id']; ?></small></td>
				<td><small><?php echo $val['sku']; ?></small></td>
				<td>
					<b>名称：</b><?php echo $val['sku_info']['product']['name']; ?>
					<?php
if ( $val['sku_info']['attribute'] )
{
?>
					<br><font color="green">属性：<?php echo $val['sku_info']['attribute']; ?></font>
					<?php
}
?>
				</td>
				<td align="center">
					<input type="text" class="input-text" style="width:60px;" name="e_quantity[<?php echo $val['id']; ?>]" value="1">
				</td>
				<td align="center">
					<input type="text" class="input-text" style="width:200px;" name="e_row_comment[<?php echo $val['id']; ?>]" value="">
				</td>
				<td align="center">
					<select name="e_del[<?php echo $val['id']; ?>]">
						<option value="0" <?php
if ( !$val['is_delete'] )
{
?>selected<?php
}
?>>正常</option>
						<option value="1" <?php
if ( $val['is_delete'] )
{
?>selected<?php
}
?>>删除</option>
					</select>
				</td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>

<div class="HY-form-table" id="base_tab">
	<div class="HY-form-table-header">
		其他
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>备注</label></td>
					<td class="value">
						<div>
							<textarea name="order[order_comment]" style="width:800px;height:80px;overflow-x:auto;overflow-y:auto;"><?php echo $order['order_comment']; ?></textarea>
						</div>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<table width="100%">
	<tr>
		<td width="25%">
			<div class="HY-form-table">
				<div class="HY-form-table-header">
					基本信息
				</div>
				<div class="HY-form-table-main clearfix-overflow;" style="height:160px;">
					<table width="100%" border="0">
						<tr>
							<td align="" width="110"><strong>订单号：</strong></td>
							<td><?php echo $order['id']; ?></td>
						</tr>
						<tr>
							<td align=""><strong>渠道订单号：</strong></td>
							<td><input type="text" name="order[target_id]" value="<?php echo $order['target_id']; ?>" class="input-text" style="width:100px;"></td>
						</tr>
						<tr>
							<td align=""><strong>渠道：</strong></td>
							<td>
								<select name="order[channel_id]">
									<option value="0">----</option>
									<?php
if ( $channel_list )
{
foreach ( $channel_list as $val )
{
?>
									<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $order['channel_id'] )
{
?>selected<?php
}
?>><?php echo $val['name']; ?></option>
									<?php
}
}
?>
								</select>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</td>
		
		<td width="25%">
			<div class="HY-form-table">
				<div class="HY-form-table-header">
					收货信息
				</div>
				<div class="HY-form-table-main clearfix-overflow;" style="height:160px;">
					<table width="100%">
						<tr>
							<td align="" width="90"><strong>收货人：</strong></td>
							<td><input type="text" name="order[order_shipping_name]" value="<?php echo $order['order_shipping_name']; ?>" class="input-text" style="width:100px;"></td>
						</tr>
						<tr>
							<td align="" width=""><strong>身份证：</strong></td>
							<td><input type="text" name="order[order_shipping_card]" value="<?php echo $order['order_shipping_card']; ?>" class="input-text" style="width:180px;"></td>
						</tr>
						<tr>
							<td align=""><strong>地址：</strong></td>
							<td><input type="text" name="order[order_shipping_address]" value="<?php echo $order['order_shipping_address']; ?>" class="input-text" style="width:220px;"></td>
						</tr>
						<tr>
							<td align=""><strong>邮编：</strong></td>
							<td><input type="text" name="order[order_shipping_zip]" value="<?php echo $order['order_shipping_zip']; ?>" class="input-text" style="width:100px;"></td>
						</tr>
						<tr>
							<td align=""><strong>固定电话：</strong></td>
							<td><input type="text" name="order[order_shipping_phone]" value="<?php echo $order['order_shipping_phone']; ?>" class="input-text" style="width:100px;"></td>
						</tr>
						<tr>
							<td align=""><strong>移动电话：</strong></td>
							<td><input type="text" name="order[order_shipping_mobile]" value="<?php echo $order['order_shipping_mobile']; ?>" class="input-text" style="width:100px;"></td>
						</tr>
					</table>
				</div>
			</div>
		</td>
		<td width="25%">
			<div class="HY-form-table">
				<div class="HY-form-table-header">
					财务信息
				</div>
				<div class="HY-form-table-main clearfix-overflow;" style="height:160px;">
					<table width="100%">
						<tr>
							<td align="" width="90"><strong>发票：</strong></td>
							<td>
								<input type="radio" name="order[order_invoice]" value="1" <?php
if ( $order['order_invoice'] )
{
?>checked<?php
}
?>>需要
								<input type="radio" name="order[order_invoice]" value="0" <?php
if ( !$order['order_invoice'] )
{
?>checked<?php
}
?>>不需要
							</td>
						</tr>
						<tr>
							<td align="" width="90"><strong>发票抬头：</strong></td>
							<td><input type="text" name="order[order_invoice_header]" value="<?php echo $order['order_invoice_header']; ?>" class="input-text" style="width:100px;"></td>
						</tr>
						<!-- <tr>
							<td align=""><strong>发票号：</strong></td>
							<td><input type="text" name="order[order_invoice_number]"  class="input-text" style="width:160px;"></td>
						</tr> -->
					</table>
				</div>
			</div>
		</td>
		<td width="25%">
			<div class="HY-form-table">
				<div class="HY-form-table-header">
					配送信息
				</div>
				<div class="HY-form-table-main clearfix-overflow;" style="height:160px;">
					<table width="100%">
						<tr>
							<td align="right" width="60"><strong>发货方式:</strong></td>
							<td><?php echo $order['ship_type_name']; ?>&nbsp;</td>
						</tr>
						<tr>
							<td align="right"><strong>收货人:</strong></td>
							<td><?php echo $order['shipping_first_name']; ?> <?php echo $order['shipping_last_name']; ?>&nbsp;</td>
						</tr>
						<tr>
							<td align="right"><strong>地址:</strong></td>
							<td><?php echo $order['shipping_first_area']; ?> <?php echo $order['shipping_second_area']; ?> <?php echo $order['shipping_third_area']; ?> <?php echo $order['shipping_address']; ?></td>
						</tr>
						<tr>
							<td align="right"><strong>电话:</strong></td>
							<td><?php echo $order['shipping_phone']; ?></td>
						</tr>
						<tr>
							<td align="right"><strong>邮编:</strong></td>
							<td><?php echo $order['shipping_zip_code']; ?></td>
						</tr>
						<tr>
							<td align="right"><strong>备注:</strong></td>
							<td><?php echo $order['comment']; ?></td>
						</tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
</table>

</form>

<table style="display:none;">
	<tbody id="tpl_product_row">
		<tr id="row_{1}">
			<td><small>{0}</small></td>
			<td><small>{1}</small></td>
			<td>
				<b>名称：</b>{2}
				<br>
				<span>{3}</span>
				<input type="hidden" name="sku[]" value="{1}">
				<input type="hidden" name="pid[]" value="{0}">
			</td>
			<td align="center">
				<input type="text" class="input-text" style="width:60px;" name="quantity[]" value="1">
			</td>
			<td align="center">
				<input type="text" class="input-text" style="width:200px;" name="row_comment[]" value="">
			</td>
			<td align="center">
				<a href="javascript:void(0);" name="remove">移除</a>
			</td>
		</tr>
	</tbody>
</table>

<div id="tpl_add_product" style="display:none">
	<table width="100%">
		<tr>
			<td align="right" width="90">输入商品ID:</td>
			<td><input type="text" id="-_-dialog_pid_name" value="" /></td>
		</tr>
	</table>
</div>

<script language="JavaScript">

$(document).ready(function(){
	$('#add-btn').click(function(){
		AddProductToRow();
	});
});

var productId = 0;

function AddRow(info){
	if ($('#row_'+info.sku).length>0){
		alert('该产品已经存在');
		return;
	}
	
	var html = $('#tpl_product_row').html().replace(/-_-/ig, '').format(
		info.sku_info.product.id,
		info.sku,
		info.sku_info.product.name,
		info.sku_info.attribute ? '<b>属性：</b>'+info.sku_info.attribute : ''
	);

	$('#product_row').append(html);

	$('a[name=remove]').click(function(){
		if (confirm('确定要移除吗?')){
			$(this).parents('tr').eq(0).remove();
		}
	});
}

function SubmitForm(){
	var post = $('#main_form').serialize();
	Loading();
	$.ajax({
		url: '?mod=order.new&rand=' + Math.random(),
		type:'POST',
		data:post,
		success: function(info){
			if (info=='200'){
				Loading('处理成功', '正在跳转到列表页面...');
				window.location='?mod=order.list';
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