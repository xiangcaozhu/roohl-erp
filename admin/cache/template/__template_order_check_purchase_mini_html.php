<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-08-09 10:55:04
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<link href="css/cal/zpcal.css" rel="stylesheet" type="text/css">
<link href="css/cal/template.css" rel="stylesheet" type="text/css">
<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>
<style>
.xiaofw_p a{color:#666666}
.xiaofw_p a:hover{color:#FF0000}

</style>
<div class="HY-content-header clearfix">
	<h3>订单-商务确定</h3>
	<div class="right">
		<!-- <button type="button" onclick="$('#excel').val(1);$('#search_form').submit();$('#excel').val(0);">导出Excel</button> -->
	</div>
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		分页:<?php echo $page_bar; ?> 每页20条记录 总共<?php echo $total; ?>条记录 <?php echo $page; ?>/<?php echo $page_num; ?>
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="80"><div align="center">订单信息</div></th>
				<th width="150">销售渠道信息</th>
				<th width="">产品信息</th>
				<th width="60"><div align="center">客服操作</div></th>
				<th width="135">操作</th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
				<th>
					<div class="input-field">
						<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
						<input type="text" name="id" id="id" value="<?php echo $_GET['id']; ?>">
					</div>
				</th>
				<th>
					<div class="input-field">
						<input type="text" name="target_id" value="<?php echo $_GET['target_id']; ?>">
					</div>
				</th>
				<th>
					<div class="input-field">
						<input type="text" name="product_name" value="<?php echo $_GET['product_name']; ?>">
					</div>
				</th>
				<th>&nbsp;</th>
				<th>
						<select name="purchase_check">
							<option value="1" <?php
if ( 1 == $_GET['purchase_check'] && $_GET['purchase_check'] != '' )
{
?>selected<?php
}
?>>已经确认</option>
							<option value="2" <?php
if ( 2 == $_GET['purchase_check'] && $_GET['purchase_check'] != '' )
{
?>selected<?php
}
?>>已经取消</option>
							<option value="0" <?php
if ( 0 == $_GET['purchase_check'] && $_GET['purchase_check'] != '' )
{
?>selected<?php
}
?>>未操作</option>
						</select>
					<button style="float:right;" type="button" onclick="$('#search_form').submit();">过滤</button></th>
				</form>
			</tr>
		</thead>
		<tbody>
			<?php
if ( $list )
{
foreach ( $list as $info )
{
?>
			<tr>
				<td align="center"><?php echo $info['id']; ?><br /><?php echo $info['purchase_check_name']; ?></td>
				<td ><?php echo $info['channel_name']; ?><br /><?php echo $info['target_id']; ?><br /><?php echo $info['order_time']; ?></td>
				<td>
					<div class="HY-grid" style="display:;">
						<table cellspacing="0" class="data">
							<thead>
								<tr class="header">
								    <th width="70">产品ID/SKU</th>
									<th width="300">产品名称</th>
									<th width="100">渠道ID</th>
									<th width="60">数量</th>
									<th>供货商</th>
								</tr>
							</thead>
							<tbody>
								<?php
if ( $info['list'] )
{
foreach ( $info['list'] as $row )
{
?>
								<tr>
									<td align=""><?php echo $row['product_id']; ?><br /><?php echo $row['sku']; ?><br /><a href="?mod=product.edit&id=<?php echo $row['product_id']; ?>" target="_blank">编辑商品</a></td>
									<td align=""><?php echo $row['sku_info']['product']['name']; ?><br /><font color="green"><?php echo $row['sku_info']['attribute']; ?></font></td>
									<td align="left"><b>编码：</b><?php echo $row['target_id']; ?><br /><b>售价：</b><?php echo $row['price']; ?><br /><b>费率：</b><?php echo $row['payout_rate']; ?></td>
									<td align="left">需求：<?php echo $row['quantity']; ?><br />库存：<?php echo $row['warehouse_live_quantity']; ?><br />锁定：<?php echo $row['warehouse_lock_quantity']; ?></td>
									<td align="left" class="xiaofw_p">
									<font color="#009900">[<?php echo $row['productInfo']['supplier_now']; ?>]<?php echo $row['supplierNow']['name']; ?></font><br />
									<?php
if ( $row['supplierInfo'] )
{
foreach ( $row['supplierInfo'] as $supplier_row )
{
?>
									<?php
if ( $row['productInfo']['supplier_now'] != $supplier_row['id'] )
{
?>
									<br /><a href="#" style="text-decoration:none;" onclick="javascript:supplier_change(<?php echo $row['product_id']; ?>,<?php echo $supplier_row['id']; ?>)">[<?php echo $supplier_row['id']; ?>]<?php echo $supplier_row['name']; ?></a><?php
}
?>
									<?php
}
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
				</td>
				<td align="center">
<?php
if ( $info['purchase_check'] == 0 )
{
?>
<button style="float:left;margin:5px;width:50px;height:50px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="fastOK(<?php echo $info['id']; ?>,'有货');">有货<br />确认</button>
<button style="float:left;margin:5px;width:50px;height:50px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog(<?php echo $info['id']; ?>, 1);">备注<br />确认</button>
<?php
}
elseif ( $info['purchase_check'] == 2 )
{
?>

<?php
if ( $info['service_check'] > 0 )
{
?>
<font color="#FF0000">
此订单<br />
已有<br />
后续操作<br />
无法确认
</font>
<?php
}
else
{
?>
<button style="float:left;margin:5px;width:50px;height:50px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="fastOK(<?php echo $info['id']; ?>,'有货');">有货<br />确认</button>
<button style="float:left;margin:5px;width:50px;height:50px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog(<?php echo $info['id']; ?>, 1);">确认<br />通过</button>
<?php
}
?>
<?php
}
?>

<?php
if ( $info['purchase_check'] == 0 )
{
?>
<button style="float:left;margin:5px;width:50px;height:50px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog(<?php echo $info['id']; ?>, 2);">取消</button>
<?php
}
elseif ( $info['purchase_check'] == 1 )
{
?>

<?php
if ( $info['service_check'] > 0 )
{
?>
<font color="#FF0000">
此订单<br />
已有<br />
后续操作<br />
无法取消
</font>
<?php
}
else
{
?>
<button style="float:left;margin:5px;width:50px;height:50px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog(<?php echo $info['id']; ?>, 2);">取消</button>
<?php
}
?>

<?php
}
?>

</td>
<td>
<?php
if ( $_GET['purchase_check'] > 0 )
{
?>
					<div style="float:right;width:135px;">
						<table cellspacing="0" class="data" style="width:135px;float:right;">
							<thead>
								<tr class="header">
								<th><span style="float:left;">产品部</span><span style="float:right;"><?php echo $info['purchase_check_name']; ?></span></th>
								</tr>
							</thead>
							<tbody>
<?php
if ( $info['purchase_check_list'] )
{
foreach ( $info['purchase_check_list'] as $row )
{
?>

<tr><td align=""><span style="float:left;"><?php echo $row['user_name_zh']; ?></span><span style="float:right;"><?php echo DateFormat($row['add_time'],'m-d H:m'); ?></span></td></tr>
<?php
if ( $row['comment'] )
{
?>
<tr><td align="left"><?php echo $row['comment']; ?></td></tr>
<?php
}
?>

<?php
}
}
?>
							</tbody>
						</table>

<table cellspacing="0" class="data"  style="width:135px;float:right;margin-top:5px;">
							<thead>
								<tr class="header">
								<th><span style="float:left;">客服部</span><span style="float:right;"><?php echo $info['service_check_name']; ?></span></th>
								</tr>
							</thead>
							<tbody>
<?php
if ( $info['service_check_list'] )
{
foreach ( $info['service_check_list'] as $row )
{
?>

<tr><td align=""><span style="float:left;"><?php echo $row['user_name_zh']; ?></span><span style="float:right;"><?php echo DateFormat($row['add_time'],'m-d H:m'); ?></span></td></tr>
<?php
if ( $row['comment'] )
{
?>
<tr><td align="left"><?php echo $row['comment']; ?></td></tr>
<?php
}
?>

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
	$('a[ctype=expand]').click(function(){
		$(this).parents('td').eq(0).find('div').toggle();
	});
});


function fastOK(orderId,comment){
window.location='?mod=order.edit.check_f&id='+orderId+'&do=purchase&comment='+comment+'&type=1&rand=' + Math.random()
}


var isSubmit = false;

function ActionLog(orderId, type){
	var html = $('#tpl_action').html().replace(/-_-/ig, '');
	html = $(html);
	html.find('form').attr('action', '?mod=order.edit.check&id='+orderId+'&do=purchase&type='+type);

	Dialog((type==1?'确认':'取消'),html,function(){
		if (isSubmit){
			return false;
		}

		if((type==2) && html.find('form').find('.input-text').val()=="")
		{
		alert('必须有取消理由')
		isSubmit = false;
		}
		else
		{
		html.find('form').submit();
		isSubmit = true;
		}

//html.find('form').submit();
//		isSubmit = true;
	});
}



function supplier_change(p_id,supplier_id){
	Loading();
	$.ajax({
		url: '?mod=order.check.supplier_change&p_id='+p_id+'&supplier_id='+supplier_id+'&rand=' + Math.random(),
		type:'GET',
		//data:post,
		success: function(info){
			if (info=='200'){
				Loading('处理成功', '正在跳转到列表页面...');
				window.location.reload();
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


<div id="tpl_action" style="display:none">
	<div>
		<form method="post" action="">
			<table width="100%">
				<tr>
					<td align="right" width="90">备注:</td>
					<td><textarea type="text" name="comment" style="width:220px;height:50px;" class="input-text"/></textarea></td>
				</tr>
			</table>
		</form>
	</div>
</div>