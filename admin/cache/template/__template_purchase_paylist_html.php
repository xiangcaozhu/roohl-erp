<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-12-19 01:46:50
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
<style>
.xiao_1 input{border:#999999 1px solid;height:16px;}
.xiao_1 select{border:#999999 1px solid;height:20px;}
.xiao_2{float:left;width:20px;height:20px; text-align:center;border:#666666 1px solid;margin-right:6px;}
.xiao_3{float:left;width:20px;height:20px; text-align:center;border:#666666 1px solid;margin-right:6px;color:#FFFFFF; background:#000000;}
.xiao_21{float:left;width:20px;height:20px; text-align:center;border:#666666 1px solid;margin-right:25px;}
.xiao_22{float:right;width:20px;height:20px; text-align:center;border:#666666 1px solid;}
</style>
<div style=" position:fixed;left:300px;top:40px;width:300px;">
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
		<p class="left"><select id="supplier" name="supplier" onchange="window.location='?mod=purchase.paylist&status='+this.options[this.selectedIndex].value+'&supplierId=<?php echo $supplierId; ?>'">
							<option value="1" <?php
if ( $_GET['status'] == 1 )
{
?>selected<?php
}
?>>未付款</option>
							<option value="2" <?php
if ( $_GET['status'] == 2 )
{
?>selected<?php
}
?>>付款完成</option>
						</select>					
	</p>
	

<span style="float:right;width:228px;border:#D8D8D8 1px solid; background:#FFFFFF;padding:10px;">
<div style="float:left;">总 <b><?php echo $total; ?></b> 条，每页 <b><?php echo $onePage; ?></b> 条。</div>
<div style="float:left;width:228px; padding:10px 0px 0px 0px;"><?php
if ( $page_num > 1 )
{
?><?php echo $page_bar_b; ?><?php
}
?></div>
</span>
</div>


<form method="post" target="_blank" action="" id="mainform">

<div class="HY-grid">
<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="50">支出单号</th>
				<th width="80">付款状态</th>
				<th width="100" align="left">总金额</th>
				<th width="150" align="left">制单人/制单日期</th>
				<th width="">供货商</th>
				<th width="200" align="center">打印</th>
			</tr>
		</thead>
		<tbody id="purchase_row">
<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr class="xiaofw_3">
				<td><?php echo $val['id']; ?></td>
				<td><?php
if ( $val['status'] > 1 )
{
?>付款完成<?php
}
else
{
?>
				<a href="?mod=purchase.new.payuppay&id=<?php echo $val['id']; ?>&status=<?php echo $_GET['status']; ?>&purchase_list_Id=<?php echo $val['purchase_id']; ?>" onclick="return confirm(\'确定付款已经完成吗?\');">确认付款</a><br />
				未付款
				<?php
}
?></td>
				<td align="left"><?php echo FormatMoney($val['all_money']); ?></td>
				<td align="left"><?php echo $val['user_name']; ?><br /><?php echo DateFormat( $val['add_time'] , 'Y-m-d H:i'); ?>
</td>
				<td>[<a href="javascript:void(0);" ctype="expand">展开/收起</a>]　<a target="_blank" href="<?php echo $url; ?>&supplierId=<?php echo $val['purchase_id']; ?>"><?php echo $val['supplier_name']; ?></a><br /><br />


<dl style="float:left;width:740px;margin:0px;padding:10px;margin-bottom:20px;border:#999999 1px solid; background:#FFFFFF;display:none;">
<dt style="float:left;width:740px;"><?php echo $val['purchase_id']; ?></dt>
</dl></td>
				<td align="center">[<a href="?mod=purchase.print_alls&supplierId=<?php echo $val['supplier_id']; ?>&purchase_list_Id=<?php echo $val['purchase_id']; ?>" target="_blank">采购单</a>]　[<a href="?mod=purchase.printZC_alls&supplierId=<?php echo $val['supplier_id']; ?>&purchase_list_Id=<?php echo $val['purchase_id']; ?>" target="_blank">支出单</a>]　[<a href="?mod=purchase.pay_excel&supplierId=<?php echo $val['supplier_id']; ?>&purchase_list_Id=<?php echo $val['purchase_id']; ?>" target="_blank">对帐单</a>]</td>
			</tr>



<?php
}
}
?>
		</tbody>
	</table>




</div>



</form>

<script language="JavaScript">
function DSD(){
window.location='<?php echo $url; ?>&supplierId='+$("#supplier_id").val();
	
}

$(document).ready(function(){
	$('a[ctype=expand]').click(function(){
		$(this).parents('td').eq(0).find('dl').toggle();
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