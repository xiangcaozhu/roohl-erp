<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-09-03 11:53:08
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<?php
if ( $buy_attribute_list )
{
foreach ( $buy_attribute_list as $attribute )
{
?>

<div name="buy_attr" attr_id="<?php echo $attribute['id']; ?>" >
	<div class="HY-grid-title">
		<div class="HY-grid-title-inner">
			<b name="attr_name"><?php echo $attribute['name']; ?></b>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="EditProductAttribute(this);">编辑</a>
			<?php
if ( $is_template )
{
?>
			<a href="javascript:void(0);" onclick="RemoveProductAttribute(this)"><b>移除属性</b></a>
			<?php
}
?>
			<a style="float:right;" href="javascript:void(0);" onclick="AddProductAttributeValue(this);">添加选项</a>
		</div>
	</div>
	<div class="HY-grid" name="table_box">
	<table cellspacing="0">
					<thead>
						<tr class="header">
							<th>名称</th>
							<th width="40">&nbsp;</th>
						</tr>
					</thead>
					<tbody name="value_box">
						<?php
if ( $attribute['value_list'] )
{
foreach ( $attribute['value_list'] as $value )
{
?>
						<tr name="value_row" class="value-row" attr_val_id="<?php echo $value['id']; ?>">
							<td><span name="value_name"><?php echo $value['name']; ?></span>&nbsp;<span name="value_service"><?php echo $value['service_name']; ?></span></td>
							<td align="center">
								<a href="javascript:void(0);" onclick="EditProductAttributeValueTextblock(this)">修改</a> 
								<?php
if ( $is_template )
{
?>
								<a href="javascript:void(0);" onclick="RemoveProductAttributeValueTextblock(this)">移除</a>
								<?php
}
?>
								<input type="hidden" name="buy_attr_val[<?php echo $attribute['id']; ?>][<?php echo $value['id']; ?>][name]" vname="name" value="<?php echo $value['name']; ?>">
								<input type="hidden" name="buy_attr_val[<?php echo $attribute['id']; ?>][<?php echo $value['id']; ?>][about]" vname="about" value="<?php echo $value['about_disabled']; ?>">
								<input type="hidden" name="buy_attr_val[<?php echo $attribute['id']; ?>][<?php echo $value['id']; ?>][append_price]" vname="append_price" value="<?php echo $value['append_price']; ?>">
								<input type="hidden" name="buy_attr_val[<?php echo $attribute['id']; ?>][<?php echo $value['id']; ?>][hidden]" vname="hidden" value="<?php echo $value['hidden']; ?>">
								<input type="hidden" name="buy_attr_val[<?php echo $attribute['id']; ?>][<?php echo $value['id']; ?>][service]" vname="service" value="<?php echo $value['service']; ?>">
							</td>
						</tr>
						<?php
}
}
?>
					</tbody>
				</table>
</div>				
	<div class="attribute-editbox clearfix" style="display:none">
		<div class="attribute-editbox-left" style="display:none">
			<div class="attribute-editbox-title">基本信息ertert</div>
			<table>
				<tr>
					<td class="label">属性名称:</td>
					<td><span name="attr_name"><?php echo $attribute['name']; ?></span></td>
				</tr>
				<tr>
					<td class="label">类型:</td>
					<td name="attr_type_view">
						<?php
if ( $attribute['type'] == 'text' )
{
?>文本框
						<?php
}
elseif ( $attribute['type'] == 'color' )
{
?>颜色
						<?php
}
elseif ( $attribute['type'] == 'image' )
{
?>图片
						<?php
}
elseif ( $attribute['type'] == 'select' )
{
?>下拉菜单
						<?php
}
elseif ( $attribute['type'] == 'textblock' )
{
?>文本选择块
						<?php
}
elseif ( $attribute['type'] == 'textgroup' )
{
?>文本输入组
						<?php
}
?>
					</td>
				<tr>
				<tr>
					<td class="label">必须:</td>
					<td><span name="attr_required"><?php
if ( $attribute['required'] == 1 )
{
?><font color="red">是</font><?php
}
else
{
?>否<?php
}
?></span></td>
				</tr>
				<tr>
					<td class="label"></td>
					<td align="right"></td>
				</tr>
			</table>
			
			<input type="hidden" name="buy_attr[<?php echo $attribute['id']; ?>][name]" value="<?php echo $attribute['name']; ?>" aname="name">
			<input type="hidden" name="buy_attr[<?php echo $attribute['id']; ?>][type]" aname="type" value="<?php echo $attribute['type']; ?>">
			<input type="hidden" name="buy_attr[<?php echo $attribute['id']; ?>][order]" aname="order" value="<?php echo $attribute['order_id']; ?>">
			<input type="hidden" name="buy_attr[<?php echo $attribute['id']; ?>][length]" aname="length" value="<?php echo $attribute['length']; ?>">
			<input type="hidden" name="buy_attr[<?php echo $attribute['id']; ?>][append_price]" aname="append_price" value="<?php echo $attribute['append_price']; ?>">
			<input type="hidden" name="buy_attr[<?php echo $attribute['id']; ?>][hidden]" aname="hidden" value="<?php echo $attribute['hidden']; ?>">
			<input type="hidden" name="buy_attr[<?php echo $attribute['id']; ?>][required]" aname="required" value="<?php echo $attribute['required']; ?>">
			<input type="hidden" name="buy_attr[<?php echo $attribute['id']; ?>][switch]" aname="switch" value="<?php echo $attribute['switch']; ?>">
			<input type="hidden" name="buy_attr[<?php echo $attribute['id']; ?>][switch_title]" aname="switch_title" value="<?php echo $attribute['switch_title']; ?>">
			<input type="hidden" name="buy_attr[<?php echo $attribute['id']; ?>][disable]" aname="disable" value="<?php echo $attribute['disable']; ?>">
			<input type="hidden" name="buy_attr[<?php echo $attribute['id']; ?>][description]" aname="description" value="<?php echo $attribute['description']; ?>">
		</div>
		<div class="attribute-editbox-right">
			<div class="attribute-editbox-title" style="display:none">项目列表 <span name="attr_item_add_view"><?php
if ( $attribute['type'] != 'text' )
{
?><a href="javascript:void(0);" onclick="AddProductAttributeValue(this);">添加选项</a><?php
}
?></span></div>
			<div class="HY-grid" name="table_box">

			</div>
		</div>
	</div>
</div>

<?php
}
}
?>