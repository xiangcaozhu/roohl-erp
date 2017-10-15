var __GlobalShopImageCategoryPath = [];
var __GlobalShopImageCategoryId = 0;
var __GlobalShopImagePage = 1;

function ShopImageBox(callHandler){
	var html = '';
	html += '<div class="clearfix">';
	html += '	<div style="float:left;margin-right:-180px;padding-bottom:10px;width:180px;"><div id="image_category_tree"></div></div>';
	html += '	<div style="margin-left:180px;padding-left:5px;">';
	html +='		<div id="image_box_list" style="height:255px;overflow:auto;overflow-y:scroll;border:1px solid #ccc;padding:5px 0 5px 5px;"></div>';
	html += '			<div class="clearfix2" style="margin-top:5px;">';
	html += '				<div style="float:left;height:20px;"><span id="image_box_uploader_handler"></span></div>';
	html += '				<div style="float:left;"><button type="button" id="image_box_uploader_handler_btn"><span>开始上传</span></button></div>';
	html += '				<div style="float:right;font-size:11px;" id="image_box_page_bar"></div>';
	html += '			</div>';
	html += '			<div>';
	html +=	 '				<span id="image_box_uploader_file"></span>&nbsp;&nbsp;&nbsp;';
	html += '				<span id="image_box_uploader_bar" style="height:20px;line-height:20px;display:none;">';
	html += '					<img src="image/rule-ajax-loader.gif" align="absmiddle">上传中...<span style="font-size:11px;"><span id="image_box_uploader_bar_per">0</span>%</span>';
	html += '				</span>';
	html += '			</div>';
	html += '	</div>';
	html += '</div>';

	var tree = null;
	var uploader = null;
	var categoryId = 0;

	Dialog( '商品图片库', html, CloseBox, CloseBox, OpenTree, '完成', '关闭', 200 );

	var swfUploaderConfig = {
		upload_url: "?mod=product.image.upload",
		file_post_name: "file",
		file_size_limit : "100 MB",
		file_types : "*.jpeg;*.jpg;*.png;*.gif",
		file_types_description : "All Files",
		file_upload_limit : "0",
		file_queue_limit : "1",

		swfupload_loaded_handler : function(){},
		file_dialog_start_handler: function(){HideBar();this.cancelUpload();},
		file_queued_handler : function(file){$('#image_box_uploader_file').html(file.name);},

		file_queue_error_handler : function(file, errorCode, message){alert('Upload Queue Error')},
		file_dialog_complete_handler : function(numFilesSelected, numFilesQueued){},
		upload_progress_handler : function(file, bytesLoaded, bytesTotal){$('#image_box_uploader_bar').show();var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);$('#image_box_uploader_bar_per').html(percent);},

		upload_error_handler : function(file, errorCode, message){alert('Upload Error')},
		upload_success_handler : function(file, serverData){HideBar();if(serverData=='1'){Load();}else{alert(serverData);}},
		upload_complete_handler : function(){},

		button_placeholder_id : "image_box_uploader_handler",button_image_url : "image/uploader_bg_image.png",button_width: 70,button_height: 20,button_text_left_padding: 15,button_text_top_padding: 0,button_cursor: SWFUpload.CURSOR.HAND,

		flash_url : "script/swfupload/swfupload.swf",
		debug: false
	};

	function CloseBox(){
		if (tree){
			tree.destroy();
		}

		if (uploader){
			uploader.destroy();
			uploader = null;
		}

		UnDialog();
	}

	function HideBar(){
		$('#image_box_uploader_bar').hide();
		$('#image_box_uploader_bar_per').html('0');
		$('#image_box_uploader_file').html('');
	}

	function Load(page){

		__GlobalShopImagePage = page;

		$('#image_box_list').empty();
		$('#image_box_list').html('<div><img src="image/rule-ajax-loader.gif" align="absmiddle">加载中...</div>');
		$.ajax({
			url:'?mod=product.image.json',
			data:{cid:categoryId, page:page, rand:Math.random()},
			dataType: 'json',
			success:function(data){
				$('#image_box_list').empty();
				if (data.total>0){
					for (var i = 0;i < data.list.length;i++){
						var info = data.list[i];
						var b = $('<div ref="{1}" style="cursor:pointer;float:left;width:90px;height:90px;text-align:center;border:1px solid #ccc;padding:2px;overflow:hidden;margin:0 5px 5px 0;"><div style="height:70px"><img src="{0}"></div>{2}</div>'.format(info.min_url, info.url, info.title));

						b.click(function(){
							callHandler.call(this,$(this).attr('ref'));
						});

						$('#image_box_list').append(b);
					}

					var pageBar = $(PageBar(page,data.total, 20, 3));

					$('#image_box_page_bar').empty();
					$('#image_box_page_bar').html(pageBar);

					$('#image_box_page_bar').find('a[rel]').click(function(){
						Load(parseInt($(this).attr('rel')));
					})
				}
			},
			error:function(){
			}
		});
	}

	function OpenTree(){

		setTimeout(function(){
			uploader = new SWFUpload(swfUploaderConfig);

			Load(__GlobalShopImagePage);

			$('#image_box_uploader_handler_btn').click(function(){
				if (!categoryId){
					alert('请选择分类');
					return;
				}

				uploader.addPostParam('cid', categoryId);
				uploader.startUpload();
			});

		}, 100);

		//Ext.onReady(function(){
		tree = new Ext.tree.TreePanel({
			el:'image_category_tree',
			height: 305,
			useArrows:true,
			autoScroll:true,
			animate:true,
			enableDD:true,
			containerScroll: true,
			rootVisible: false,
			frame: false,
			bodyStyle: 'border:1px solid #ccc;',
			root: new Ext.tree.AsyncTreeNode(),
			loader: new Ext.tree.TreeLoader({
				dataUrl: '?mod=product.image.category.json',
				preloadChildren: true,
				clearOnLoad: false
			})
		});

		tree.on('expandnode',function(node){
			if (node.childNodes.length>0){
				var pathList = __GlobalShopImageCategoryPath;
				var path = node.getPath();

				if ($.inArray(path,pathList)==-1){
					pathList[pathList.length] = node.getPath();
					__GlobalShopImageCategoryPath = pathList;
				}
			}
		});

		tree.on('collapsenode',function(node){
			if (node.childNodes.length>0){
				var pathList = __GlobalShopImageCategoryPath;
				var path = node.getPath();

				pathList = $.map(pathList, function(p){
					if (p.substring(0, path.length) == path)
						return null;
					else
						return p;
				});

				__GlobalShopImageCategoryPath = pathList;
			}
		});

		tree.getLoader().on('load',function(){
			var pathList = __GlobalShopImageCategoryPath;
			for(var i=0; i<pathList.length;i++){
				tree.expandPath(pathList[i]);
			}

			if (__GlobalShopImageCategoryId){
				var selectNode = tree.getNodeById(__GlobalShopImageCategoryId);
				if (selectNode){
					selectNode.select();
					categoryId =__GlobalShopImageCategoryId;
					Load(__GlobalShopImagePage);
				}
			}
		});

		tree.on('click',function(node){
			__GlobalShopImageCategoryId = node.id;
			__GlobalShopImagePage = 1;
			categoryId = node.id;
			Load(1);
		});

		tree.getRootNode().attributes.id = 0;
		tree.getRootNode().attributes.name = '根分类';

		tree.render();
		//});

	}
}