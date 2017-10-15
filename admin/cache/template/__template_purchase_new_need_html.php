<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-12-22 08:51:56
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">按需采购 </h3>
	<p class="right">
		<button  id="" type="button" class="scalable back" onclick="if($('#My_supplier').val()==0){alert('请先添加采购商品')}else{window.location='?mod=purchase.new.need.new&purchase_Id='+$('#My_supplier').val()+'';}" style=""><span>建立采购单</span></button>
	<input type="hidden" name="My_supplier" id="My_supplier" value="0" /></p>
</div>
<script>
function doSSS(sku_id,supplierId){
var url ="?mod=purchase.need&APAP=1&supplierId="+supplierId+"&sku_id="+sku_id
$("#HtmlDoFormA").attr("src",url)
}

function flushaa(str,obj){
$("div#"+obj).show();
$("div#"+obj).html(str)

}

</script>
<iframe src="" name="HtmlDoFormA" id="HtmlDoFormA" style="float:right;width:900px;height:600px;display:none;"></iframe>

<table width="100%">
	<tr>
		<td>
<?php
if ( $need_supplier )
{
foreach ( $need_supplier as $supplier )
{
?>
<?php
if ( $supplier['is_my'] == 1 )
{
?>
			<div class="HY-grid-title">
				<div class="HY-grid-title-inner">
					<a href="?mod=purchase.need&S_supplier=<?php echo $supplier['supplierId']; ?>"><?php echo $supplier['supplierName']; ?> → 待采购商品</a>
				</div>
			</div>
			<div class="HY-grid" id="Line_<?php echo $supplier['supplierId']; ?>">
				<table cellspacing="0" class="data" id="grid_table"  <?php
if ( $S_supplier != $supplier['supplierId'] )
{
?>style="display:none"<?php
}
?>>
					<thead>
						<tr class="header">
							<th width="20"><div align="center"><input <?php
if ( $supplier['supplierId'] == $My_supplier )
{
?>checked<?php
}
?> type="checkbox" sku_All="Line_<?php echo $supplier['supplierId']; ?>" <?php
if ( $val['disabled'] )
{
?>disabled<?php
}
?> ></div></th>
							<th width="120">商品ID/SKU</th>
							<th width="">商品</th>
							<th width="30"><div align="center">需求</div></th>
							<th width="30"><div align="center">在途</div></th>
							<th width="30"><div align="center">库存</div></th>
							<th width="30"><div align="center">锁定</div></th>
							<th width="30"><div align="center">可用</div></th>
							<th width="200">订单信息</th>
						</tr>
					</thead>
					<tbody>
<?php
if ( $supplier['needList'] )
{
foreach ( $supplier['needList'] as $val )
{
?>
						<tr>
							<td align="center"><input type="checkbox" sku_supplier="<?php echo $val['sku']; ?>_<?php echo $val['supplierId']; ?>" supplierId="<?php echo $val['supplierId']; ?>" sku="<?php echo $val['sku']; ?>" sku_id="<?php echo $val['sku_id']; ?>" <?php
if ( $val['checked'] )
{
?>checked<?php
}
?> <?php
if ( $val['disabled'] )
{
?>disabled<?php
}
?>></td>
							<td align="left"><?php echo $val['sku_info']['product']['id']; ?> - <?php echo $val['sku']; ?></td>
							<td><?php echo $val['sku_info']['product']['name']; ?>　　<?php
if ( $val['isnew'] > 0 )
{
?><br /><font color="#FF0000">[有二次添加产品，请注意！]</font><?php
}
?>
								<div><?php
if ( $val['sku_info']['attribute'] )
{
?><b>属性：</b><?php echo $val['sku_info']['attribute']; ?><?php
}
?></div>
							</td>
							<td align="center"><font color="blue"><b><?php echo $val['total_quantity']; ?></b></font></td>
							<td align="center"><font color="#999900"><b><?php echo $val['onroad_quantity']; ?></b></font></td>
							<td align="center"><font color="green"><b><?php echo $val['warehouse_quantity']; ?></b></font></td>
							<td align="center"><font color="red"><b><?php echo $val['warehouse_lock_quantity']; ?></b></font></td>
							<td align="center"><font color="blue"><b><?php echo $val['warehouse_live_quantity']; ?></b></font></td>
							<td >
								<div class="clearfix">
									<span style="float:left;">共<?php echo $val['total_num']; ?>个订单</span>
									<span style="float:right;"><a href="javascript:void(0);" onclick="doSSS(<?php echo $val['sku_id']; ?>,<?php echo $supplier['supplierId']; ?>);" >展开/收起</a></span>
								</div>
								<div class="HY-grid" style="display:none;width:200px;" id="one_<?php echo $val['sku_id']; ?>_<?php echo $supplier['supplierId']; ?>">
									<?php
if ( $val['list'] )
{
foreach ( $val['list'] as $row )
{
?>
									<table cellspacing="0" class="data" id="grid_table" style="margin-bottom:15px;">
										<thead>
											<tr class="header">
												<th width="60"><div align="center">订单号</div></th>
												<th width="40"><div align="center">需求</div></th>
												<th width="40"><div align="center">售价</div></th>
												<th width="60"><div align="center">银行</div></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td align="center" title="<?php
if ( trim($row['manager_edit_user_name']) )
{
?><font color="#FF0000"><span title="添加时间：<?php echo DateFormat($row['manager_edit_time']); ?>">[添加人：<?php echo $row['manager_edit_user_zh']; ?>]</span></font><?php
}
else
{
?>下单时间：<?php echo $row['add_time']; ?><?php
}
?>">
												<?php echo $row['order_id']; ?></td>
												<td align="center"><?php echo $row['quantity']; ?></td>
												<td align="center"><?php echo $row['price']; ?></td>
												<td align="center"><?php echo $row['channelName']; ?></td>
											</tr>
											<?php
if ( $row['orderComment'] && $row['orderComment'] != '|' )
{
?>
											 <tr>
												<td colspan="4">客户：<?php echo $row['orderComment']; ?></td>
											</tr>
											<?php
}
?>
											<?php
if ( $row['purchaseCheck'] )
{
?>
											 <tr>
												<td colspan="4">产品部：<?php echo $row['purchaseCheck']; ?></td>
											</tr>
											<?php
}
?>
											<?php
if ( $row['serviceCheck'] )
{
?>
											 <tr>
												<td colspan="4">客服部：<?php echo $row['serviceCheck']; ?></td>
											</tr>
											<?php
}
?>
										</tbody>
									</table>
									<?php
}
}
?>
								</div>
							</td>
						</tr>
<?php
}
}
?>
					</tbody>
				</table>
			</div>
<?php
}
?>
<?php
}
}
?>
		&nbsp;</td>
		<td width="400">
		
			<div class="HY-grid-title">
				<div class="HY-grid-title-inner">
					已选商品
				</div>
			</div>
			<div class="HY-grid">
				<table cellspacing="0" class="data" id="grid_table">
					<thead>
						<tr class="header">
							<th style="display:none" width="70">SKU</th>
							<th style="display:none" width="60">商品ID</th>
							<th width="">名称</th>
							<th width="30"><div align="center">操作</div></th>
						</tr>
					</thead>
					<tbody id="lock_list">
					</tbody>
				</table>
			</div>
		
		</td>
	</tr>
</table>

<script language="JavaScript">
$(document).ready(function(){
	$('a[ctype=expand]').click(function(){
		$(this).parents('td').eq(0).find('.HY-grid').toggle();
	});

//$('#My_supplier').val(<?php echo $My_supplier; ?>);




$(':checkbox[sku_All]').click(function(){
var Lines   = $(this).attr('sku_All');
var objLine = $('#'+Lines)
var listobj = objLine.find(':checkbox[sku_supplier]');


if (this.checked){
for (var i = 0; i  < listobj.length; i++){
		var box = listobj.eq(i);
		///////////////////////////////////////
		var sku = box.attr('sku');
		var skuId = box.attr('sku_id');
		var supplierId = box.attr('supplierId');
		//var obj = box;
		var type = '';
		//box.checked = true;
			if($('#My_supplier').val()>0 && $('#My_supplier').val()!=supplierId )
			{
			alert("不能同时选择两个供货商的产品！");
			return false;
			}
			else
			{
			type = 'add';
			$('#My_supplier').val(supplierId);
			}

		LockDo(type, sku,skuId,supplierId);
	}
}else{
//////////////
for (var i = 0; i  < listobj.length; i++){
		var box = listobj.eq(i);
		///////////////////////////////////////
		var sku = box.attr('sku');
		var skuId = box.attr('sku_id');
		var supplierId = box.attr('supplierId');
		//var obj = box;
		var type = '';
		//box.checked = false;
			type = 'delete';

		LockDo(type, sku,skuId,supplierId);
	}
	///////////

}








});








	$(':checkbox[sku_supplier]').click(function(){
		var sku = $(this).attr('sku');
		var skuId = $(this).attr('sku_id');
		var supplierId = $(this).attr('supplierId');
		var obj = this;
		var type = '';
		if (this.checked){
			
			if($('#My_supplier').val()>0 && $('#My_supplier').val()!=supplierId )
			{
			alert("不能同时选择两个供货商的产品！");
			return false;
			}
			else
			{
			type = 'add';
			$('#My_supplier').val(supplierId);
			}
			
		}else{
			type = 'delete';
		}

		LockDo(type, sku,skuId,supplierId);
	});

	LoadLockList();
});

function LockDo(type, sku, skuId,supplierId){
	if ($(':checkbox[sku_supplier='+sku+'_'+supplierId+']').length){
		var obj = $(':checkbox[sku_supplier='+sku+'_'+supplierId+']')[0];
	}else{
		var obj = false;
	}
	$.ajax({
		url: '?mod=purchase.lock&type='+type+'&randnum={0}'.format(Math.random()),
		type: "GET",
		data: {"sku":sku,'sku_id':skuId,'supplierId':supplierId}, 
		success: function(info){
			if (info=='200' || info==200){
				LoadLockList();
				if (type=='delete' && obj){
					obj.checked = false;
				}
				else{obj.checked = true;}
			}else if (info==404){
				alert('产品已经被别人锁定');
				LoadLockList();
				if (obj){
					obj.checked = false;
					obj.disabled = true;
				}
			}else{
				alert('网络错误' + info);
				if (obj){
					obj.checked = false;
				}
			}
		},
		error:function(info){
			alert('网络错误' + info);
			obj.checked = false;
		}
	});
}

function LoadLockList(){
	$.ajax({
		url: '?mod=purchase.lock&type=get&randnum={0}'.format(Math.random()),
		type: "GET",
		processData: true,
		dataType:'json',
		success: function(info){
			$('#lock_list').empty();
			if (info.length>0){
				for(var i =0; i < info.length; i++){
					var val = info[i];
					html   = '<tr>';
				//	html += '	<td >{0}</td>'.format(val.sku);
				//	html += '	<td >{0}</td>'.format(val.sku_info.product.id);
					html += '	<td >{0}</td>'.format(val.sku_info.product.name);
					html += '	<td align="center"><a href="javascript:void(0);" onclick="LockDo(\'delete\', \'{0}\', \'{1}\', \'{2}\')">移除</a></td>'.format(val.sku, val.sku_id ,val.supplierId);
					html += '</tr>';

					$('#lock_list').append(html);
					$('#My_supplier').val(val.supplierId);
				}
			}
			else{$('#My_supplier').val(0);}
		},
		error:function(info){
			alert('网络错误'+info);
		}
	});
}




</script>