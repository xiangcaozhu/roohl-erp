<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-08-01 14:03:55
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>

<div class="HY-content-header clearfix">
	<?php
if ( $check )
{
?>
	<h3>待处理文件检查</h3>
	<?php
}
else
{
?>
	<h3>导入订单</h3>
	<?php
}
?>
	<p class="right">
		<button type="button" class="scalable save" onclick="$('form').submit();"><span>提交数据</span></button>
	</p>
</div>

<form method="post" enctype="multipart/form-data" <?php
if ( $check )
{
?>action="?mod=order.importcheck"<?php
}
?>>
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		<?php
if ( $check )
{
?>
		待处理文件检查
		<?php
}
else
{
?>
		导入订单
		<?php
}
?>
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>导入类型<span class="required">*</span></label></td>
					<td class="value">
						<select name="channel_parent_id">
						<option value="0">选择银行</option>
							<?php
if ( $channel_parent_list )
{
foreach ( $channel_parent_list as $val )
{
?>
							<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $_GET['channel_parent_id'] )
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