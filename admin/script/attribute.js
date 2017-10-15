
function AddProductAttribute(){

	var switchHtml = '';
	var allAttrBox = $('*[name="buy_attr"]');

	allAttrBox.each(function(){
		switchHtml += '<lable style="display:block;width:100px;float:left;"><input type="checkbox" value="{1}" name="attr_switch">{0}</lable>'.format(
			$(this).find('input[aname=name]').val(),
			$(this).attr('attr_id')
		);
	});

	Dialog(
		'添加属性',
		$('#tpl_add_attribute').html().replace(/-_-/ig, '').format(switchHtml),
		function(){
			if (!$('#attr_name').val()){
				alert('请填写属性名称');
				return false;
			}

			var switchIndex = [];
			var switchName = [];
			$(':checkbox[name="attr_switch"][checked]').each(function(){
				switchIndex.push(this.value);
				switchName.push('<span type="attr_name_show_"'+this.value+'>'+$('*[attr_id='+this.value+']').find('input[aname=name]').val()+'</span>');
			});

			var htmlObject = $($('#tpl_attribute_box').html().replace(/-_-/ig, '').format(globalAttributeId));
			//htmlObject.find('*[name=buy_attr]').attr('attr_id',globalAttributeId);
			htmlObject.find('*[name=attr_name]').html($('#attr_name').val());
			htmlObject.find('*[name=attr_description]').html($('#attr_description').val());
			htmlObject.find('*[name=attr_type_view]').html($('#attr_type option:selected').html());
			htmlObject.find('*[name=attr_order_id]').html(parseInt($('#attr_order_id').val()) ? parseInt($('#attr_order_id').val()) : 0);
			htmlObject.find('*[name=attr_hidden]').html(($(':radio[name="attr_hidden"][checked]').val() == 1 ? '<font color="red">是</font>' : '否'));
			htmlObject.find('*[name=attr_required]').html(($(':radio[name="attr_required"][checked]').val() == 1 ? '<font color="red">是</font>' : '否'));
			htmlObject.find('*[name=attr_disable]').html(($(':radio[name="attr_disable"][checked]').val() == 1 ? '<font color="red">是</font>' : '否'));
			htmlObject.find('*[name=attr_switch_title]').html($('#attr_switch_title').val());
			htmlObject.find('*[name=attr_switch]').html(switchName.join(','));
			htmlObject.find('*[name=attr_item_add_view]').html(($('#attr_type').val() == 'text' ? '' : '<a href="javascript:void(0);" onclick="AddProductAttributeValue(this);">添加选项</a>'));

			// set hidden value
			htmlObject.find('*[aname=name]').val($('#attr_name').val());
			htmlObject.find('*[aname=type]').val($('#attr_type').val());
			htmlObject.find('*[aname=order]').val(parseInt($('#attr_order_id').val()) ? parseInt($('#attr_order_id').val()) : 0);
			htmlObject.find('*[aname=hidden]').val($(':radio[name="attr_hidden"][checked]').val());
			htmlObject.find('*[aname=required]').val($(':radio[name="attr_required"][checked]').val());
			htmlObject.find('*[aname=disable]').val($(':radio[name="attr_disable"][checked]').val());
			htmlObject.find('*[aname=switch]').val(switchIndex.join(','));
			htmlObject.find('*[aname=switch_title]').val($('#attr_switch_title').val());
			htmlObject.find('*[aname=description]').val($('#attr_description').val());


			htmlObject.find('*[name=table_box]').append($('#tpl_attribute_'+$('#attr_type').val()+'_box').html());
			$('#pattr_box').append(htmlObject);

			UnDialog();
			globalAttributeId++;
		}
	);
}

function RemoveProductAttribute(btn){
	if (window.confirm('确定移除该属性吗?')){
		$(btn).parents('div[name="buy_attr"]').remove();
	}
}


function EditProductAttribute(btn){
	var attrBox = $(btn).parents('*[name="buy_attr"]');
	var attrId = attrBox.attr('attr_id');
	var switchIndex = attrBox.find('input[aname="switch"]').val().split(',');

	var switchHtml = '';
	var allAttrBox = $('*[name="buy_attr"]');

	allAttrBox.each(function(){
		if ($(this).attr('attr_id')!=attrId){
			switchHtml += '<lable style="display:block;width:100px;float:left;"><input type="checkbox" value="{1}" name="attr_switch" {2}>{0}</lable>'.format(
				$(this).find('input[aname=name]').val(),
				$(this).attr('attr_id'),
				$.inArray($(this).attr('attr_id'), switchIndex) != -1 ? 'checked' : ''
			);
		}
	});

	var htmlObject = $($('#tpl_edit_attribute').html().replace(/-_-/ig, ''));
	htmlObject.find('input[id=attr_name]').val(attrBox.find('input[aname="name"]').val());
	htmlObject.find('input[id=attr_description]').val(attrBox.find('input[aname="description"]').val());
	htmlObject.find('input[id=attr_order_id]').val(attrBox.find('input[aname="order"]').val());
	htmlObject.find('input[id=attr_switch_title]').val(attrBox.find('input[aname="switch_title"]').val());
	htmlObject.find('*[id=attr_switch_view]').html(switchHtml);
	htmlObject.find('input[id=attr_switch_title]').val(attrBox.find('input[aname="switch_title"]').val());

	Dialog(
		'编辑属性',
		htmlObject
		,
		function(){
			if (!$('#attr_name').val()){
				alert('请填写属性名称');
				return false;
			}

			var switchIndex = [];
			var switchName = [];
			$(':checkbox[name="attr_switch"][checked]').each(function(){
				switchIndex.push(this.value);
				switchName.push('<span type="attr_name_show_"'+this.value+'>'+$('*[attr_id='+this.value+']').find('input[aname=name]').val()+'</span>');
			});

			attrBox.find('*[name="attr_name"]').html($('#attr_name').val());
			attrBox.find('*[name="attr_order_id"]').html(parseInt($('#attr_order_id').val()) ? parseInt($('#attr_order_id').val()) : '0');
			attrBox.find('*[name="attr_hidden"]').html($(':radio[name="attr_hidden"][checked]').val() == 1 ? '<font color="red">是</font>' : '否');
			attrBox.find('*[name="attr_required"]').html($(':radio[name="attr_required"][checked]').val() == 1 ? '<font color="red">是</font>' : '否');
			attrBox.find('*[name="attr_disable"]').html($(':radio[name="attr_disable"][checked]').val() == 1 ? '<font color="red">是</font>' : '否');
			attrBox.find('*[name="attr_switch"]').html(switchName.join(','));
			attrBox.find('*[name="attr_switch_title"]').html($('#attr_switch_title').val());
			attrBox.find('*[name="attr_description"]').html($('#attr_description').val());

			attrBox.find('input[aname="name"]').val($('#attr_name').val());
			attrBox.find('input[aname="order"]').val(parseInt($('#attr_order_id').val()) ? parseInt($('#attr_order_id').val()) : '0');
			attrBox.find('input[aname="hidden"]').val($(':radio[name="attr_hidden"][checked]').val());
			attrBox.find('input[aname="required"]').val($(':radio[name="attr_required"][checked]').val());
			attrBox.find('input[aname="disable"]').val($(':radio[name="attr_disable"][checked]').val());
			attrBox.find('input[aname="switch"]').val(switchIndex.join(','));
			attrBox.find('input[aname="switch_title"]').val($('#attr_switch_title').val());
			attrBox.find('input[aname="description"]').val($('#attr_description').val());

			UnDialog();
		}
	);

	if (attrBox.find('input[aname="hidden"]').val()==1)
		htmlObject.find(':radio[id=attr_hidden][value=1]').attr('checked',true);
	else
		htmlObject.find(':radio[id=attr_hidden][value=0]').attr('checked',true);

	if (attrBox.find('input[aname="required"]').val()==1)
		htmlObject.find(':radio[id=attr_required][value=1]').attr('checked',true);
	else
		htmlObject.find(':radio[id=attr_required][value=0]').attr('checked',true);

	if (attrBox.find('input[aname="disable"]').val()==1)
		htmlObject.find(':radio[id=attr_disable][value=1]').attr('checked',true);
	else
		htmlObject.find(':radio[id=attr_disable][value=0]').attr('checked',true);
}

function AddProductAttributeValue(btn){
	var box = $(btn).parents('*[name="buy_attr"]');
	var attrType = box.find('input[aname="type"]').val();
	if (attrType == 'text'){
		AddProductAttributeValueText(box);
	}else if (attrType == 'color'){
		AddProductAttributeValueColor(box);
	}else if (attrType == 'image'){
		AddProductAttributeValueImage(box);
	}else if (attrType == 'select'){
		AddProductAttributeValueSelect(box);
	}else if (attrType == 'textblock'){
		AddProductAttributeValueTextblock(box);
	}else if (attrType == 'textgroup'){
		AddProductAttributeValueTextgroup(box);
	}

	globalAttributeValueId++;
}


/******** Text ********/

function AddProductAttributeValueText(valBox){
	var htmlObject = $($('#tpl_add_attribute_text').html().replace(/-_-/ig, ''));
	htmlObject.find('input[id=attr_length]').val(valBox.find('input[aname=length]').val());
	htmlObject.find('input[id=attr_append_price]').val(valBox.find('input[aname=append_price]').val());
	Dialog(
		'文本框属性',
		htmlObject,
		function(){
			valBox.find('*[name="attr_length"]').html($('#attr_length').val());
			valBox.find('*[name="attr_append_price"]').html(FormatMoney($('#attr_append_price').val()));

			valBox.find('input[aname="length"]').val($('#attr_length').val());
			valBox.find('input[aname="append_price"]').val(FormatMoney($('#attr_append_price').val()));

			UnDialog();
		}
	);
}

/******** Color ********/

function AddProductAttributeValueColor(box){
	var valBox = box.find('*[name="value_box"]');
	var attrId = box.attr('attr_id');

	var htmlObject = $($('#tpl_add_attribute_color').html().replace(/-_-/ig, ''));

	Dialog(
		'添加属性值',
		htmlObject,
		function(){
			if (!$('#attr_val_name').val()){
				alert('请填写属性值名称');
				return false;
			}

			if (!$('#attr_val_color').val()){
				alert('请填写颜色');
				return false;
			}

			var valRow = $($('#tpl_attribute_value_color').find('tbody').html().format(
				attrId,
				globalAttributeValueId
			));

			/*
			console.log(attrId);
			console.log($('#tpl_attribute_value_color').find('tbody').html());

			console.log($('#tpl_attribute_value_color').find('tbody').html().format(
				attrId,
				globalAttributeValueId
			));
			*/

			valRow.find('input[vname=color]').val($('#attr_val_color').val());
			valRow.find('input[vname=name]').val($('#attr_val_name').val());
			valRow.find('input[vname=append_price]').val(FormatMoney($('#attr_val_append_price').val()));
			valRow.find('input[vname=hidden]').val($(':radio[name="attr_val_hidden"][checked]').val());
			valRow.find('span[name=value_hidden]').html(($(':radio[name="attr_val_hidden"][checked]').val() == 1 ? '<font color="red">是</font>' : '否'));
			valRow.find('span[name=value_append_price]').html(FormatMoney($('#attr_val_append_price').val()));
			valRow.find('span[name=value_name]').html($('#attr_val_name').val());
			valRow.find('.select-block').css('background-color', $('#attr_val_color').val());

			valBox.append(valRow);
			UnDialog();
		}
	);

	htmlObject.find(':radio[id=attr_val_hidden][value=0]').attr('checked', true);
}

function EditProductAttributeValueColor(btn){
	var valRow = $(btn).parents('*[name="value_row"]');
	var color = valRow.find('input[vname="color"]').val();
	var name = valRow.find('input[vname="name"]').val();
	var price = valRow.find('input[vname="append_price"]').val();
	var hidden = valRow.find('input[vname="hidden"]').val();

	var htmlObject = $($('#tpl_add_attribute_color').html().replace(/-_-/ig, ''));
	htmlObject.find('input[id=attr_val_name]').val(name);
	htmlObject.find('input[id=attr_val_color]').val(color);
	htmlObject.find('input[id=attr_val_append_price]').val(price);

	Dialog(
		'编辑属性值',
		htmlObject,
		function(){
			if (!$('#attr_val_name').val()){
				alert('请填写属性值名称');
				return false;
			}

			if (!$('#attr_val_color').val()){
				alert('请填写颜色');
				return false;
			}

			valRow.find('.select-block').css('background-color', $('#attr_val_color').val());

			valRow.find('span[name="value_name"]').html($('#attr_val_name').val());
			valRow.find('input[vname="name"]').val($('#attr_val_name').val());

			valRow.find('input[vname="color"]').val($('#attr_val_color').val());

			valRow.find('input[vname="append_price"]').val(FormatMoney($('#attr_val_append_price').val()));
			valRow.find('span[name="value_append_price"]').html(FormatMoney($('#attr_val_append_price').val()));

			valRow.find('input[vname="hidden"]').val($(':radio[name="attr_val_hidden"][checked]').val());
			valRow.find('span[name="value_hidden"]').html($(':radio[name="attr_val_hidden"][checked]').val() == 1 ? '<font color="red">是</font>' : '否');

			UnDialog();
		}
	);

	if (hidden==1)
		htmlObject.find(':radio[id=attr_val_hidden][value=1]').attr('checked', true);
	else
		htmlObject.find(':radio[id=attr_val_hidden][value=0]').attr('checked', true);
}

function RemoveProductAttributeValueColor(btn){
	if (window.confirm('确定移除该选项吗?')){
		$(btn).parents('tr[name="value_row"]').remove();
	}
}

/******** Image ********/

function DestoryUploader(){
	if (swfuAttribute){
		swfuAttribute.destroy();
		swfuAttribute = null;
	}
}

function AddProductAttributeValueImage(box){
	var valBox = box.find('*[name="value_box"]');
	var attrId = box.attr('attr_id');

	var htmlObject = $($('#tpl_add_attribute_image').html().replace(/-_-/ig, ''));

	Dialog(
		'添加属性值',
		htmlObject,
		function(){
			var ext = $('#attr_file_review').attr('ext');
			var fileUrl = $('#attr_file_review').attr('file_url');
			var fileName = $('#attr_file_review').attr('file_name');

			if (!$('#attr_val_name').val()){
				alert('请填写属性值名称');
				return false;
			}

			/*
			if (!ext){
				alert('请上传图片');
				return false;
			}
			*/

			var valRow = $($('#tpl_attribute_value_image').find('tbody').html().format(
				attrId,
				globalAttributeValueId,
				fileUrl,
				$('#attr_val_name').val(),
				FormatMoney($('#attr_val_append_price').val()),
				$(':radio[name="attr_val_hidden"][checked]').val() == 1 ? '<font color="red">是</font>' : '否'
			));
			valRow.find('input[vname=name]').val($('#attr_val_name').val());
			valRow.find('input[vname=ext]').val(ext);
			valRow.find('input[vname=file_url]').val(fileUrl);
			valRow.find('input[vname=file_name]').val(fileName);
			valRow.find('input[vname=append_price]').val(FormatMoney($('#attr_val_append_price').val()));
			valRow.find('input[vname=hidden]').val($(':radio[name="attr_val_hidden"][checked]').val());

			valBox.append(valRow);

			DestoryUploader();
			UnDialog();
		},
		function(){
			var ext = $('#attr_file_review').attr('ext');
			var fileUrl = $('#attr_file_review').attr('file_url');
			var fileName = $('#attr_file_review').attr('file_name');

			if (ext){
				$.ajax({url: '?mod=product.attribute.buy.file.del&file={0}&randnum={1}'.format(fileName+'.'+ext, Math.random())});
			}

			DestoryUploader();
		},
		function(){
			setTimeout(function(){
				swfuAttribute = new SWFUpload(swfuAttributeConfig);
			}, 100);
		}
	);

	htmlObject.find(':radio[id=attr_val_hidden][value=0]').attr('checked', true);
}


function EditProductAttributeValueImage(btn){
	var valRow = $(btn).parents('*[name="value_row"]');
	var name = valRow.find('input[vname="name"]').val();
	var ext = valRow.find('input[vname="ext"]').val();
	var fileUrl = valRow.find('input[vname="file_url"]').val();
	var fileName = valRow.find('input[vname="file_name"]').val();
	var price = valRow.find('input[vname="append_price"]').val();
	var hidden = valRow.find('input[vname="hidden"]').val();

	var htmlObject = $($('#tpl_add_attribute_image').html().replace(/-_-/ig, ''));
	htmlObject.find('input[id=attr_val_name]').val(name);
	htmlObject.find('input[id=attr_val_append_price]').val(price);
	htmlObject.find('input[id=attr_val_append_price]').val(price);
	htmlObject.find('span[id=attr_file_review]').find('img').attr('src',fileUrl);

	Dialog(
		'编辑属性值',
		htmlObject,
		function(){
			if (!$('#attr_val_name').val()){
				alert('请填写属性值名称');
				return false;
			}

			valRow.find('input[vname="name"]').val($('#attr_val_name').val());
			valRow.find('span[name="value_name"]').html($('#attr_val_name').val());

			valRow.find('input[vname="append_price"]').val(FormatMoney($('#attr_val_append_price').val()));
			valRow.find('span[name="value_append_price"]').html(FormatMoney($('#attr_val_append_price').val()));

			valRow.find('input[vname="hidden"]').val($(':radio[name="attr_val_hidden"][checked]').val());
			valRow.find('span[name="value_hidden"]').html($(':radio[name="attr_val_hidden"][checked]').val() == 1 ? '<font color="red">是</font>' : '否');

			var ext = $('#attr_file_review').attr('ext');
			var fileUrl = $('#attr_file_review').attr('file_url');
			var fileName = $('#attr_file_review').attr('file_name');

			if (ext){
				var p = valRow.find('.attribute-image').parent();
				valRow.find('.attribute-image').remove();
				p.html('<img class="attribute-image" src="{0}" />'.format(fileUrl));
				valRow.find('input[vname="ext"]').val(ext);
				valRow.find('input[vname="file_url"]').val(fileUrl);
				valRow.find('input[vname="file_name"]').val(fileName);
			}

			DestoryUploader();
			UnDialog();
		},
		function(){
			var ext = $('#attr_file_review').attr('ext');
			var fileUrl = $('#attr_file_review').attr('file_url');
			var fileName = $('#attr_file_review').attr('file_name');

			if (ext){
				$.ajax({url: '?mod=product.attribute.buy.file.del&file={0}&randnum={1}'.format(fileName+'.'+ext, Math.random())});
			}

			DestoryUploader();
		},
		function(){
			setTimeout(function(){
				swfuAttributeConfig.swfupload_loaded_handler = null;
				if (fileName&&ext){
					swfuAttributeConfig.swfupload_loaded_handler = function(){
						this.addPostParam('old', '');
					};
				}
				swfuAttribute = new SWFUpload(swfuAttributeConfig);

			}, 100);
		}
	);

	if (hidden==1)
		htmlObject.find(':radio[id=attr_val_hidden][value=1]').attr('checked', true);
	else
		htmlObject.find(':radio[id=attr_val_hidden][value=0]').attr('checked', true);
}

function RemoveProductAttributeValueImage(btn){
	if (window.confirm('确定移除该选项吗?')){
		$(btn).parents('tr[name="value_row"]').remove();
	}
}


function AttributeUploadDone(error, data){
	if (error.fail){
		alert('上传失败');
		return false;
	}

	$('#attr_file_review').html('<img src="{0}" width="32" height="32" class="attribute-image" />'.format(data.file_url));
	$('#attr_file_review').attr('ext', data.ext);
	$('#attr_file_review').attr('file_url', data.file_url);
	$('#attr_file_review').attr('file_name', data.file_name);
}


/******** Select ********/

function AddProductAttributeValueSelect(box){
	var valBox = box.find('*[name="value_box"]');
	var attrId = box.attr('attr_id');

	var htmlObject = $($('#tpl_add_attribute_select').html().replace(/-_-/ig, ''));

	Dialog(
		'添加属性值',
		htmlObject,
		function(){
			if (!$('#attr_val_name').val()){
				alert('请填写属性值名称');
				return false;
			}

			var valRow = $($('#tpl_attribute_value_select').find('tbody').html().format(
				attrId,
				globalAttributeValueId,
				$('#attr_val_name').val(),
				FormatMoney($('#attr_val_append_price').val()),
				$(':radio[name="attr_val_hidden"][checked]').val() == 1 ? '<font color="red">是</font>' : '否'
			));

			valRow.find('input[vname=name]').val($('#attr_val_name').val());
			valRow.find('input[vname=append_price]').val(FormatMoney($('#attr_val_append_price').val()));
			valRow.find('input[vname=hidden]').val($(':radio[name="attr_val_hidden"][checked]').val());
			valBox.append(valRow);
			UnDialog();
		}
	);

	htmlObject.find(':radio[id=attr_val_hidden][value=0]').attr('checked', true);
}

function EditProductAttributeValueSelect(btn){
	var valRow = $(btn).parents('*[name="value_row"]');
	var name = valRow.find('input[vname="name"]').val();
	var price = valRow.find('input[vname="append_price"]').val();
	var hidden = valRow.find('input[vname="hidden"]').val();

	var htmlObject = $($('#tpl_add_attribute_select').html().replace(/-_-/ig, ''));
	htmlObject.find('input[id=attr_val_name]').val(name);
	htmlObject.find('input[id=attr_val_append_price]').val(price);

	Dialog(
		'编辑属性值',
		htmlObject,
		function(){
			if (!$('#attr_val_name').val()){
				alert('请填写属性值名称');
				return false;
			}

			valRow.find('span[name="value_name"]').html($('#attr_val_name').val());
			valRow.find('input[vname="name"]').val($('#attr_val_name').val());

			valRow.find('input[vname="append_price"]').val(FormatMoney($('#attr_val_append_price').val()));
			valRow.find('span[name="value_append_price"]').html(FormatMoney($('#attr_val_append_price').val()));

			valRow.find('input[vname="hidden"]').val($(':radio[name="attr_val_hidden"][checked]').val());
			valRow.find('span[name="value_hidden"]').html($(':radio[name="attr_val_hidden"][checked]').val() == 1 ? '<font color="red">是</font>' : '否');

			UnDialog();
		}
	);

	if (hidden==1)
		htmlObject.find(':radio[id=attr_val_hidden][value=1]').attr('checked', true);
	else
		htmlObject.find(':radio[id=attr_val_hidden][value=0]').attr('checked', true);

}

function RemoveProductAttributeValueSelect(btn){
	if (window.confirm('确定移除该选项吗?')){
		$(btn).parents('tr[name="value_row"]').remove();
	}
}


/******** TextBlock xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx********/

function kkklp(types){
	if(types==1){return "客服操作";}
	else{return "";}
}
function AddProductAttributeValueTextblock(box){
	var valBox = box.find('*[name="value_box"]');
	var attrId = box.attr('attr_id');

	var htmlObject = $($('#tpl_add_attribute_textblock').html().replace(/-_-/ig, ''));

	Dialog(
		'添加属性值',
		htmlObject,
		function(){
			if (!$('#attr_val_name').val()){
				alert('请填写属性值名称');
				return false;
			}

			var valRow = $($('#tpl_attribute_value_textblock').find('tbody').html().format(
				attrId,
				globalAttributeValueId,
				$('#attr_val_name').val(),
				$('#attr_val_service').val(),
				//FormatMoney($('#attr_val_append_price').val()),
				$(':radio[name="attr_val_hidden"][checked]').val()
			));

			valRow.find('input[vname=name]').val($('#attr_val_name').val());
			//valRow.find('input[vname=append_price]').val(FormatMoney($('#attr_val_append_price').val()));
			valRow.find('input[vname=hidden]').val($(':radio[name="attr_val_hidden"][checked]').val());
			//valRow.find('input[vname="service"]').val($('#attr_val_service').val());
			
			if($('#attr_val_service').attr('checked')){valRow.find('input[vname="service"]').val(1);valRow.find('span[name="value_service"]').html('客服操作');}
			else{valRow.find('input[vname="service"]').val(0);valRow.find('span[name="value_service"]').html('');}



			
			valBox.append(valRow);
			UnDialog();
		}
	);

	htmlObject.find(':radio[id=attr_val_hidden][value=0]').attr('checked', true);
}

function EditProductAttributeValueTextblock(btn){
	var valRow = $(btn).parents('*[name="value_row"]');
	var name = valRow.find('input[vname="name"]').val();
	//var price = valRow.find('input[vname="append_price"]').val();
	var hidden = valRow.find('input[vname="hidden"]').val();
	var service = valRow.find('input[vname="service"]').val();

	var htmlObject = $($('#tpl_add_attribute_textblock').html().replace(/-_-/ig, ''));
	htmlObject.find('input[id=attr_val_name]').val(name);
	//htmlObject.find('input[id=attr_val_append_price]').val(price);
	
	if(service>0){
		htmlObject.find('input[id=attr_val_service]').attr('checked', true);
		}

	Dialog(
		'编辑属性值',
		htmlObject,
		function(){
			if (!$('#attr_val_name').val()){
				alert('请填写属性值名称');
				return false;
			}

			valRow.find('span[name="value_name"]').html($('#attr_val_name').val());
			valRow.find('input[vname="name"]').val($('#attr_val_name').val());
			
			//valRow.find('span[name="value_service"]').html($('#attr_value_service').val());
			//valRow.find('span[name="value_service"]').html(kkklp($('input[id=attr_val_service]').val()));
			//valRow.find('input[vname="service"]').val($('#attr_value_service').val());
			//valRow.find('input[vname="service"]').val($('input[id=attr_val_service]').val());

			//valRow.find('input[vname="append_price"]').val(FormatMoney($('#attr_val_append_price').val()));
			//valRow.find('span[name="value_append_price"]').html(FormatMoney($('#attr_val_append_price').val()));

			valRow.find('input[vname="hidden"]').val($(':radio[name="attr_val_hidden"][checked]').val());
			valRow.find('span[name="value_hidden"]').html($(':radio[name="attr_val_hidden"][checked]').val() == 1 ? '<font color="red">是</font>' : '否');
			
			//if(valRow.find('span[name="value_service"]').html()!=""){valRow.find('input[vname="service"]').attr('checked', true);}
			
			
			if($('#attr_val_service').attr('checked')){valRow.find('input[vname="service"]').val(1);valRow.find('span[name="value_service"]').html('客服操作');}
			else{valRow.find('input[vname="service"]').val(0);valRow.find('span[name="value_service"]').html('');}
			
			
			
			

			UnDialog();
		}
	);

	if (hidden==1)
		htmlObject.find(':radio[id=attr_val_hidden][value=1]').attr('checked', true);
	else
		htmlObject.find(':radio[id=attr_val_hidden][value=0]').attr('checked', true);
}

function RemoveProductAttributeValueTextblock(btn){
	if (window.confirm('确定移除该选项吗?')){
		$(btn).parents('tr[name="value_row"]').remove();
	}
}

/******** TextGroup ********/

function AddProductAttributeValueTextgroup(box){
	var valBox = box.find('*[name="value_box"]');
	var attrId = box.attr('attr_id');

	var htmlObject = $($('#tpl_add_attribute_textgroup').html().replace(/-_-/ig, ''));
	//htmlObject.find('input[id=attr_val_hidden][value=0]')[0].checked = true;
	//htmlObject.find('input[id=attr_val_required][value=0]').attr('checked', true);
	Dialog(
		'添加属性值',
		htmlObject,
		function(){
			if (!$('#attr_val_name').val()){
				alert('请填写属性值名称');
				return false;
			}

			var valRow = $($('#tpl_attribute_value_textgroup').find('tbody').html().format(
				attrId,
				globalAttributeValueId,
				$('#attr_val_name').val(), 
				FormatMoney($('#attr_val_append_price').val()),
				parseInt($('#attr_val_length').val()),
				$(':radio[name="attr_val_hidden"][checked]').val() == 1 ? '<font color="red">是</font>' : '否',
				$(':radio[name="attr_val_required"][checked]').val() == 1 ? '<font color="red">是</font>' : '否'
			));

			valRow.find('input[vname=name]').val($('#attr_val_name').val());
			valRow.find('input[vname=append_price]').val(FormatMoney($('#attr_val_append_price').val()));
			valRow.find('input[vname=hidden]').val($(':radio[name="attr_val_hidden"][checked]').val());
			valRow.find('input[vname=required]').val($(':radio[name="attr_val_required"][checked]').val());
			valRow.find('input[vname=length]').val(parseInt($('#attr_val_length').val()));
			valBox.append(valRow);
			UnDialog();
		}
	);

	htmlObject.find('input[id=attr_val_hidden][value=0]').attr('checked', true);
	htmlObject.find('input[id=attr_val_required][value=0]').attr('checked', true);
}

function EditProductAttributeValueTextgroup(btn){
	var valRow = $(btn).parents('*[name="value_row"]');
	var name = valRow.find('input[vname="name"]').val();
	var price = valRow.find('input[vname="append_price"]').val();
	var hidden = valRow.find('input[vname="hidden"]').val();
	var length = valRow.find('input[vname="length"]').val();
	var required = valRow.find('input[vname="required"]').val();

	var htmlObject = $($('#tpl_add_attribute_textgroup').html().replace(/-_-/ig, ''));
	htmlObject.find('input[id=attr_val_name]').val(name);
	htmlObject.find('input[id=attr_val_append_price]').val(price);
	htmlObject.find('input[id=attr_val_length]').val(length);

	Dialog(
		'编辑属性值',
		htmlObject,
		function(){
			if (!$('#attr_val_name').val()){
				alert('请填写属性值名称');
				return false;
			}

			valRow.find('span[name="value_name"]').html($('#attr_val_name').val());
			valRow.find('input[vname="name"]').val($('#attr_val_name').val());

			valRow.find('input[vname="append_price"]').val(FormatMoney($('#attr_val_append_price').val()));
			valRow.find('span[name="value_append_price"]').html(FormatMoney($('#attr_val_append_price').val()));

			valRow.find('input[vname="hidden"]').val($(':radio[name="attr_val_hidden"][checked]').val());
			valRow.find('span[name="value_hidden"]').html($(':radio[name="attr_val_hidden"][checked]').val() == 1 ? '<font color="red">是</font>' : '否');

			valRow.find('input[vname="length"]').val($('#attr_val_length').val());
			valRow.find('span[name="value_length"]').html($('#attr_val_length').val());

			valRow.find('input[vname="required"]').val($(':radio[name="attr_val_required"][checked]').val());
			valRow.find('span[name="value_required"]').html($(':radio[name="attr_val_required"][checked]').val() == 1 ? '<font color="red">是</font>' : '否');

			UnDialog();
		}
	);

	if (hidden==1)
		htmlObject.find(':radio[id=attr_val_hidden][value=1]').attr('checked', true);
	else
		htmlObject.find(':radio[id=attr_val_hidden][value=0]').attr('checked', true);

	if (required==1)
		htmlObject.find(':radio[id=attr_val_required][value=1]').attr('checked', true);
	else
		htmlObject.find(':radio[id=attr_val_required][value=0]').attr('checked', true);
}

function RemoveProductAttributeValueTextgroup(btn){
	if (window.confirm('确定移除该选项吗?')){
		$(btn).parents('tr[name="value_row"]').remove();
	}
}


/******** About ********/

function SetAboutDisabledValue(btn){
	var valRow = $(btn).parents('*[name="value_row"]');
	var buyAttributeBox = $('*[name="buy_attr"]');
	var parentBox = $(btn).parents('*[name="buy_attr"]');

	var html = '';

	var aboutList = [];
	if (valRow.find('input[vname=about]').val()){
		aboutList = valRow.find('input[vname=about]').val().split(',');
	}

	for (var i = 0; i  < buyAttributeBox.length; i++){
		var box = buyAttributeBox.eq(i);
		var boxType = box.find('input[aname=type]').val();
		var valueBoxList = box.find('.value-row');

		if (isNaN(box.attr('attr_id'))){
			continue;
		}

		if (parentBox.attr('attr_id') == box.attr('attr_id') || boxType == 'text' || boxType == 'textgroup' || boxType == 'select'){
			continue;
		}

		html += '<div style="padding:0 10px;"><p><b>{0}</b></p><p style="padding:0 10px;">'.format(box.find('input[aname="name"]').val());

		for (var n = 0; n < valueBoxList.length; n++){
			var valueBox = valueBoxList.eq(n);
			var vname = valueBox.find('input[vname="name"]').val();
			var vid = valueBox.attr('attr_val_id');

			html += '<span><lable><input type="checkbox" value="{1}" name="about_atttr_val" {2}>{0}</lable></span>'.format(vname, vid, $.inArray(vid, aboutList) >= 0 ? 'checked' : '');
		}

		html += '</p></div>';
	}

	Dialog(
		'设定关联',
		html,
		function(){
			var list = [];
			$(':checkbox[name="about_atttr_val"][checked]').each(function(){
				list[list.length] = $(this).val();
			});

			valRow.find('input[vname="about"]').val(list.join(','));

			LoopAbout(list, aboutList, valRow.attr('attr_val_id'));
			UnDialog();
		}
	);
}

function LoopAbout(newAboutList,beforeAboutList,valueId){
	for(var i = 0; i < newAboutList.length; i++){
		var vid = newAboutList[i];
		if ($.inArray(vid, beforeAboutList) == -1){
			var oAboutInput = $('*[attr_val_id='+vid+']').find('input[vname="about"]');

			if (oAboutInput.length > 0){
				if (oAboutInput.val() != ""){
					var oAboutList = oAboutInput.val().split(',');
				}else{
					var oAboutList = [];
				}

				if ($.inArray(valueId, oAboutList)==-1){
					oAboutList[oAboutList.length] = valueId;

					oAboutInput.val(oAboutList.join(','));
				}
			}
		}
	}

	for(var i = 0; i < beforeAboutList.length; i++){
		var vid = beforeAboutList[i];
		if ($.inArray(vid, newAboutList) == -1){
			var oAboutInput = $('*[attr_val_id='+vid+']').find('input[vname="about"]');
			if (oAboutInput.length > 0){
				if (oAboutInput.val() != ""){
					var oAboutList = oAboutInput.val().split(',');
				}else{
					var oAboutList = [];
				}

				var oAboutNewList = $.grep(oAboutList, function(n,i){return n!=valueId});

				oAboutInput.val(oAboutNewList.join(','));
			}
		}
	}

}

function LoopAboutAll(){
	var aboutInputList = $('input[vname="about"]');

	for (var i = 0; i < aboutInputList.length; i++){
		var aboutList = aboutInputList.eq(i).val().split(',');
		var valueRow = aboutInputList.eq(i).parents('*[name=value_row]');
		var valueId = valueRow.attr('attr_val_id');

		if (valueId=="" || !valueId){
			continue;
		}

		if (aboutList.length>0){
			for(var ii = 0; ii < aboutList.length ; ii++){
				var vid = aboutList[ii];
				if (!vid || vid==''){
					continue;
				}

				var oAboutInput = $('*[attr_val_id='+vid+']').find('input[vname="about"]');

				if (oAboutInput.length > 0){
					if (oAboutInput.val() != ""){
						var oAboutList = oAboutInput.val().split(',');
					}else{
						var oAboutList = [];
					}

					if ($.inArray(valueId, oAboutList)==-1){
						oAboutList[oAboutList.length] = valueId;
						oAboutInput.val(oAboutList.join(','));
					}
				}
			}
		}
	}
}

var __TemplateListPage = 1;

function ListAttributeTemplate(page){
	page = page ? page : 1;
	__TemplateListPage = page;

	$.ajax({
		url: '?mod=product.attribute.buy.template.ajax&page='+page +'&type=list&rand=' + Math.random(),
		processData: true,
		dataType:'json',
		success: function(info){
			if (info.html){
				var html = info.html;
				html += "<div style=\"text-align:right;\">" +PageBar(page, info.total, 10, 5, 'ListAttributeTemplate') +"</div>";
				Dialog('选择属性模板', 
					html
				);
			}
		},
		error:function(info){
			alert('错误', "网络传输错误,请重试...");
			return false;
		}
	});
}

function PreviewAttributeTemplate(id,type){
	$.ajax({
		url: '?mod=product.attribute.buy.template.ajax&id='+id +'&type=preview&rand=' + Math.random(),
		processData: true,
		dataType:'json',
		success: function(info){
			if (info.html){
				Dialog(
					'预览', 
					info.html,
					function(){if(type==2){ApplyAttributeTemplate(id);}else{UnDialog();}},
					function(){if(type==2){ListAttributeTemplate(__TemplateListPage);}},
					function(){AttributeEvent();},
					(type==2 ?'应用':''),
					(type==2 ?'返回':'')
				);
			}
		},
		error:function(info){
			alert('错误', "网络传输错误,请重试...");
			return false;
		}
	});
}

var __TemplateInUse = [];

function ApplyAttributeTemplate(id){
	if ($.inArray(id, __TemplateInUse) != -1){
		alert('本次操作已经使用过该模板了');
		return false;
	}

	$.ajax({
		url: '?mod=product.attribute.buy.template.ajax&id='+id +'&type=apply&rand=' + Math.random(),
		processData: true,
		dataType:'json',
		success: function(info){
			if (info.html){
				$('#pattr_box').append(info.html);
				__TemplateInUse[__TemplateInUse.length] = id;
				UnDialog();
			}
		},
		error:function(info){
			alert('错误', "网络传输错误,请重试...");
			return false;
		}
	});
}

function PreviewAttribute(post){
	$.ajax({
		url: '?mod=product.attribute.buy.preview&rand=' + Math.random(),
		type:'POST',
		processData: true,
		data:post,
		dataType:'json',
		success: function(info){
			if (info.html){
				Dialog(
					'预览', 
					info.html,
					function(){},
					function(){},
					function(){AttributeEvent();},
					'应用',
					'返回'
				);
			}
		},
		error:function(info){
			UnDialog();
			alert('错误', "网络传输错误,请重试...");
			return false;
		}
	});
}


function AttributeEvent(){
$('*[type="attr-value"]').click(function(){

	if ($(this).attr('disabled')==1){
		return false;
	}

	var select = $(this).attr('select');

	var listBox = $(this).parents('.right').eq(0);
	var selectedBox = listBox.find('*[type="attr-value"][select="1"]');
	if (selectedBox.length > 0){
		DoUnSelect(selectedBox[0]);
	}

	if (select == 1){
		DoUnSelect(this);
	}else{
		DoSelect(this);
	}

	function DoSelect(obj){
		$(obj).addClass('select');
		$(obj).attr('select', 1);
		$(obj).append('<i></i>');

		$(obj).siblings('input').val($(obj).attr('value_id'));
		$(obj).siblings('input').attr('append', $(obj).attr('append'));
		$(obj).siblings('input').attr('attr_value_name', $(obj).attr('value_name'));

		DoDisabledAll();
		AppendMoney();
	}

	function DoUnSelect(obj){
		$(obj).removeClass('select');
		$(obj).attr('select', 0);
		$(obj).find('i').remove();

		$(obj).siblings('input').val('');
		$(obj).siblings('input').attr('append', '');
		$(obj).siblings('input').attr('attr_value_name', '');

		DoUnDisabled($(obj).attr('about'));
		DoDisabledAll();
		AppendMoney();
	}

	function DoDisabledAll(){
		var allSelectedBox = listBox.find('*[type="attr-value"][select="1"]');
		for (var i = 0; i < allSelectedBox.length; i++){
			var selectedBox = allSelectedBox.eq(i);
			var about = selectedBox.attr('about');
			DoDisabled(about);
		}
	}

	function DoDisabled(about){
		if (about){
			var aboutList = about.split(',');
			for (var i = 0; i < aboutList.length; i++){
				var valueBox = $('#attr-val-'+aboutList[i]);
				if (valueBox.length > 0 && valueBox.attr('disabled')!= 1){
					valueBox.attr('disabled', 1);
					valueBox.addClass('disabled');
				}
			}
		}
	}

	function DoUnDisabled(about){
		if (about){
			var aboutList = about.split(',');
			for (var i = 0; i < aboutList.length; i++){
				var valueBox = $('#attr-val-'+aboutList[i]);
				if (valueBox.length > 0 && valueBox.attr('disabled')== 1){
					valueBox.attr('disabled', 0);
					valueBox.removeClass('disabled');
				}
			}
		}
	}
});

$('input[name^="attr_store"]').blur(function(){
	$(this).attr('attr_value_name', $(this).val());
	AppendMoney();
});

$('select[name^="attr_store"]').change(function(){
	$(this).attr('attr_value_name', $(this).find('option[selected]').attr('value_name'));
	$(this).attr('append', $(this).find('option[selected]').attr('append'));
	AppendMoney();
});

$('*[atype="attr-switch"]').click(function(){
	var switchList = $(this).attr('switch').split(',');
	var attrBox = $(this).parents('*[type=attr-box]');

	if ($(this).attr('checked')){
		for (var i = 0;i < switchList.length; i++){
			$('#attr-box-'+switchList[i]).show().attr('disable', 0);
		}

		attrBox.attr('disable', 1);
		attrBox.find('.color,.image,.textblock').addClass('disabled').attr('disabled', 1);
		attrBox.find('select,input[type=text]').attr('disabled', true).attr('disabled', 1);
	}else{
		for (var i = 0;i < switchList.length; i++){
			$('#attr-box-'+switchList[i]).hide().attr('disable', 1);
		}

		attrBox.attr('disable', 0);
		attrBox.find('.color,.image,.textblock').removeClass('disabled').attr('disabled', 0);
		attrBox.find('select,input[type=text]').attr('disabled', false).attr('disabled', 0);
	}

	AppendMoney();
});

function AppendMoney(){
	var allAttrBox = $('*[type="attr-box"]');

	var desc = [];
	var appendTotal = 0;
	allAttrBox.each(function(){
		if ($(this).attr('disable')==1){
			return;
		}

		var store = $(this).find('*[name^="attr_store"]');

		if ($(this).attr('atype')!='textgroup'){
			if (store.val() !=''){
				var append = store.attr('append');
				append = parseFloat(append);
				append = isNaN(append) ? 0 : append;
				appendTotal += append;

				desc[desc.length] = store.attr('attr_name') + ':' + store.attr('attr_value_name');
			}
		}else{
			var groupBox = $(this).find('.textgroup-box');
			var groupDesc = [];
			groupBox.find('*[name^="attr_store"]').each(function(){
				if ($(this).val() !=''){
					var append = $(this).attr('append');
					append = parseFloat(append);
					append = isNaN(append) ? 0 : append;
					appendTotal += append;

					groupDesc[groupDesc.length] = $(this).attr('value_name') + ':' + $(this).val();
				}
			});

			if (groupDesc.length > 0){
				desc[desc.length] = store.attr('attr_name') + ':(' + groupDesc.join(',') + ')';
			}
		}
	});

	if (desc.length>0){
		$('.view-selected-attribute').html(desc.join(','));
	}
	else{
		$('.view-selected-attribute').empty();
	}

	var money = $('span[type="money"]');
	for (var i = 0; i < money.length; i++){
		var m = money.eq(i).attr('value');
		m = parseFloat(m);
		m = isNaN(m) ? 0 : m;

		money.eq(i).html(FormatMoney(appendTotal+m));
	}
}
}




function AttributeEventNoLimit(){
$('*[type="attr-value"]').click(function(){

	if ($(this).attr('disabled')==1){
		return false;
	}

	var select = $(this).attr('select');

	var listBox = $(this).parents('.right').eq(0);
	var selectedBox = listBox.find('*[type="attr-value"][select="1"]');
	if (selectedBox.length > 0){
		DoUnSelect(selectedBox[0]);
	}

	if (select == 1){
		DoUnSelect(this);
	}else{
		DoSelect(this);
	}

	function DoSelect(obj){
		$(obj).addClass('select');
		$(obj).attr('select', 1);
		$(obj).append('<i></i>');

		$(obj).siblings('input').val($(obj).attr('value_id'));
		$(obj).siblings('input').attr('append', $(obj).attr('append'));
		$(obj).siblings('input').attr('attr_value_name', $(obj).attr('value_name'));

		DoDisabledAll();
		AppendMoney();
	}

	function DoUnSelect(obj){
		$(obj).removeClass('select');
		$(obj).attr('select', 0);
		$(obj).find('i').remove();

		$(obj).siblings('input').val('');
		$(obj).siblings('input').attr('append', '');
		$(obj).siblings('input').attr('attr_value_name', '');

		DoUnDisabled($(obj).attr('about'));
		DoDisabledAll();
		AppendMoney();
	}

	function DoDisabledAll(){
		var allSelectedBox = listBox.find('*[type="attr-value"][select="1"]');
		for (var i = 0; i < allSelectedBox.length; i++){
			var selectedBox = allSelectedBox.eq(i);
			var about = selectedBox.attr('about');
			DoDisabled(about);
		}
	}

	function DoDisabled(about){
		if (about){
			var aboutList = about.split(',');
			for (var i = 0; i < aboutList.length; i++){
				var valueBox = $('#attr-val-'+aboutList[i]);
				if (valueBox.length > 0 && valueBox.attr('disabled')!= 1){
					valueBox.attr('disabled', 1);
					valueBox.addClass('disabled');
				}
			}
		}
	}

	function DoUnDisabled(about){
		if (about){
			var aboutList = about.split(',');
			for (var i = 0; i < aboutList.length; i++){
				var valueBox = $('#attr-val-'+aboutList[i]);
				if (valueBox.length > 0 && valueBox.attr('disabled')== 1){
					valueBox.attr('disabled', 0);
					valueBox.removeClass('disabled');
				}
			}
		}
	}
});

$('input[name^="attr_store"]').blur(function(){
	$(this).attr('attr_value_name', $(this).val());
	AppendMoney();
});

$('select[name^="attr_store"]').change(function(){
	$(this).attr('attr_value_name', $(this).find('option[selected]').attr('value_name'));
	$(this).attr('append', $(this).find('option[selected]').attr('append'));
	AppendMoney();
});

$('*[atype="attr-switch"]').click(function(){
	var switchList = $(this).attr('switch').split(',');
	var attrBox = $(this).parents('*[type=attr-box]');

	if ($(this).attr('checked')){
		for (var i = 0;i < switchList.length; i++){
			$('#attr-box-'+switchList[i]).show().attr('disable', 0);
		}

		attrBox.attr('disable', 1);
		attrBox.find('.color,.image,.textblock').addClass('disabled').attr('disabled', 1);
		attrBox.find('select,input[type=text]').attr('disabled', true).attr('disabled', 1);
	}else{
		for (var i = 0;i < switchList.length; i++){
			$('#attr-box-'+switchList[i]).hide().attr('disable', 1);
		}

		attrBox.attr('disable', 0);
		attrBox.find('.color,.image,.textblock').removeClass('disabled').attr('disabled', 0);
		attrBox.find('select,input[type=text]').attr('disabled', false).attr('disabled', 0);
	}

	AppendMoney();
});

function AppendMoney(){
	var allAttrBox = $('*[type="attr-box"]');

	var desc = [];
	var appendTotal = 0;
	allAttrBox.each(function(){
		if ($(this).attr('disable')==1){
			return;
		}

		var store = $(this).find('*[name^="attr_store"]');

		if ($(this).attr('atype')!='textgroup'){
			if (store.val() !=''){
				var append = store.attr('append');
				append = parseFloat(append);
				append = isNaN(append) ? 0 : append;
				appendTotal += append;

				desc[desc.length] = store.attr('attr_name') + ':' + store.attr('attr_value_name');
			}
		}else{
			var groupBox = $(this).find('.textgroup-box');
			var groupDesc = [];
			groupBox.find('*[name^="attr_store"]').each(function(){
				if ($(this).val() !=''){
					var append = $(this).attr('append');
					append = parseFloat(append);
					append = isNaN(append) ? 0 : append;
					appendTotal += append;

					groupDesc[groupDesc.length] = $(this).attr('value_name') + ':' + $(this).val();
				}
			});

			if (groupDesc.length > 0){
				desc[desc.length] = store.attr('attr_name') + ':(' + groupDesc.join(',') + ')';
			}
		}
	});

	if (desc.length>0){
		$('.view-selected-attribute').html(desc.join(','));
		$('#s_attribute').val('');
	}
	else{
		$('.view-selected-attribute').empty();
		var title=$('.view-selected-attribute').attr('title');
		$('.view-selected-attribute').html(title);
		$('#s_attribute').val('noselect');
	}

	var money = $('span[type="money"]');
	for (var i = 0; i < money.length; i++){
		var m = money.eq(i).attr('value');
		m = parseFloat(m);
		m = isNaN(m) ? 0 : m;

		money.eq(i).html(FormatMoney(appendTotal+m));
	}
}
}