var swfuBlock = [];
var swfuBlockConfig = clone(swfConfig);

swfuBlockConfig.upload_url = "?mod=tool.upload";
swfuBlockConfig.file_post_name = "file";
swfuBlockConfig.file_queued_handler = function(file){
};
swfuBlockConfig.file_dialog_complete_handler = function(numFilesSelected, numFilesQueued){
	if (numFilesQueued>0){
		this.startUpload();

		var uploaderBox = this.customSettings['box'];
		uploaderBox.find('*[ftype=uploader_bar]').show();
	}
};
swfuBlockConfig.upload_progress_handler = function(file, bytesLoaded, bytesTotal){
	var uploaderBox = this.customSettings['box'];

	var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
	uploaderBox.find('*[ftype=uploader_bar_per]').html(percent);
};
swfuBlockConfig.upload_success_handler =  function(file, serverData){
	var uploaderBox = this.customSettings['box'];
	
	if (serverData!="0"){
		var reviewUrl = '?mod=tool.image&width=240&height=240&file='+serverData;

		uploaderBox.find('*[ftype=uploader_review]').html('<img src="'+reviewUrl+'" class="image" />');
		uploaderBox.find('*[ftype=uploader_temp_file]').val(serverData);
		uploaderBox.find('*[ftype=uploader_url]').val(reviewUrl);
	}else{
		uploaderBox.find('*[ftype=uploader_bar]').hide();
		uploaderBox.find('*[ftype=uploader_bar_per]').html(0);
		alert('上传失败');
	}
};

swfuBlockConfig.upload_complete_handler = function(){
	var uploaderBox = this.customSettings['box'];

	uploaderBox.find('*[ftype=uploader_bar]').hide();
	uploaderBox.find('*[ftype=uploader_bar_per]').html(0);
};

swfuBlockConfig.button_placeholder_id = '';
swfuBlockConfig.custom_settings = {};

function BlockListDestoryUploader(){
	if (swfuBlock.length > 0){
		for (var i = 0; i < swfuBlock.length; i++){
			swfuBlock[i].destroy();
			swfuBlock[i] = null;
		}
	}

	swfuBlock = [];
}

var GlobalRowId = 10000;


function BlockListAddRow(obj,levelType){

	var blockBox = $(obj).parents('*[name=block_form]').eq(0);
	var inputForm = $(blockBox.find('*[name=tpl_block_'+levelType+'_input_form]').html().replace(/-_-/ig, ''));

	BlockListDestoryUploader();

	Dialog(
		'添加行',
		inputForm,
		function(){

			if (levelType=='main'){
				var row = $(blockBox.find('*[name=tpl_block_'+levelType+'_row] tbody').html().replace(/-_-/ig, '').format(GlobalRowId));
			}else{
				var parentRowId = $(obj).parents('tr').eq(0).attr('row_id');
				var row = $(blockBox.find('*[name=tpl_block_'+levelType+'_row] tbody').html().replace(/-_-/ig, '').format(GlobalRowId,parentRowId));
			}

			row.find('td[field]').each(function(){
				var fname = $(this).attr('field');
				var ftype = $(this).attr('type');
				var td = '';
				if (ftype=='text'){
					var v = $('input[name=block_input_'+fname+']').val();

					$(this).find('div').html(v);
					$(this).find('input[fname='+fname+']').val(v);

				}else if (ftype=='image'){
					var v = $('input[name=block_input_'+fname+']').val();
					var u = $('input[name=block_input_'+fname+'_url]').val();

					$(this).find('div').html('<img src="{0}" onclick="Thumb(this, 240);"/>'.format(u));
					$(this).find('input[fname='+fname+']').val(v);

				}else if (ftype=='product'){
					var v = $('input[name=block_input_'+fname+']').val();

					$(this).find('div').html('产品ID:{0} <span type="product_name" pid={0}></span>'.format(v));
					$(this).find('input[fname='+fname+']').val(v);

					RenderProduct($(this).find('span[type=product_name]'));
				}
			});

			if (levelType=='main'){
				blockBox.find('*[type=main-body]').append(row);

			}else{
				$(obj).parents('tr').eq(0).find('*[type=child-body]').append(row);
			}

			GlobalRowId++;

			BlockListDestoryUploader();
			UnDialog();
		},
		function(){
			BlockListDestoryUploader();
		},
		function(){
			setTimeout(function(){
				$('*[ftype=uploader_box]').each(function(){
					var btnId = $(this).find('*[ftype=uploader]').attr('id');
					var config = clone(swfuBlockConfig);

					if (btnId){
						config.button_placeholder_id = btnId;
						config.custom_settings['box'] = $(this);
						config.custom_settings['width'] = $(this).attr('fwidth');
						config.custom_settings['height'] = $(this).attr('fheight');

						swfuBlock.push(new SWFUpload(config));
					}
				});

			}, 100);
		}
	);
}

function BlockSetUploader(btnId){
	var uploader = $('#'+btnId);
	var uploaderBox = uploader.parents('*[ftype=uploader_box]').eq(0);

	var config = clone(swfuBlockConfig);
	config.button_placeholder_id = btnId;
	config.custom_settings['box'] = uploaderBox;
	config.custom_settings['width'] = uploaderBox.attr('fwidth');
	config.custom_settings['height'] = uploaderBox.attr('fheight');

	new SWFUpload(config);
}

function BlockListEditRow(obj, levelType){
	var rowBox = $(obj).parents('tr[row_id]').eq(0);
	var blockBox = $(obj).parents('*[name=block_form]').eq(0);

	var inputForm = $(blockBox.find('*[name=tpl_block_'+levelType+'_input_form]').html().replace(/-_-/ig, ''));

	// 依次赋值
	inputForm.find('input[fname]').each(function(){
		var fname = $(this).attr('fname');
		var value = rowBox.find('input[fname='+fname+']').val();
		var ftype = rowBox.find('input[fname='+fname+']').parents('td').eq(0).attr('type');

		if (ftype=='image'){
			var url = rowBox.find('td[field='+fname+'][level='+levelType+']').find('img').attr('src');
			var inputFieldBox = $(this).parents('td').eq(0);
			if (url){
				inputFieldBox.find('*[ftype=uploader_review]').html('<img src="{0}" onclick="Thumb(this, 240);">'.format(url));
			}
		}else{
			$(this).val(value);
		}
	});

	Dialog(
		'编辑行',
		inputForm,
		function(){
			// 再次赋值....
			rowBox.find('td[level='+levelType+']').each(function(){
				var fname = $(this).attr('field');
				var ftype = $(this).attr('type');

				if (ftype=='text'){
					var v = $('input[name=block_input_'+fname+']').val();

					$(this).find('div').html(v);
					$(this).find('input[fname='+fname+']').val(v);

				}else if (ftype=='image'){
					var v = $('input[name=block_input_'+fname+']').val();
					var u = $('input[name=block_input_'+fname+'_url]').val();

					if (v){
						$(this).find('div').html('<img src="{0}"/ onclick="Thumb(this, 240);">'.format(u));
						$(this).find('input[fname='+fname+']').val(v);
					}

				}else if (ftype=='product'){
					var v = $('input[name=block_input_'+fname+']').val();

					$(this).find('div').html('产品ID:{0} <span type="product_name" pid={0}></span>'.format(v));
					$(this).find('input[fname='+fname+']').val(v);

					RenderProduct($(this).find('span[type=product_name]'));
				}
			});

			BlockListDestoryUploader();
			UnDialog();
		},
		function(){
			BlockListDestoryUploader();
		},
		function(){
			setTimeout(function(){
				$('*[ftype=uploader_box]').each(function(){
					var btnId = $(this).find('*[ftype=uploader]').attr('id');
					var config = clone(swfuBlockConfig);

					config.button_placeholder_id = btnId;
					config.custom_settings['box'] = $(this);
					config.custom_settings['width'] = $(this).attr('fwidth');
					config.custom_settings['height'] = $(this).attr('fheight');

					swfuBlock.push(new SWFUpload(config));
				});

			}, 100);
		}
	);
}

function BlockListDelRow(obj, levelType){
	if(window.confirm('确定删除吗?')){
		var rowBox = $(obj).parents('tr[row_id]').eq(0).remove();
	}
}

function BlockListUpRow(obj, levelType){
	var rowBox = $(obj).parents('tr[row_id]').eq(0);

	var prev = rowBox.prev('tr[row_id]').eq(0);

	if (prev.length > 0){
		prev.before(rowBox);
	}
}

function BlockListDownRow(obj, levelType){
	var rowBox = $(obj).parents('tr[row_id]').eq(0);

	var after = rowBox.next('tr[row_id]').eq(0);

	if (after.length > 0){
		after.after(rowBox);
	}
}


/******** 块模型管理 ********/


/******** 添加列表字段 ********/
function BlockPatternAddListField(listType){
	Dialog(
		'添加字段  选择类型',
		$('#tpl_add_field').html().replace(/-_-/ig, ''),
		function(){
			var type = $('#field_type').val();

			if (type=='text' || type=='product'){
				Dialog(
					'添加字段  录入信息',
					$('#tpl_add_field_base').html().replace(/-_-/ig, ''),
					function(){
						var row = $($('#tpl_field_row').find('tbody').html().format(listType));
						row.find('*[name=alias_name]').html($('#field_alias_name').val());
						row.find('*[name=name]').html($('#field_name').val());
						row.find('*[name=type]').html($('option[value='+type+']').html());

						row.find('*[fname=alias_name]').val($('#field_alias_name').val());
						row.find('*[fname=name]').val($('#field_name').val());
						row.find('*[fname=type]').val(type);

						$('#'+listType+'_field_row_box').append(row);

						UnDialog();
					}
				);
			}else if (type=='image'){
				Dialog(
					'添加字段  录入信息',
					$('#tpl_add_field_image').html().replace(/-_-/ig, ''),
					function(){
						var row = $($('#tpl_field_row').find('tbody').html().format(listType));
						var thumbType = $('input[name=field_thumb_type][checked]').val();

						if (thumbType!='cut'){
							thumbType = 'normal';
						}

						row.find('*[name=alias_name]').html($('#field_alias_name').val());
						row.find('*[name=name]').html($('#field_name').val());
						row.find('*[name=type]').html($('option[value='+type+']').html());
						row.find('*[name=extra]').html('宽:'+parseInt($('#field_width').val())+'px;'+'高:'+parseInt($('#field_height').val())+'px;'+'缩略图:'+(thumbType=='cut'?'裁剪':'不裁剪'));

						row.find('*[fname=alias_name]').val($('#field_alias_name').val());
						row.find('*[fname=name]').val($('#field_name').val());
						row.find('*[fname=type]').val(type);
						row.find('*[fname=width]').val(parseInt($('#field_width').val()));
						row.find('*[fname=height]').val(parseInt($('#field_height').val()));
						row.find('*[fname=thumb_type]').val(thumbType);

						$('#'+listType+'_field_row_box').append(row);

						UnDialog();
					}
				);
			}
		}
	);
}

function RenderProduct(box){
	var productId = box.attr('pid');

	$.ajax({
		url: '?mod=cms.product.get&pid='+productId+'&rand='+ Math.random(),
		type:'POST',
		processData: true,
		dataType:'json',
		success: function(info){
			box.html(info.name);
			box.css('padding-left', '20px');
			box.css('color', '#ccc');
		},
		error:function(info){
			return false;
		}
	});
}

$(document).ready(function(){
	$('span[type=product_name]').each(function(){
		RenderProduct($(this));
	});
});


/******** 编辑列表字段 ********/
function BlockPatternEditListField(obj){
	var row = $(obj).parents('*[name=field_row]').eq(0);
	var type = row.find('*[fname=type]').val();
	var name = row.find('*[fname=name]').val();
	var aliasName = row.find('*[fname=alias_name]').val();
	var width = row.find('*[fname=width]').val();
	var height = row.find('*[fname=height]').val();
	var thumbType = row.find('*[fname=thumb_type]').val();

	if (thumbType!='cut'){
		thumbType = 'normal';
	}

	if (type=='text' || type=='product'){
		var htmlObject = $($('#tpl_add_field_base').html().replace(/-_-/ig, ''));
		htmlObject.find('#field_alias_name').val(aliasName);
		htmlObject.find('#field_name').val(name);

		Dialog(
			'编辑字段',
			htmlObject,
			function(){
				row.find('*[name=alias_name]').html($('#field_alias_name').val());
				row.find('*[name=name]').html($('#field_name').val());
				row.find('*[name=type]').html($('option[value='+type+']').html());

				row.find('*[fname=alias_name]').val($('#field_alias_name').val());
				row.find('*[fname=name]').val($('#field_name').val());

				UnDialog();
			}
		);
	}else if (type=='image'){
		var htmlObject = $($('#tpl_add_field_image').html().replace(/-_-/ig, ''));
		htmlObject.find('#field_alias_name').val(aliasName);
		htmlObject.find('#field_name').val(name);
		htmlObject.find('#field_width').val(width);
		htmlObject.find('#field_height').val(height);
		htmlObject.find('#field_height').val(height);
		htmlObject.find('input[name=field_thumb_type]').attr('checked', false);
		htmlObject.find('input[name=field_thumb_type][value='+thumbType+']').attr('checked', true);

		Dialog(
			'编辑字段',
			htmlObject,
			function(){
				var thumbType = $('input[name=field_thumb_type][checked]').val();

				if (thumbType!='cut'){
					thumbType = 'normal';
				}

				row.find('*[name=alias_name]').html($('#field_alias_name').val());
				row.find('*[name=name]').html($('#field_name').val());
				row.find('*[name=type]').html($('option[value='+type+']').html());
				row.find('*[name=extra]').html('宽:'+parseInt($('#field_width').val())+'px;'+'高:'+parseInt($('#field_height').val())+'px;'+'缩略图:'+(thumbType=='cut'?'裁剪':'不裁剪'));

				row.find('*[fname=alias_name]').val($('#field_alias_name').val());
				row.find('*[fname=name]').val($('#field_name').val());
				row.find('*[fname=type]').val($('#field_type').val());
				row.find('*[fname=width]').val(parseInt($('#field_width').val()));
				row.find('*[fname=height]').val(parseInt($('#field_height').val()));
				row.find('*[fname=thumb_type]').val(thumbType);

				UnDialog();
			}
		);
	}
}