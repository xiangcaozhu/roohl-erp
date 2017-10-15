<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-09-03 14:04:43
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<!-- template -->

<div id="tpl_add_attribute" style="display:none">
	<table width="100%">
		<tr>
			<td align="right" width="90">属性名称:</td>
			<td><input type="text" class="input-text" id="-_-attr_name" style="width:150px;" value="" /></td>
		</tr>
		<tr style="display:none">
			<td align="right">类型:</td>
			<td>
				<select id="-_-attr_type" style="width:100px;line-height:2em;">
					<!-- <option value="text">文本框</option>
					<option value="color">颜色</option>
					<option value="image">图片</option> -->
					<option value="textblock" selected="selected">文本选择块</option>
					<!-- <option value="select">下拉菜单</option>
					<option value="textgroup">文本输入组</option> -->
				</select>
			</td>
		</tr>
		<tr style="display:none">
			<td align="right">必须:</td>
			<td><input name="-_-attr_required" type="radio" id="-_-attr_required" value="1" checked="checked">
			<font color="red">是</font> <input type="radio" name="-_-attr_required" value="0" id="-_-attr_required">否</td>
		</tr>
	</table>
</div>


<div id="tpl_attribute_box" style="display:none">
	<div name="-_-buy_attr" attr_id="{0}">
		<div class="HY-grid-title">
			<div class="HY-grid-title-inner">
				<input type="hidden" name="buy_attr[{0}][name]" value="" aname="name">
				<input type="hidden" name="buy_attr[{0}][type]" aname="type" value="">
				<input type="hidden" name="buy_attr[{0}][order]" aname="order" value="">
				<input type="hidden" name="buy_attr[{0}][length]" aname="length" value="20">
				<input type="hidden" name="buy_attr[{0}][append_price]" aname="append_price" value="0.00">
				<input type="hidden" name="buy_attr[{0}][hidden]" aname="hidden" value="">
				<input type="hidden" name="buy_attr[{0}][required]" aname="required" value="">
				<input type="hidden" name="buy_attr[{0}][switch]" aname="switch" value="">
				<input type="hidden" name="buy_attr[{0}][switch_title]" aname="switch_title" value="">
				<input type="hidden" name="buy_attr[{0}][disable]" aname="disable" value="">
				<input type="hidden" name="buy_attr[{0}][description]" aname="description" value="">
				<b name="attr_name"></b>
				<a href="javascript:void(0);" onclick="RemoveProductAttribute(this)"><b>移除属性</b></a>
				<span style="float:right;" name="attr_item_add_view"></span>
			</div>
		</div>
			<div class="HY-grid" name="table_box"></div>

	</div>
</div>

<div id="tpl_edit_attribute" style="display:none">
	<table width="100%">
		<tr>
			<td align="right" width="90">属性名称:</td>
			<td><input type="text" class="input-text" id="-_-attr_name" style="width:150px;" value="" /></td>
		</tr>
		<tr style="display:none">
			<td align="right"> 必须:</td>
			<td><input type="radio" name="-_-attr_required" id="-_-attr_required" value="1"><font color="red">是</font> <input type="radio" name="-_-attr_required" value="0" id="-_-attr_required">否</td>
		</tr>
	</table>
</div>

<!-- 文本输入 -->

<div id="tpl_add_attribute_text" style="display:none">
	<table width="100%">
		<tr>
			<td align="right">长度:</td>
			<td><input type="text" class="input-text" id="-_-attr_length" style="width:100px;" value="{0}" /></td>
		</tr>
	</table>
</div>

<div id="tpl_attribute_text_box" style="display:none">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="140">长度</th>
				<th width="">&nbsp;</th>
			</tr>
		</thead>
		<tbody name="value_box">
			<tr>
				<td><span name="attr_length">20</span>&nbsp;</td>
				<td align="right"><a href="javascript:void(0);" onclick="AddProductAttributeValue(this);">修改</a></td>
			</tr>
		</tbody>
	</table>
</div>

<!-- 颜色选择 -->

<div id="tpl_add_attribute_color" style="display:none">
	<table width="100%">
		<tr>
			<td align="right">名称:</td>
			<td><input type="text" class="input-text" id="-_-attr_val_name" style="width:150px;" value="" /></td>
		</tr>
		<tr>
			<td align="right">颜色:</td>
			<td><input type="text" class="input-text" id="-_-attr_val_color" style="width:100px;" value="" /><button type="button" onclick="ColorPanel(this,$(this).prev()[0])">....</button></td>
		</tr>
	</table>
</div>

<div id="tpl_attribute_color_box" style="display:none">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="40">&nbsp;</th>
				<th width="140">名称</th>
				<th width="">&nbsp;</th>
			</tr>
		</thead>
		<tbody name="value_box">
		</tbody>
	</table>
</div>

<table id="tpl_attribute_value_color" style="display:none">
	<tr name="value_row" class="value-row" attr_val_id="{1}">
		<td><div class="select-block"></div></td>
		<td><span name="value_name"></span>&nbsp;</td>
		<td align="right">
			<a href="javascript:void(0);" onclick="EditProductAttributeValueColor(this)">修改</a>
			<a href="javascript:void(0);" onclick="RemoveProductAttributeValueColor(this)">移除</a>
			<input type="hidden" name="buy_attr_val[{0}][{1}][color]" vname="color" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][name]" vname="name" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][about]" vname="about" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][append_price]" vname="append_price" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][hidden]" vname="hidden" value="">
		</td>
	</tr>
</table>

<!-- 图片选择 -->

<div id="tpl_add_attribute_image" style="display:none">
	<table width="100%">
		<tr>
			<td align="right">名称:</td>
			<td><input type="text" class="input-text" id="-_-attr_val_name" style="width:150px;" value="" /></td>
		</tr>
		<tr>
			<td align="right">图片:</td>
			<td class="clearfix">
				<div style="float:left;height:20px;">
					<span id="-_-swfuploader_attribute_btn"></span>
				</div>
				<div id="-_-swfuploader_attribute_bar" style="height:20px;line-height:20px;float:left;display:none;">
					<span id="-_-swfuploader_attribute_file"></span>&nbsp;&nbsp;&nbsp;
					<img src="image/rule-ajax-loader.gif" align="absmiddle">上传中...
					<span style="font-size:11px;"><span id="-_-swfuploader_attribute_bar_per">0</span>%</span>
				</div>
				<div class="clear"></div>
				<span id="-_-attr_file_review"><img src="{1}" width="32" height="32" class="attribute-image" /></span>
			</td>
		</tr>
	</table>
</div>

<div id="tpl_attribute_image_box" style="display:none">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="40">&nbsp;</th>
				<th width="140">名称</th>
				<th width="">&nbsp;</th>
			</tr>
		</thead>
		<tbody name="value_box">
		</tbody>
	</table>
</div>

<table id="tpl_attribute_value_image" style="display:none">
	<tr name="value_row" class="value-row" attr_val_id="{1}">
		<td><img class="attribute-image" src="{2}" /></td>
		<td><span name="value_name">{3}</span>&nbsp;</td>
		<td align="right">
			<a href="javascript:void(0);" onclick="EditProductAttributeValueImage(this)">修改</a>
			<a href="javascript:void(0);" onclick="RemoveProductAttributeValueImage(this)">移除</a>
			<input type="hidden" name="buy_attr_val[{0}][{1}][name]" vname="name" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][ext]" vname="ext" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][file_url]" vname="file_url" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][file_name]" vname="file_name" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][about]" vname="about" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][append_price]" vname="append_price" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][hidden]" vname="hidden" value="">
		</td>
	</tr>
</table>

<!-- 下拉菜单 -->

<div id="tpl_add_attribute_select" style="display:none">
	<table width="100%">
		<tr>
			<td align="right">名称:</td>
			<td><input type="text" class="input-text" id="-_-attr_val_name" style="width:150px;" value="" /></td>
		</tr>
	</table>
</div>

<div id="tpl_attribute_select_box" style="display:none">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="140">名称</th>
				<th width="">&nbsp;</th>
			</tr>
		</thead>
		<tbody name="value_box">
		</tbody>
	</table>
</div>

<table id="tpl_attribute_value_select" style="display:none">
	<tr name="value_row" class="value-row" attr_val_id="{1}">
		<td><span name="value_name">{2}</span>&nbsp;</td>
		<td align="right">
			<a href="javascript:void(0);" onclick="EditProductAttributeValueSelect(this)">修改</a>
			<a href="javascript:void(0);" onclick="RemoveProductAttributeValueSelect(this)">移除</a>
			<input type="hidden" name="buy_attr_val[{0}][{1}][name]" vname="name" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][about]" vname="about" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][append_price]" vname="append_price" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][hidden]" vname="hidden" value="">
		</td>
	</tr>
</table>

<!-- 文本选择块 -->

<div id="tpl_add_attribute_textblock" style="display:none">
	<table width="100%">
		<tr>
			<td align="right">名称:</td>
			<td><input type="text" class="input-text" id="-_-attr_val_name" style="width:150px;" value="" />　　<label style="cursor:pointer;"><input id="-_-attr_val_service" name="-_-attr_val_service" type="checkbox" style="cursor:pointer;" value="0" />
			&nbsp;客服</label></td>
		</tr>
	</table>
</div>

<div id="tpl_attribute_textblock_box" style="display:none">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="140">名称</th>
				<th width="">&nbsp;</th>
			</tr>
		</thead>
		<tbody name="value_box">
		</tbody>
	</table>
</div>

<table id="tpl_attribute_value_textblock" style="display:none">
	<tr name="value_row" class="value-row" attr_val_id="{1}">
		<td><span name="value_name">{2}</span>&nbsp;<span name="value_service">{3}</span></td>
		<td align="right">
			<a href="javascript:void(0);" onclick="EditProductAttributeValueTextblock(this)">修改</a>
			<a href="javascript:void(0);" onclick="RemoveProductAttributeValueTextblock(this)">移除</a>
			<input type="hidden" name="buy_attr_val[{0}][{1}][name]" vname="name" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][hidden]" vname="hidden" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][service]" vname="service" value="">
		</td>
	</tr>
</table>


<!-- 文本输入组 -->


<div id="tpl_add_attribute_textgroup" style="display:none">
	<table width="100%">
		<tr>
			<td align="right">名称:</td>
			<td><input type="text" class="input-text" id="-_-attr_val_name" style="width:150px;" value="" /></td>
		</tr>
		<tr>
			<td align="right">必须:</td>
			<td>
			<input type="radio" name="attr_val_required" id="-_-attr_val_required" value="1"><font color="red">是</font>
			 <input type="radio" name="attr_val_required" value="0" id="-_-attr_val_required">否
			</td>
		</tr>
	</table>
</div>

<div id="tpl_attribute_textgroup_box" style="display:none">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="140">名称</th>
				<th width="80">必须</th>
				<th width="">&nbsp;</th>
			</tr>
		</thead>
		<tbody name="value_box">
		</tbody>
	</table>
</div>

<table id="tpl_attribute_value_textgroup" style="display:none">
	<tr name="value_row" class="value-row" attr_val_id="{1}">
		<td><span name="value_name">{2}</span>&nbsp;</td>
		<td><span name="value_required">{6}</span>&nbsp;</td>
		<td align="right">
			<a href="javascript:void(0);" onclick="EditProductAttributeValueTextgroup(this)">修改</a>
			<a href="javascript:void(0);" onclick="RemoveProductAttributeValueTextgroup(this)">移除</a>
			<input type="hidden" name="buy_attr_val[{0}][{1}][name]" vname="name" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][about]" vname="about" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][append_price]" vname="append_price" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][hidden]" vname="hidden" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][length]" vname="length" value="">
			<input type="hidden" name="buy_attr_val[{0}][{1}][required]" vname="required" value="">
		</td>
	</tr>
</table>