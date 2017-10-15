<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-12-22 10:50:32
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">为订单添加产品 订单号:<?php echo $order['id']; ?> 渠道:<?php echo $channel['name']; ?></h3>
	<div class="right">
		<button type="button" class="scalable save" onclick="SubmitForm();"><span>保存数据</span></button>
	</div>
</div>


<form method="post" id="main_form" onsubmit="return false;">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		<input type="hidden" name="channel_id" value="<?php echo $channel['id']; ?>">
		为订单添加产品 订单号:<?php echo $order['id']; ?> 渠道:<?php echo $channel['name']; ?>
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>渠道<span class="required"></span></label></td>
					<td class="value">
						<?php echo $channel['name']; ?>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>SKU<span class="required"></span></label></td>
					<td class="value">
						<input name="sku" id="sku" value="" class="input-text" type="text" style="width:180px;"/>
						<button type="button" onclick="AddChannelProduct();">查找SKU</button>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

</form>

<div id="tpl_add_channel_product" style="display:none">
	<table width="100%">
		<tr>
			<td align="right" width="90">输入商品ID:</td>
			<td><input type="text" id="-_-dialog_pid_name" value="" /></td>
		</tr>
	</table>
</div>


<script language="JavaScript">

var productId = 0;
var channelId = <?php echo $channel['id']; ?>;

function AddChannelProduct(){
	var html = $('#tpl_add_channel_product').html().replace(/-_-/ig, '');
	Dialog('添加商品',html,GetProductToRow,false,function(){
		var auto = new Ext.form.AutoCompleteField({
			applyTo: 'dialog_pid_name',
			hideTrigger:true,
			width:200,
			hiddenName:'dialog_pid',
			store:autoComplateChannelProductStore,
			mode: 'local',
			tpl:autoComplateChannelProductTemplate,
			valueField:'id',
			displayField:'name',
			queryId:'key',
			emptyText:'请输入渠道产品编号或者名称进行查找...'
		});
	});
}

function AddRow(info){
	$.ajax({
		url: '?mod=product.collate.ajax.sku&sku='+info.sku+'&channel_id=<?php echo $channel['id']; ?>&times=<?php echo $order['order_instalment_times']; ?>&type=check_sku&rand=' + Math.random(),
		processData: true,
		dataType:'json',
		success: function(info){
			if (!info.product||!info.product.id){
				alert('没有找到指定的商品');
				return;
			}

			if (!info.collate){
				alert('渠道产品不存在');
				return;
			}

			if (!info.price){
				alert('价格不存在');
				return;
			}

			//if (info.price.price<=0){
				//alert('价格数据错误');
				//return;
			//}

			$('#sku').val(info.sku);
			UnDialog();
		},
		error:function(info){
			alert("网络传输错误,请重试...");
			return false;
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
				window.location='?mod=order.edit&id=<?php echo $order['id']; ?>';
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