<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-05-15 15:31:39
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>

<div class="HY-content-header clearfix">
	<h3>新建库房</h3>
	<p class="right">
		<button type="button" class="scalable save" onclick="$('form').submit();"><span>保存数据</span></button>
	</p>
</div>

<form method="post" enctype="multipart/form-data">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		新建库房
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>库房名称<span class="required">*</span></label></td>
					<td class="value"><input name="name" id="name" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>