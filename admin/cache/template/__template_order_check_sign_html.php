<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2016-12-01 15:47:17
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
	<h3 class="head-tax-rule">订单签收</h3>　　<button type="button" onclick="kkcx();">查询快递</button>
	<div class="right">
		<button type="button" onclick="$('#excel').val(1);$('#search_form').submit();$('#excel').val(0);">导出Excel</button> | 
		<button type="button" onclick="$('#main_form').submit();">更新数据</button>
	</div>
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		待发货订单 分页:<?php echo $page_bar; ?> 每页20条记录 总共<?php echo $total; ?>条记录 <?php echo $page; ?>/<?php echo $page_num; ?>
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<th width="45">订单ID</th>
				<th width="150">渠道信息</th>
				<th width="">订单信息</th>
				<th width="400">物流公司</th>
				<th width="140">签收时间</th>
				<th width="60">操作</th>
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
					<div class="input-field">
					<select name="channel_id" style="width:150px">
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
</select><?php echo $_GET['channel_name']; ?>
</div>
<div class="input-field">
<input type="text" name="target_id" value="<?php echo $_GET['target_id']; ?>">
</div>
				</th>
				<th>
					<div class="input-from">
						<div class="clearfix">
							<div class="left2">客户名:</div>
							<input type="text" name="order_customer_name" value="<?php echo $_GET['order_customer_name']; ?>">
						</div>
						<div class="clearfix">
							<div class="left2">收货人名:</div>
							<input type="text" name="order_shipping_name" value="<?php echo $_GET['order_shipping_name']; ?>">
						</div>
					</div>
				</th>
				<th>
					<div class="input-field">
						<input type="text" name="logistics_company" value="<?php echo $_GET['logistics_company']; ?>">
					</div>
					<div class="input-field">
						<input type="text" name="logistics_sn" value="<?php echo $_GET['logistics_sn']; ?>">
					</div>
				</th>
				<th>
					<div class="input-from">
						<div class="clearfix">
							<div class="left">开始:</div>
							<input type="text" name="begin_sign_date" id="begin_sign_date" value="<?php echo $_GET['begin_sign_date']; ?>">
							<img src="image/grid-cal.gif" alt="" class="v-middle" id="begin_sign_date_btn" />
						</div>
						<div class="clearfix">
							<div class="left">结束:</div>
							<input type="text" name="end_sign_date" id="end_sign_date" value="<?php echo $_GET['end_sign_date']; ?>">
							<img src="image/grid-cal.gif" alt="" class="v-middle" id="end_sign_date_btn" />
						</div>
					</div>
				</th>
				<th><button type="button" onclick="$('#search_form').submit();">过滤</button>
				<div class="input-field">
						<select name="sign_status">
							<option value=""></option>
							<option value="1" <?php
if ( 1 == $_GET['sign_status'] && $_GET['sign_status'] != '' )
{
?>selected<?php
}
?>>已签收</option>
							<option value="0" <?php
if ( 0 == $_GET['sign_status'] && $_GET['sign_status'] != '' )
{
?>selected<?php
}
?>>未签收</option>
						</select>
					</div>
					</th>
				</form>	
			</tr>
		</thead>
		<tbody>
			<form method="post" action="?mod=order.edit.sign" id="main_form">
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr>
				<td align="center"><?php echo $val['id']; ?></td>
				<td align="left"><?php echo $val['channel_name']; ?><br><?php echo $val['target_id']; ?><br /><?php echo $val['order_time']; ?></td>
				<td >
					<div class="HY-grid" style="">
<?php
if ( $val['list'] )
{
foreach ( $val['list'] as $row )
{
?>
&nbsp;<b><?php echo $row['sku_info']['product']['name']; ?>　<font color="#006600"><?php echo $row['sku_info']['attribute']; ?></font></b><br />
<?php
}
}
?>
<br />				
						
						
&nbsp;<b>收货人：</b><?php echo $val['order_shipping_name']; ?><br />
&nbsp;<b>地　址：</b><?php echo $val['order_shipping_address']; ?><br />
&nbsp;<b>邮　编：</b><?php echo $val['order_shipping_zip']; ?><br />
<?php
if ( trim($val['order_shipping_phone']) )
{
?><b>&nbsp;电　话：</b><?php echo $val['order_shipping_phone']; ?><br /><?php
}
?>
<?php
if ( trim($val['order_shipping_mobile']) )
{
?><b>&nbsp;电　话：</b><?php echo $val['order_shipping_mobile']; ?><br /><?php
}
?>
					</div>
				</td>
				<td align="">
物流公司：<input type="text" class="input-text" style="width:130px;" name="logistics_company[<?php echo $val['id']; ?>]" value="<?php echo $val['logistics_company']; ?>"><br />
物流单号：<input type="text" class="input-text" style="width:130px;" name="logistics_sn[<?php echo $val['id']; ?>]" value="<?php echo $val['logistics_sn']; ?>"><br />
(<?php echo $val['warehouse_name']; ?>)　<?php echo $val['delivery_status_name']; ?>　　　<span id="me_<?php echo $val['id']; ?>"><input type="hidden" class="exp_nu" /></span><hr>
<div id="express_<?php echo $val['id']; ?>">
<?php
if ( trim($val['logistics_sn']) )
{
?><a href="#" id="Btnex_<?php echo $val['id']; ?>" name="<?php echo $val['id']; ?>" com="<?php echo $val['logistics_company']; ?>" sn="<?php echo $val['logistics_sn']; ?>" class="Btn_Express" onclick="GetExpress('<?php echo $val['logistics_company']; ?>','<?php echo $val['logistics_sn']; ?>',<?php echo $val['id']; ?>)">查询</a><?php
}
?>
</div>
				</td>
				<td align="">
					签收时间：<input type="text" class="input-text" style="width:110px;" id="sign_date_<?php echo $val['id']; ?>" name="sign_time[<?php echo $val['id']; ?>]" value="<?php
if ( $val['sign_status'] == 1 )
{
?><?php echo $val['sign_time']; ?><?php
}
?>"><img src="image/grid-cal.gif" alt="" align="absmiddle" id="sign_date_btn_<?php echo $val['id']; ?>" />
					<script language="JavaScript">
					var cal = new Zapatec.Calendar.setup({
						inputField     :    "sign_date_<?php echo $val['id']; ?>",     // id of the input field
						ifFormat       :    "%Y-%m-%d %H:%M",     // format of the input field
						showsTime      :     true,
						button         :    "sign_date_btn_<?php echo $val['id']; ?>",  // trigger button (well, IMG in our case)
						weekNumbers    :    false,  // allows user to change first day of week
						firstDay       :    1, // first day of week will be Monday
						align          :    "Bl"           // alignment (defaults to "Bl")
					});
					</script>
					<br /><br />签收人：
<input type="text" class="input-text" style="width:110px;" id="sign_name_<?php echo $val['id']; ?>" name="sign_name[<?php echo $val['id']; ?>]" value="<?php
if ( $val['sign_status'] == 1 )
{
?><?php echo $val['sign_name']; ?><?php
}
?>">

				</td>
				<td align="center"><?php echo $val['sign_status_name']; ?></td>
			</tr>
			<?php
}
}
?>
			</form>
		</tbody>
	</table>
</div>

<script language="JavaScript">


var cal = new Zapatec.Calendar.setup({
	inputField     :    "begin_sign_date",     // id of the input field
	ifFormat       :    "%Y-%m-%d",     // format of the input field
	showsTime      :     false,
	button         :    "begin_sign_date_btn",  // trigger button (well, IMG in our case)
	weekNumbers    :    false,  // allows user to change first day of week
	firstDay       :    1, // first day of week will be Monday
	align          :    "Bl"           // alignment (defaults to "Bl")
});

var cal = new Zapatec.Calendar.setup({
	inputField     :    "end_sign_date",     // id of the input field
	ifFormat       :    "%Y-%m-%d",     // format of the input field
	showsTime      :     false,
	button         :    "end_sign_date_btn",  // trigger button (well, IMG in our case)
	weekNumbers    :    false,  // allows user to change first day of week
	firstDay       :    1, // first day of week will be Monday
	align          :    "Bl"           // alignment (defaults to "Bl")
});
</script>

<script language="JavaScript">
$(document).ready(function(){
	$('a[ctype=expand]').click(function(){
		$(this).parents('td').eq(0).find('.HY-grid').toggle();
	});
});

</script>



<script language="JavaScript">
$(document).ready(function(){
	$('a[ctype=expand]').click(function(){
		$(this).parents('td').eq(0).find('div').toggle();
	});
});

var isSubmit = false;

function Action(orderId, type){
	var html = $('#tpl_action').html().replace(/-_-/ig, '');
	html = $(html);

	Dialog((type==1?'确认':'取消'),html,function(){
		if (isSubmit){
			return false;
		}

		html.find('form').attr('action', '?mod=order.edit.sign&id='+orderId+'&date='+$('#sign_date').val());
		html.find('form').submit();
		isSubmit = true;
	},
	function(){},
	function(){
		setTimeout(function(){
			var cal = new Zapatec.Calendar.setup({
				inputField     :    "sign_date",     // id of the input field
				ifFormat       :    "%Y-%m-%d",     // format of the input field
				showsTime      :     false,
				button         :    "sign_date_btn",  // trigger button (well, IMG in our case)
				weekNumbers    :    false,  // allows user to change first day of week
				firstDay       :    1, // first day of week will be Monday
				align          :    "Bl"           // alignment (defaults to "Bl")
			});
		}, 200);
		
	});
}
</script>


<div id="tpl_action" style="display:none">
	<div>
		<form method="post" action="">
			<table width="100%">
				<tr>
					<td align="right" width="90">时间:</td>
					<td>
						<input type="text" class="input-text" name="" id="-_-sign_date"><img src="image/grid-cal.gif" alt="" align="absmiddle" id="-_-sign_date_btn" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>


<script language="JavaScript">
function GetExpress(keywords,order,id){
$('#express_'+id+'').html('查询中--------');
//window.open('?mod=order.expressp&keywords='+escape(keywords)+'&order='+order)
	$.ajax({
		url: '?mod=order.expressp&keywords='+escape(keywords)+'&order='+order,
		processData: true,
		type:"GET",
		dataType:'json',
		//dataType:'text',
		//data:postData,
		success: function(info){
			//alert(info.data);
			$('#me_'+id+'').html(info.message);
			$('#express_'+id+'').html(info.dataAll);
			if(info.sign_time){
			$('#sign_date_'+id+'').val(info.sign_time);
			$('#sign_name_'+id+'').val(info.sign_name);
			}
			if($(".exp_nu").length<1){alert('查询完毕！')}
			
			
		},
		error:function(info){
			//alert("网络传输错误,请重试...");
			return false;
		}
	});
}



//$(document).ready(function(){

function kkcx(){
//$("#exp_nu").val($(".Btn_Express").length)


$(".Btn_Express").each(function(i,oneOrder){
var obj=$("#Btnex_"+oneOrder.name+"");
var com=obj.attr('com');
var sn=obj.attr('sn');
var pid=oneOrder.name;
GetExpress(com,sn,pid);
});



}
//com="<?php echo $val['logistics_company']; ?>" sn="<?php echo $val['logistics_sn']; ?>" pid="<?php echo $val['id']; ?>" c

  
//});
</script>