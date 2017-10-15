<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-11-26 15:48:36
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>



<div class="HY-content-header clearfix">
	<h3>修改供应商</h3>
	<p class="right">
		<button type="button" class="scalable save" onclick="$('form').submit();"><span>保存数据</span></button>
	</p>
</div>

<form method="post" enctype="multipart/form-data">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		修改供应商
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>
					<div align="right"><span class="required">*</span>供应商名称：</div>
					</label></td>
					<td class="value"><input name="name" id="name" value="<?php echo $name; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right"><span class="required">*</span>产品经理：</div>
					</label></td>
					<td class="value">
					<select name="manage_id">
					<option value="0">---</option>
						<?php
if ( $cp_list )
{
foreach ( $cp_list as $val )
{
?>
					<?php
if ( $group_man == 1 )
{
?>
						<option value="<?php echo $val['user_id']; ?>" <?php
if ( $manage_id == $val['user_id'] )
{
?>selected<?php
}
?>><?php echo $val['user_real_name']; ?></option>
					<?php
}
else
{
?>
					<?php
if ( $manage_id == $val['user_id'] )
{
?><option value="<?php echo $val['user_id']; ?>" selected ><?php echo $val['user_real_name']; ?></option><?php
}
?>
					<?php
}
?>
						<?php
}
}
?>
					</select>
				    </td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right"><span class="required">*</span>发货方式：</div>
					</label></td>
					<td class="value">
					<select name="key_mode">
					<option value="0" <?php
if ( 0 == $key_mode )
{
?>selected<?php
}
?> >代发货</option>
					<option value="1" <?php
if ( 1 == $key_mode )
{
?>selected<?php
}
?> >库房调货</option>
					</select>
				    </td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right">运营品牌：<span class="required"></span></div>
					</label></td>
					<td class="value">
<?php
if ( $brandList )
{
foreach ( $brandList as $val )
{
?>
<div style="float:left;width:120px;height:25px;">
<input <?php
if ( $val['selected'] == 1 )
{
?>checked="checked"<?php
}
?> name="y_product[]" type="checkbox" class="input-text" id="BL_<?php echo $val['id']; ?>" style="cursor:pointer;" value="<?php echo $val['id']; ?>"  />
<label style="cursor:pointer;" for="BL_<?php echo $val['id']; ?>"><?php echo $val['name']; ?></label>
</div>
<?php
}
}
?>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right">联系人：<span class="required"></span></div>
					</label></td>
					<td class="value"><input name="linkman" id="linkman" value="<?php echo $linkman; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right">电话：<span class="required"></span></div>
					</label></td>
					<td class="value"><input name="phone" id="phone" value="<?php echo $phone; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right">公司地址：<span class="required"></span></div>
					</label></td>
					<td class="value"><input name="company_address" id="company_address" value="<?php echo $company_address; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right">公司电话：<span class="required"></span></div>
					</label></td>
					<td class="value"><input name="company_phone" id="company_phone" value="<?php echo $company_phone; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right">公司法人：<span class="required"></span></div>
					</label></td>
					<td class="value"><input name="company_person" id="company_person" value="<?php echo $company_person; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right">公司性质：<span class="required"></span></div>
					</label></td>
					<td class="value"><input name="company_nature" id="company_nature" value="<?php echo $company_nature; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right">注册资本：<span class="required"></span></div>
					</label></td>
					<td class="value"><input name="registered_capital" id="registered_capital" value="<?php echo $registered_capital; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right">税号：<span class="required"></span></div>
					</label></td>
					<td class="value"><input name="tax" id="tax" value="<?php echo $tax; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right">开户行：<span class="required"></span></div>
					</label></td>
					<td class="value"><input name="accountbank" id="accountbank" value="<?php echo $accountbank; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right">账号：<span class="required"></span></div>
					</label></td>
					<td class="value"><input name="account_number" id="account_number" value="<?php echo $account_number; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr style="display:none">
					<td class="label"><label>
					<div align="right">开户账号：<span class="required"></span></div>
					</label></td>
					<td class="value"><input name="opennumber" id="opennumber" value="<?php echo $opennumber; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>
					<div align="right">备注：<span class="required"></span></div>
					</label></td>
					<td class="value"><input name="comment" id="comment" value="<?php echo $comment; ?>" class="input-text" type="text" style="width:400px;"/></td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>