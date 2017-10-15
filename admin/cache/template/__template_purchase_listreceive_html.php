<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-15 01:29:32
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<style>
.xiaofw_0 td{font-size:12px;line-height:1.3; padding-top:5px;}

</style>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">常规库未完成采购单列表 </h3>
	<p class="right"  style="display:none">
		<button type="button" onclick="$('#excel').val(1);$('#search_form').submit();$('#excel').val(0);">导出Excel</button>
	</p>
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		总共<?php echo $total; ?>条记录
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="60"><div align="right">采购单号</div></th>
				<th width="70">制单人员</th>
				<th width="80">采购类型</th>
				<th width="60">付款方式</th>
				<th width="160">下单日期/预计到货日期</th>
				<th width="110">库房</th>
				<th width="70">收货入库</th>
				<th>供应商</th>
				<th width="60">总金额</th>
				<th width="50">操作</th>
				<th width="120">打印</th>
		  </tr>
	  <form method="post" id="search_form" name="search_form" action="?mod=purchase.listreceive">
<tr class="filter_a">
<th><input type="text" name="id" id="id" value="<?php echo $id; ?>" style="width:52px;text-align:right;height:18px;line-height:18px; float:right; padding-right:5px;"></th>
<th>&nbsp;</th>
<th>
<select name="type_id"  style="height:22px;line-height:22px;width:75px;">
<option value=""></option>
<option value="1" <?php
if ( $type_id == 1 )
{
?>selected<?php
}
?>>常规采购</option>
<option value="2" <?php
if ( $type_id == 2 )
{
?>selected<?php
}
?>>按需采购</option>
</select>
</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th><select name="warehouse_id"  style="height:22px;line-height:22px;width:108px;">
<option value=""></option>
<?php
if ( $warehouse_list )
{
foreach ( $warehouse_list as $val )
{
?>
<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $warehouse_id )
{
?>selected<?php
}
?>><?php echo $val['name']; ?></option>
<?php
}
}
?>
</select></th>
<th>&nbsp;</th>
<th><input type="text" id="supplier_na" name="supplier_na" value=""  style="height:18px;line-height:18px;" /></th>
<th><input type="hidden" name="supplier_id" id="supplier_id" value=""><input type="hidden" id="supplier_name" name="supplier_name" value="" /></th>
<th><button type="button" onclick="$('#supplier_id').val($('#supplier').val());$('#supplier_name').val($('#supplier_na').val());$('#search_form').submit();">过滤</button></th>
<th>&nbsp;</th>
</tr>
</form>

		</thead>
		<tbody>
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr class="xiaofw_0">
				<td align="right" height="20"><?php echo $val['id']; ?></td>
				<td ><?php echo $val['user_name_zh']; ?><?php echo $val['user_me']; ?></td>
				<td align="center"><?php echo $val['type_name']; ?></td>
				<td align="center"><?php echo $val['payment_type_name']; ?></td>
				<td align="center"><?php echo $val['add_time']; ?> / <?php echo $val['plan_arrive_time']; ?></td>
				<td align="center"><?php echo $val['warehouse_name']; ?></td>
				<td align="center"><?php echo $val['receive_status_name']; ?></td>
				<td ><?php echo $val['supplier_name']; ?>&nbsp;</td>
				<td align="center"  style="display:none"><?php echo $val['status_name']; ?></td>
				<td align="left">&yen;<?php echo $val['total_money']; ?></td>
				<td align="center"><a href="?mod=purchase.view&id=<?php echo $val['id']; ?>" target="_blank">查看</a></td>
				<td align="center">
<a href="?mod=purchase.print&id=<?php echo $val['id']; ?>" target="_blank">采购单</a>　
<?php
if ( $val['type'] == 2 )
{
?><a href="?mod=purchase.printWL&id=<?php echo $val['id']; ?>" target="_blank">发货单</a><?php
}
else
{
?>　　　<?php
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



<script language="JavaScript">

$(document).ready(function(){
	var auto = new Ext.form.AutoCompleteField({
		applyTo: 'supplier_na',
		hideTrigger:true,
		width:260,
		hiddenName:'supplier',
		store:autoComplateSupplierStore,	
		mode: 'local',
		tpl:autoComplateSupplierTemplate,
		valueField:'id',
		displayField:'name',
		queryId:'key',
		emptyText:'<?php echo $supplier_name; ?>'
	});
});



</script>