<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-03-04 17:08:36
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<script type="text/javascript" src="script/jquery-ui-1.7.1.js"></script>
<script type="text/javascript" src="script/swfupload/swfupload.js"></script>
<script type="text/javascript" src="script/uploader.js"></script>
<script type="text/javascript" src="script/cms-block.js"></script>

<link rel="stylesheet" href="css/htmleditor.css" type="text/css" media="screen" />
<script language="javascript" type="text/javascript" src="script/htmleditor.js"></script>
			<form method="post" enctype="multipart/form-data" target="_blank" id="main_form">

<div class="HY-main-columns clearfix">
	<div class="HY-main-columns-left" >


<div class="HY-form-table" id="attribute_buy_tab" style="display:block;width:300px;margin-top:52px;">
				<div class="HY-form-table-header clearfix2">
					<div class="left">购买属性</div>
					<div class="right">
					</div>
				</div>
				<div class="HY-form-table-main ">
					
					<div style="padding-top:10px;" id="user_define_buy_attr">
						<button type="button" class="append" onclick="AddProductAttribute();"><span>添加属性</span></button>
						<button type="button" class="preview" onclick="PreviewAttribute($('#main_form').serialize())"><span>预览</span></button>
						<div class="block10"></div>
						<div id="pattr_box" style="margin-bottom:20px;"><?php echo $attribute_form; ?></div>
					</div>
				</div>
			</div>









	</div>
	<div class="HY-main-columns-right">
		<div class="main-col-inner">
			<div class="HY-content-header clearfix-overflow">
				<h3>
					<?php
if ( $edit )
{
?>
					编辑产品:<?php echo $product['name']; ?>
					<?php
}
else
{
?>
					添加产品
					<?php
}
?>
					所属分类:<?php echo $category['name']; ?>
				</h3>
				<div class="right">
					<button type="button" class="scalable " onclick="$('form').reset();"><span>重置</span></button>
					<button type="button" class="scalable save" onclick="SubmitForm();"><span>保存数据</span></button>
				</div>
			</div>

			<div class="HY-form-table" id="base_tab">
				<div class="HY-form-table-header">
					基本信息
				</div>
				<div class="HY-form-table-main">
					<table cellspacing="0" class="HY-form-table-table">
						<tbody>
							<tr>
								<td class="label"><label>
								<div align="right"><span class="required">*</span>商品名称：</div>
								</label></td>
								<td class="value"><input name="name" id="name" value="<?php echo $product['name']; ?>" class="input-text" type="text" style="width:90%;"/>
								<input name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>" type="hidden"/></td>
								<td><small>&nbsp;</small></td>
							</tr>
							<tr>
								<td class="label"><label>
								<div align="right"><span class="required">*</span>规格：</div>
								</label></td>
								<td class="value"><input name="weight" id="weight" value="<?php
if ( $product['weight'] )
{
?><?php echo $product['weight']; ?><?php
}
else
{
?>-<?php
}
?>" class="input-text" type="text"  style="width:50px;"/></td>
								<td><small>&nbsp;</small></td>
							</tr>
							<tr>
								<td class="label"><label>
								<div align="right">品牌：</div>
								</label></td>
								<td class="value">
									<select name="brand_id" style="width:200px;">
										<option value="0">------无------</option>
										<?php
if ( $brand_list )
{
foreach ( $brand_list as $brand )
{
?>
										<option value="<?php echo $brand['id']; ?>" <?php
if ( $product['brand_id'] == $brand['id'] )
{
?>selected<?php
}
?>><?php echo $brand['name']; ?></option>
										<?php
}
}
?>
									</select>								</td>
								<td><small>&nbsp;</small></td>
							</tr>
							<tr>
								<td class="label"><label>
								<div align="right">类型：</div>
								</label></td>
								<td class="value">
								<label style="cursor:pointer;"><input  <?php
if ( $product['board'] == 1 )
{
?>checked="checked"<?php
}
?>  type="radio" name="board" value="1" />-3C--</label>　
								<label style="cursor:pointer;"><input  <?php
if ( $product['board'] == 2 )
{
?>checked="checked"<?php
}
?>  type="radio" name="board" value="2" />-非3C-</label>　								</td>
								<td><small>&nbsp;</small></td>
							</tr>
							<tr>
								<td class="label"><label>
								<div align="right"><span class="required">*</span>市场价：</div>
								</label></td>
								<td class="value"><input name="market_price" id="market_price" value="<?php echo $product['market_price']; ?>" class="input-text" type="text"  style="width:50px;"/></td>
								<td><small>&nbsp;</small></td>
							</tr>
							<tr>
								<td class="label"><label>
								<div align="right"><span class="required">*</span>成本价：</div>
								</label></td>
								<td class="value"><input name="cost_price" id="cost_price" value="<?php echo $product['cost_price']; ?>" class="input-text" type="text"  style="width:50px;"/></td>
								<td><small>&nbsp;</small></td>
							</tr>
							<tr>
								<td class="label"><label>
								<div align="right">简介：</div>
								</label></td>
								<td class="value">
									<div>
										<textarea name="summary" id="summary" style="width:800px;height:160px;overflow-x:auto;overflow-y:auto;"><?php echo $product['summary']; ?></textarea>
									</div>								</td>
								<td><small>&nbsp;</small></td>
							</tr>
							<tr>
								<td class="label"><label>
								<div align="right">默认供货商：</div>
								</label></td>
							  <td class="value">
							  <select name="supplier_now" style="width:400px;">
							  <option value="0">------无------</option>
<?php
if ( $supplier_list )
{
foreach ( $supplier_list as $val )
{
?>
							<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $product['supplier_now'] )
{
?>selected<?php
}
?>><?php echo $val['op']; ?> - <?php echo $val['name']; ?></option>
<?php
}
}
?></select>	
							  <td><small>&nbsp;</small></td>
							</tr>
														<tr style="display:none">
								<td class="label"><label>
								<div align="right">可选供货商：</div>
								</label></td>
							  <td class="value">
<?php
if ( $supplier_list )
{
foreach ( $supplier_list as $val )
{
?>
<div style="float:left;width:270px;">
<input <?php
if ( $val['selected'] == 1 )
{
?>checked="checked"<?php
}
?> style="cursor:pointer;" type="checkbox" name="supplier_id[]" id="supplier_id_<?php echo $val['id']; ?>" value="<?php echo $val['id']; ?>" />
<label style="cursor:pointer;<?php
if ( $val['selected'] == 1 )
{
?>color:#FF0000;<?php
}
?>" for="supplier_id_<?php echo $val['id']; ?>"><?php echo $val['name']; ?></label>
</div>
<?php
}
}
?>
							  <td><small>&nbsp;</small></td>
							</tr>


							<tr style="display:none;">
								<td class="label"><label>
								<div align="right">列表图片</div>
								</label></td>
								<td class="value clearfix">
									<div id="swfuploader_list_review" <?php
if ( !$product['image_list_url'] )
{
?>style="display:none;"<?php
}
?>>
										<img src="<?php echo $product['image_list_url']; ?>" class="HY-img">
										<input type="hidden" name="image_list_file" id="image_list_file">
									</div>
									    <div align="right"></div>
									
									<div style="float:left;height:20px;">
										<span id="swfuploader_list"></span>									</div>
									<div id="swfuploader_list_bar" style="height:20px;line-height:20px;float:left;display:none;">
										<span id="swfuploader_list_file"></span>&nbsp;&nbsp;&nbsp;
										<img src="image/rule-ajax-loader.gif" align="absmiddle">上传中...
										<span style="font-size:11px;"><span id="swfuploader_list_bar_per">0</span>%</span>									</div>
								</td>
								  <div align="right"></div>
								
								<td class=""><div align="right"></div></td>
							</tr>
						</tbody>
					</table>
			  </div>
			</div>
			
			
			
			
			
			
			
			
			
			
		</div>
	</div>
</div>
			</form>


<script type="text/javascript">
var swfuList;
var swfuListConfig = clone(swfConfig);

swfuListConfig.upload_url = "?mod=tool.upload";
swfuListConfig.file_post_name = "file";
swfuListConfig.file_queued_handler = function(file){
	$('#swfuploader_list_file').html(file.name);
};
swfuListConfig.file_dialog_complete_handler = function(numFilesSelected, numFilesQueued){
	if (numFilesQueued>0){
		this.startUpload();
		$('#swfuploader_list_bar').show();
	}
};
swfuListConfig.upload_progress_handler = function(file, bytesLoaded, bytesTotal){
	var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
	$('#swfuploader_list_bar_per').html(percent);
};
swfuListConfig.upload_success_handler =  function(file, serverData){
	if (serverData!="0"){
		this.addPostParam('old', serverData);
		$('#swfuploader_list_review').show();
		$('#image_list_file').val(serverData);
		$('#swfuploader_list_review img').attr('src', '?mod=tool.image&thumb=auto&width=64&height=64&file='+serverData );

	}else{
		$('#swfuploader_list_bar').hide();
		$('#swfuploader_list_bar_per').html(0);
		$('#swfuploader_list_file').html('');
		alert('上传失败');
	}
};

swfuListConfig.upload_complete_handler = function(){
	$('#swfuploader_list_bar').hide();
	$('#swfuploader_list_bar_per').html(0);
	$('#swfuploader_list_file').html('');
};

swfuListConfig.button_placeholder_id = 'swfuploader_list';


window.onload = function () {
	swfuList = new SWFUpload(swfuListConfig);
};


</script>

<?php echo $attribute_template; ?>


<script language="JavaScript">
<?php
if ( $edit )
{
?>
var globalAttributeId = -10000;
var globalAttributeValueId = -10000;
<?php
}
else
{
?>
var globalAttributeId = 1;
var globalAttributeValueId = 1;
<?php
}
?>
</script>

<script language="javascript" type="text/javascript" src="script/attribute-uploader.js"></script>
<script language="javascript" type="text/javascript" src="script/attribute.js"></script>



<script language="JavaScript">

function NextTab(){
	//if($('li[class="active"]').next('li').find('a').length){
	//	TabSelect($('li[class="active"]').next('li').find('a')[0], $('li[class="active"]').next('li').find('a').attr('att'));
	//}
}

function TabSelect(obj,id){
	//$('.HY-form-table').hide();
	//$('#'+id).show();
	//$('li').find('a').removeClass('active');
	//$(obj).addClass('active');
}

function SubmitForm(){
	//textEditor.Sync();
	var post = $('#main_form').serialize();
	Loading();
	$.ajax({
		url: '<?php echo $_SERVER['REQUEST_URI']; ?>&rand=' + Math.random(),
		type:'POST',
		data:post,
		success: function(info){
			if (info>0){
				Loading('处理成功', '正在跳转到列表页面...');
				window.location='?mod=product.edit&id='+info;
			}else{
				alert(info);
				UnLoading();
			}
		},
		error:function(info){
			alert('网络错误,请重试');
			UnLoading();
		}
	});
}

function OnSubmit(){
/*
	$('#picture').attr('disabled', true);
	
	var list = [];

	$('#image_detail_list div').each(function(){
		list[list.length] = $(this).attr('pid');
	});

	$('#image_detail_order').val(list.join(','));
*/
	if(!$('#name').val()){
		alert('请填写商品名称');
		$('#name').focus();
		return false;
	}

	if(!$('#weight').val()||$('#weight').val()<0||isNaN($('#weight').val())){
		alert('请填写商品重量');
		$('#name').focus();
		return false;
	}

	return true;
}


//var textEditor;

$(document).ready(function(){

	if (window.location.hash!=''){
		$('a[href='+window.location.hash+']').trigger('click');
	}


	//textEditor = new HtmlEditor('summary');
	//textEditor.Init();
});

</script>
<style>
.picture{
	cursor:move;
	width:52px;height:52px;border:1px solid #ccc;float:left;text-align:center;
	margin-right:4px;
	margin-bottom:4px;
	padding:5px;
	position:relative;
}
</style>
