<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-05 09:16:59
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>

<div class="HY-content-header clearfix">
	<h3>订单批量到款</h3>
	<p class="right">
		<button type="button" class="scalable save" onclick="$('form').submit();"><span>提交数据</span></button>
	</p>
</div>

<form method="post" enctype="multipart/form-data" <?php
if ( $check )
{
?>action="?mod=order.check.check_f"<?php
}
?>>
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		订单批量到款
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>导入类型<span class="required">*</span></label></td>
					<td class="value">
						<select name="channel_parent_id">
							<?php
if ( $channel_parent_list )
{
foreach ( $channel_parent_list as $val )
{
?>
							<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $_POST['channel_parent_id'] )
{
?>selected<?php
}
?>><?php echo $val['name']; ?></option>
							<?php
}
}
?>
						</select>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>文件<span class="required">*</span></label></td>
					<td class="value"><input name="file" id="file" value="" class="input-text" type="file"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>