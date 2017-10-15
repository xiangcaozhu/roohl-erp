<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-16 08:18:13
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>



<div class="HY-content-header clearfix">
	<h3>编辑品牌</h3>
	<p class="right">
		<button type="button" class="scalable save" onclick="$('form').submit();"><span>保存数据</span></button>
	</p>
</div>

<form method="post" enctype="multipart/form-data">
<div class="HY-form-table">
	<div class="HY-form-table-header">
		编辑品牌
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>品牌名称<span class="required">*</span></label></td>
					<td class="value"><input name="name" id="name" value="<?php echo $brand['name']; ?>" class="input-text" type="text" style=""/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>品牌Url<span class="required"></span></label></td>
					<td class="value"><input name="url" id="url" value="<?php echo $brand['url']; ?>" class="input-text" type="text" style=""/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>品牌Logo<span class="required">*</span></label></td>
					<td class="value">
						<input name="logo" id="logo" value="" class="input-file" type="file" style=""/><br /><br />
						<img src="<?php echo $brand['img_url']; ?>" />
						<input type="hidden" name="redirect" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
					</td>
					<td class="note"></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>