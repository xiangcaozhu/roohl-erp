<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-11-28 11:05:57
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>

<div class="HY-content-header clearfix">
	<h3>添加供应商</h3>
	<p class="right">
		<button type="button" class="scalable save" onclick="$('form').submit();"><span>保存数据</span></button>
	</p>
</div>

<form method="post" enctype="multipart/form-data">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		添加供应商
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>供应商名称<span class="required">*</span></label></td>
					<td class="value"><input name="name" id="name" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>运营产品<span class="required"></span></label></td>
					<td class="value"><input name="y_product" id="y_product" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>联系人<span class="required"></span></label></td>
					<td class="value"><input name="linkman" id="linkman" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>电话<span class="required"></span></label></td>
					<td class="value"><input name="phone" id="phone" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>公司地址<span class="required"></span></label></td>
					<td class="value"><input name="company_address" id="company_address" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>公司电话<span class="required"></span></label></td>
					<td class="value"><input name="company_phone" id="company_phone" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>公司法人<span class="required"></span></label></td>
					<td class="value"><input name="company_person" id="company_person" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>公司性质<span class="required"></span></label></td>
					<td class="value"><input name="company_nature" id="company_nature" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>注册资本<span class="required"></span></label></td>
					<td class="value"><input name="registered_capital" id="registered_capital" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>税号<span class="required"></span></label></td>
					<td class="value"><input name="tax" id="tax" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>账号<span class="required"></span></label></td>
					<td class="value"><input name="account_number" id="account_number" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>开户行<span class="required"></span></label></td>
					<td class="value"><input name="accountbank" id="accountbank" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr style="display:none">
					<td class="label"><label>开户账号<span class="required"></span></label></td>
					<td class="value"><input name="opennumber" id="opennumber" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>备注<span class="required"></span></label></td>
					<td class="value"><input name="comment" id="comment" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>