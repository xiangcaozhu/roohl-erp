<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-12-19 01:52:44
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3>新建常规采购</h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="if($('#Supplier_id').val()==0){alert('请先选择供货商！')}else{$('#main_form').submit();}" style=""><span>下一步</span></button>
	</div>
</div>

<form method="get" id="main_form" onsubmit="return false;">
<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
<div class="HY-form-table" id="base_tab">
	<div class="HY-form-table-header">
		选择供货商
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>供货商dd</label></td>
					<td class="value">
<var id="supplierSID_var"  class="MSearch_box" init="0" py="1" style="float:left;height:24px;border:#000000 1px solid; text-align:left;background:#FFFFFF url(image/Ajax.radio.png) no-repeat right 4px;" MSname="">
<select style="display:none" name="supplier" id="supplier">
<option value="0" >供货商</option>
<?php
if ( $Supplier_list )
{
foreach ( $Supplier_list as $val )
{
?>
<option op="<?php echo $val['name_op']; ?>" value="<?php echo $val['id']; ?>"><?php echo $val['name']; ?></option>
<?php
}
}
?>
</select>
</var>

					</td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>


</form>
    <script type="text/javascript" src='script/search.js'></script>