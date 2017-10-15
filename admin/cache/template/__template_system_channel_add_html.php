<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-02-05 14:45:43
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>

<div class="HY-content-header clearfix">
	<h3>添加渠道</h3>
	<p class="right">
		<button type="button" class="scalable save" onclick="$('form').submit();"><span>保存数据</span></button>
	</p>
</div>

<form method="post" enctype="multipart/form-data">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		添加渠道
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>渠道名称<span class="required">*</span></label></td>
					<td class="value"><input name="name" id="name" value="" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>