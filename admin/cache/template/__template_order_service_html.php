<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-12-19 15:43:27
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
.xiao_1 input{border:#999999 1px solid;height:16px;}
.xiao_1 select{border:#999999 1px solid;height:20px;}
.xiao_2{float:left;width:20px;height:20px; text-align:center;border:#666666 1px solid;margin-right:6px;}
.xiao_3{float:left;width:20px;height:20px; text-align:center;border:#666666 1px solid;margin-right:6px;color:#FFFFFF; background:#000000;}
.xiao_21{float:left;width:20px;height:20px; text-align:center;border:#666666 1px solid;margin-right:25px;}
.xiao_22{float:right;width:20px;height:20px; text-align:center;border:#666666 1px solid;}
</style>

<div style="margin:0px auto;width:100%; padding:0px;">
<ul style="float:right;width:950px;">
<?php
if ( $list )
{
foreach ( $list as $info )
{
?>
<dl style="float:left;width:928px;margin:0px;padding:0px;margin-bottom:20px;border:#999999 1px solid; background:#FFFFFF; position:relative;">
<dt style="float:left;width:908px; padding:5px 10px; background:#E8E8E8;border-bottom:#999999 1px solid;"><span style="float:left;">订单号：<b><?php echo $info['id']; ?></b>　　导入时间：<?php echo $info['add_time']; ?></span>
<span style="float:right;">订单状态:<b>
<?php
if ( $info['status'] > 1 )
{
?><font color="red">售后退单退货</font>
<?php
}
else
{
?>
<?php
if ( $info['service_check'] == 2 )
{
?><font color="red">已取消</font><?php
}
else
{
?><font color="green">正常</font><?php
}
?>
<?php
}
?>
</b>
</span></dt>
<dt style="float:left;width:730px; padding:10px; position:relative;margin-bottom:10px;">
<div style="float:left;width:730px; padding-bottom:10px;">
<table width="730" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
  <tr style=" background:url(image/sort_row_bg.gif) repeat-x left top;line-height:25px; font-weight:bold;">
    <td width="40" height="25"><div align="center">ID</div></td>
    <td width="70"><div align="center">SKU</div></td>
    <td width="70"><div align="center">渠道编号</div></td>
    <td><div align="left">&nbsp;名称</div></td>
	<td width="70"><div align="center">属性</div></td>
    <td width="40"><div align="center">数量</div></td>
	<td width="70"><div align="center">单价</div></td>
  </tr>
<?php
if ( $info['list'] )
{
foreach ( $info['list'] as $row )
{
?>
<tr style="line-height:25px;">
    <td bgcolor="#FFFFFF" align="center" ><?php echo $row['sku_info']['product']['id']; ?></td>
    <td bgcolor="#FFFFFF" align="center" ><?php echo $row['sku']; ?></td>
    <td bgcolor="#FFFFFF" align="center" ><?php
if ( trim($row['target_id']) && $row['price'] > 0 )
{
?><?php echo $row['target_id']; ?><?php
}
else
{
?><font color="#FF0000">赠品</font><?php
}
?></td>
    <td bgcolor="#FFFFFF">&nbsp;<?php echo $row['sku_info']['product']['name']; ?></td>
	<td bgcolor="#FFFFFF" align="center" ><?php echo $row['sku_info']['attribute']; ?></td>
    <td bgcolor="#FFFFFF" align="center" ><?php echo $row['quantity']; ?></td>
	<td bgcolor="#FFFFFF" align="center" ><?php echo $row['price']; ?></td>
  </tr>
<?php
}
}
?>
</table>
</div>

<div style="float:left;width:730px; padding-bottom:10px; padding-top:5px; text-align:right;">

<ul style="float:left;width:480px;border:#999999 1px dashed; background:#E1E1E1; padding:5px 10px;line-height:1.7; text-align:left;">
<span style="float:left;"><b>收货人：</b><?php echo $info['order_shipping_name']; ?></span>
<span style="float:right;"><b>　邮编：</b><?php echo $info['order_shipping_zip']; ?></span>
<span style="float:left;width:480px;">
<b>　电话：</b><?php echo $info['order_shipping_phone']; ?><?php
if ( trim($info['order_shipping_phone']) && trim($info['order_shipping_mobile']) )
{
?> / <?php
}
?><?php echo $info['order_shipping_mobile']; ?>
<br /><b>　地址：</b><?php echo $info['order_shipping_address']; ?>
</span>
</ul>
<ul style="float:right;width:180px;border:#999999 1px dashed; background:#E1E1E1; padding:5px 10px;line-height:1.7; text-align:right;">
<?php echo $info['channel_name']; ?><br />
<?php echo $info['order_time']; ?><br />
<b><?php echo $info['target_id']; ?></b>
</ul>
</div>				

<div style="float:left;width:730px;">

</div>

<div style="float:left;width:730px;" id="service_box<?php echo $info['id']; ?>">
<ul style="float:left;width:718px; padding:5px;border:#D8D8D8 1px solid;">
<button style="float:left;width:100px;height:25px;color:#FFFFFF;line-height:1.3; font-weight:bold;margin-right:30px;" type="button" onclick="ServiceLog(<?php echo $info['id']; ?>,1);">售后处理</button>


<?php
if ( $info['status'] == 1 && $info['logistics_sn'] != '' )
{
?>
<button style="float:left;width:100px;height:25px;color:#FFFFFF;line-height:1.3; font-weight:bold;" type="button" onclick="DoTdTh(<?php echo $info['id']; ?>);">同意退货</button>
<?php
}
else
{
?>
<?php
if ( $info['status'] == 2 )
{
?>
<button style="float:left;width:100px;height:25px;color:#FFFFFF;line-height:1.3; font-weight:bold;"  id="xiaofwggg" type="button" onclick="DoTdTh_1(<?php echo $info['id']; ?>);">货物退回中->货物退回入库</button>
<?php
}
?>
<?php
if ( $info['status'] == 3 )
{
?>
货物退回入库
<?php
}
?>

<?php
}
?>


<button style="float:right;width:100px;height:25px;color:#FFFFFF;line-height:1.3; font-weight:bold;" type="button" onclick="ServiceLog(<?php echo $info['id']; ?>,2);">售后完毕</button>
</ul>

<?php
if ( $info['service_list'] )
{
foreach ( $info['service_list'] as $row )
{
?>
<ul style="float:left;width:718px; padding:5px;border:#D8D8D8 1px solid;border-top:0px;">
<span style="float:left;"><?php echo $row['comment']; ?></span>
<span style="float:right;"><?php echo $row['user_name_zh']; ?>：<?php echo DateFormat($row['add_time'],'m-d H:i'); ?></span>
</ul>
<?php
}
}
?>
</div>

</dt>



<dd style="float:right;margin:0px;width:160px; padding-right:10px;margin-bottom:10px;">
<?php
if ( $info['order_comment'] && $info['order_comment'] != '|' )
{
?>
<fieldset style="float:left;width:136px; padding:5px 10px;border:#0066CC 2px dashed;margin-bottom:10px;">
<legend style="color:#0066CC;">客户备注</legend>
<span style="float:left;width:136px; text-align:left;"><?php echo $info['order_comment']; ?></span>
</fieldset>
<?php
}
?>
<div style="float:left; padding:5px 10px;width:140px;border:#999999 1px dashed; background:#F1F1F1;margin-top:10px;">
产品部：<?php echo $info['purchase_check_name']; ?><br />
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
<div style="float:left; padding:5px 10px;width:140px;border:#999999 1px dashed; background:#F1F1F1;margin-top:10px;">
客服部：<?php echo $info['service_check_name']; ?><br />
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
<div style="float:left; padding:5px 10px;width:140px;border:#999999 1px dashed; background:#F1F1F1;margin-top:10px;">
<?php
if ( $info['warehouse_id'] == 5 )
{
?>
发货方式：<font color="#CC0099">★代发货</font><br />
发货状态：<?php
if ( $info['logistics_sn'] != '' )
{
?><font color="green">已发货</font><br />物流公司：<?php echo $info['logistics_company']; ?><br />单号：<?php echo $info['logistics_sn']; ?><?php
}
else
{
?><font color="red">未发货</font><?php
}
?>
<?php
}
else
{
?>
发货方式：<font color="#FF6600">库房发货</font><br />
发货状态：<?php
if ( $info['logistics_sn'] != '' )
{
?><font color="green">已发货</font><br />物流公司：<?php echo $info['logistics_company']; ?><br />单号：<?php echo $info['logistics_sn']; ?><?php
}
else
{
?><font color="red">未发货</font><?php
}
?>
<?php
}
?>
</div>
<div style="float:left; padding:5px 10px;width:140px;border:#999999 1px dashed; background:#F1F1F1;margin-top:10px;">
签收状态：<?php echo $info['sign_status_name']; ?><br />到款状态：<?php echo $info['finance_recieve_name']; ?>
</div>
<div style="float:left; padding:5px 10px;width:140px;border:#999999 1px dashed; background:#F1F1F1;margin-top:10px;">
<?php
if ( $info['order_invoice'] == 2 )
{
?>
<font color="#FFCC00">开收据</font><?php
if ( $info['order_invoice_status'] == 1 )
{
?><font color="#FFCC00"> → 已开收据</font><?php
}
else
{
?><font color="red"> → 未开收据</font><?php
}
?></font>
<?php
}
elseif ( $info['order_invoice'] == 1 )
{
?>
<font color="#3366CC">开发票</font><?php
if ( $info['order_invoice_status'] == 1 )
{
?><font color="#3366CC"> → 已开发票</font><?php
}
else
{
?><font color="red"> → 未开发票</font><?php
}
?></font>
<?php
}
else
{
?>不需要票据<?php
}
?>
</div>


</dd>
</dl>
<?php
}
}
?>
</ul>
<ul style=" position:fixed;top:85px;left:280px;width:250px;margin:0px; padding:0px;" class="xiao_1">
<span style="float:left;width:228px;border:#D8D8D8 1px solid; background:#FFFFFF;padding:10px;">
<div style="float:left;">总 <b><?php echo $total; ?></b> 条，每页 <b><?php echo $onePage; ?></b> 条。</div>
<div style="float:left;width:228px; padding:10px 0px 0px 0px;"><?php
if ( $page_num > 1 )
{
?><?php echo $page_bar_b; ?><?php
}
?></div>
</span>
<form method="get" id="search_form">
<span style="float:left;margin-top:10px;width:228px;border:#D8D8D8 1px solid; background:#FFFFFF;padding:10px;">
<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>"><input type="hidden" name="excel" id="excel" value="0">

<div style="float:left;width:228px;height:25px;">
订单编号：<input style="width:60px;" type="text" name="id" id="id" value="<?php echo $_GET['id']; ?>">
</div>
<div style="float:left;width:228px;height:25px;">
售后状态：<select name="order_service" style="width:150px">
<option value="" <?php
if ( ""==_GET.order_service )
{
?>selected<?php
}
?>>所有订单</option>
<option value="1" <?php
if ( 1 == $_GET['order_service'] )
{
?>selected<?php
}
?>>售后处理中</option>
<option value="2" <?php
if ( 2 == $_GET['order_service'] )
{
?>selected<?php
}
?>>售后完毕</option>
</select>
</div>
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
<div style="float:left;width:228px;height:25px;">
渠道单号：<input style="width:150px;" type="text" name="target_id" value="<?php echo $_GET['target_id']; ?>">
</div>

<div style="float:left;width:228px;height:25px;">
　产品名：<input type="text" style="width:150px;" name="product_name" value="<?php echo $_GET['product_name']; ?>">
</div>
<div style="float:left;width:228px;height:25px;">
　收货人：<input type="text"  style="width:150px;" name="order_shipping_name" value="<?php echo $_GET['order_shipping_name']; ?>">
</div>
<div style="float:left;width:228px;height:22px;">
　　电话：<input type="text" style="width:150px;" name="phone" value="<?php echo $_GET['phone']; ?>">
</div>
</span>
<span style="float:left;margin-top:10px;width:228px;border:#D8D8D8 1px solid; background:#FFFFFF;padding:10px;">
<button style="float:left;" type="button" onclick="$('#excel').val(1);$('#search_form').submit();$('#excel').val(0);">导出</button>
<button  style="float:right;" type="button" onclick="$('#search_form').submit();">筛选订单</button>
</span>
</form>
<form method="post" id="print_invoice" target="_blank" action="index.php?mod=order.print_invoice"></form>
</ul>
</div>

<br />

<script type="text/javascript">



function up_order_invoice(orderId){
//var order_invoice=$('#order_invoice_'+orderId+'').val();
//var order_invoice_header=$('#order_invoice_header_'+orderId+'').val();
//var order_invoice_type=$('#order_invoice_type_'+orderId+'').val();
//var order_invoice_product=$('#order_invoice_product_'+orderId+'').val();
var T_url ='?mod=order.edit.up_order_invoices&id='+orderId+'&rand=' + Math.random();
	//window.location=T_url;
	$.ajax({
		url: T_url,
		type:'GET',
		//data:post,
		success: function(info){
			if (info==200 || info=='200'){
				alert('处理成功');
				$('#button_invoice_'+orderId+'').css('display','none')
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




var isSubmit = false;

function DoTdTh(orderID){


	var html = $('#tpl_action').html().replace(/-_-/ig, '');
	html = $(html);
	//html.find('form').attr('action', '#');

	Dialog('退单理由',html,function(){
		if (isSubmit){
			return false;
		}

		if(html.find('form').find('.input-text').val()=="")
		{
		alert('必须有退单理由')
		isSubmit = false;
		}
		else
		{
		//html.find('form').submit();

	$.ajax({
		url: '?mod=order.edit.tdth&order_id='+orderID+'&comment='+html.find('form').find('.input-text').val()+'&rand=' + Math.random(),
		type:'GET',
		//data:post,
		success: function(info){
			if (info=='200' || info==200){
				alert('处理成功');
				window.location.reload();
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





		isSubmit = true;
		}

//html.find('form').submit();
//		isSubmit = true;
	});
	
	
	/*
	

*/
}

function DoTdTh_1(orderID){
$("#xiaofwggg").hide();
	$.ajax({
		url: '?mod=order.edit.tdth_1&order_id='+orderID+'&rand=' + Math.random(),
		type:'GET',
		//data:post,
		success: function(info){
			if (info=='200' || info==200){
				alert('处理成功');
				window.location.reload();
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




<div id="tpl_action_1" style="display:none">
	<div>
		<form method="post" action="">
			<table width="100%">
				<tr>
					<td align="center"><textarea type="text" name="comment" style="width:380px;height:50px;" class="input-text"/></textarea></td>
				</tr>
			</table>
		</form>
	</div>
</div>

<script>
function ServiceLog(orderId,type){
isSubmit_a = false;
	var html = $('#tpl_action_1').html().replace(/-_-/ig, '');
	html = $(html);
	//html.find('form').attr('action', '?mod=order.edit.service&id='+orderId);
	title = '售后记录';


if(type==2){
				$.ajax({
				url:'?mod=order.edit.service&orderId='+orderId+'&do=service&type='+type+'&rand=' + Math.random(),
				type:'GET',
				success: function(info){
					if (info=='200' || info==200){
					
					UnDialog();
					alert('操作成功！');
					}
					else{alert(info);}
				},
				error:function(info){alert('网络错误,请重试');}
				});


}
else
{
	Dialog_1(title,html,function(){if (isSubmit_a){return false;}

		comment=html.find('form').find('.input-text').val();
		if(comment==''){alert('内容不能为空！');return false;}
				$.ajax({
				url:'?mod=order.edit.service&orderId='+orderId+'&comment='+comment+'&do=service&type='+type+'&rand=' + Math.random(),
				type:'GET',
				success: function(info){
					if (info=='200' || info==200){
				
					$('#service_box'+orderId+'').append('<ul style="float:left;width:718px; padding:5px;border:#D8D8D8 1px solid;border-top:0px;"><span style="float:left;">'+comment+'</span><span style="float:right;"><?php echo $session['user_real_name']; ?>：<?php echo DateFormat(time(),"m-d H:i"); ?></span></ul>');


					UnDialog();
					//alert('操作成功！');
					}
					else{alert(info);}
				},
				error:function(info){alert('网络错误,请重试');}
				});
		isSubmit_a = true;

	});
}





}

</script>