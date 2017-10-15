<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-12-24 09:33:10
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<link href="css/cal/zpcal.css" rel="stylesheet" type="text/css">
<link href="css/cal/template.css" rel="stylesheet" type="text/css">
<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>

<div class="HY-content-header clearfix-overflow">
	<h3><?php echo $info['type_name']; ?></h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="SubmitForm();" style=""><span>保存采购单</span></button>
	</div>
</div>

<form method="post" id="main_form" onsubmit="return false;">

<div class="clearfix">
	<div class="left">
		<table>
			<tr>
				<td align="left">供应商：<?php echo $info['supplier_name']; ?><input type="hidden" id="supplier_name" value="<?php echo $info['supplier_name']; ?>" /></td>
</tr>
</table>
</div>
	<div class="right">
		<table>
			<tr>
				<td>
					发往仓库：
					<select name="warehouse_id">
						<?php
if ( $warehouse_list )
{
foreach ( $warehouse_list as $val )
{
?>
						<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $info['warehouse_id'] )
{
?>selected<?php
}
?>><?php echo $val['name']; ?></option>
						<?php
}
}
?>
					</select>
					&nbsp;&nbsp;付款方式：
					<select name="payment_type">
						<?php
if ( $payment_type_list )
{
foreach ( $payment_type_list as $key => $val )
{
?>
						<option value="<?php echo $key; ?>" <?php
if ( $key == $info['payment_type'] )
{
?>selected<?php
}
?>><?php echo $val; ?></option>
						<?php
}
}
?>
					</select>　
				</td>
				<td></td>
				<td>
					预计到货时间：<input type="text" name="plan_arrive_time" id="plan_arrive_time" class="input-text" style="width:100px;" value="<?php echo DateFormat($info['plan_arrive_time'], 'Y-m-d'); ?>"><img src="image/grid-cal.gif" alt="" align="absmiddle" id="date_btn" />
				
				</td>
			</tr>
		</table>
	</div>
</div>
<div class="block5"></div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		采购商品列表
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="100">商品ID</th>
				<th width="120">SKU</th>
				<th width=""><nobr>商品名称<nobr></th>
				<th width="190">采购数量</th>
				<th width="120">采购价格</th>
				<?php
if ( $type != 'new' )
{
?>
				<th width="90">代发货运费</th>
				<?php
}
?>
				<th width="220">备注</th>
				<th width="120">操作</th>
			</tr>
		</thead>
		<tbody id="purchase_row">
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr id="row_{1}">
				<td><small><?php echo $val['sku_info']['product']['id']; ?></small></td>
				<td><small><?php echo $val['sku']; ?></small></td>
				<td>
					<b>名称：</b><?php echo $val['sku_info']['product']['name']; ?>
					<br>
					<span><?php echo $val['sku_info']['attribute']; ?></span>
				</td>
				<td align="center">
					<div class="clearfix">
						<span style="float:left;"><input type="text" class="input-text" style="width:60px;" name="quantity[<?php echo $val['id']; ?>]" value="<?php echo $val['quantity']; ?>"></span>
					</div>
				</td>
				<td align="center">
					&yen;<input type="text" class="input-text" style="width:60px;" name="price[<?php echo $val['id']; ?>]" value="<?php echo $val['price']; ?>">
				</td>
				<?php
if ( $type != 'new' )
{
?>
				<td align="left">￥<input type="text" class="input-text" style="width:50px;" name="help_cost[<?php echo $val['id']; ?>]" value="<?php echo $val['help_cost']; ?>"></td>
				<?php
}
?>
				<td align="center">
					<input type="text" class="input-text" style="width:200px;" name="row_comment[<?php echo $val['id']; ?>]" value="<?php echo $val['comment']; ?>">
				</td>
				<td align="center">
					<a href="?mod=purchase.edit.del&id=<?php echo $val['id']; ?>" onclick="return confirm('确定要取消这一行吗?');">单行取消</a>
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
							<textarea name="comment" style="width:800px;height:120px;overflow-x:auto;overflow-y:auto;"><?php echo $info['comment']; ?></textarea>
						</div>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

</form>

<table style="display:none;">
	<tbody id="tpl_allot_row">
		<tr>
			<td align="center"><small>{0}</small></td>
			<td align="center"><small>{1}</small></td>
			<td align="center"><small>{2}</small></td>
			<td align="center"><small>{3}</small></td>
		</tr>
	</tbody>
</table>

<table style="display:none;">
<tbody id="tpl_product_row">
<tr id="row_{1}">
<td>{0}</td>
<td>{1}</td>
<td>{2}{3}</td>
<td align="left"><input type="text" class="input-text" style="width:40px;" name="quantity[]" value="1"></td>
<td align="left">&yen;<input type="text" class="input-text" style="width:50px;" name="price[]" value="0.00"></td>
<td align="left" style="display:none">&yen;<input type="text" class="input-text" style="width:50px;" name="price[]" value="0.00"></td>
<td align="left"><input type="text" class="input-text" style="width:100px;" name="row_comment[]" value=""></td>
<td align="center">
<input type="hidden" name="sku[]" value="{1}">
<input type="hidden" name="pid[]" value="{0}">
<a href="javascript:void(0);" name="remove">移除</a></td>
</tr>
</tbody>
</table>
<script language="JavaScript">

$(document).ready(function(){
	$('a[ctype=expand]').click(function(){
		$(this).parents('td').eq(0).find('.HY-grid').toggle();
	});
});

$(document).ready(function(){
	$('#add-btn').click(function(){
		AddProductToRow();
	});
	var auto = new Ext.form.AutoCompleteField({
		applyTo: 'supplier_name',
		hideTrigger:true,
		width:250,
		hiddenName:'supplier',
		store:autoComplateSupplierStore,	
		mode: 'local',
		tpl:autoComplateSupplierTemplate,
		valueField:'id',
		displayField:'name',
		queryId:'key',
		emptyText:'请输入供应商名称进行查找...'
	});

	$('a[ctype=expand]').click(function(){
		$(this).parents('td').eq(0).find('.HY-grid').toggle();
	});

	$('a[name=remove]').click(function(){
		if (confirm('确定要移除吗?')){
			$(this).parents('tr').eq(0).remove();
		}
	});

	$('input[name^=quantity]').keyup(function(){
		var $this = $(this);
		var $tr = $(this).parents('tr').eq(0);
		var sku = $tr.find('input[name^=sku]').val();
		var num = $this.val();

		var $table = $this.parents('td').eq(0).find('tbody');

		$.ajax({
			url: '?mod=purchase.ajax.allot&sku='+sku+'&num='+num+'&rand=' + Math.random(),
			processData: true,
			dataType:'json',
			success: function(list){
				$table.empty();
				if (list){
					for (i in list){
						var info = list[i];
						var html = $('#tpl_allot_row').html().replace(/-_-/ig, '').format(
							info.order_id,
							info.quantity,
							!info.purchase_quantity ? 0 : info.purchase_quantity,
							!info._num ? 0 : info._num
						);
							
						$table.append(html);
					}
				}
			},
			error:function(info){
				alert("网络传输错误,请重试...");
				return false;
			}
		});
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
		info.sku_info.attribute ? ' → <font color="#FF0000">'+info.sku_info.attribute : '</font>'
	);

	$('#purchase_row').append(html);

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
		url: '?mod=purchase.edit&id=<?php echo $info['id']; ?>&rand=' + Math.random(),
		type:'POST',
		data:post,
		success: function(info){
			if (info=='200' || info==200){
				Loading('处理成功', '正在跳转到列表页面...');
				window.location='?mod=purchase.check';
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


<link rel="stylesheet" type="text/css" href="script/ext/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="script/ext/css/core.css" />

<style>
.x-tree-node,
.x-menu-item
{font-size:12px;}
</style>

<script type="text/javascript" src="script/ext/ext-base.js"></script>
<script type="text/javascript" src="script/ext/ext-all.js"></script>
<script type="text/javascript" src="script/ext-ext.js"></script>

<script language="JavaScript">

Ext.BLANK_IMAGE_URL = 'script/ext/s.gif';


$(document).ready(function(){

	var auto = new Ext.form.AutoCompleteField({
		applyTo: 'supplier_name',
		hideTrigger:true,
		width:200,
		hiddenName:'supplier',
		store:autoComplateSupplierStore,	
		mode: 'local',
		tpl:autoComplateSupplierTemplate,
		valueField:'id',
		displayField:'name',
		queryId:'key',
		hiddenValue:'<?php echo $info['supplier_id']; ?>',
		emptyText:'请输入供应商名称进行查找...'
	});
});

</script>


<script type="text/javascript">

var cal = new Zapatec.Calendar.setup({
	inputField     :    "plan_arrive_time",     // id of the input field
	ifFormat       :    "%Y-%m-%d",     // format of the input field
	showsTime      :     false,
	button         :    "date_btn",  // trigger button (well, IMG in our case)
	weekNumbers    :    false,  // allows user to change first day of week
	firstDay       :    1, // first day of week will be Monday
	align          :    "Bl"           // alignment (defaults to "Bl")
});

</script>