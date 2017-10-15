<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-11 08:57:03
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<style>
.xiaofw_0{border:#000000 1px solid;height:20px; background:#FFFFFF;}

</style>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">采购单列表 </h3>
	<p class="right">
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
				<th>供应商</th>
				<th width="110">库房</th>
				<th width="60">收货状态</th>
				<th width="60">类型</th>
				<th width="60">付款方式</th>
				<th width="60">采购员</th>
				<th width="40">品种</th>
				<th width="40">件数</th>
				<th width="60">总金额</th>
				<th width="100">下单时间</th>
				<th width="100">经理审核</th>
				<th width="200">操作</th>
		  </tr>
	  <form method="post" id="search_form" name="search_form" action="?mod=purchase.listpay">
<tr class="filter_a">
<th><input type="text" name="id" id="id" value="<?php echo $id; ?>" style="width:52px;text-align:right;height:18px;line-height:18px; float:right; padding-right:5px;"></th>
<th><input type="text" id="supplier_na" name="supplier_na" value=""  style="height:18px;line-height:18px;" /></th>
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
<th><input type="hidden" name="supplier_id" id="supplier_id" value=""></th>
<th><input type="hidden" id="supplier_name" name="supplier_name" value="" /></th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th>&nbsp;</th>
<th><button type="button" onclick="$('#supplier_id').val($('#supplier').val());$('#supplier_name').val($('#supplier_na').val());$('#search_form').submit();">过滤</button></th>
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
			<tr>
				<td align="right"><?php echo $val['id']; ?></td>
				<td ><?php echo $val['supplier_name']; ?>&nbsp;</td>
				<td align="center"><?php echo $val['warehouse_name']; ?></td>
				<td align="center"  style="display:none"><?php echo $val['status_name']; ?></td>
				<td align="center"><?php echo $val['receive_status_name']; ?></td>
				<td align="center"><?php echo $val['type_name']; ?></td>
				<td align="center"><?php echo $val['payment_type_name']; ?></td>
				<td ><?php echo $val['user_name_zh']; ?></td>
				<td align="center"><?php echo $val['total_breed']; ?></td>
				<td align="center"><?php echo $val['total_quantity']; ?></td>
				<td align="right">&yen;<?php echo $val['total_money']; ?></td>
				<td align="center"><small><?php echo $val['add_time']; ?></small></td>
				<td >
					 <?php
if ( $val['workflow_allow_do'] )
{
?>
					( <a href="?mod=purchase.check&id=<?php echo $val['id']; ?>" onclick="return confirm('确定要审核通过吗?');">审核通过</a> )
					<?php
}
else
{
?>
					<?php echo $val['workflow_status_name']; ?>
					<?php
}
?>
				</td>
				<td >
					<a href="?mod=purchase.view&id=<?php echo $val['id']; ?>">查看</a>
					<a href="?mod=purchase.edit&id=<?php echo $val['id']; ?>">修改</a>
					<a href="?mod=purchase.del&id=<?php echo $val['id']; ?>" onclick="return confirm('确定删除吗?');">删除</a>
					<a href="?mod=purchase.print&id=<?php echo $val['id']; ?>" target="_blank">打印</a>
					<a href="?mod=purchase.printWL&id=<?php echo $val['id']; ?>" target="_blank">物流</a>

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