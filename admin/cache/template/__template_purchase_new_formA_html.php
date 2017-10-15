<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-12-29 14:56:04
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
	<?php
if ( $type == 'new' )
{
?>
	<h3>常规采购</h3>
	<?php
}
else
{
?>
	<h3>按需采购</h3>
	<?php
}
?>
	<div class="right">
		<button type="button" class="scalable back" onclick="SubmitForm();" style=""><span>保存采购单</span></button>
	</div>
</div>

<form method="post" id="main_form" onsubmit="return false;">

<div class="clearfix">
	<div class="left">
		<?php
if ( $type == 'new' )
{
?>
		<button type="button" id="add-btn">添加采购商品</button>
		<?php
}
?>
	</div>
	<div class="right">
		<table>
			<tr>
				<td>供应商：</td>
				<td><?php echo $supplierName; ?><input type="hidden" id="supplier" name="supplier" value="<?php echo $supplierId; ?>" /></td>
				<td>&nbsp;&nbsp;&nbsp;发往仓库：
					<select name="warehouse_id">
					<option value="">---</option>
						<?php
if ( $warehouse_list )
{
foreach ( $warehouse_list as $val )
{
?>
						<option value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
						<?php
}
}
?>
					</select>　
<!--
					产品类型：
					<select name="product_type">
						<option value="0">----</option>
						<option value="1">3C</option>
						<option value="2">非3C</option>
					</select>
-->
					付款方式：
					<select name="payment_type">
						<?php
if ( $payment_type_list )
{
foreach ( $payment_type_list as $key => $val )
{
?>
						<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
						<?php
}
}
?>
					</select>　

					发票：
					<select name="invoice_type">
						<option value="1">增值税发票</option>
						<option value="2">普通票</option>
					</select>

					<?php
if ( $type == 'new' )
{
?>
					<input type="hidden" name="type" value="1">
					<?php
}
else
{
?>
					<input type="hidden" name="type" value="2">
					<?php
}
?>
				</td>
				<td>　预计到货时间：<input type="text" name="plan_arrive_time" id="plan_arrive_time" class="input-text" style="width:100px;"><img src="image/grid-cal.gif" alt="" align="absmiddle" id="date_btn" style="cursor:pointer;" />
				
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
				<th width="60"><div align="center">操作</div></th>
				<th width="40">ID</th>
				<th width="100">SKU</th>
				<th width="">名称 - 属性</th>
				<th width="60"><div align="center">数量</div></th>
				<th width="90">采购单价</th>
				<?php
if ( $type != 'new' )
{
?>
				<th width="90">代发货运费</th>
				<th><div align="right">订单号→销售价</div></th>
				<?php
}
?>
				<th width="120">备注</th>
			</tr>
		</thead>
		<tbody id="purchase_row">
			<?php
if ( $lock_list )
{
foreach ( $lock_list as $val )
{
?>
			<tr id="row_{1}">
				<td align="center">
<input type="hidden" name="sku[]" value="<?php echo $val['sku']; ?>">
<input type="hidden" name="pid[]" value="<?php echo $val['sku_info']['product']['id']; ?>">
					<a href="javascript:void(0);" name="remove">移除</a>
				</td>
<td><?php echo $val['sku_info']['product']['id']; ?></td>
<td><b><?php echo $val['sku']; ?></b ></td>
<td><?php echo $val['sku_info']['product']['name']; ?>
<?php
if ( $val['sku_info']['attribute'] )
{
?> → <font color="#FF0000"><?php echo $val['sku_info']['attribute']; ?></font><?php
}
?>
</td>

<td align="center"><?php echo $val['advice_quantity']; ?><input type="hidden" name="quantity[]" value="<?php echo $val['advice_quantity']; ?>"></td>
<td align="left">￥<input type="text" class="input-text" style="width:50px;" name="price[]" value="<?php echo $val['sku_info']['product']['cost_price']; ?>"></td>
<td align="left">￥<input type="text" class="input-text" style="width:50px;" name="help_cost[]" value="0"></td>
<td align="right">
<?php
if ( $val['order_product_list'] )
{
?>
<?php
if ( $val['order_product_list'] )
{
foreach ( $val['order_product_list'] as $row )
{
?>
<a href="?mod=order.list_all&excel=0&id=<?php echo $row['order_id']; ?>&channel_id=&target_id=&order_status=&begin_date=&end_date=&purchase_check=&service_check=&lock_status=&delivery_status=&warehouse_type=&logistics_type=&sign_status=&finance_recieve=&order_invoice=&order_invoice_status=&product_name=&order_shipping_name=&phone=" target="_blank"><?php echo $row['order_id']; ?>→<?php echo $row['price']; ?></a><br />
<?php
}
}
?>
<?php
}
?>
</td>
<td align="left"><input type="text" class="input-text" style="width:100px;" name="row_comment[]" value=""></td>
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
							<textarea name="comment" style="width:800px;height:120px;overflow-x:auto;overflow-y:auto;"><?php echo $description['intro']; ?></textarea>
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
<tr id="row_{2}">
<td align="center">
<input type="hidden" name="pid[]" value="{1}">
<input type="hidden" name="sku[]" value="{2}">
<a href="javascript:void(0);" name="remove">移除</a></td>
<td>{1}</td>
<td>{2}</td>
<td>{3}{4}</td>
<td align="left"><input type="text" class="input-text" style="width:40px;" name="quantity[]" value="1"></td>
<td align="left">&yen;<input type="text" class="input-text" style="width:50px;" name="price[]" value="{0}"></td>
<?php
if ( $type != 'new' )
{
?>
<td align="left">&yen;<input type="text" class="input-text" style="width:50px;" name="help_cost[]" value="0.00"></td>
<?php
}
?>
<td align="left"><input type="text" class="input-text" style="width:100px;" name="row_comment[]" value=""></td>
</tr>
</tbody>
</table>

<script language="JavaScript">

$(document).ready(function(){
	$('#add-btn').click(function(){
	  // if(!$('#supplier').val()){alert("请先选择供货商！")}
	  // else{
	   AddProductToRow();
	  // }
	});

/*
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
*/
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
var supplierId = <?php echo $supplierId; ?>;

function AddRow(info){
	if ($('#row_'+info.sku).length>0){
		alert('该产品已经存在');
		return false;
	}
	
	var html = $('#tpl_product_row').html().replace(/-_-/ig, '').format(
		info.sku_info.product.cost_price,
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
		url: '?mod=purchase.new.uping&rand=' + Math.random(),
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