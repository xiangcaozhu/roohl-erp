<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-11 09:18:32
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">采购单付款 </h3>
	<p class="right">
		<button type="button" onclick="$('#excel').val(1);$('#search_form').submit();$('#excel').val(0);">导出Excel</button>
	</p>
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
				<th width="60"><div align="center">采购单号</div></th>
				<th><div align="center">供应商</div></th>
				<th width="80"><div align="center">库房/收货</div></th>
				<th width="60"><div align="center">采购类型</div></th>
				<th width="80"><div align="center">采购/付款</div></th>
				<th width="80"><div align="center">总金额</div></th>
				<th width="100"><div align="center">下单时间</div></th>
				<th width="130"><div align="center">付款状态</div></th>
				<th width="130"><div align="center">发票</div></th>
				<th width="100"><div align="center">操作</div></th>
			</tr>
			<tr class="filter">
				<form method="get" id="search_form">
				<th>
					<div class="input-field">
						<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
						<input type="text" name="id" id="id" value="<?php echo $_GET['id']; ?>">
						<input type="hidden" name="excel" id="excel" value="0">
					</div>				</th>
				<th>
					<div class="input-field">
						<select name="supplier_id">
							<option value=""></option>
							<?php
if ( $supplier_list )
{
foreach ( $supplier_list as $val )
{
?>
							<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $_GET['supplier_id'] )
{
?>selected<?php
}
?>><?php echo $val['name']; ?></option>
							<?php
}
}
?>
						</select>
					</div>				</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>
					<div class="input-field">
						<select name="pay_status">
							<option value=""></option>
							<option value="1" <?php
if ( 1 == $_GET['pay_status'] && $_GET['pay_status'] != '' )
{
?>selected<?php
}
?>>已付款</option>
							<option value="0" <?php
if ( 0 == $_GET['pay_status'] && $_GET['pay_status'] != '' )
{
?>selected<?php
}
?>>未付款</option>
						</select>
					</div>				</th>
				<th>
					<div class="input-field">
						<select name="pay_invoice">
							<option value=""></option>
							<option value="1" <?php
if ( 1 == $_GET['pay_invoice'] && $_GET['pay_invoice'] != '' )
{
?>selected<?php
}
?>>有发票</option>
							<option value="0" <?php
if ( 0 == $_GET['pay_invoice'] && $_GET['pay_invoice'] != '' )
{
?>selected<?php
}
?>>无发票</option>
						</select>
					</div>				</th>
				<th><button type="button" onclick="$('#search_form').submit();">过滤</button></th>
				</form>
			</tr>
		</thead>
		<tbody>
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr>
				<td ><small><?php echo $val['id']; ?></small><span style="display:none">状态<?php echo $val['status_name']; ?></span></td>
				<td ><?php echo $val['supplier_name']; ?><br />品种:<?php echo $val['total_breed']; ?>　　件数：<?php echo $val['total_quantity']; ?></td>
				<td align="center"><?php echo $val['warehouse_name']; ?><br /><?php echo $val['receive_status_name']; ?></td>
				<td align="center"><?php echo $val['type_name']; ?><br /><?php echo $val['product_type_name']; ?></td>
				<td align="center"><?php echo $val['user_name_zh']; ?><br /><?php echo $val['payment_type_name']; ?></td>
				<td align="right">&yen;<?php echo $val['total_money']; ?></td>
				<td align="center"><small><?php echo $val['add_time']; ?></small></td>
				<td id="pay_row_<?php echo $val['id']; ?>">
					<?php
if ( $val['pay_status'] == 0 )
{
?>
					<a style="cursor:pointer;" onclick="set_pay_status(<?php echo $val['id']; ?>,'#pay_row_<?php echo $val['id']; ?>');"><span style="color:red;"><?php echo $val['pay_status_name']; ?><br />设置已付款</span></a>
					<?php
}
else
{
?>
					<div style="margin:0px auto;width:98%"><span style="color:green;float:left;"><?php echo $val['pay_status_name']; ?></span><span style="float:right;"><?php echo $val['pay_user_name']; ?></span></div><br />
					<div style="margin:0px auto;width:98%"><small><?php echo DateFormat($val['pay_time'], 'y-m-d G:i'); ?></small></div>
					<?php
}
?>	
					</td>
				<td id="pay_invoice_row_<?php echo $val['id']; ?>">
					<?php
if ( $val['pay_invoice'] == 0 )
{
?>
					<a style="cursor:pointer;" onclick="set_pay_invoice(<?php echo $val['id']; ?>,'#pay_invoice_row_<?php echo $val['id']; ?>');"><span style="color:red;float:left;">无发票<br />收到发票</span></a>
					<?php
}
else
{
?>
					<div style="margin:0px auto;width:98%"><span style="color:green;float:left;">有发票</span><span style="float:right;"><?php echo $val['pay_invoice_order']; ?></span></div><br />
					<div style="margin:0px auto;width:98%"><span style="float:left;"><?php echo $val['pay_invoice_user_name']; ?></span><span style="float:right;"><small><?php echo DateFormat($val['pay_invoice_time'], 'Y-m-d G:i'); ?></small></span></div>
				
					<?php
}
?>	
					</td>
				<td >
					<a href="?mod=purchase.view&id=<?php echo $val['id']; ?>" target="_blank">查看</a><br />
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


<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>



<script language="JavaScript">
function set_pay_status(purchase_id,obj){
	$.ajax({
		url: '?mod=purchase.pay.checkpay&purchase_id='+purchase_id+'&pay_user_id=<?php echo $session['user_id']; ?>&pay_user_name=<?php echo $session['user_real_name']; ?>&rand=' + Math.random(),
		type:'POST',
		data:'',
		success: function(info){
			if (info!=''){
			$(obj).html(info);
			alert("设置成功！");
			}
		},
		error:function(info){
			alert('网络错误,请重试');
		}
	});
}


$(document).ready(function(){
	/*
	var auto = new Ext.form.AutoCompleteField({
		applyTo: 'supplier_name',
		hideTrigger:true,
		width:200,
		hiddenName:'supplier',
		store:autoComplateSupplierStore,	
		mode: 'local',
		tpl:autoComplateSupplierTemplate,
		valueField:'id',
		displayField:'name',
		queryId:'key',
		emptyText:'请输入供应商名称进行查找...'
	});
	*/
});

var isSubmit = false;

function Action(orderId, payStatus, payTime, payInvoice, payInvoiceTime){
	var html = $('#tpl_action').html().replace(/-_-/ig, '');
	html = $(html);

	Dialog('设置',html,function(){
		if (isSubmit){
			return false;
		}

		html.find('form').attr('action', '?mod=purchase.pay.check&id='+orderId);
		html.find('form').submit();
		isSubmit = true;
	},
	function(){},
	function(){
		setTimeout(function(){
			var cal = new Zapatec.Calendar.setup({
				inputField     :    "pay_date",     // id of the input field
				ifFormat       :    "%Y-%m-%d",     // format of the input field
				showsTime      :     false,
				button         :    "pay_date_btn",  // trigger button (well, IMG in our case)
				weekNumbers    :    false,  // allows user to change first day of week
				firstDay       :    1, // first day of week will be Monday
				align          :    "Bl"           // alignment (defaults to "Bl")
			});

			var cal = new Zapatec.Calendar.setup({
				inputField     :    "pay_invoice_date",     // id of the input field
				ifFormat       :    "%Y-%m-%d",     // format of the input field
				showsTime      :     false,
				button         :    "pay_invoice_date_btn",  // trigger button (well, IMG in our case)
				weekNumbers    :    false,  // allows user to change first day of week
				firstDay       :    1, // first day of week will be Monday
				align          :    "Bl"           // alignment (defaults to "Bl")
			});
		}, 200);


		if ( payStatus==1 ){
			$(':radio[name=pay_status][value=1]').attr('checked',true);
		} else {
			$(':radio[name=pay_status][value=0]').attr('checked',true);
		}

		if ( payInvoice==1 ){
			$(':radio[name=pay_invoice][value=1]').attr('checked',true);
		} else {
			$(':radio[name=pay_invoice][value=0]').attr('checked',true);
		}

		$('#pay_date').val(payTime);
		$('#pay_invoice_date').val(payInvoiceTime);
		
	});
}




function set_pay_invoice(purchase_id,obj){
	var html = $('#tpl_action').html().replace(/-_-/ig, '');
	html = $(html);

	Dialog('输入发票编号',html,function(){
		if (isSubmit){
			return false;
		}
		
		if(!$('#pay_invoice_order').val()){
		alert('请填写发票编号');
		!$('#pay_invoice_order').focus();
		return false;
	    }
		
		
		
		
		$.ajax({
		url: '?mod=purchase.pay.check&purchase_id='+purchase_id+'&pay_invoice_order='+$('#pay_invoice_order').val()+'&pay_invoice_user_id=<?php echo $session['user_id']; ?>&pay_invoice_user_name=<?php echo $session['user_real_name']; ?>&rand=' + Math.random(),
		type:'POST',
		data:'',
		success: function(info){
			if (info!=''){
			$(obj).html(info);
			UnDialog();
			alert("设置成功！");
			}
		},
		error:function(info){
			alert('网络错误,请重试');
		}
	});






		//html.find('form').attr('action', '?mod=purchase.pay.check&id='+orderId);
	//	html.find('form').submit();
	//	isSubmit = true;
	},
	function(){},
	function(){}

		
	);
}


</script>

<div id="tpl_action" style="display:none">
	<div>
		<form method="post" action="">
			<table width="100%">
				<tr>
					<td align="right" width="90">发票编号:</td>
					<td>
						<input type="text" class="input-text" name="-_-pay_invoice_order" id="-_-pay_invoice_order" style="width:200px;">
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>