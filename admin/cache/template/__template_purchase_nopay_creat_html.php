<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-12-19 01:41:01
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<style>
.xiaofw_0{border:#000000 1px solid;height:20px; background:#FFFFFF;}
.xiaofw_1{float:left;}
.xiaofw_2{float:right;}
.xiaofw_3 td{ font-size:13px;line-height:1.3; padding-top:5px;}
.STYLE1 {color: #666666}
.xiaofw_5 b{ color:#009900}
.xiaofw_5 font{ color:#999999; text-decoration:none; }
.xiaofw_5 strong{color:#333333}
.xiaofw_5 a{cursor:pointer;}
.xiaofw_5 em{ color:#CC0000;}
</style>
<div style=" position:fixed;right:20px;top:40px;width:300px;">
 <var id="supplierSID_var"  class="MSearch_box" init="0" py="1" style="float:right;height:24px;border:#000000 1px solid; text-align:left;background:#FFFFFF url(image/Ajax.radio.png) no-repeat right 4px;" MSname="">
<select style="display:none" name="supplier_id" id="supplier_id" action="DSD()">
<option value="0" <?php
if ( 0 == $_GET['supplierId'] )
{
?>selected<?php
}
?> >供货商</option>
<?php
if ( $Supplier_list )
{
foreach ( $Supplier_list as $val )
{
?>
<option op="<?php echo $val['name_op']; ?>" <?php
if ( $val['id'] == $_GET['supplierId'] )
{
?>selected<?php
}
?> value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
<?php
}
}
?>
</select>
</var>
</div>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">
<?php
if ( $_GET['supplierId'] > 0 )
{
?><input type="checkbox" onclick="if (this.checked){$('input[name^=purchase_list_Id]').attr('checked', true);}else{$('input[name^=purchase_list_Id]').attr('checked', false);}">　<?php
}
?>未付款采购单列表 </h3>

    
    
	　　总金额：<?php echo $all_money_all; ?>
	
	<p class="right">

	</p>
</div>


<div style="margin:0px auto; display:table;width:100%;">
<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
<div style="font-size:13px;float:left;width:300px;border:#4D92CD 2px solid; background:#FFFFFF;margin:10px;height:50px; padding:10px;line-height:30px;">
<a href="?mod=purchase.nopay_creatS&paymentType=<?php echo $_GET['paymentType']; ?>&supplierId=<?php echo $val['supplier_id']; ?>"><?php echo $val['supplier_name']; ?></a><br>
总金额：<?php echo $val['Allmoney']; ?>
</div>
<?php
}
}
?>
</div>
<script language="JavaScript">
function DSD(){
window.location='?mod=<?php echo $_GET['mod']; ?>&paymentType=<?php echo $_GET['paymentType']; ?>&supplierId='+$("#supplier_id").val();
	
}


$(document).ready(function(){
	$('a[ctype=expand]').click(function(){
		$(this).parents('td').eq(0).find('div').toggle();
	});
});

var isSubmit = false;

function ActionLog(purchaseId, type, call){
	var html = $('#tpl_action').html().replace(/-_-/ig, '');
	html = $(html);

	if (call==1){
		html.find('form').attr('action', '?mod=purchase.new.call_1&id='+purchaseId+'&supplierId=<?php echo $_GET['supplierId']; ?>');
		title = '拒绝原因';
	}
	//else{
	//	html.find('form').attr('action', '?mod=order.edit.check&id='+orderId+'&do=service&type='+type);
	//	title = type==1?'确认':'取消';
	//}

	Dialog(title,html,function(){
		if (isSubmit){
			return false;
		}
		
		if( !html.find('form').find('#comment').val() ){
		alert('请输入拒绝原因');
			return false;
		}

		html.find('form').submit();
		isSubmit = true;
	});
}
</script>

<div id="tpl_action" style="display:none">
	<div>
		<form method="post" action="">
			<table width="100%">
				<tr>
					<td align="right" width="90">备注:</td>
					<td><textarea type="text" name="comment" id="comment" style="width:220px;height:50px;" class="input-text"/></textarea></td>
				</tr>
			</table>
		</form>
	</div>
</div>
<script type="text/javascript" src='script/search.js'></script>