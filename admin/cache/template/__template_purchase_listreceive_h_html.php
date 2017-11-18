<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2017-11-18 00:18:35
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
<div style="margin:0px auto;width:1220px; padding:0px;">
<ul style="float:left;width:950px;">
<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
<dl style="float:left;width:928px;margin:0px;padding:10px;margin-bottom:20px;border:#999999 1px solid; background:<?php echo $val['Error_This']; ?>;">
<dt style="float:left;width:740px;">
<div style="float:left;width:740px; padding-bottom:5px;border-bottom:#999999 1px solid;">
<span style="float:left;">采购单号：<?php
if ( $U_ID == 68 )
{
?><a target="_blank" href="?mod=purchase.E_CGD&id=<?php echo $val['id']; ?>"><?php echo $val['id']; ?></a><?php
}
else
{
?><b><font color="#0066CC"><?php echo $val['id']; ?></font></b><?php
}
?>　　下单日期：<b><font color="#0066CC"><?php echo $val['add_time']; ?></font></b>&nbsp;&nbsp;[<?php echo $val['ReceiveOrderTotal']; ?>/<?php echo $val['PurchaseOrderTotal']; ?>]</span>
<span style="float:right;"><a href="?mod=purchase.print&id=<?php echo $val['id']; ?>" target="_blank">采购单</a>　
<?php
if ( $val['type'] == 2 )
{
?><a href="?mod=purchase.printZC&id=<?php echo $val['id']; ?>" target="_blank">支出单</a>　<a href="?mod=purchase.printWL&id=<?php echo $val['id']; ?>" target="_blank">发货单</a>　<a href="?mod=purchase.printWL_excel&id=<?php echo $val['id']; ?>&name=<?php echo $val['supplier_name']; ?>" target="_blank">导出发货单</a><?php
}
else
{
?>　　　<?php
}
?></span>
</div>
<div style="float:left;width:740px; padding-top:7px; padding-bottom:5px;">
<span style="float:left;">制单人员:<b><font color="#0066CC"><?php echo $val['user_name_zh']; ?><?php echo $val['user_me']; ?></font></b>　　付款方式：<b><font color="#0066CC"><?php echo $val['payment_type_name']; ?></font></b></span>
<span style="float:right;">供货商：<b><font color="#0066CC"><?php echo $val['supplier_name']; ?></font></b></span>
</div>
<div style="float:left;width:740px; padding-bottom:10px; padding-top:5px;">

<table width="740" border="0" cellpadding="0" cellspacing="1" bgcolor="#999999">
<tr style=" background:url(image/sort_row_bg.gif) repeat-x left top;line-height:25px; font-weight:bold;">
<th width="180">
<table cellspacing="0" width="180" >
<tr>
<th width="80"><div align="center">销售渠道</div></th>
<th width="30"><div align="center">数量</div></th>
<th width="70"><div align="center">售价</div></th>
</tr>
</table>
</th>
<th width="" ><div align="left">&nbsp;名称</div></th>
<th width="40"><div align="center">数量</div></th>
<th width="70"><div align="center">采购单价</div></th>
<th width="70"><div align="center">代发运费</div></th>
<th width="70"><div align="center">合计/元</div></th>
</tr>

<?php
if ( $val['productList'] )
{
foreach ( $val['productList'] as $row )
{
?>
<tr>
<td align="center" bgcolor="#FFFFFF">

<?php
if ( $row['relation_list'] )
{
?>
						<table cellspacing="0" width="180" >
								<?php
if ( $row['relation_list'] )
{
foreach ( $row['relation_list'] as $rows )
{
?>
								<tr>
									<td align="center" valign="middle"  width="80" height="22" style="padding-top:3px;"><?php echo $rows['channel_name']; ?></td>
									<td align="center" width="30" height="22" style="padding-top:3px;"><?php echo $rows['total_quantity']; ?></td>
									<td align="center" width="70" height="22" style="padding-top:3px;">
									<?php
if ( $rows['channel_id'] == 75 || $rows['channel_id'] == 73 )
{
?>
									<?php
if ( $rows['channel_id'] == 751 )
{
?>
									<?php echo FormatMoney($rows['bj_price']/$rows['total_quantity']); ?>
									<?php
}
else
{
?>
									<?php echo FormatMoney($rows['xs_price']); ?>
									<?php
}
?>
									<?php
}
else
{
?>
									<?php echo FormatMoney($rows['xs_price']); ?>
									<?php
}
?>
									</td>
								</tr>
								<?php
}
}
?>
						</table>
<?php
}
?>


</td>
			<td bgcolor="#FFFFFF" style="padding:5px;line-height:1.3;" title="商品ID:<?php echo $row['product_id']; ?>　商品SKU：<?php echo $row['sku']; ?>"><?php echo $row['sku_info']['product']['name']; ?>
			<?php
if ( $row['sku_info']['attribute'] )
{
?>　<font color="#CC0000"><?php echo $row['sku_info']['attribute']; ?></font><?php
}
?>
			</td>
			<td align="center" bgcolor="#FFFFFF">
				<?php echo $row['quantity']; ?>&nbsp;			</td>
			<td align="center" bgcolor="#FFFFFF">
				&yen;<?php echo $row['price']; ?>			</td>
			<td align="center" bgcolor="#FFFFFF">
				&yen;<?php echo $row['help_cost']; ?>			</td>
			<td align="center" bgcolor="#FFFFFF">
				&yen;<?php echo FormatMoney($row['all_money']); ?>			</td>
		</tr>
<?php
}
}
?>
		<tr>
			<td colspan="6" align="right" bgcolor="#FFFFFF" style="padding:5px;"><b>合计：￥<?php echo $val['all_money']; ?></b></td>
		</tr>
		<?php
if ( $row['comment'] )
{
?>
		<tr>
		  <td colspan="6" bgcolor="#FFFFFF" style="padding:5px;" align="left">
		  备注：<?php echo $row['comment']; ?>
		  </td>
		</tr>
		<?php
}
?>
	</tbody>
</table>
</div>


</dt>		
				
<dd style="float:right;margin:0px;width:160px;padding-left:10px;border-left:#999999 1px solid;">
<div style="float:left; padding:5px 10px;width:140px;border:#999999 1px dashed; background:#F1F1F1;">
发货状态：<b><?php echo $val['receive_status_name']; ?></b>
</div>

<?php
if ( $val['orderList'] )
{
foreach ( $val['orderList'] as $rowp )
{
?>
<div style="float:left; padding:5px 10px;width:140px;border:#999999 1px dashed; background:#F1F1F1;margin-top:10px;">
订单：<a href="?mod=order.list_all&id=<?php echo $rowp['id']; ?>" target="_blank"><?php echo $rowp['id']; ?></a> → <?php
if ( $rowp['logistics_sn'] )
{
?><font color="#006600">已发货</font><?php
}
else
{
?><font color="#990033">未发货</font><?php
}
?>
</div>
<?php
}
}
?>
								
								

</dd>
</dl>
<?php
}
}
?>
</ul>
<ul style=" position:fixed;top:85px;left:280px;width:250px;margin:0px; padding:0px;" class="xiao_1">
<span style="float:left;width:228px;border:#D8D8D8 1px solid; background:#FFFFFF;padding:10px;">
<div style="float:left;">总共 <b><?php echo $total; ?></b> 条，每页 <b><?php echo $onePage; ?></b> 条。</div>
<?php
if ( $page_num > 1 )
{
?><div style="float:left;width:228px; padding:10px 0px 0px 0px;"><?php echo $page_bar_b; ?></div><?php
}
?>
</span>
<form method="get" id="search_form" name="search_form">
<span style="float:left;margin-top:10px;width:228px;border:#D8D8D8 1px solid; background:#FFFFFF;padding:10px;">
<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
<div style="float:left;width:228px;height:25px;">
采购单号：<input style="width:60px;" type="text" name="id" id="id" value="<?php echo $_GET['id']; ?>"><input type="hidden" name="excel" id="excel" value="0">
</div>
<div style="float:left;width:228px;height:25px;">
　订单号：<input style="width:60px;" type="text" name="order_id" id="order_id" value="<?php echo $_GET['order_id']; ?>">
</div>
<div style="float:left;width:228px;height:25px; display:none;">
<select name="suppSSlier_id" style="widtSSh:225px">
<option value="">供货商</option>
<?php
if ( $Supplier_list )
{
foreach ( $Supplier_list as $val )
{
?>
<option  <?php
if ( $val['id'] == $_GET['supplier_id'] )
{
?>selected<?php
}
?>  value="<?php echo $val['id']; ?>"><?php echo $val['op']; ?> - <?php echo $val['name']; ?></option>
<?php
}
}
?>
</select>
</div>

<var id="supplierSID_var"  class="MSearch_box" init="0" py="1" style="float:right;width:228px;height:24px;border:#000000 1px solid; text-align:left;background:#FFFFFF url(image/Ajax.radio.png) no-repeat right 4px;" MSname="">
<select style="display:none" name="supplier_id" id="supplier_id">
<option value="0" <?php
if ( 0 == $_GET['supplier_id'] )
{
?>selected<?php
}
?> >供货商</option>
<?php
if ( $Supplier_list )
{
foreach ( $Supplier_list as $supplier )
{
?>
<option op="<?php echo $supplier['name_op']; ?>" <?php
if ( $supplier['id'] == $_GET['supplier_id'] )
{
?>selected<?php
}
?> value="<?php echo $supplier['id']; ?>"><?php echo $supplier['name']; ?></option>
<?php
}
}
?>
</select>
</var>


</span>
<span style="float:left;margin-top:10px;width:228px;border:#D8D8D8 1px solid; background:#FFFFFF;padding:10px;">
<dl style="float:left;width:228px;margin:0px;padding:0px;">
<dt style="float:left;width:228px;height:25px;margin:0px;padding:0px;">下单日期</dt>
<dd style="float:left;width:94px;height:22px;margin:0px;padding:0px; position:relative;">
<input style="width:76px;" type="text" name="begin_date" id="begin_date" value="<?php echo $_GET['begin_date']; ?>">
<img src="image/grid-cal.gif" width="18" height="18" id="begin_date_btn" style="position:absolute;top:2px;right:0px;" />
</dd>
<dd style="float:left;width:30px;height:22px;margin:0px;padding:0px; text-align:right;line-height:25px; font-size:20px; position:relative;">=></dd>
<dd style="float:right;width:94px;height:22px;margin:0px;padding:0px; position:relative;">
<input style="width:76px;" type="text" name="end_date" id="end_date" value="<?php echo $_GET['end_date']; ?>">
<img src="image/grid-cal.gif" width="18" height="18" id="end_date_btn" style="position:absolute;top:2px;right:0px;" />
</dd>
</dl>
</span>



<span style="float:left;margin-top:10px;width:228px;border:#D8D8D8 1px solid; background:#FFFFFF;padding:10px;">
<div style="float:left;width:114px;height:22px;">
<select name="receive_status" style="width:93px">
<option value="">发货状态</option>
<option value="1"  <?php
if ( $_GET['receive_status'] == 1 && $_GET['receive_status'] != '' )
{
?>selected<?php
}
?> >　未发货</option>
<option value="2"  <?php
if ( $_GET['receive_status'] == 2 && $_GET['receive_status'] != '' )
{
?>selected<?php
}
?> >　部分发货</option>
<option value="3"  <?php
if ( $_GET['receive_status'] == 3 && $_GET['receive_status'] != '' )
{
?>selected<?php
}
?> >　全部发货</option>
</select>
</div>
<div style="float:right;width:105px;height:22px;">
<select name="status" style="width:93px">
<option value="">采购单状态</option>
<option value="3" <?php
if ( 3 == $_GET['status'] && $_GET['status'] != '' )
{
?>selected<?php
}
?>>　发货中</option>
<option value="5" <?php
if ( 5 == $_GET['status'] && $_GET['status'] != '' )
{
?>selected<?php
}
?>>　已完成</option>
</select>
</div>
</span>

<span style="float:left;margin-top:10px;width:228px;border:#D8D8D8 1px solid; background:#FFFFFF;padding:10px;">
<?php
if ( $total < 200 )
{
?>
<button style="float:left;" type="button" onclick="$('#excel').val(1);$('#search_form').submit();$('#excel').val(0);">导出</button>
<?php
}
?>
<button  style="float:right;" type="button" onclick="$('#search_form').submit();">筛选订单</button>
</span>
</form>
</ul>
</div>
<script type="text/javascript">

var cal = new Zapatec.Calendar.setup({
	inputField     :    "begin_date",     // id of the input field
	ifFormat       :    "%Y-%m-%d",     // format of the input field
	showsTime      :     false,
	button         :    "begin_date_btn",  // trigger button (well, IMG in our case)
	weekNumbers    :    false,  // allows user to change first day of week
	firstDay       :    1, // first day of week will be Monday
	align          :    "Bl"           // alignment (defaults to "Bl")
});

var cal = new Zapatec.Calendar.setup({
	inputField     :    "end_date",     // id of the input field
	ifFormat       :    "%Y-%m-%d",     // format of the input field
	showsTime      :     false,
	button         :    "end_date_btn",  // trigger button (well, IMG in our case)
	weekNumbers    :    false,  // allows user to change first day of week
	firstDay       :    1, // first day of week will be Monday
	align          :    "Bl"           // alignment (defaults to "Bl")
});









</script>
<script type="text/javascript" src='script/search.js'></script>