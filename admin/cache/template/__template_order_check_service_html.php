<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-08-26 11:08:58
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<link href="css/cal/zpcal.css" rel="stylesheet" type="text/css">
<link href="css/cal/template.css" rel="stylesheet" type="text/css">
<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>

<div class="HY-content-header clearfix">
	<h3>订单-客服确定</h3>
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
				<th width="40">订单号</th>
				<!-- <th width="140">渠道订单号</th> -->
				<th width="">订单详情</th>
				<th width="150">客户信息</th>
				<th width="150">发票信息</th>
				<th width="60"><div align="center">客服操作</div></th>
				<th width="230">客服呼叫记录</th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
				<th>
					<div class="input-field">
						<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
						<input type="text" name="id" id="id" value="<?php echo $_GET['id']; ?>">
						<input type="hidden" name="excel" id="excel" value="0">
					</div>
				</th>
				<th>
						<select name="channel_id" style="float:left;margin-top:3px;">
							<option value=""></option>
							<?php
if ( $channel_list )
{
foreach ( $channel_list as $val )
{
?>
							<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $_GET['channel_id'] )
{
?>selected<?php
}
?>><?php echo $val['name']; ?></option>
							<?php
}
}
?>
						</select>
						<span style="float:left;margin-left:20px; padding-top:3px;">收货人：</span><span style="float:left;width:110px;"><div class="input-field"><input style="width:100px" type="text" name="order_shipping_name" value="<?php echo $_GET['order_shipping_name']; ?>"></div></span>
						<span style="float:left;margin-left:20px; padding-top:3px;">电话：</span><span style="float:left;width:110px;"><div class="input-field"><input style="width:100px" type="text" name="phone" value="<?php echo $_GET['phone']; ?>"></div></span>
				</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th><select name="service_check" style="float:left;margin-top:3px;height:22px;">
							<option value=""></option>
							<option value="1" <?php
if ( 1 == $_GET['service_check'] && $_GET['service_check'] != '' )
{
?>selected<?php
}
?>>已经确认</option>
							<option value="2" <?php
if ( 2 == $_GET['service_check'] && $_GET['service_check'] != '' )
{
?>selected<?php
}
?>>已经取消</option>
							<option value="0" <?php
if ( 0 == $_GET['service_check'] && $_GET['service_check'] != '' )
{
?>selected<?php
}
?>>未操作</option>
						</select></th>
				<th>
						
					<button style="float:right;margin-top:3px;" type="button" onclick="$('#search_form').submit();">过滤</button>
				</th>
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
			<tr id="one_line_<?php echo $info['id']; ?>">
				<td ><?php echo $info['id']; ?><br /><br /><a target="_blank" href="?mod=order.detail&id=<?php echo $info['id']; ?>">详情</a></td>
				<td>
<div style=" padding-top:8px">
　<?php echo $info['channel_name']; ?> → 下单时间：<?php echo $info['order_time']; ?> → 导入时间：<?php echo $info['add_time']; ?>
</div>

<div class="HY-grid" style="padding-top:5px;">
						<table cellspacing="0" class="data">
							<thead>
								<tr class="header">
									<th width="60"><div align="center">渠道编号</div></th>
									<th width="">产品</th>
									<th width="30">数量</th>
									<th width="100"><div align="center">属性</div></th>
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
									<td align="center"><?php
if ( trim($row['target_id']) )
{
?><?php echo $row['target_id']; ?><?php
}
else
{
?><font color="#FF0000">赠品</font><?php
}
?></td>
									<td align=""><?php echo $row['sku']; ?> <?php echo $row['sku_info']['product']['name']; ?>　
									<?php
if ( trim($row['manager_edit_user_name'])>0 )
{
?>
									<font color="#FF0000"><span title="添加时间：<?php echo DateFormat($row['manager_edit_time']); ?>">[添加人：<?php echo $row['user_name_zh']; ?>]</span></font>
									<?php
}
?>
									</td>
									<td align="center"><?php echo $row['quantity']; ?></td>
									<td align="center">
									<?php
if ( $row['buy_type'] )
{
?><font color="red">购买属性：<?php echo $row['buy_type']; ?></font><br /><?php
}
?>
									<font color="green"><?php echo $row['sku_info']['attribute']; ?></font>
									<?php
if ( $row['sku_info']['is_base'] == 0 && $info['NoEdit'] != 1 )
{
?>
									<br /><a href="javascript:void(0);" onclick="AttributeEdit(<?php echo $row['sku_info']['product']['id']; ?>,<?php echo $row['id']; ?>);">修改属性</a>
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
<div class="HY-grid" style=" padding-top:0px">
<table cellspacing="0" class="data">
<tr class="header">
<th style="border-bottom:#333333 1px solid;">
<span style="float:left; font-weight:normal;"><b>客户信息</b><input type="hidden" id="order_invoidce_<?php echo $info['id']; ?>" value="<?php echo $info['ordedr_invoice']; ?>" /></span>
<span id="e_a_<?php echo $info['id']; ?>" style="float:right;cursor:pointer;" onclick="$('#one_user_e_<?php echo $info['id']; ?>').css('display','');$('#one_user_<?php echo $info['id']; ?>').css('display','none');$('#e_b_<?php echo $info['id']; ?>').css('display','');$('#e_a_<?php echo $info['id']; ?>').css('display','none');">编辑客户信息</span>
<span id="e_b_<?php echo $info['id']; ?>" style="float:right; cursor:pointer; display:none;" onclick="$('#one_user_e_<?php echo $info['id']; ?>').css('display','none');$('#one_user_<?php echo $info['id']; ?>').css('display','');$('#e_a_<?php echo $info['id']; ?>').css('display','');$('#e_b_<?php echo $info['id']; ?>').css('display','none');">取消编辑</span>
</th>
</tr>
</table>

<table cellspacing="0" id="one_user_<?php echo $info['id']; ?>">
<tr><td align="right" width="50">收货人：</td><td id="one_user_<?php echo $info['id']; ?>_1"><?php echo $info['order_shipping_name']; ?></td></tr>
<tr><td align="right">电　话：</td><td id="one_user_<?php echo $info['id']; ?>_2"><?php echo $info['order_shipping_phone']; ?></td></tr>
<tr><td align="right">手　机：</td><td id="one_user_<?php echo $info['id']; ?>_3"><?php echo $info['order_shipping_mobile']; ?></td></tr>
<tr><td align="right">地　址：</td><td id="one_user_<?php echo $info['id']; ?>_4"><?php echo $info['order_shipping_address']; ?></td></tr>
<tr><td align="right">邮　编：</td><td id="one_user_<?php echo $info['id']; ?>_5"><?php echo $info['order_shipping_zip']; ?></td></tr>
</table>

<table cellspacing="0" class="data" id="one_user_e_<?php echo $info['id']; ?>">
<tr><td align="right" width="50">收货人：</td><td ><input style="width:100px;" type="text" id="order_shipping_name_<?php echo $info['id']; ?>" value="<?php echo $info['order_shipping_name']; ?>" /></td></tr>
<tr><td align="right">电　话：</td><td ><input style="width:130px;" type="text" id="order_shipping_phone_<?php echo $info['id']; ?>" value="<?php echo $info['order_shipping_phone']; ?>" /></td></tr>
<tr><td align="right">手　机：</td><td ><input style="width:130px;" type="text" id="order_shipping_mobile_<?php echo $info['id']; ?>" value="<?php echo $info['order_shipping_mobile']; ?>" /></td></tr>
<tr><td align="right">地　址：</td><td ><input style="width:95%;" type="text" id="order_shipping_address_<?php echo $info['id']; ?>" value="<?php echo $info['order_shipping_address']; ?>" /></td></tr>
<tr><td align="right">邮　编：</td><td ><input style="width:80px;" type="text" id="order_shipping_zip_<?php echo $info['id']; ?>" value="<?php echo $info['order_shipping_zip']; ?>" /></td></tr>
<tr><td align="right">&nbsp;</td><td >
<button style="float:left;margin:2px;margin-left:10px;" type="button" onclick="up_order_user(<?php echo $info['id']; ?>);">确认修改</button>
<button style="float:left;margin:2px;margin-left:30px;" type="button" onclick="$('#one_user_e_<?php echo $info['id']; ?>').css('display','none');$('#one_user_<?php echo $info['id']; ?>').css('display','');$('#e_a_<?php echo $info['id']; ?>').css('display','');$('#e_b_<?php echo $info['id']; ?>').css('display','none');">取消修改</button>
</td></tr>
</table>

<table cellspacing="0" class="data">
<?php
if ( $info['serviceEditUserList'] )
{
foreach ( $info['serviceEditUserList'] as $row )
{
?>
<tr><td colspan="2" align="left">[<?php echo $row['user_name_zh']; ?>/<?php echo DateFormat($row['add_time'],'m-d H:i'); ?>]→<?php echo $row['comment']; ?></td></tr>
<?php
}
}
?>
</table>
</div>
<script>
$('#one_user_e_<?php echo $info['id']; ?>').css('display','none');
</script>

</td>
<td >

<div class="HY-grid" style=" padding-top:8px">
<?php
if ( $info['order_comment'] )
{
?>
<table cellspacing="0" class="data" style="margin-bottom:6px;">
<tr class="header">
<th style="border-bottom:#333333 1px solid;">
<span style="float:left; font-weight:normal;">备注</span>
<span style="float:right;">-</span>
</th>
</tr>
<tbody><tr><td align="left" style="color:#FF0000">
<?php echo $info['order_comment']; ?>
</td></tr></tbody>
</table>
<?php
}
?>
</div>

<div>
<?php $Myline = 1; ?>
<?php
if ( $info['purchase_check_list'] )
{
foreach ( $info['purchase_check_list'] as $row )
{
?>
<?php
if ( $Myline == 1 )
{
?>
<table cellspacing="0" class="data" style="margin-bottom:6px;">
<thead>
<tr class="header">
<th style="border-bottom:#333333 1px solid;">
<span style="float:left; font-weight:normal;">产品部</span>
<span style="float:right;"><?php echo $info['purchase_check_name']; ?></span>
</th>
</tr>
</thead>
<tbody>
<tr><td align="right">
<span style="float:left;"><?php echo DateFormat($row['add_time'],'m-d H:i'); ?></span>
<span style="float:right;"><?php echo $row['user_name_zh']; ?></span>
</td></tr>
<?php
if ( $row['comment'] )
{
?><tr><td align="right" style="color:#FF0000"><?php echo $row['comment']; ?></td></tr><?php
}
?>
</tbody>
</table>
<?php
}
?>
<?php $Myline = $Myline+1; ?>
<?php
}
}
?>
</div>



<div class="HY-grid" style=" padding-top:8px">
<?php $Myline = 1; ?>
<?php
if ( $info['service_check_list'] )
{
foreach ( $info['service_check_list'] as $row )
{
?>
<?php
if ( $Myline == 1 )
{
?>
<table cellspacing="0" class="data" style="margin-bottom:6px;">
<tr class="header">
<th style="border-bottom:#333333 1px solid;">
<span style="float:left; font-weight:normal;">客服部</span>
<span style="float:right;"><?php echo $info['service_check_name']; ?></span>
</th>
</tr>
<tbody>
<tr><td align="right">
<span style="float:left;"><?php echo $row['user_name_zh']; ?></span>
<span style="float:right;"><?php echo DateFormat($row['add_time'],'m-d H:i'); ?></span>
</td></tr>
<?php
if ( $row['comment'] )
{
?><tr><td align="right" style="color:#FF0000"><?php echo $row['comment']; ?></td></tr><?php
}
?>
</tbody>
</table>
<?php
}
?>
<?php $Myline = $Myline+1; ?>
<?php
}
}
?>
</div>



</td>
<td >
<div class="HY-grid" style=" padding-top:8px">
<table cellspacing="0" class="data" style="margin-bottom:6px;">
<tr class="header">
<th style="border-bottom:#333333 1px solid;">
<span style="float:left; font-weight:normal;">发票</span>
<span style="float:right;">
<label style=" cursor:pointer;"><input onclick="$('#order_invoice_<?php echo $info['id']; ?>').val(0);$('#one_invoice_<?php echo $info['id']; ?>').css('display','none');" type="radio" name="t_order_invoice_<?php echo $info['id']; ?>" value="0" <?php
if ( $info['order_invoice'] == 0 )
{
?>checked<?php
}
?>>不需要</label>
</span>
</th>
</tr>
<tr><td align="left">
<label style=" cursor:pointer;float:left; padding:3px 0px;margin-left:10px;">
<input onclick="$('#order_invoice_<?php echo $info['id']; ?>').val(1);$('#one_invoice_<?php echo $info['id']; ?>').css('display','block');" type="radio" name="t_order_invoice_<?php echo $info['id']; ?>" value="1" <?php
if ( $info['order_invoice'] == 1 )
{
?>checked<?php
}
?>>开发票</label>
<label style=" cursor:pointer;float:left; padding:3px 0px;margin-left:20px;">
<input onclick="$('#order_invoice_<?php echo $info['id']; ?>').val(2);$('#one_invoice_<?php echo $info['id']; ?>').css('display','block');" type="radio" name="t_order_invoice_<?php echo $info['id']; ?>" value="2" <?php
if ( $info['order_invoice'] == 2 )
{
?>checked<?php
}
?>>开收据</label>
</td></tr>
<tbody id="one_invoice_<?php echo $info['id']; ?>" style="display:<?php
if ( $info['order_invoice'] > 0 )
{
?>block<?php
}
elseif ( $info['channel_id'] == 62 && $info['order_invoice_header'] != '' )
{
?>block<?php
}
else
{
?>none<?php
}
?>;">
<tr><td align="center">
<span style="float:left; padding-top:4px;">抬头：</span>
<span style="float:left;"><input type="text" id="order_invoice_header_<?php echo $info['id']; ?>" value="<?php echo $info['order_invoice_header']; ?>" class="input-text" style="width:90px;margin:3px 0px;"></span>
</td></tr>


<tr><td align="left"  style="border-bottom:0px; padding-top:6px;">
<label style=" cursor:pointer;float:left; padding:3px 0px;margin-left:10px;">
<input onclick="$('#order_invoice_type_<?php echo $info['id']; ?>').val(1);$('#order_invoice_product_<?php echo $info['id']; ?>').css('display','none');" type="radio" name="t_order_invoice_type_<?php echo $info['id']; ?>" value="1" <?php
if ( $info['order_invoice_type'] == 1 )
{
?>checked<?php
}
?>>办公用品</label>
<label style=" cursor:pointer;float:left; padding:3px 0px;margin-left:20px;">
<input onclick="$('#order_invoice_type_<?php echo $info['id']; ?>').val(2);$('#order_invoice_product_<?php echo $info['id']; ?>').css('display','none');" type="radio" name="t_order_invoice_type_<?php echo $info['id']; ?>" value="2" <?php
if ( $info['order_invoice_type'] == 2 )
{
?>checked<?php
}
?>>礼品</label>
</td></tr>

<tr style="border-top:0px;"><td align="left" style="border-top:0px;">
<label style=" cursor:pointer;float:left; padding:3px 0px;margin-left:10px;">
<input onclick="$('#order_invoice_type_<?php echo $info['id']; ?>').val(3);$('#order_invoice_product_<?php echo $info['id']; ?>').css('display','block');" type="radio" name="t_order_invoice_type_<?php echo $info['id']; ?>" value="3" <?php
if ( $info['order_invoice_type'] == 3 )
{
?>checked<?php
}
?>>产品名称</label><br />
<textarea rows="5" id="order_invoice_product_<?php echo $info['id']; ?>" style="width:135px;margin:3px 0px;display:<?php
if ( $info['order_invoice_type'] == 3 )
{
?>block<?php
}
else
{
?>none<?php
}
?>;"><?php
if ( $info['order_invoice_product'] )
{
?><?php echo $info['order_invoice_product']; ?><?php
}
else
{
?><?php echo $info['order_invoice_product_m']; ?><?php
}
?></textarea>
</td></tr>
</tbody>
<tr><td >
<input type="hidden" id="order_invoice_type_<?php echo $info['id']; ?>" value="<?php echo $info['order_invoice_type']; ?>" />
<input type="hidden" id="order_invoice_<?php echo $info['id']; ?>" value="<?php echo $info['order_invoice']; ?>" />
<button style="float:left;margin:5px;" type="button" onclick="up_order_invoice(<?php echo $info['id']; ?>);">更新发票信息</button>
</td></tr>
</table>
</div>


								
</td>

<td align="center">
			
			
<div class="HY-grid" style=" padding-top:8px">
<?php
if ( $info['purchase_check'] = 1 )
{
?>

<?php
if ( $info['frontChange'] > 0 )
{
?>
<font color="#FF0000">
此订单<br />
有产品<br />
需要确认<br />
购买属性
</font>
<?php
}
else
{
?>

<?php
if ( $info['service_check'] != 1 )
{
?>
<button style="float:left;margin:5px;width:50px;height:50px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="fastOK(<?php echo $info['id']; ?>);">直接<br />确认</button>
<button style="float:left;margin:5px;width:50px;height:50px;color:#FFFFFF;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog_1(<?php echo $info['id']; ?>, 1, 0);">备注<br />确认</button>
<?php
}
?>

<?php
}
?>
<?php
}
?>


<?php
if ( $info['service_check'] == 0 )
{
?>
<button style="float:left;margin:5px;width:50px;height:50px;color:#000000; font-weight:bold;" type="button" onclick="ActionLog_1(<?php echo $info['id']; ?>, 2, 0);">取消</button>
<?php
}
else
{
?>

<?php
if ( $info['service_check'] == 1 )
{
?>
<?php
if ( $info['NoEdit'] == 1 )
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
<button style="float:left;margin:5px;width:50px;height:50px;color:#000000; font-weight:bold;" type="button" onclick="ActionLog(<?php echo $info['id']; ?>, 2, 0);">取消</button>
<?php
}
?>
<?php
}
?>

<?php
}
?>

</div>						
						
						
						</td>


				<td>
				<div class="HY-grid" style=" padding-top:8px">
						<table cellspacing="0" class="data">
							<tbody id="call_line_<?php echo $info['id']; ?>">
								<?php
if ( $info['service_call_list'] )
{
foreach ( $info['service_call_list'] as $row )
{
?>
								<tr>
									<td align="left">&nbsp;<?php echo $row['comment']; ?></td>
									<td align="center" width="50"><?php echo $row['user_name_zh']; ?></td>
									<td align="center" width="70"><?php echo DateFormat($row['add_time'],'m-d H:m'); ?></td>
								</tr>
								<?php
}
}
?>
							</tbody>
						</table>
						<p>
<button style="float:right;margin-left:10px;margin-top:10px;" type="button" onclick="fastcall(<?php echo $info['id']; ?>,1,'无人接听');">无人接听</button>
<button style="float:right;margin-left:10px;margin-top:10px;" type="button" onclick="fastcall(<?php echo $info['id']; ?>,2,'客户关机');">客户关机</button>
<button style="float:right;margin-left:10px;margin-top:10px;" type="button" onclick="fastcall(<?php echo $info['id']; ?>,3,'客户挂断');">客户挂断</button>
<button style="float:right;margin-left:10px;margin-top:10px;" type="button" onclick="ActionLog_2(<?php echo $info['id']; ?>, 1, 1);">其他情况</button>
<button style="float:right;margin-left:10px;margin-top:10px;" type="button" onclick="fastcall(<?php echo $info['id']; ?>,4,'来电提醒');">来电提醒</button>
<button style="float:right;margin-left:10px;margin-top:10px;" type="button" onclick="fastcall(<?php echo $info['id']; ?>,5,'无法接通');">无法接通</button>			
				</p>
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


<script language="JavaScript">
$(document).ready(function(){
	$('a[ctype=expand]').click(function(){
		$(this).parents('td').eq(0).find('div').toggle();
	});
});

var isSubmit = false;

function ActionLog(orderId, type, call){
	var html = $('#tpl_action').html().replace(/-_-/ig, '');
	html = $(html);

	if (call==1){
		html.find('form').attr('action', '?mod=order.edit.call&id='+orderId);
		title = '呼叫记录';
	}else{
		html.find('form').attr('action', '?mod=order.edit.check&id='+orderId+'&do=service&type='+type);
		title = type==1?'确认':'取消';
	}

	Dialog(title,html,function(){
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
	});
}
















//UnDialog();

function ActionLog_1(orderId, type, call){
	var html = $('#tpl_action').html().replace(/-_-/ig, '');
	html = $(html);

	if (call==1){
		html.find('form').attr('action', '?mod=order.edit.call&id='+orderId);
		title = '呼叫记录';
	}else{
		html.find('form').attr('action', '?mod=order.edit.check&id='+orderId+'&do=service&type='+type);
		title = type==1?'确认':'取消';
	}

	Dialog(title,html,function(){
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
		comment=html.find('form').find('.input-text').val();
		$.ajax({
		url:'?mod=order.edit.check_f&id='+orderId+'&comment='+comment+'&do=service&type='+type+'&rand=' + Math.random(),
		type:'GET',
		success: function(info){
			if (info=='200'){
			$('#one_line_'+orderId+'').css('display','none');
			UnDialog();
			alert('操作成功！');
			}else{
				alert(info);
			}
		},
		error:function(info){
			alert('网络错误,请重试');
		}
	});





		isSubmit = true;
		}
	});
}














function ActionLog_2(orderId, type, call){
	var html = $('#tpl_action').html().replace(/-_-/ig, '');
	html = $(html);

	if (call==1){
		html.find('form').attr('action', '?mod=order.edit.call&id='+orderId);
		title = '呼叫记录';
	}else{
		html.find('form').attr('action', '?mod=order.edit.check&id='+orderId+'&do=service&type='+type);
		title = type==1?'确认':'取消';
	}

	Dialog(title,html,function(){
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
		comment=html.find('form').find('.input-text').val();
		$.ajax({
		//url:'?mod=order.edit.check_f&id='+orderId+'&do=service&comment='+comment+'&type='+type+'&rand=' + Math.random(),
		url: '?mod=order.edit.call_h&id='+orderId+'&comment='+comment+'&rand=' + Math.random(),
		type:'GET',
		success: function(info){
			if (info=='200'){
			//$('#one_line_'+orderId+'').css('display','none');
			
			$('#call_line_'+orderId+'').append('<tr><td align="left">&nbsp;'+comment+'</td><td align="center" width="50"><?php echo $session['user_real_name']; ?></td><td align="center" width="70"><?php echo DateFormat(time(),'m-d H:m'); ?></td></tr>');

			UnDialog();
			alert('操作成功！');
			}else{
				alert(info);
			}
		},
		error:function(info){
			alert('网络错误,请重试');
		}
	});





		isSubmit = true;
		}
	});
}





function fastOK(orderId){
	$.ajax({
		url:'?mod=order.edit.check_f&id='+orderId+'&do=service&type=1&rand=' + Math.random(),
		type:'GET',
		//data:post,
		success: function(info){
			if (info=='200'){
			alert('操作成功！');
			$('#one_line_'+orderId+'').css('display','none');
			}else{
				alert(info);
			}
		},
		error:function(info){
			alert('网络错误,请重试');
		}
	});






}




function fastcall(orderId,comments,title){
	//Loading();
	$.ajax({
		url: '?mod=order.edit.call_h&id='+orderId+'&comment='+comments+'&rand=' + Math.random(),
		type:'GET',
		//data:post,
		success: function(info){
			if (info=='200'){
				//Loading('处理成功', '正在跳转到列表页面...');
				//window.location='?mod=order.check.service&service_check=<?php echo $_GET['service_check']; ?>';

	$('#call_line_'+orderId+'').append('<tr><td align="left">&nbsp;'+title+'</td><td align="center" width="50"><?php echo $session['user_real_name']; ?></td><td align="center" width="70"><?php echo DateFormat(time(),'m-d H:m'); ?></td></tr>');
	alert('处理成功');

				
				
				
			}else{
				alert(info);
				//UnLoading();
			}
		},
		error:function(info){
			alert('网络错误,请重试');
			//UnLoading();
		}
	});
}




function up_order_invoice(orderId){
	//Loading();
	var order_invoice=$('#order_invoice_'+orderId+'').val();
	var order_invoice_header=$('#order_invoice_header_'+orderId+'').val();
	
	var order_invoice_type=$('#order_invoice_type_'+orderId+'').val();
	var order_invoice_product=$('#order_invoice_product_'+orderId+'').val();
	
	
	var T_url ='?mod=order.edit.up_order_invoice&id='+orderId+'&order_invoice='+order_invoice+'&order_invoice_header='+order_invoice_header+'&order_invoice_type='+order_invoice_type+'&order_invoice_product='+order_invoice_product+'&rand=' + Math.random();
	//window.location=T_url;
	$.ajax({
		url: T_url,
		type:'GET',
		//data:post,
		success: function(info){
			if (info==200){
				alert('处理成功');
				//window.location='?mod=order.check.service&service_check=<?php echo $_GET['service_check']; ?>';
			}else{
				alert(info);
				//UnLoading();
			}
		},
		error:function(info){
			alert('网络错误,请重试');
			//UnLoading();
		}
	});
}




function up_order_user(orderId){
	//Loading();
	var order_shipping_name=$('#order_shipping_name_'+orderId+'').val();
	var order_shipping_phone=$('#order_shipping_phone_'+orderId+'').val();
	var order_shipping_mobile=$('#order_shipping_mobile_'+orderId+'').val();
	var order_shipping_address=$('#order_shipping_address_'+orderId+'').val();
	var order_shipping_zip=$('#order_shipping_zip_'+orderId+'').val();
	var T_url ='?mod=order.edit.up_order_user&id='+orderId+'&order_shipping_name='+order_shipping_name+'&order_shipping_phone='+order_shipping_phone+'&order_shipping_mobile='+order_shipping_mobile+'&order_shipping_address='+order_shipping_address+'&order_shipping_zip='+order_shipping_zip+'&rand=' + Math.random();
	//window.location=T_url;
	$.ajax({
		url: T_url,
		type:'GET',
		//data:post,
		success: function(info){
			if (info==200){
			$('#one_user_e_'+orderId+'').css('display','none');
			$('#one_user_'+orderId+'').css('display','');
			$('#e_a_'+orderId+'}').css('display','');
			$('#e_b_'+orderId+'').css('display','none');
			$('#one_user_'+orderId+'_1').text(order_shipping_name);
			$('#one_user_'+orderId+'_2').text(order_shipping_phone);
			$('#one_user_'+orderId+'_3').text(order_shipping_mobile);
			$('#one_user_'+orderId+'_4').text(order_shipping_address);
			$('#one_user_'+orderId+'_5').text(order_shipping_zip);
				alert('处理成功');
				//window.location='?mod=order.check.service&service_check=<?php echo $_GET['service_check']; ?>';
			}else{
				alert(info);
				//UnLoading();
			}
		},
		error:function(info){
			alert('网络错误,请重试');
			//UnLoading();
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

<script>
function AttributeEdit(pid,id){
	productId = pid;
	orderProductId = id;
	$.ajax({
		url: '?mod=product.ajax.sku&pid='+pid+'&type=get_product&rand=' + Math.random(),
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
				Dialog('选择属性',html,AttributeEditSku,false,function(){AttributeEventNoLimit();});
			}else{
				alert('没有待选属性');
			}
		},
		error:function(info){
			alert("网络传输错误,请重试...");
			return false;
		}
	});
}



function AttributeEditSku(){
	var postData = $('#dialog-attribute-form').serialize();
	$.ajax({
		url: '?mod=product.ajax.sku&pid='+productId+'&type=get_sku&rand=' + Math.random(),
		processData: true,
		type:"POST",
		dataType:'json',
		data:postData,
		success: function(info){
			if (!info.product||!info.product.id){
				alert('没有找到指定的商品');
				return;
			}

			if (!info.sku){
				alert('没有查询到SKU');
				return;
			}

			if ($('#sku-'+orderProductId).text()==info.sku){
				UnDialog();
				return;
			}

			//window.location='?mod=order.fastEdit&e_sku='+info.sku+'&e_id='+orderProductId+'&rand=' + Math.random();
			fastEdit(orderProductId,info.sku);
			//$('#sku-'+orderProductId).html('<font color="red">'+info.sku+'</font>');
			//$('#sku-input-'+orderProductId).val(info.sku);
			//$('#attribute-info-'+orderProductId).html('<font color="red">'+info.sku_info.attribute+'</font>');

			UnDialog();
		},
		error:function(info){
			alert("网络传输错误,请重试...");
			return false;
		}
	});
}


function fastEdit(e_id,e_sku){
	Loading();
	$.ajax({
		url: '?mod=order.fastEdit&e_sku='+e_sku+'&e_id='+e_id+'&rand=' + Math.random(),
		type:'GET',
		//data:post,
		success: function(info){
			if (info=='200'){
				Loading('处理成功', '正在跳转到列表页面...');
				window.location='?mod=order.check.service&service_check=<?php echo $_GET['service_check']; ?>';
				//window.location='?mod=order.check.service&service_check=<?php echo $_GET['service_check']; ?>';
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