<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-10 10:34:31
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>

<div class="HY-content-header clearfix">
	<h3>编辑管理员</h3>
	<p class="right">
		<button type="button" class="scalable save" onclick="$('form').submit();"><span>保存数据</span></button>
	</p>
</div>

<form method="post">
<div class="HY-form-table">
	<div class="HY-form-table-header">
		编辑管理员
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>用户名<span class="required">*</span></label></td>
					<td class="value"><?php echo $user['user_name']; ?></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>登录密码<span class="required">*</span></label></td>
					<td class="value"><input name="user_password" id="user_password" value="" class="input-text" type="password" style=""/></td>
					<td class="note">不更改请留空</td>
				</tr>
				<tr>
					<td class="label"><label>确认密码<span class="required">*</span></label></td>
					<td class="value"><input name="user_password_confirm" id="user_password_confirm" value="" class="input-text" type="password" style=""/></td>
					<td class="note">不更改请留空</td>
				</tr>
				<tr>
					<td class="label"><label>真实姓名<span class="required"></span></label></td>
					<td class="value"><input name="user_real_name" id="user_real_name" value="<?php echo $user['user_real_name']; ?>" class="input-text" type="text" style=""/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>管理组<span class="required"></span></label></td>
					<td class="value">
						<select name="user_group[]" style="width:300px;">
							<?php
if ( $group_list )
{
foreach ( $group_list as $group )
{
?>
							<option value="<?php echo $group['id']; ?>" <?php echo $group['selected']; ?>><?php echo $group['name']; ?></option>
							<?php
}
}
?>
						</select>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>上级产品经理<span class="required"></span></label></td>
					<td class="value">
						<select name="user_product_1" style="width:300px;">
						     <option value="0">不设置</option>
							<?php
if ( $jl_list )
{
foreach ( $jl_list as $jlgroup )
{
?>
							<option value="<?php echo $jlgroup['user_id']; ?>" <?php echo $jlgroup['selected']; ?>><?php echo $jlgroup['user_real_name']; ?>→<?php echo $jlgroup['user_real_name_1']; ?></option>
							<?php
}
}
?>
						</select>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>上级产品总监<span class="required"></span></label></td>
					<td class="value">
						<select name="user_product" style="width:300px;">
						     <option value="0">不是产品经理</option>
							<?php
if ( $zj_list )
{
foreach ( $zj_list as $zjgroup )
{
?>
							<option value="<?php echo $zjgroup['user_id']; ?>" <?php echo $zjgroup['selected']; ?>><?php echo $zjgroup['user_real_name']; ?></option>
							<?php
}
}
?>
						</select>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>