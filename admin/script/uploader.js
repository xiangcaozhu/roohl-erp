function FileQueueError(file, errorCode, message)  {
	switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
			alert("You have attempted to queue too many files.\n" + (message === 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));
			return;
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			alert("The file you selected is too big.");
			return;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			alert("The file you selected is empty.  Please select another file.");
			return;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			alert("The file you choose is not an allowed file type.");
			return;
		default:
			alert("An error occurred in the upload. Try again later.");
			return;
	}
}

function UploadError(file, errorCode, message) {
	if (errorCode === SWFUpload.UPLOAD_ERROR.FILE_CANCELLED) {
		return;
	}
			
	switch (errorCode) {
	case SWFUpload.UPLOAD_ERROR.MISSING_UPLOAD_URL:
		alert("There was a configuration error.  You will not be able to upload a resume at this time.");
		return;
	case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
		alert("You may only upload 1 file.");
		return;
	case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
	case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
		break;
	default:
		alert("An error occurred in the upload. Try again later.");
		return;
	}

	switch (errorCode) {
	case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
		progress.setStatus("Upload Error");
		break;
	case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
		progress.setStatus("Upload Failed.");
		break;
	case SWFUpload.UPLOAD_ERROR.IO_ERROR:
		progress.setStatus("Server (IO) Error");
		break;
	case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
		progress.setStatus("Security Error");
		break;
	case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
		progress.setStatus("Upload Cancelled");
		break;
	case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
		progress.setStatus("Upload Stopped");
		break;
	}
}

var swfConfig = {
	upload_url: "?mod=tool.upload",
	file_post_name: "file",
	file_size_limit : "100 MB",
	file_types : "*.jpeg;*.jpg;*.png;*.gif",
	file_types_description : "All Files",
	file_upload_limit : "0",
	file_queue_limit : "1",

	swfupload_loaded_handler : function(){},
	file_dialog_start_handler: function(){
		this.cancelUpload();
	},

	file_queued_handler : function(file){
		$('#swfuploader_list_file').html(file.name);
	},

	file_queue_error_handler : FileQueueError,
	file_dialog_complete_handler : function(numFilesSelected, numFilesQueued){},

	upload_progress_handler : function(file, bytesLoaded, bytesTotal){},

	upload_error_handler : UploadError,
	upload_success_handler : function(file, serverData){},

	upload_complete_handler : function(){},

	button_placeholder_id : "swfuploader_list",
	button_image_url : "image/uploader_bg.png",
	button_width: 70,
	button_height: 20,
	//button_text: '<span class="theFont">上传</span>',
	//button_text_style: ".theFont {font-size: 12px;color:blue;}",
	button_text_left_padding: 15,
	button_text_top_padding: 0,
	button_cursor: SWFUpload.CURSOR.HAND,

	flash_url : "script/swfupload/swfupload.swf",
	debug: false
};