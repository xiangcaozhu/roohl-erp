<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-08 01:30:22
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>

<div class="HY-content-header clearfix">
	<h3>导入产品信息</h3>
	<p class="right">
		<button type="button" class="scalable save" onclick="$('form').submit();"><span>提交数据</span></button>
	</p>
</div>

<form method="post" enctype="multipart/form-data" <?php
if ( $check )
{
?>action="?mod=product.import"<?php
}
?>>
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">导入产品信息</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<input type="hidden" name="id" value="1">
					<td class="label"><label>文件<span class="required">*</span></label></td>
					<td class="value"><input name="file" id="file" value="" class="input-text" type="file"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>