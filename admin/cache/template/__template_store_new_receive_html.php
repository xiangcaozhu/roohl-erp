<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-05 06:26:01
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3><?php echo $warehouse_info['name']; ?> 收货入库</h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="SubmitForm();" style=""><span>保存数据</span></button>
	</div>
</div>

<form method="post" id="main_form" onsubmit="return false;">

<div class="clearfix">
	<div class="left">
		<b>收货人：</b><?php echo $info['user_name']; ?>&nbsp;&nbsp;
		<b>日期：</b><?php echo DateFormat($info['add_time']); ?>&nbsp;&nbsp;
		<b>收货类型：</b><?php echo $info['type_name']; ?>&nbsp;&nbsp;
	</div>
	<div class="right">
		
	</div>
</div>
<div class="block5"></div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		待入库商品列表
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="100">商品ID</th>
				<th width="120">SKU</th>
				<th width=""><nobr>商品名称<nobr></th>
				<th width="70">收货数</th>
				<th width="70">已入库数</th>
				<th width="70">待入库数</th>
				<th width="100">本次入库数</th>
				<th width="130">目标货位</th>
			</tr>
		</thead>
		<tbody id="purchase_row">
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr>
				<td><small><?php echo $val['sku_info']['product']['id']; ?></small></td>
				<td><small><?php echo $val['sku']; ?></small></td>
				<td>
					<b>名称：</b><?php echo $val['sku_info']['product']['name']; ?>
					<br>
					<span><?php echo $val['sku_info']['attribute']; ?></span>
				</td>
				<td align="center"><?php echo $val['quantity']; ?></td>
				<td align="center"><?php echo $val['into_quantity']; ?></td>
				<td align="center"><?php echo $val['wait_quantity']; ?></td>
				<td align="center">
					<input type="text" class="input-text" style="width:60px;" name="quantity[<?php echo $val['id']; ?>]" value="">
				</td>
				<td align="center">
					<input type="text" id="place_id_<?php echo $val['id']; ?>">
				</td>
			</tr>
			<script language="JavaScript">
			$(document).ready(function(){
				var auto = new Ext.form.AutoCompleteField({
					applyTo: 'place_id_<?php echo $val['id']; ?>',
					hideTrigger:true,
					width:110,
					hiddenName:'place_id[<?php echo $val['id']; ?>]',
					store:autoComplatePlaceStore,	
					mode: 'local',
					tpl:autoComplatePlaceTemplate,
					valueField:'id',
					displayField:'name',
					queryId:'key',
					emptyText:'按货位名称查找...'
				});
			});
			</script>
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
							<textarea name="comment" style="width:800px;height:120px;overflow-x:auto;overflow-y:auto;"></textarea>
						</div>
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
	$('a[ctype=expand]').click(function(){
		$(this).parents('td').eq(0).find('.HY-grid').toggle();
	});
});

function SubmitForm(){
	var post = $('#main_form').serialize();
	Loading();
	$.ajax({
		url: '?mod=store.new.receive<?php echo $warehouse_uri; ?>&id=<?php echo $info['id']; ?>&rand=' + Math.random(),
		type:'POST',
		data:post,
		success: function(info){
			if (info=='200'){
				Loading('处理成功', '正在跳转到列表页面...');
				window.location='?mod=store.receive<?php echo $warehouse_uri; ?>';
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
<script>
var warehouseId = '<?php echo $warehouse_id; ?>';
</script>

<script type="text/javascript" src="script/ext/ext-base.js"></script>
<script type="text/javascript" src="script/ext/ext-all.js"></script>
<script type="text/javascript" src="script/ext-ext.js"></script>

<script language="JavaScript">

Ext.BLANK_IMAGE_URL = 'script/ext/s.gif';

</script>