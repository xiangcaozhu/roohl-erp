<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2016-09-05 17:34:09
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<meta http-equiv="refresh" content="300;url=?mod=order.check.service_2"> 
<link href="css/cal/zpcal.css" rel="stylesheet" type="text/css">
<link href="css/cal/template.css" rel="stylesheet" type="text/css">
<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>
<style>
.xiao_1 input{border:#999999 1px solid;height:16px;}
.xiao_1 select{border:#999999 1px solid;height:20px;}
.xiao_2{float:left;width:20px;height:20px; text-align:center;border:#666666 1px solid;margin-right:6px;}
.xiao_3{float:left;width:20px;height:20px; text-align:center;border:#666666 1px solid;margin-right:6px;color:#FFFFFF; background:#000000;}
.xiao_21{float:left;width:20px;height:20px; text-align:center;border:#666666 1px solid;margin-right:25px;}
.xiao_22{float:right;width:20px;height:20px; text-align:center;border:#666666 1px solid;}
</style>

<div style="margin:0px auto;width:100%; padding:0px;">









<?php
if ( $orderInfo['id'] )
{
?>
<ul style="width:950px; position:fixed;left:0px;top:0px;" id="callBox">
<dl id="one_line_<?php echo $orderInfo['id']; ?>" style="float:left;width:928px;margin:0px;padding:10px;margin-bottom:20px;border:#999999 1px solid; background:#FFFFFF;">
<dt style="float:left;width:740px;border-right:#999999 1px solid;padding-right:10px;">
<div style="float:left;width:740px; padding-bottom:5px;">
<span style="float:left;">订单号：<b><?php echo $orderInfo['id']; ?></b>　　导入时间：<?php echo $orderInfo['add_time']; ?></span>
<span style="float:right;"><?php echo $orderInfo['channel_name']; ?>&nbsp;→&nbsp;[<?php echo $orderInfo['order_time']; ?>]&nbsp;→&nbsp;<b><?php echo $orderInfo['target_id']; ?></b></span>
</div>
<div style="float:left;width:740px;">
<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
  <tr style=" background:url(image/sort_row_bg.gif) repeat-x left top;line-height:25px; font-weight:bold;">
    <td width="70"><div align="center">渠道编号</div></td>
    <td><div align="left">&nbsp;银行销售名称</div></td>
	<td width="80"><div align="center">银行属性</div></td>
	<td width="80"><div align="center">系统属性</div></td>
    <td width="40"><div align="center">数量</div></td>
	<td width="70"><div align="center">单价</div></td>
  </tr>
<?php
if ( $orderInfo['product_list'] )
{
foreach ( $orderInfo['product_list'] as $row )
{
?>
<tr style="line-height:25px;">
    <td bgcolor="#FFFFFF" align="center" ><?php
if ( trim($row['target_id']) && $row['price'] > 0 )
{
?><?php echo $row['target_id']; ?><?php
}
else
{
?><font color="red">赠品</font><?php
}
?></td>
    <td bgcolor="#FFFFFF"><div style="float:left; padding:6px 5px;line-height:1.4;">
	<?php
if ( trim($row['target_id']) && $row['price'] > 0 )
{
?>
	银行：<?php echo $row['extra_name']; ?><br />
	系统：<?php echo $row['sku_info']['product']['name']; ?>
	<?php
}
else
{
?><?php echo $row['sku_info']['product']['name']; ?><?php
}
?>
	
	</div></td>
	<td bgcolor="#FFFFFF" align="center"><?php
if ( $row['buy_type'] )
{
?><font color="red"><?php echo $row['buy_type']; ?></font><?php
}
?></td>
	<td bgcolor="#FFFFFF" align="center">	
	<?php
if ( $row['sku_info']['attribute'] )
{
?><span style="color:green" id="attribute_<?php echo $row['id']; ?>"><?php echo $row['sku_info']['attribute']; ?></span><br /><?php
}
?>
<?php
if ( $row['sku_info']['is_base'] == 0 && $info['NoEdit'] != 1 )
{
?><a href="javascript:void(0);" onclick="AttributeEdit(<?php echo $row['sku_info']['product']['id']; ?>,<?php echo $row['id']; ?>);">修改属性</a><?php
}
?>
	</td>
    <td bgcolor="#FFFFFF" align="center" ><?php echo $row['quantity']; ?></td>
	<td bgcolor="#FFFFFF" align="center" ><font color="red"><b><?php echo $row['price']; ?></b></td>
  </tr>

<?php
}
}
?>
</table>
</div>
<div style="float:left;width:740px;margin-top:20px;">
<fieldset style="float:left;width:420px; padding:10px;border:#0066CC 2px dashed;">
<legend style="color:#0066CC;">
<b>客户信息</b>　　
<a id="e_a_<?php echo $orderInfo['id']; ?>" style="cursor:pointer;" onclick="$('#one_user_e_<?php echo $orderInfo['id']; ?>').css('display','');$('#one_user_<?php echo $orderInfo['id']; ?>').css('display','none');$('#e_b_<?php echo $orderInfo['id']; ?>').css('display','');$('#e_a_<?php echo $orderInfo['id']; ?>').css('display','none');">编辑客户信息</a>
<a id="e_b_<?php echo $orderInfo['id']; ?>" style="cursor:pointer; display:none;" onclick="$('#one_user_e_<?php echo $orderInfo['id']; ?>').css('display','none');$('#one_user_<?php echo $orderInfo['id']; ?>').css('display','');$('#e_a_<?php echo $orderInfo['id']; ?>').css('display','');$('#e_b_<?php echo $orderInfo['id']; ?>').css('display','none');">取消编辑</a>
</legend>
<table width="420" cellspacing="0" id="one_user_<?php echo $orderInfo['id']; ?>">
<tr><td align="right" width="50">收货人：</td><td id="one_user_<?php echo $orderInfo['id']; ?>_1"><?php echo $orderInfo['order_shipping_name']; ?></td></tr>
<tr><td align="right">电　话：</td><td id="one_user_<?php echo $orderInfo['id']; ?>_2"><?php echo $orderInfo['order_shipping_phone']; ?></td></tr>
<tr><td align="right">手　机：</td><td id="one_user_<?php echo $orderInfo['id']; ?>_3"><?php echo $orderInfo['order_shipping_mobile']; ?></td></tr>
<tr><td align="right">地　址：</td><td id="one_user_<?php echo $orderInfo['id']; ?>_4"><?php echo $orderInfo['order_shipping_address']; ?></td></tr>
<tr><td align="right">邮　编：</td><td id="one_user_<?php echo $orderInfo['id']; ?>_5"><?php echo $orderInfo['order_shipping_zip']; ?></td></tr>
</table>
<table cellspacing="0" width="420" id="one_user_e_<?php echo $orderInfo['id']; ?>">
<tr><td align="right" width="50" height="25">收货人：</td><td ><input style="width:100px;" type="text" id="order_shipping_name_<?php echo $orderInfo['id']; ?>" value="<?php echo $orderInfo['order_shipping_name']; ?>" /></td></tr>
<tr><td align="right" height="25">电　话：</td><td ><input style="width:130px;" type="text" id="order_shipping_phone_<?php echo $orderInfo['id']; ?>" value="<?php echo $orderInfo['order_shipping_phone']; ?>" /></td></tr>
<tr><td align="right" height="25">手　机：</td><td ><input style="width:130px;" type="text" id="order_shipping_mobile_<?php echo $orderInfo['id']; ?>" value="<?php echo $orderInfo['order_shipping_mobile']; ?>" /></td></tr>
<tr><td align="right" height="25">地　址：</td><td ><input style="width:360px;" type="text" id="order_shipping_address_<?php echo $orderInfo['id']; ?>" value="<?php echo $orderInfo['order_shipping_address']; ?>" /></td></tr>
<tr><td align="right" height="25">邮　编：</td><td ><input style="width:80px;" type="text" id="order_shipping_zip_<?php echo $orderInfo['id']; ?>" value="<?php echo $orderInfo['order_shipping_zip']; ?>" /></td></tr>
<tr><td align="right">&nbsp;</td><td >
<button style="float:left;margin:2px;" type="button" onclick="up_order_user(<?php echo $orderInfo['id']; ?>);">确认修改</button>
<button style="float:left;margin:2px;margin-left:30px;" type="button" onclick="$('#one_user_e_<?php echo $orderInfo['id']; ?>').css('display','none');$('#one_user_<?php echo $orderInfo['id']; ?>').css('display','');$('#e_a_<?php echo $orderInfo['id']; ?>').css('display','');$('#e_b_<?php echo $orderInfo['id']; ?>').css('display','none');">取消修改</button>
</td></tr>
</table>
<table cellspacing="0" width="420" style="border-top:#993333 1px solid;margin-top:10px;">
<?php
if ( $orderInfo['serviceEditUserList'] )
{
foreach ( $orderInfo['serviceEditUserList'] as $row )
{
?>
<tr><td align="left" style="color:#666666;">[<?php echo $row['user_name_zh']; ?>/<?php echo DateFormat($row['add_time'],'m-d H:i'); ?>]→<?php echo $row['comment']; ?></td></tr>
<?php
}
}
?>
</table>
</fieldset>
<script>
$('#one_user_e_<?php echo $orderInfo['id']; ?>').css('display','none');
</script>



<fieldset style="float:right;width:250px; padding:10px;border:#CC3366 2px dashed;">
<legend style="color:#CC3366;">
<b>发票信息</b>　
<label style=" cursor:pointer;margin-left:5px;"><input onclick="$('#order_invoice_<?php echo $orderInfo['id']; ?>').val(0);$('#one_invoice_<?php echo $orderInfo['id']; ?>').css('display','none');" type="radio" name="t_order_invoice_<?php echo $orderInfo['id']; ?>" value="0" <?php
if ( $orderInfo['order_invoice'] == 0 )
{
?>checked<?php
}
?>>不需要</label>
<label style=" cursor:pointer;margin-left:5px;"><input onclick="$('#order_invoice_<?php echo $orderInfo['id']; ?>').val(1);$('#one_invoice_<?php echo $orderInfo['id']; ?>').css('display','block');" type="radio" name="t_order_invoice_<?php echo $orderInfo['id']; ?>" value="1" <?php
if ( $orderInfo['order_invoice'] == 1 )
{
?>checked<?php
}
?>>开发票</label>
<label style=" cursor:pointer;margin-left:5px;"><input onclick="$('#order_invoice_<?php echo $orderInfo['id']; ?>').val(2);$('#one_invoice_<?php echo $orderInfo['id']; ?>').css('display','block');" type="radio" name="t_order_invoice_<?php echo $orderInfo['id']; ?>" value="2" <?php
if ( $orderInfo['order_invoice'] == 2 )
{
?>checked<?php
}
?>>开收据</label>
</legend>


<table cellspacing="0" width="250" id="one_invoice_<?php echo $orderInfo['id']; ?>" style="display:<?php
if ( $orderInfo['order_invoice'] > 0 )
{
?><?php
}
elseif ( $orderInfo['channel_id'] == 62 && $orderInfo['order_invoice_header'] != '' )
{
?><?php
}
else
{
?>none<?php
}
?>;">
<tr><td align="right" width="50" height="25">抬头：</td><td ><input type="text" id="order_invoice_header_<?php echo $orderInfo['id']; ?>" value="<?php echo $orderInfo['order_invoice_header']; ?>" class="input-text" style="width:180px;"></td></tr>
<tr><td align="right" height="25">内容：</td><td >
<label style=" cursor:pointer;">
<input onclick="$('#order_invoice_type_<?php echo $orderInfo['id']; ?>').val(1);$('#order_invoice_product_<?php echo $orderInfo['id']; ?>_tr').css('display','none');" type="radio" name="t_order_invoice_type_<?php echo $orderInfo['id']; ?>" value="1" <?php
if ( $orderInfo['order_invoice_type'] == 1 )
{
?>checked<?php
}
?>>办公用品</label>
<label style=" cursor:pointer;margin-left:5px;">
<input onclick="$('#order_invoice_type_<?php echo $orderInfo['id']; ?>').val(2);$('#order_invoice_product_<?php echo $orderInfo['id']; ?>_tr').css('display','none');" type="radio" name="t_order_invoice_type_<?php echo $orderInfo['id']; ?>" value="2" <?php
if ( $orderInfo['order_invoice_type'] == 2 )
{
?>checked<?php
}
?>>礼品</label>
<label style=" cursor:pointer;margin-left:5px;">
<input onclick="$('#order_invoice_type_<?php echo $orderInfo['id']; ?>').val(3);$('#order_invoice_product_<?php echo $orderInfo['id']; ?>_tr').css('display','');" type="radio" name="t_order_invoice_type_<?php echo $orderInfo['id']; ?>" value="3" <?php
if ( $orderInfo['order_invoice_type'] == 3 )
{
?>checked<?php
}
?>>产品名称</label>
</td></tr>
<tr id="order_invoice_product_<?php echo $orderInfo['id']; ?>_tr" style="display:<?php
if ( $orderInfo['order_invoice_type'] == 3 )
{
?><?php
}
else
{
?>none<?php
}
?>;"><td align="right">&nbsp;</td><td >
<textarea rows="3" id="order_invoice_product_<?php echo $orderInfo['id']; ?>" style="width:180px;"><?php
if ( $orderInfo['order_invoice_product'] )
{
?><?php echo $orderInfo['order_invoice_product']; ?><?php
}
else
{
?><?php echo $orderInfo['order_invoice_product_m']; ?><?php
}
?></textarea>
</td></tr>
</table>
<table cellspacing="0" width="250">
<tr><td align="right" width="50">&nbsp;</td><td >
<input type="hidden" id="order_invoice_type_<?php echo $orderInfo['id']; ?>" value="<?php echo $orderInfo['order_invoice_type']; ?>" />
<input type="hidden" id="order_invoice_<?php echo $orderInfo['id']; ?>" value="<?php echo $orderInfo['order_invoice']; ?>" />
<button style="float:right;margin:5px;" type="button" onclick="up_order_invoice(<?php echo $orderInfo['id']; ?>);">更新发票信息</button>
</td></tr>
</table>
</fieldset>


</div>

</dt>		
				
<dd style="float:right;margin:0px;width:160px;">
<?php
if ( $orderInfo['order_comment'] && $orderInfo['order_comment'] != '|' )
{
?>
<fieldset style="float:left;width:136px; padding:5px 10px;border:#0066CC 2px dashed;margin-bottom:10px;">
<legend style="color:#0066CC;">客户备注</legend>
<span style="float:left;width:136px; text-align:left;"><?php echo $orderInfo['order_comment']; ?></span>
</fieldset>
<?php
}
?>


<div style="float:left; padding:5px 10px;width:140px;border:#999999 1px dashed; background:#F1F1F1;">
产品部：<?php echo $orderInfo['purchase_check_name']; ?><br />
<?php $Myline = 1; ?>
<?php
if ( $orderInfo['purchase_check_list'] )
{
foreach ( $orderInfo['purchase_check_list'] as $row )
{
?>
<?php
if ( $Myline == 1 )
{
?>
<?php echo $row['user_name_zh']; ?>：<?php echo DateFormat($row['add_time'],'m-d H:i'); ?><?php
if ( $row['comment'] )
{
?><br /><font color="#666666"><?php echo $row['comment']; ?></font><?php
}
?>
<?php
}
?>
<?php $Myline = $Myline+1; ?>
<?php
}
}
?>
</div>
<div style="float:left; padding:5px;width:150px;border:#999999 1px dashed; background:#F1F1F1;margin-top:10px;" id="Btn_<?php echo $orderInfo['id']; ?>">
<?php
if ( $orderInfo['purchase_check'] == 2 )
{
?>
<button style="float:left;margin-right:5px;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog_1(<?php echo $orderInfo['id']; ?>, 2, 0);">取消</button>
<?php
}
else
{
?>

<?php
if ( $orderInfo['service_check'] == 2 )
{
?>
<button style="float:left;margin-right:5px;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="fastOK(<?php echo $orderInfo['id']; ?>);">直接<br />确认</button>
<button style="float:left;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog_1(<?php echo $orderInfo['id']; ?>, 1, 0);">备注<br />确认</button>
<?php
}
?>

<?php
if ( $orderInfo['service_check'] == 0 )
{
?>
<?php
if ( $orderInfo['frontChange'] > 0 )
{
?>
<font color="#663399">此订单有产品需要确认<br />购买属性</font>
<?php
}
else
{
?>
<button style="float:left;margin-right:5px;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="fastOK(<?php echo $orderInfo['id']; ?>);">直接<br />确认</button>
<button style="float:left;margin-right:5px;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog_1(<?php echo $orderInfo['id']; ?>, 1, 0);">备注<br />确认</button>
<button style="float:left;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog_1(<?php echo $orderInfo['id']; ?>, 2, 0);">取消</button>
<?php
}
?>
<?php
}
?>

<?php
if ( $orderInfo['service_check'] == 1 )
{
?>
<?php
if ( $orderInfo['NoEdit'] == 1 )
{
?>
<font color="#FF0000">此订单已有后续操作<br />无法更改</font>
<?php
}
else
{
?>
<button style="float:left;margin-right:5px;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog(<?php echo $orderInfo['id']; ?>, 2, 0);">取消</button>
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
<div style="float:left; padding:5px;width:150px;border:#999999 1px dashed; background:#F1F1F1;margin-top:10px;">
<div style="float:left;" id="call_line_<?php echo $orderInfo['id']; ?>">
<?php
if ( $orderInfo['service_call_list'] )
{
foreach ( $orderInfo['service_call_list'] as $row )
{
?>
<ul style="float:left;width:140px; padding:5px;border-bottom:#D8D8D8 1px solid;" title="操作员：<?php echo $row['user_name_zh']; ?>">
<span style="float:left;"><?php echo $row['comment']; ?></span>
<span style="float:right;"><?php echo DateFormat($row['add_time'],'m-d H:i'); ?></span>
</ul>
<?php
}
}
?>
</div>
<button style="float:left;margin-left:5px;margin-top:10px;" type="button" onclick="fastcall(<?php echo $orderInfo['id']; ?>,1,'无人接听');">无人接听</button>
<button style="float:left;margin-left:12px;margin-top:10px;" type="button" onclick="fastcall(<?php echo $orderInfo['id']; ?>,2,'客户关机');">客户关机</button>
<button style="float:left;margin-left:5px;margin-top:10px;" type="button" onclick="fastcall(<?php echo $orderInfo['id']; ?>,3,'客户挂断');">客户挂断</button>
<button style="float:left;margin-left:12px;margin-top:10px;" type="button" onclick="fastcall(<?php echo $orderInfo['id']; ?>,4,'来电提醒');">来电提醒</button>
<button style="float:left;margin-left:5px;margin-top:10px;" type="button" onclick="fastcall(<?php echo $orderInfo['id']; ?>,5,'无法接通');">无法接通</button>			
<button style="float:left;margin-left:12px;margin-top:10px;" type="button" onclick="ActionLog_2(<?php echo $orderInfo['id']; ?>, 1, 1);">其他情况</button>
</div>


</dd>
</dl>
<?php
}
?>
</ul>





















<ul style=" position:fixed;top:40px;left:20px;width:250px;margin:0px; padding:0px;" class="xiao_1">
<span style="float:left;width:228px;border:#D8D8D8 1px solid; background:#FFFFFF;padding:10px;">
<div style="float:left;">总共 <b><?php echo $total; ?></b> 条，待外呼订单</b>。</div>
<button  style="float:right;" type="button" onclick="getNewOrder(<?php echo $orderInfo['id']; ?>);">接入订单</button>
</span>
<form method="get" id="search_form">
<span style="float:left;margin-top:10px;width:228px;border:#D8D8D8 1px solid; background:#FFFFFF;padding:10px;">
<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
<input type="hidden" name="call" id="call" value="0">
<div style="float:left;width:228px;height:25px;">
销售渠道：<select name="channel_id" style="width:150px">
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
</div>
</span>

</form>

<?php $Myline = 1; ?>
<?php
if ( $lock_call )
{
foreach ( $lock_call as $callval )
{
?>
<span style="float:left;margin-top:10px;<?php
if ( $Myline == 1 )
{
?>margin-right:10px;<?php
}
?>width:48px;height:68px; padding-left:70px; text-align:center;border:#D8D8D8 1px solid; background:#FFFFFF url(image/call.jpg) no-repeat left 5px;">
<br /><?php echo $callval['id']; ?><br /><?php echo $callval['lock_call_user_name']; ?>
</span>
<?php $Myline = $Myline+1; ?>

<?php
if ( $Myline == 3 )
{
?>
<?php $Myline = 1; ?>
<?php
}
?>

<?php
}
}
?>
</ul>
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
			if (info=='200' ||  info==200){
			//$('#one_line_'+orderId+'').css('display','none');
var htmlStr='';
if(type==2)
{
htmlStr='<button style="float:left;margin-right:5px;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="fastOK(<?php echo $orderInfo['id']; ?>);">直接<br />确认</button><button style="float:left;margin-right:5px;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog_1(<?php echo $orderInfo['id']; ?>, 1, 0);">备注<br />确认</button>';
}else{
htmlStr='<button style="float:left;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog_1(<?php echo $orderInfo['id']; ?>, 2, 0);">取消</button>'
}
			$('#Btn_<?php echo $orderInfo['id']; ?>').html(htmlStr);
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
		url: '?mod=order.edit.call_h_call&id='+orderId+'&comment='+comment+'&rand=' + Math.random(),
		type:'GET',
		success: function(info){
			if (info=='200' || info==200){
			//$('#one_line_'+orderId+'').css('display','none');
			
			$('#call_line_'+orderId+'').append('<ul style="float:left;width:140px; padding:5px;border-bottom:#D8D8D8 1px solid;" title="操作员：<?php echo $session['user_real_name']; ?>"><span style="float:left;">'+comment+'</span><span style="float:right;"><?php echo DateFormat(time(),"m-d H:m"); ?></span></ul>');

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
			if (info=='200' || info==200){
var htmlStr='<button style="float:left;margin-right:5px;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog_1(<?php echo $orderInfo['id']; ?>, 2, 0);">取消</button>';
			$('#Btn_<?php echo $orderInfo['id']; ?>').html(htmlStr);
			alert('操作成功！');
			//$('#one_line_'+orderId+'').css('display','none');
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
		url: '?mod=order.edit.call_h_call&id='+orderId+'&comment='+comments+'&rand=' + Math.random(),
		type:'GET',
		//data:post,
		success: function(info){
			if (info=='200' || info==200){
				//Loading('处理成功', '正在跳转到列表页面...');
				//window.location='?mod=order.check.service&service_check=<?php echo $_GET['service_check']; ?>';

	$('#call_line_'+orderId+'').append('<ul style="float:left;width:140px; padding:5px;border-bottom:#D8D8D8 1px solid;" title="操作员：<?php echo $session['user_real_name']; ?>"><span style="float:left;">'+title+'</span><span style="float:right;"><?php echo DateFormat(time(),"m-d H:i"); ?></span></ul>');
	
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
			if (info==200 || info=="200"){
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
			if (info==200 || info=="200"){
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
			fastEdit(orderProductId,info.sku,info.sku_info.attribute);
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


function fastEdit(e_id,e_sku,attribute){

	//Loading();
	$.ajax({
		url: '?mod=order.fastEdit_call&id=<?php echo $orderInfo['id']; ?>&e_sku='+e_sku+'&e_id='+e_id+'&rand=' + Math.random(),
		type:'GET',
		//data:post,
		success: function(info){
			if (info=='200' || info==200){
				//Loading('处理成功', '正在跳转到列表页面...');
				
				//$("#attribute_"+e_sku+"_"+e_id+"")
				
			$('#attribute_'+e_id).html(attribute);
			
var htmlStr='<button style="float:left;margin-right:5px;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="fastOK(<?php echo $orderInfo['id']; ?>);">直接<br />确认</button><button style="float:left;margin-right:5px;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog_1(<?php echo $orderInfo['id']; ?>, 1, 0);">备注<br />确认</button><button style="float:left;width:45px;height:45px;color:#000000;line-height:1.3; font-weight:bold;" type="button" onclick="ActionLog_1(<?php echo $orderInfo['id']; ?>, 2, 0);">取消</button>'
				$('#Btn_<?php echo $orderInfo['id']; ?>').html(htmlStr);
				alert('处理成功');
				//window.location='?mod=order.check.service_1&service_check=<?php echo $_GET['service_check']; ?>';
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






function getNewOrder(orderID){
	$.ajax({
		url: '?mod=order.fast_re_call&id=<?php echo $orderInfo['id']; ?>&rand=' + Math.random(),
		type:'GET',
		//data:post,
		success: function(info){
			if (info=='200' || info==200){
				$('#call').val(1);$('#search_form').submit();
				//window.location='?mod=order.check.service_1&service_check=<?php echo $_GET['service_check']; ?>';
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