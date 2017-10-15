<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2014-01-13 17:17:37
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">产品销售毛利表 </h3>
</div>


<form method="POST" id="main_form">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td align="left" width="170">
						日期开始：<input name="begin_date" id="begin_date" value="<?php echo $_POST['begin_date']; ?>" class="input-text" type="text" style="width:70px;"/><img src="image/grid-cal.gif" id="begin_date_btn" align="absmiddle"/>
					</td>
					<td align="left" width="170">
						日期结束：<input name="end_date" id="end_date" value="<?php echo $_POST['end_date']; ?>" class="input-text" type="text" style="width:70px;"/><img src="image/grid-cal.gif" id="end_date_btn" align="absmiddle"/>
					</td>
					<td align="left" width="90">
						<select name="board">
							<option value="0">商品类型</option>
							<option value="1" <?php
if ( 1 == $_POST['board'] )
{
?>selected<?php
}
?>>　3C</option>
							<option value="2" <?php
if ( 2 == $_POST['board'] )
{
?>selected<?php
}
?>>　非3C</option>
						</select>
					</td>
					<td align="left" width="170">
						<select name="channel_id">
							<option value="0">销售渠道</option>
							<?php
if ( $channel_list )
{
foreach ( $channel_list as $val )
{
?>
							<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $_POST['channel_id'] )
{
?>selected<?php
}
?>>　<?php echo $val['name']; ?></option>
							<?php
}
}
?>
						</select>
					</td>
					<td align="left" width="110">
						<select name="warehouse_id">
							<option value="0">发货方式</option>
							<option value="5" <?php
if ( 5 == $_POST['warehouse_id'] )
{
?>selected<?php
}
?>>　★代发货</option>
							<option value="6" <?php
if ( 6 == $_POST['warehouse_id'] )
{
?>selected<?php
}
?>>　库房发货</option>
						</select>
					</td>
					<td align="left" width="300">
						<select name="supplier_id" style="width:280px;">
							<option value="0">供货商</option>
							<?php
if ( $Supplier_list )
{
foreach ( $Supplier_list as $val )
{
?>
							<option value="<?php echo $val['id']; ?>" <?php
if ( $_POST['supplier_id'] == $val['id'] )
{
?>selected<?php
}
?>>　<?php echo $val['op']; ?>　<?php echo $val['mini_name']; ?></option>
							<?php
}
}
?>
						</select>
					</td>					<td width="150" align="left">
						<button type="button" onclick="$('#excel').val(0);$('#main_form').submit();">确定查询</button>
					</td>
					<td><input type="hidden" name="excel" id="excel" value="0">
					<button type="button" onclick="$('#excel').val(1);$('#main_form').submit();">导出Excel</button></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>

<link href="css/cal/zpcal.css" rel="stylesheet" type="text/css">
<link href="css/cal/template.css" rel="stylesheet" type="text/css">
<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>

<script language="JavaScript">

$(document).ready(function(){
	$('#add-btn').click(function(){
		AddProductToRow();
	});
});




</script>


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


<div class="HY-grid">
<table cellspacing="0" class="data" id="grid_table">
<thead>
			<tr class="header">
				<td align="left" >
				<?php
if ( $channel_name )
{
?>
				渠道名称：<?php echo $channel_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php
}
?>
				<?php
if ( $supplier_name )
{
?>
				供货商：<?php echo $supplier_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php
}
?>
				<?php
if ( $board_name )
{
?>
				类型：<?php echo $board_name; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<?php
}
?>
				<?php echo $nowday; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
			</tr>
	</thead>
</table>
<table cellspacing="0" class="data" id="grid_table">
		<tbody>
			<tr>
				<?php
if ( $_POST['channel_id'] > 0 )
{
?><td width="70" align="center" bgcolor="#FFFFFF">银行编号</td><?php
}
?>
				<td width="30" align="center" bgcolor="#FFFFFF">ID</td>
				<td width="30" align="center" bgcolor="#FFFFFF">类型</td>
				<td align="left" bgcolor="#FFFFFF"><div align="left">商品名称</div></td>
				<?php
if ( $_POST['channel_id'] > 0 )
{
?><td width="50" align="center" bgcolor="#FFFFFF"><div align="center">单价</div></td><?php
}
?>
				<td width="30" align="center" bgcolor="#FFFFFF"><div align="center">采购</div></td>
				<td width="30" align="center" bgcolor="#FFFFFF"><div align="center">销售</div></td>
				<td width="80" align="center" bgcolor="#FFFFFF"><div align="center">总销售</div></td>
				<td width="80" align="center" bgcolor="#FFFFCC"><div align="center">总成本</div></td>
				<td width="60" align="center" bgcolor="#FFFFFF"><div align="center">总佣金</div></td>
				<td width="60" align="center" bgcolor="#FFFFFF"><div align="center">总运费</div></td>
				<td width="60" align="center" bgcolor="#FFFFFF"><div align="center">总税金</div></td>
				<td width="70" align="center" bgcolor="#FFFFFF"><div align="center">总运营费</div></td>
				<td width="80" bgcolor="#993366"><div align="center" style="color:#FFFFFF;">毛利润</div></td>
			</tr>
		</tbody>
			<tr style="color:#006600; font-weight:bold;" >
				<?php
if ( $_POST['channel_id'] > 0 )
{
?><td align="center" ></td><?php
}
?>
				<td align="center"></td>
				<td align="center"></td>
				<td align="center"></td>
				<?php
if ( $_POST['channel_id'] > 0 )
{
?><td align="center"></td><?php
}
?>
				<td align="center" ></td>
				<td align="center" ></td>
				<td align="center"><?php echo FormatMoney($M_1); ?></td>
				<td align="center" bgcolor="#FFFFCC"><?php echo FormatMoney($M_2); ?></td>
				<td align="center"><?php echo FormatMoney($M_3); ?></td>
				<td align="center"><?php echo FormatMoney($M_4); ?></td>
				<td align="center"><?php echo FormatMoney($M_5); ?></td>
				<td align="center"><?php echo FormatMoney($M_6); ?></td>
				<td width="70" bgcolor="#993366"><div align="center" style="color:#FFFFFF;"><?php echo FormatMoney($M_7); ?></div></td>
			</tr>

		<tbody>
			<?php
if ( $list['product_data'] )
{
foreach ( $list['product_data'] as $product )
{
?>
			<tr style="<?php
if ( $product['profit'] < 0 )
{
?>color:#FF0000;<?php
}
?>" >
			<?php
if ( $_POST['channel_id'] > 0 )
{
?><td align="center" style="<?php
if ( $product['quantity_error'] > 0 )
{
?>background:#666666;<?php
}
?>"><?php echo $product['targetId']; ?></td> <?php
}
?>
				<td align="center" style="<?php
if ( $product['quantity_error'] > 0 )
{
?>background:#666666;<?php
}
?>"><?php echo $product['id']; ?></td>
				<td align="center" style="<?php
if ( $product['quantity_error'] > 0 )
{
?>background:#666666;<?php
}
?>"><?php echo $product['board']; ?></td>
				<td align="left" style="<?php
if ( $product['quantity_error'] > 0 )
{
?>background:#666666;<?php
}
?>"><?php echo $product['nameing']; ?></td>
			<?php
if ( $_POST['channel_id'] > 0 )
{
?><td align="center"><?php echo FormatMoney($product['salePrice']); ?></td><?php
}
?>
				<td align="center" style="<?php
if ( $product['quantity_error'] > 0 )
{
?>background:#666666;<?php
}
?>"><?php echo $product['purchaseQuantity']; ?></td>
				<td align="center" style="<?php
if ( $product['quantity_error'] > 0 )
{
?>background:#666666;<?php
}
?>"><?php echo $product['saleQuantity']; ?></td>
				<td align="center" style="<?php
if ( $product['quantity_error'] > 0 )
{
?>background:#666666;<?php
}
?>"><?php echo $product['totalSalePrice']; ?></td>
				<td align="center" style="<?php
if ( $product['quantity_error'] > 0 )
{
?>background:#666666;<?php
}
else
{
?>background:#FFFFCC;<?php
}
?>"><?php echo FormatMoney($product['totalstockPrice']); ?></td>
				<td align="center" style="<?php
if ( $product['quantity_error'] > 0 )
{
?>background:#666666;<?php
}
?>"><?php echo FormatMoney($product['totalPayout']); ?></td>
				<td align="center" style="<?php
if ( $product['quantity_error'] > 0 )
{
?>background:#666666;<?php
}
?>"><?php echo FormatMoney($product['totalKdf']); ?></td>
				<td align="center" style="<?php
if ( $product['quantity_error'] > 0 )
{
?>background:#666666;<?php
}
?>"><?php echo FormatMoney($product['totalSj']); ?></td>
				<td align="center" style="<?php
if ( $product['quantity_error'] > 0 )
{
?>background:#666666;<?php
}
?>"><?php echo FormatMoney($product['totalYyf']); ?></td>
				<td width="70" bgcolor="#993366"><div align="center" style="color:#FFFFFF;"><b><?php echo FormatMoney($product['profit']); ?></b></div></td>
			</tr>
			<?php
}
}
?>
		</tbody>

	</table>
	</div>
