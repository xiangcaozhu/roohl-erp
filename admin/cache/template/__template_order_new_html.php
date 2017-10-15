<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-12-22 10:50:23
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<?php
if ( $edit )
{
?>
	<h3>编辑订单</h3>
	<?php
}
else
{
?>
	<h3>新建订单</h3>
	<?php
}
?>
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
				<th width="100">销售价格</th>
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
				<td><small id="sku-<?php echo $val['id']; ?>"><?php echo $val['sku']; ?></small></td>
				<td>
					<b>名称：</b><?php echo $val['sku_info']['product']['name']; ?>
					<?php
if ( $val['sku_info']['attribute'] )
{
?>
					<br><font color="green">属性：<span id="attribute-info-<?php echo $val['id']; ?>"><?php echo $val['sku_info']['attribute']; ?></span></font>
					<?php
}
?>
					<input type="hidden" name="e_sku[<?php echo $val['id']; ?>]" value="" id="sku-input-<?php echo $val['id']; ?>">
				</td>
				<td align="center">
					<input type="text" class="input-text" style="width:60px;" name="e_quantity[<?php echo $val['id']; ?>]" value="<?php echo $val['quantity']; ?>">
				</td>
				<td align="center">
					&yen;<input type="text" class="input-text" style="width:60px;" name="e_price[<?php echo $val['id']; ?>]" value="<?php echo $val['price']; ?>" readonly>
				</td>
				<td align="center">
					<input type="text" class="input-text" style="width:200px;" name="e_row_comment[<?php echo $val['id']; ?>]" value="<?php echo $val['comment']; ?>">
				</td>
				<td align="center">
					<a href="javascript:void(0);" onclick="AttributeEdit(<?php echo $val['product_id']; ?>, <?php echo $val['id']; ?>);">修改属性</a>
					<a href="?mod=order.edit.del&order_id=<?php echo $val['order_id']; ?>&order_product_id=<?php echo $val['id']; ?>" onclick="return confirm('确定删除该行产品吗? 确定后将跳转,请确认当前修改已经保存');">删除</a>
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
		<td width="30%">
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
						<tr>
							<td><strong>客户名称：</strong></td>
							<td><input type="text" name="order[order_customer_name]" value="<?php echo $order['order_customer_name']; ?>" class="input-text" style="width:100px;"></td>
						</tr>
						<tr>
							<td align=""><strong>客户卡号：</strong></td>
							<td><input type="text" name="order[order_customer_card]" value="<?php echo $order['order_customer_card']; ?>" class="input-text" style="width:100px;"></td>
						</tr>
						<tr>
							<td><strong>优先发货：</strong></td>
							<td>
								<input type="radio" name="order[delivery_first]" value="1" <?php
if ( $order['delivery_first'] )
{
?>checked<?php
}
?>>是
								<input type="radio" name="order[delivery_first]" value="0" <?php
if ( !$order['delivery_first'] )
{
?>checked<?php
}
?>>否
							</td>
						</tr>
						<tr>
							<td><strong>付款方式：</strong></td>
							<td>
								<input type="radio" name="order[payment_type]" value="2" <?php
if ( $order['payment_type'] == 2 )
{
?>checked<?php
}
?>>先款后货
								<input type="radio" name="order[payment_type]" value="1" <?php
if ( $order['payment_type'] == 1 )
{
?>checked<?php
}
?>>货到付款
							</td>
						</tr>
					</table>
				</div>
			</div>
		</td>
		
		<td width="30%">
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
		<td width="30%">
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
							<td><input type="text" name="order[order_invoice_header]" value="<?php echo $order['order_invoice_header']; ?>" class="input-text" style="width:200px;"></td>
						</tr>
						<tr>
							<td align="" width="90"><strong>已开发票：</strong></td>
							<td>
								<input type="radio" name="order[order_invoice_status]" value="1" <?php
if ( $order['order_invoice_status'] )
{
?>checked<?php
}
?>>是<?php
if ( $order['order_invoice_time'] )
{
?>(<?php echo DateFormat($order['order_invoice_time']); ?>)<?php
}
?>
								<input type="radio" name="order[order_invoice_status]" value="0" <?php
if ( !$order['order_invoice_status'] )
{
?>checked<?php
}
?>>否
							</td>
						</tr>
						<tr>
							<td align=""><strong>发票号：</strong></td>
							<td><input type="text" name="order[order_invoice_number]" value="<?php echo $order['order_invoice_number']; ?>" class="input-text" style="width:160px;"></td>
						</tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
</table>

</form>

<?php
if ( $product_list )
{
foreach ( $product_list as $val )
{
?>
<?php echo debug(unserialize($val['import_data'])); ?>
<?php
}
}
?>
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
				&yen;<input type="text" class="input-text" style="width:60px;" name="price[]" value="1">
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
		if (confirm('即将跳转到新的页面,未保存的数据将不会保存,确定不需要保存吗?')){
			location = '?mod=order.edit.add&id=<?php echo $order['id']; ?>';
		}
	});
});

function SubmitForm(){
	var post = $('#main_form').serialize();
	Loading();
	$.ajax({
		url: '<?php echo $_SERVER['REQUEST_URI']; ?>&rand=' + Math.random(),
		type:'POST',
		data:post,
		success: function(info){
			if (info=='200' || info==200){
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

var productId = 0;
var orderProductId = 0;


function AttributeEdit(pid,id){
	productId = pid;
	orderProductId = id;
	$.ajax({
		url: '?mod=product.ajax.sku&pid='+pid+'&type=get_product&rand=' + Math.random(),
		processData: true,
		dataType:'json',
		success: function(info){
			if (!info.product||!info.product.id){
				alert('没有找到指定的商品');
				return;
			}

			productId = pid;

			if (info.have_attribute==1){
				var html = info.attribute_html;
				Dialog('选择属性',html,AttributeEditSku,false,function(){AttributeEventNoLimit();});
			}else{
				alert('没有待选属性');
			}
		},
		error:function(info){
			alert("网络传输错误,请重试...");
			return false;
		}
	});
}


function AttributeEditSku(){
	var postData = $('#dialog-attribute-form').serialize();
	$.ajax({
		url: '?mod=product.ajax.sku&pid='+productId+'&type=get_sku&rand=' + Math.random(),
		processData: true,
		type:"POST",
		dataType:'json',
		data:postData,
		success: function(info){
			if (!info.product||!info.product.id){
				alert('没有找到指定的商品');
				return;
			}

			if (!info.sku){
				alert('没有查询到SKU');
				return;
			}

			if ($('#sku-'+orderProductId).text()==info.sku){
				UnDialog();
				return;
			}

			$('#sku-'+orderProductId).html('<font color="red">'+info.sku+'</font>');
			$('#sku-input-'+orderProductId).val(info.sku);
			$('#attribute-info-'+orderProductId).html('<font color="red">'+info.sku_info.attribute+'</font>');

			UnDialog();
		},
		error:function(info){
			alert("网络传输错误,请重试...");
			return false;
		}
	});
}
</script>