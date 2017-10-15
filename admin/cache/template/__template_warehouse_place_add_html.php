<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-05-16 17:07:33
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>

<div class="HY-content-header clearfix">
	<h3>新建货位</h3>
	<p class="right">
		<button type="button" class="scalable save" onclick="$('form').submit();"><span>保存数据</span></button>
	</p>
</div>

<form method="post" enctype="multipart/form-data">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		新建货位
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>货位名称<span class="required">*</span></label></td>
					<td class="value">
						<input name="name" id="name" value="" class="input-text" type="text" style="width:150px;"/>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>别名<span class="required">*</span></label></td>
					<td class="value">
						<input name="nick_name" id="nick_name" value="" class="input-text" type="text" style="width:150px;"/> (如：手机；质检货位；销退货位...)
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>所在库房<span class="required"></span></label></td>
					<td class="value">
						<select name="warehouse_id">
							<?php
if ( $list )
{
foreach ( $list as $info )
{
?>
							<option value="<?php echo $info['id']; ?>"><?php echo $info['name']; ?></option>
							<?php
}
}
?>
						</select>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>不参与出库<span class="required"></span></label></td>
					<td class="value">
						<input type="radio" name="no_delivery" value="1">是
						<input type="radio" name="no_delivery" value="0" checked>否
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>