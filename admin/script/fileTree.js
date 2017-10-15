if(jQuery) (function($){
	$.extend($.fn, {
		fileTree: function(o, h) {
			// Defaults
			if( !o ) var o = {};
			if( o.root == undefined ) o.root = '/';
			if( o.script == undefined ) o.script = 'jqueryFileTree.php';
			if( o.folderEvent == undefined ) o.folderEvent = 'dblclick';
			if( o.expandSpeed == undefined ) o.expandSpeed= 500;
			if( o.collapseSpeed == undefined ) o.collapseSpeed= 500;
			if( o.expandEasing == undefined ) o.expandEasing = null;
			if( o.collapseEasing == undefined ) o.collapseEasing = null;
			if( o.multiFolder == undefined ) o.multiFolder = true;
			if( o.loadMessage == undefined ) o.loadMessage = 'Loading...';
			if( o.onlyDir == undefined ) o.onlyDir = 0;
			if( o.handlerEvent == undefined ) o.handlerEvent = 'click';

			if ( o.onlyDir ) o.folderEvent = 'dblclick';
			if ( o.onlyDir ) o.onlyDir = 1; else o.onlyDir = 0;			
			
			function showTree(c, t) {
				$(c).addClass('wait');
				$(".jqueryFileTree.start").remove();
				$.post(o.script+'&rand=' + Math.random(), { dir: t, only_dir:o.onlyDir }, function(data) {
					$(c).find('.start').html('');
					$(c).removeClass('wait').append(data);
					if( o.root == t ) $(c).find('UL:hidden').show(); else $(c).find('UL:hidden').slideDown({ duration: o.expandSpeed, easing: o.expandEasing });
					bindTree(c);
				});
			}
			
			function bindTree(t) {

				$(t).find('LI A').click(function(){
					$(this).parents('.jqueryFileTree').find('.focus').removeClass('focus');
					$(this).addClass('focus');
				});

				$(t).find('LI A').bind(o.handlerEvent, function() {
					if (!o.onlyDir){
						if ($(this).parent().hasClass('directory')){
							h('');
						}else{
							h($(this).attr('rel'));
						}

					}else if (o.onlyDir){
						h($(this).attr('rel'));
					}
				});

				$(t).find('LI A').bind(o.folderEvent, function() {
					if( $(this).parent().hasClass('directory') ) {
						if( $(this).parent().hasClass('collapsed') ) {
							// Expand
							if( !o.multiFolder ) {
								$(this).parent().parent().find('UL').slideUp({ duration: o.collapseSpeed, easing: o.collapseEasing });
								$(this).parent().parent().find('LI.directory').removeClass('expanded').addClass('collapsed');
							}
							$(this).parent().find('UL').remove(); // cleanup
							showTree( $(this).parent(), escape($(this).attr('rel').match( /.*\// )) );
							$(this).parent().removeClass('collapsed').addClass('expanded');
						} else {
							// Collapse
							$(this).parent().find('UL').slideUp({ duration: o.collapseSpeed, easing: o.collapseEasing });
							$(this).parent().removeClass('expanded').addClass('collapsed');
						}
					} else {
						//h($(this).attr('rel'));
					}
					return false;
				});
				// Prevent A from triggering the # on non-click events
				if( o.folderEvent.toLowerCase != 'click' ) $(t).find('LI A').bind('click', function() { return false; });
			}
			// Loading message
			$(this).html('<ul class="jqueryFileTree start"><li class="wait">' + o.loadMessage + '<li></ul>');
			// Get the initial file list
			showTree( $(this), escape(o.root) );
		
		}
	});
	
})(jQuery);


function OpenFileBox(path,onlyDir,call){

	if( onlyDir == undefined ) onlyDir = false;

	var html = '';
	html += '<div>';
	html += '	<div>起始: <span>'+path+'</span></div>';
	html += '	<div class="clearfix2" style="margin-bottom:5px">';
	html += '		<div style="float:left;">已选: <span>'+path+'</span><span style="font-weight:bold;color:green;" rel="selected_path"></span></div>';
	if (onlyDir){
		html += '		<div style="float:right;"><input type="text" class="input-text" rel="file_box_folder_name" style="width:30px;"> <button type="button" class="" rel="file_box_folder_btn"><span>新建文件夹</span></button></div>';
	}
	html += '	</div>';
	html += '	<div style="height:190px;overflow:auto;border:1px solid #ccc;"><div rel="file_box_tree"></div></div>';
	html += '</div>';

	var box = $(html);
	var selectedPath = path;
	var sel = '';

	Dialog( '浏览...', box, Handler, false, Init );

	function Handler(){
		call.call(this,sel);
		UnDialog();
	}

	function InitTree(){
		box.find('*[rel=file_box_tree]').empty();
		box.find('*[rel=file_box_tree]').fileTree({ root:path, script: '?mod=tool.fileTree', expandSpeed: 400, collapseSpeed: 400, multiFolder: true, onlyDir: onlyDir }, function(file) {
			selectedPath = file;
			var select = file.substr(path.length);
			sel = select;
			box.find('*[rel=selected_path]').html(select);
		});
	}

	function Init(){

		InitTree();

		box.find('*[rel=file_box_folder_btn]').click(function(){
			var name = $.trim(box.find('*[rel=file_box_folder_name]').val());

			if (name==''){
				alert('请输入文件夹名称');
				return false;
			}

			if (window.confirm('确定要在: '+selectedPath+' 下面建立文件夹: '+name+' 吗?')){
				box.find('*[rel=file_box_folder_name]').val('');

				if(!box.find('a[rel='+selectedPath+']').parent().hasClass('collapsed')) {
					box.find('a[rel='+selectedPath+']').trigger('dblclick');
				}

				$.ajax({
					url:'?mod=tool.createFolder&rand=' + Math.random(),
					type:'post',
					data:{path:selectedPath,name:name},
					success:function(info){
						if (info=='1'){
							if (box.find('a[rel='+selectedPath+']').length>0){
								box.find('a[rel='+selectedPath+']').trigger('dblclick');
							}else{
								InitTree();
							}
						}else{
							alert(info);
						}
					},
					error:function(){
						alert('网络错误,请重试');
					}
				});
			}
		
		});
	}
}