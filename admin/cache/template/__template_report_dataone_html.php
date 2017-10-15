<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-10-09 19:12:01
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule" style="float:left;">每日渠道销售明细</h3>
  <div style="float:right; ">
   <span style="float:right;width:180px;"><input name="report_date" id="report_date" value="<?php echo $_GET['datanow']; ?>" type="text" onclick="SelectDate(this)" style="width:0px;height:0px; display:block;margin-right:170px;"/></span> <span style="float:right;">[<?php echo $beginTime_s; ?>]　-　[<?php echo $endTime_s; ?>]　　　</span>
  </div>
</div>



<h4 style="padding-bottom:10px;"><span id="thisdata"></span>&nbsp;&nbsp;总销售额：<?php echo $day_total_price; ?></h4>

<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
				<td colspan="5" align="left" >&nbsp;渠道：<?php echo $val['channel_name']; ?>　　总销售额：<?php echo $val['total_price']; ?></td>
			</tr>
		</thead>
<?php
if ( $val['total_price'] > 0 )
{
?>
		<tbody>
			<tr>
				<td width="30" align="center" bgcolor="#FFFFFF">ID</td>
				<td width="40" align="center" bgcolor="#FFFFFF"><div align="center">数量</div></td>
				<td width="80" align="center" bgcolor="#FFFFFF"><div align="center">合计</div></td>
				<td align="left" bgcolor="#FFFFFF"><div align="left">商品名称</div></td>
				<td width="170" bgcolor="#FFFFFF"></td>
			</tr>
		</tbody>
<?php
}
?>
		<tbody>
			<?php
if ( $val['product_data'] )
{
foreach ( $val['product_data'] as $product )
{
?>
			<tr>
				<td align="center"><?php echo $product['get_pid']; ?></td>
				<td align="center"><?php echo $product['total_quantity']; ?></td>
				<td align="center"><?php
if ( $product['total_price'] > 0 )
{
?><?php echo FormatMoney($product['total_price']); ?><?php
}
else
{
?>赠品<?php
}
?></td>
				<td align="left"><?php echo $product['p_name']; ?></td>
				<td align="center"></td>
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>
<?php
}
}
?>


<iframe src="" name="HtmlDoFormA" id="HtmlDoFormA" style="float:right;width:900px;height:600px;display:;"></iframe>


<script type="text/javascript" src="script/newcr.js"></script>
<script language="JavaScript">

Date.prototype.Koodformat = function(style){ 
var o = {
    "M+" : this.getMonth() + 1, //month
    "d+" : this.getDate(),      //day
    "h+" : this.getHours(),     //hour
    "m+" : this.getMinutes(),   //minute
    "s+" : this.getSeconds(),   //second
    "w+" : "天一二三四五六".charAt(this.getDay()),   //week
    "q+" : Math.floor((this.getMonth() + 3) / 3), //quarter
    "S" : this.getMilliseconds() //millisecond
}
if(/(y+)/.test(style)){
    style = style.replace(RegExp.$1,
    (this.getFullYear() + "").substr(4 - RegExp.$1.length));
}
for(var k in o){
    if(new RegExp("("+ k +")").test(style)){
      style = style.replace(RegExp.$1,
        RegExp.$1.length == 1 ? o[k] :
        ("00" + o[k]).substr(("" + o[k]).length));
    }
}
//this.getFullYear()+"-"+this.getMonth()+"-"+this.getDate()
return style;
};


$(document).ready(function(){
	//$('#add-btn').click(function(){
	//	AddProductToRow();
//	});
	
	var today=new Date()
	lpday = today.Koodformat("yyyy-MM-dd")
	
	if($("#report_date").val()==""){$("#report_date").val(lpday)}
	$("#thisdata").text($("#report_date").val())
	$('#report_date').click();
	//SelectDate($("#report_date"))
	
});




</script>