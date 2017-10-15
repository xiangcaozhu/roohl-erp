var swfuAttribute;
var swfuAttributeConfig = clone(swfConfig);

swfuAttributeConfig.upload_url = "?mod=product.attribute.buy.file.upload";
swfuAttributeConfig.file_post_name = "attr_file";
swfuAttributeConfig.file_queued_handler = function(file){
	$('#swfuploader_attribute_file').html(file.name);
};
swfuAttributeConfig.file_dialog_complete_handler = function(numFilesSelected, numFilesQueued){
	if (numFilesQueued>0){
		this.startUpload();
		$('#swfuploader_attribute_bar').show();
	}
};
swfuAttributeConfig.upload_progress_handler = function(file, bytesLoaded, bytesTotal){
	var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);
	$('#swfuploader_attribute_bar_per').html(percent);
};
swfuAttributeConfig.upload_success_handler =  function(file, serverData){
	if (serverData!="0"){
		eval("var serverInfo = "+serverData+";");
		if (serverInfo.error==null){
			var data = serverInfo.data;
			$('#attr_file_review').html('<img src="{0}" width="32" height="32" class="attribute-image" />'.format(data.file_url));
			$('#attr_file_review').attr('ext', data.ext);
			$('#attr_file_review').attr('file_url', data.file_url);
			$('#attr_file_review').attr('file_name', data.file_name);
		}else{
			alert('上传失败');
		}
	}else{
		$('#swfuploader_attribute_bar').hide();
		$('#swfuploader_attribute_bar_per').html(0);
		$('#swfuploader_attribute_file').html('');
		alert('上传失败');
	}
};

swfuAttributeConfig.upload_complete_handler = function(){
	$('#swfuploader_attribute_bar').hide();
	$('#swfuploader_attribute_bar_per').html(0);
	$('#swfuploader_attribute_file').html('');
};

swfuAttributeConfig.button_placeholder_id = 'swfuploader_attribute_btn';