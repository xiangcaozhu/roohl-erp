<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-12-22 08:51:31
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
﻿<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule"><?php
if ( !$edit )
{
?>新建<?php
}
else
{
?>编辑<?php
}
?>渠道产品对照</h3>
	<div class="right">
		<button type="button" class="scalable save" onclick="SubmitForm();"><span>保存数据</span></button>
	</div>
</div>


<form method="post" id="main_form" onsubmit="return false;">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		<?php
if ( !$edit )
{
?>新建<?php
}
else
{
?>编辑<?php
}
?>渠道产品对照
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>渠道<span class="required"></span></label></td>
					<td class="value">
						<select name="channel_id">
						<option value="">选择渠道</option>
							<?php
if ( $channel_list )
{
foreach ( $channel_list as $val )
{
?>
							<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $collate['channel_id'] )
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
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>渠道产品ID<span class="required"></span></label></td>
					<td class="value">
						<input name="target_id" value="<?php echo $collate['target_id']; ?>" class="input-text" type="text" style="width:150px;" />
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>SKU<span class="required"></span></label></td>
					<td class="value">
						<input name="sku" id="sku" value="<?php echo $collate['sku']; ?>" class="input-text" type="text" style="width:180px;"/>
						<button type="button" id="add-btn">查找SKU</button>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>赠品SKU (1)<span class="required"></span></label></td>
					<td class="value">
						<input name="gift_sku" id="gift_sku" value="<?php echo $collate['gift_sku']; ?>" class="input-text" type="text" style="width:180px;"/>
						<button type="button" id="add-gift-btn">查找SKU</button>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>赠品SKU (2)<span class="required"></span></label></td>
					<td class="value">
						<input name="gift_sku2" id="gift_sku2" value="<?php echo $collate['gift_sku2']; ?>" class="input-text" type="text" style="width:180px;"/>
						<button type="button" id="add-gift-btn2">查找SKU</button>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>赠品SKU (3)<span class="required"></span></label></td>
					<td class="value">
						<input name="gift_sku3" id="gift_sku3" value="<?php echo $collate['gift_sku3']; ?>" class="input-text" type="text" style="width:180px;"/>
						<button type="button" id="add-gift-btn3">查找SKU</button>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>赠品SKU (4)<span class="required"></span></label></td>
					<td class="value">
						<input name="gift_sku4" id="gift_sku4" value="<?php echo $collate['gift_sku4']; ?>" class="input-text" type="text" style="width:180px;"/>
						<button type="button" id="add-gift-btn4">查找SKU</button>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>赠品SKU (5)<span class="required"></span></label></td>
					<td class="value">
						<input name="gift_sku5" id="gift_sku5" value="<?php echo $collate['gift_sku5']; ?>" class="input-text" type="text" style="width:180px;"/>
						<button type="button" id="add-gift-btn5">查找SKU</button>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>银行链接<span class="required"></span></label></td>
					<td class="value">
						<input name="bank_link" value="<?php echo $collate['bank_link']; ?>" class="input-text" type="text" style="width:350px;" />
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>银行名称<span class="required"></span></label></td>
					<td class="value">
						<input name="bank_name" value="<?php echo $collate['bank_name']; ?>" class="input-text" type="text" style="width:350px;" />
					</td>
					<td><small>&nbsp;</small></td>
				</tr>

				<tr>
					<td class="label"><label>备注<span class="required"></span></label></td>
					<td class="value">
						<textarea name="cmment" id="cmment" style="width:600px;height:100px;overflow-x:auto;overflow-y:auto;"><?php echo $collate['comment']; ?></textarea>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">产品价格信息</h3>
	<div class="right">
		<!-- <button type="button" class="scalable save" id="add-price-btn"><span>增加一行</span></button> -->
	</div>
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		产品价格信息
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="200">分期数</th>
				<th width="120">单价<input type="text" class="input-text" style="width:60px;" id="money" name="money" value=""></th>
				<th width="100">费率</th>
				<th width="120" style="display:none">>发票</th>
				<th width="70"><button type="button" onclick="payoutRate(1)">广发</button></th>
				<th width="70"><button type="button" onclick="payoutRate(2)">建行3C</button></th>
				<th width="70"><button type="button" onclick="payoutRate(3)">建行非3C</button></th>
				
				<th width="70"><button type="button" onclick="payoutRate(4)">交行家居百货</button></th>
				<th width="70"><button type="button" onclick="payoutRate(5)">交行电脑手机数码</button></th>
				<th width="70"><button type="button" onclick="payoutRate(6)">交行家电美容</button></th>
				<th width="70"><button type="button" onclick="payoutRate(7)">交行配饰奢侈品</button></th>
				<th width="">备注</th>
			</tr>
		</thead>
		<tbody>
			<?php
if ( $price_list )
{
foreach ( $price_list as $key => $val )
{
?>
			<tr>
				<td align="center"><?php echo $key; ?></td>
				<td align="center"><input type="text" class="input-text" style="width:60px;" id="price_<?php echo $key; ?>" name="price[<?php echo $key; ?>]" value="<?php echo $val['price']; ?>"></td>
				<td align="center"><input type="text" class="input-text" style="width:60px;" id="payout_rate_<?php echo $key; ?>" name="payout_rate[<?php echo $key; ?>]" value="<?php echo $val['payout_rate']; ?>"></td>
				<td align="center" style="display:none"><input type="checkbox" name="invoice[<?php echo $key; ?>]" value="1" checked ></td>
				
				
				<td width=""><?php echo GetFeiLv('payout_rate_gf',$key); ?></td>
				<td width=""><?php echo GetFeiLv('payout_rate_jh',$key); ?></td>
				<td width=""><?php echo GetFeiLv('payout_rate_jh1',$key); ?></td>
				<td width=""><?php echo GetFeiLv('payout_rate_jt',$key); ?></td>
				<td width=""><?php echo GetFeiLv('payout_rate_jt1',$key); ?></td>
				<td width=""><?php echo GetFeiLv('payout_rate_jt2',$key); ?></td>
				<td width=""><?php echo GetFeiLv('payout_rate_jt3',$key); ?></td>
				
				<td align=""><input type="hidden" class="input-text" style="width:300px;" name="row_comment[<?php echo $key; ?>]" value="<?php echo $val['comment']; ?>"></td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>
</form>

<table style="display:none;">
	<tbody id="tpl_price_row">
		<tr>
			<td align="center"><input type="text" class="input-text" style="width:60px;" name="price[]" value=""></td>
			<td align="center"><input type="text" class="input-text" style="width:60px;" name="instalment_times[]" value=""></td>
			<td align="center"><input type="text" class="input-text" style="width:60px;" name="instalment_price[]" value=""></td>
			<td align="center"><input type="text" class="input-text" style="width:60px;" name="payout_rate[]" value=""></td>
			<td align="center"><input type="text" class="input-text" style="width:60px;" name="invoice[]" value=""></td>
			<td align="center"><input type="text" class="input-text" style="width:200px;" name="row_comment[]" value=""></td>
			<td align="center">
				<a href="javascript:void(0);" name="remove">移除</a>
			</td>
		</tr>
	</tbody>
</table>

<script language="JavaScript">
function payoutRate(type)
{
if(type==1){
<?php
if ( $price_list )
{
foreach ( $price_list as $key => $val )
{
?>
$("#payout_rate_<?php echo $key; ?>").val(<?php echo GetFeiLv('payout_rate_gf',$key); ?>);
if($("#money").val()!=""){$("#price_<?php echo $key; ?>").val($("#money").val());}
<?php
}
}
?>
}
if(type==2){
<?php
if ( $price_list )
{
foreach ( $price_list as $key => $val )
{
?>
$("#payout_rate_<?php echo $key; ?>").val(<?php echo GetFeiLv('payout_rate_jh',$key); ?>);
if($("#money").val()!=""){$("#price_<?php echo $key; ?>").val($("#money").val());}
<?php
}
}
?>
}
if(type==3){
<?php
if ( $price_list )
{
foreach ( $price_list as $key => $val )
{
?>
$("#payout_rate_<?php echo $key; ?>").val(<?php echo GetFeiLv('payout_rate_jh1',$key); ?>);
if($("#money").val()!=""){$("#price_<?php echo $key; ?>").val($("#money").val());}
<?php
}
}
?>
}


if(type==4){
<?php
if ( $price_list )
{
foreach ( $price_list as $key => $val )
{
?>
$("#payout_rate_<?php echo $key; ?>").val(<?php echo GetFeiLv('payout_rate_jt',$key); ?>);
if($("#money").val()!=""){$("#price_<?php echo $key; ?>").val($("#money").val());}
<?php
}
}
?>
}
if(type==5){
<?php
if ( $price_list )
{
foreach ( $price_list as $key => $val )
{
?>
$("#payout_rate_<?php echo $key; ?>").val(<?php echo GetFeiLv('payout_rate_jt1',$key); ?>);
if($("#money").val()!=""){$("#price_<?php echo $key; ?>").val($("#money").val());}
<?php
}
}
?>
}
if(type==6){
<?php
if ( $price_list )
{
foreach ( $price_list as $key => $val )
{
?>
$("#payout_rate_<?php echo $key; ?>").val(<?php echo GetFeiLv('payout_rate_jt2',$key); ?>);
if($("#money").val()!=""){$("#price_<?php echo $key; ?>").val($("#money").val());}
<?php
}
}
?>
}
if(type==7){
<?php
if ( $price_list )
{
foreach ( $price_list as $key => $val )
{
?>
$("#payout_rate_<?php echo $key; ?>").val(<?php echo GetFeiLv('payout_rate_jt3',$key); ?>);
if($("#money").val()!=""){$("#price_<?php echo $key; ?>").val($("#money").val());}
<?php
}
}
?>
}












}










var skuBox = false;

$(document).ready(function(){
	$('#add-btn').click(function(){
		skuBox = '#sku';
		AddSaleProductToRow();
	});

	$('#add-gift-btn').click(function(){
		skuBox = '#gift_sku';
		AddProductToRow();
	});
	$('#add-gift-btn2').click(function(){
		skuBox = '#gift_sku2';
		AddProductToRow();
	});
	$('#add-gift-btn3').click(function(){
		skuBox = '#gift_sku3';
		AddProductToRow();
	});
	$('#add-gift-btn4').click(function(){
		skuBox = '#gift_sku4';
		AddProductToRow();
	});
	$('#add-gift-btn5').click(function(){
		skuBox = '#gift_sku5';
		AddProductToRow();
	});
});

function AddRow(info){
	$(skuBox).val(info.sku);
	UnDialog();
}

function AddPrice(){
	var html = $('#tpl_price_row').html().replace(/-_-/ig, '');

	$('#price_row').append(html);

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
		url: '<?php echo $_SERVER['REQUEST_URI']; ?>&rand=' + Math.random(),
		type:'POST',
		data:post,
		success: function(info){
			if (info=='200' || info==200){
				Loading('处理成功', '正在跳转到列表页面...');
				window.location='?mod=product.collate';
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


function AddSaleProductToRow(){
	var html = $('#tpl_add_product').html().replace(/-_-/ig, '');
	Dialog('添加销售商品',html,GetSaleProductToRow,false,function(){
		var auto = new Ext.form.AutoCompleteField({
			applyTo: 'dialog_pid_name',
			hideTrigger:true,
			width:410,
			hiddenName:'dialog_pid',
			store:autoComplateProductSale,	
			mode: 'local',
			tpl:autoComplateProductSaleTemplate,
			valueField:'id',
			displayField:'name',
			queryId:'key',
			emptyText:'请输入商品编号或者名称进行查找...'
		});
	});
}

function GetSaleProductToRow(){
	var pid = $('#dialog_pid').val();
	var sku = $('#dialog_sku').val();
	if (!pid && !sku){
		alert('请输入产品');
		return;
	}

	if (sku){
		$.ajax({
			url: '?mod=product.ajax.sku&sku='+sku+'&type=check_sku&times=<?php echo $_POST['times']; ?>&rand=' + Math.random(),
			processData: true,
			dataType:'json',
			success: function(info){
				if (!info.product||!info.product.id){
					alert('没有找到指定的商品');
					return;
				}

				if (!info.sku){
					alert('没有查询到SKU');
					return;
				}

				AddRow(info);
			},
			error:function(info){
				alert("网络传输错误,请重试...");
				return false;
			}
		});

		return true;
	}

	$.ajax({
		url: '?mod=product.ajax.sku&pid='+pid+'&sku='+sku+'&type=get_product_all&rand=' + Math.random(),
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
				Dialog('选择属性',html,GetSkuToRow,false,function(){AttributeEventNoLimit();});
}else{
				if (!info.sku){
					alert('没有查询到SKU');
					return;
				}
				AddRow(info);
				AddProductToRow()

}
		},
		error:function(info){
			alert("网络传输错误,请重试...");
			return false;
		}
	});
}
</script>