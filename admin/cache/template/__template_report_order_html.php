<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-08 15:29:54
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">订单统计查询</h3>
</div>


<form method="POST" id="main_form">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		订单统计查询
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>开始日期<span class="required"></span></label></td>
					<td class="value">
						<input name="begin_date" id="begin_date" value="" class="input-text" type="text" style="width:150px;"/> <img src="image/grid-cal.gif" id="begin_date_btn" align="absmiddle"/>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>结束日期<span class="required"></span></label></td>
					<td class="value">
						<input name="end_date" id="end_date" value="" class="input-text" type="text" style="width:150px;"/> <img src="image/grid-cal.gif" id="end_date_btn" align="absmiddle"/>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"> </label></td>
					<td class="value">
						<button type="button" onclick="$('#main_form').submit();">确定查询</button>
					</td>
					<td><small>&nbsp;</small></td>
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
