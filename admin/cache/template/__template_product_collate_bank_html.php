<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-12-23 13:59:00
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<link href="css/cal/zpcal.css" rel="stylesheet" type="text/css">
<link href="css/cal/template.css" rel="stylesheet" type="text/css">
<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>

<style type="text/css">
<!--
.STYLE1 {color: #CC0000}
-->
</style>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">渠道销售表 </h3>
	<button style="float:right;" type="button" onclick="$('#excel').val(1);$('#search_form').submit();$('#excel').val(0);">导出</button>
	
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		分页:<?php echo $page_bar; ?> 每页20条记录 总共<?php echo $total; ?>条记录 <?php echo $page; ?>/<?php echo $page_num; ?>
	</div>
</div>
<div style="float:right;width:1000px;">

<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
<dl style="float:left;width:210px; padding:14px;border:#D8D8D8 1px solid;margin-left:10px;margin-top:10px; background:#FFFFFF;">
<dd style="float:left;width:210px;border-bottom:#D8D8D8 1px solid; padding-bottom:10px;">
ID:<?php echo $val['id']; ?><a style="float:right;" href="?mod=product.collate.edit&id=<?php echo $val['id']; ?>">修改</a>
</dd>
<dt style="float:left;width:210px;"><a href="<?php echo $val['bank_link']; ?>" target="_blank"><img src="../GoodImg/<?php echo $val['sku_info']['product']['id']; ?>.jpg" width="210" height="210" /></a></dt>
<dd style="float:left;width:210px;border-top:#D8D8D8 1px solid;height:90px; padding-top:10px;">
<?php echo $val['channel_name']; ?> → <?php echo $val['target_id']; ?><br />
<font color="#339966"><?php echo $val['bank_name']; ?></font><br />
价格：<b><font color="#FF0000"><?php echo $val['one_money']; ?></font></b>
</dd>
<dd style="float:left;width:210px;border-top:#D8D8D8 1px solid;height:90px; padding-top:10px;">
<?php echo $val['supplier_name']; ?><br />
<b>ID:</b><?php echo $val['sku_info']['product']['id']; ?> → <b>SKU:</b><?php echo $val['sku']; ?><br />
<font color="#339966"><?php echo $val['sku_info']['product']['name']; ?></font>
<?php
if ( $val['sku_info']['attribute'] )
{
?>
<font color="#FF0000"><br /><b>购买属性：</b><?php echo $val['sku_info']['attribute']; ?></font>	
<?php
}
?>
</dd>
</dl>
			<?php
}
}
?>
		</tbody>
	</table>
</div>