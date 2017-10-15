<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-08 15:28:51
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule"><?php echo $warehouse_info['name']; ?> 库存查询 </h3>
</div>


<form method="get" id="main_form">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		<?php echo $warehouse_info['name']; ?> 库存查询
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>货位<span class="required"></span></label></td>
					<td class="value">
						<input name="mod" value="warehouse.stock.detail" type="hidden"/>
						<input name="warehouse_id" value="<?php echo $_GET['warehouse_id']; ?>" type="hidden"/>
						<input name="name" id="place_name" value="" class="input-text" type="text" style="width:150px;"/>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>SKU<span class="required"></span></label></td>
					<td class="value">
						<input name="sku" id="sku" value="" class="input-text" type="text" style="width:180px;"/>
						<button type="button" id="add-btn">查找SKU</button>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>查看类型<span class="required"></span></label></td>
					<td class="value">
						<select name="view_type">
							<option value="0">所有</option>
							<option value="1">库存数大于0</option>
							<option value="2">库存数等于0</option>
						</select>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"> </label></td>
					<td class="value">
						<button type="button" onclick="$('#main_form').submit();">确定查询</button>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>

<script language="JavaScript">

$(document).ready(function(){
	$('#add-btn').click(function(){
		AddProductToRow();
	});

	var auto = new Ext.form.AutoCompleteField({
		applyTo: 'place_name',
		hideTrigger:true,
		width:140,
		hiddenName:'place_id',
		store:autoComplatePlaceStore,
		mode: 'local',
		tpl:autoComplatePlaceTemplate,
		valueField:'id',
		displayField:'name',
		queryId:'key',
		emptyText:'按货位名称查找...'
	});
});

function AddRow(info){
	$('#sku').val(info.sku);
	UnDialog();
}



var warehouseId = '<?php echo $warehouse_id; ?>';

</script>
