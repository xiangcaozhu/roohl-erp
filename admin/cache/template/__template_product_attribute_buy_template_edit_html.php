<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-08 15:20:29
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix">
	<h3>编辑产品购买属性模板</h3>
	<p class="right">
		<button type="button" class="scalable save" onclick="$('form').submit();"><span>保存数据</span></button>
	</p>
</div>

<form method="post" enctype="multipart/form-data" id="main_form">
<div class="HY-form-table" id="price_tab">
	<div class="HY-form-table-header">
		编辑模板
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>模板名称<span class="required">*</span></label></td>
					<td class=""><input name="name" id="name" value="<?php echo $info['name']; ?>" class="input-text" type="text" style=""/></td>
				</tr>
				<tr>
					<td class="label"><label>属性设置<span class="required">*</span></label></td>
					<td class="">

						<button type="button" class="append" onclick="AddProductAttribute();"><span>添加属性</span></button>
						<button type="button" class="preview" onclick="PreviewAttribute($('#main_form').serialize())"><span>预览</span></button>
						<div class="block10"></div>
						<div id="pattr_box" style="margin-bottom:20px;"><?php echo $attribute_form; ?></div>

					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</form>

<?php echo $attribute_template; ?>

<script language="JavaScript">

var globalAttributeId = -10000;
var globalAttributeValueId = -10000;

</script>


<script type="text/javascript" src="script/swfupload/swfupload.js"></script>
<script type="text/javascript" src="script/uploader.js"></script>
<script language="javascript" type="text/javascript" src="script/attribute.js"></script>
<script src="script/color_functions.js"></script>		
<script type="text/javascript" src="script/js_color_picker_v2.js"></script>


<link rel="stylesheet" href="css/js_color_picker_v2.css" media="screen">

<style>

.select-block{
	float:left;
	border:1px solid #666;
	width:32px;
	height:32px;
	margin-right:2px;
	background-color:red;
}

.value-row{
	height:34px;
	line-height:34px;
	margin-bottom:2px;
}

.attribute-image{
	border:1px solid #666;
	width:32px;
	height:32px;
	margin-right:2px;
	vertical-align:middle;
}

</style>