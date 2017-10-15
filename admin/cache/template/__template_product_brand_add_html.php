<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-16 08:11:22
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix">
	<h3>添加品牌</h3>
	<p class="right">
		<button type="button" class="scalable save" onclick="$('form').submit();"><span>保存数据</span></button>
	</p>
</div>

<form method="post" enctype="multipart/form-data">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		添加品牌
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>品牌名称<span class="required">*</span></label></td>
					<td class="value"><input name="name" id="name" value="" class="input-text" type="text" style=""/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>品牌Url<span class="required"></span></label></td>
					<td class="value"><input name="url" id="url" value="" class="input-text" type="text" style=""/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>品牌Logo<span class="required">*</span></label></td>
					<td class="value"><input name="logo" id="logo" value="" class="input-file" type="file" style=""/></td>
					<td class="note"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>