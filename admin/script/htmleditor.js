String.prototype.format = function(){var str = this;for(var i=0;i<arguments.length;i++){var re = new RegExp('\\{' + (i) + '\\}','gm');str = str.replace(re, arguments[i]);var re2 = new RegExp('\\%7B' + (i) + '\\%7D','gm');str = str.replace(re2, arguments[i]);}return str;}

var HtmlEditor = function(textAreaId){
	this.textAreaId = textAreaId;
	this.editorId = textAreaId + '_editor';
	this.isIe = $.browser.msie;
	this.viewEditor = true;
	this.toolBar = true;
	this.submitBtn = false;
	this.otherBtn = '';
	this.__ColorLock = 0;
	this.pluginBotton = {};
}

HtmlEditor.prototype.AddBotton = function(name,data){
	this.pluginBotton[name] = data;
}

HtmlEditor.prototype.Init = function(){
	if ($('#'+this.textAreaId).length == 0){
		return false;
	}

	this.textArea = $('#'+this.textAreaId);

	this.status = 'view';

	var editorHtml =		'<div class="editor" id="'+this.editorId+'">';
	editorHtml +=		'<div class="editor-tool"><table><tr></tr></table></div>';
	editorHtml +=		'<div class="editor-main"></div>';
	editorHtml +=		'</div>';

	this.textArea.before(editorHtml);

	this.editor = $('#'+this.editorId);
	this.ToolBar();
	this.editor.find('.editor-main').append(this.textArea);

	this.editor.find('.editor-main').height((parseInt(this.textArea.css('height').replace('px', ''))+6).toString()+"px");
	this.editor.find('.editor-main').width(this.textArea.css('width'));
	this.editor.width((parseInt(this.textArea.css('width').replace('px', ''))+4).toString()+"px");

	/******** Iframe ********/

	var iframe = document.createElement('iframe');
	iframe.id = this.textAreaId + '_iframe';
	this.iframe = iframe;
	this.iframe.border = 0;
	this.iframe.frameBorder = 0;

	this.textArea.after($(this.iframe));
	$(this.iframe).css('width',(parseInt(this.textArea.css('width').replace('px', ''))+4).toString()+"px");
	$(this.iframe).css('height',(parseInt(this.textArea.css('height').replace('px', ''))+4).toString()+"px");

	this.win = this.iframe.contentWindow;
	this.doc = this.iframe.contentWindow.document;

	this.doc.open();
	this.doc.write('<style>*{padding:0px;margin:0px;font-family:"Lucida Grande",Tahoma,"Luxi Sans",Verdana,sans;font-size:12px;}body{padding:4px;background-color:#fff;cursor:text;height:95%;}</style><body>{0}</body>'.format(this.textArea.val()));
	this.doc.close();
	this.doc.designMode = 'on';

	this.iframe = $(this.iframe);
	this.textArea.hide();

	var editor = this;
	this.textArea.parents('form').submit(function(){
		if (editor.status == 'view'){
			editor.textArea.val(editor.doc.body.innerHTML);
		}
	});

	return false;
}

HtmlEditor.prototype.Sync = function(){
	if (this.status == 'view'){
		this.textArea.val(this.doc.body.innerHTML);
	}
}

HtmlEditor.prototype.ToolBar = function(){
	var btnHtml = '<table class="editor-btn" cellspacing="0" cellpadding="0" btn="'+this.editorId+'_btn" btn-type="{3}" unselectable="on"><tr unselectable="on"><td class="editor-btn-left" unselectable="on"></td><td class="editor-btn-main" unselectable="on"><span style="background-position: {0} {1};{4}" title="{2}" unselectable="on"></span></td><td class="editor-btn-right" unselectable="on"></td></tr></table>';
	var splitHtml = '<span class="editor-split"></span>';

	this.editor.find('.editor-tool > table tr').append($('<td>'+btnHtml.format('0', '0', '粗体', 'bold')+'</td>'));
	this.editor.find('.editor-tool > table tr').append($('<td>'+btnHtml.format('-16px', '0', '斜体', 'italic')+'</td>'));
	this.editor.find('.editor-tool > table tr').append($('<td>'+btnHtml.format('-32px', '0', '下划线', 'underline')+'</td>'));

	this.editor.find('.editor-tool > table tr').append($('<td>'+splitHtml+'</td>'));
	this.editor.find('.editor-tool > table tr').append($('<td>'+btnHtml.format('-160px', '0', '字体颜色', 'forecolor')+'</td>'));
	this.editor.find('.editor-tool > table tr').append($('<td>'+btnHtml.format('-176px', '0', '背景颜色', 'backcolor')+'</td>'));

	this.editor.find('.editor-tool > table tr').append($('<td>'+splitHtml+'</td>'));
	this.editor.find('.editor-tool > table tr').append($('<td>'+btnHtml.format('-112px', '0', '左对齐', 'justifyleft')+'</td>'));
	this.editor.find('.editor-tool > table tr').append($('<td>'+btnHtml.format('-128px', '0', '居中对齐', 'justifycenter')+'</td>'));
	this.editor.find('.editor-tool > table tr').append($('<td>'+btnHtml.format('-144px', '0', '右对齐', 'justifyright')+'</td>'));
	
	this.editor.find('.editor-tool > table tr').append($('<td>'+splitHtml+'</td>'));
	this.editor.find('.editor-tool > table tr').append($('<td>'+btnHtml.format('-208px', '0', '插入链接', 'link')+'</td>'));
	this.editor.find('.editor-tool > table tr').append($('<td>'+btnHtml.format('0', '0', '插入图片', 'image', 'background:transparent url(../image/editor/picture.png) repeat-x scroll 0px 0px;')+'</td>'));

	for (k in this.pluginBotton){
		var inf = this.pluginBotton[k];

		if (inf=='|'){
			this.editor.find('.editor-tool > table tr').append($('<td>'+splitHtml+'</td>'));
		}else{
			this.editor.find('.editor-tool > table tr').append($('<td>'+btnHtml.format('0', '0', inf.text, k, 'background:transparent url('+inf.image+') repeat-x scroll 0px 0px;')+'</td>'));
		}
	}

	this.editor.find('.editor-tool > table tr').append($('<td>'+splitHtml+'</td>'));
	this.editor.find('.editor-tool > table tr').append($('<td>'+btnHtml.format('-192px', '0', '模式:可视化/代码', 'model')+'</td>'));

	$('.editor-btn').mouseover(function(){
		if ($(this).attr('focus')!=1){
			$(this).addClass('hover');
		}
	});

	$('.editor-btn').mouseout(function(){
		if ($(this).attr('focus')!=1){
			$(this).removeClass('hover');
		}
	});

	var editor = this;

	$('table[btn='+this.editorId+'_btn]').click(function(){
		var btn = $(this);
		var type = btn.attr('btn-type');

		if (editor.pluginBotton[type]){
			if (editor.pluginBotton[type]['handler']){
				editor.pluginBotton[type]['handler'].call();
			}
		}

		switch(type){
			case "bold":
			case "underline":
			case "italic":
			case "justifyleft":
			case "justifycenter":
			case "justifyright":
				editor.Command(type);
			break;

			case 'link':
				editor.SaveFocus();

				var dialog = '';
				dialog += '<table width="100%"><tr><td width="70">连接地址</td><td><input rtpe="text" in="link_url" style="width:180px;" value="http://" /></td></tr><tr><td width="">连接文字</td><td><input rtpe="text" in="link_text" style="width:120px;" /></td></tr></table>'; 
				editor.AddDialog('插入连接', dialog, function(){
					var link = editor.editor.find('input[in=link_url]').val();
					var text = editor.editor.find('input[in=link_text]').val();

					if (!link || link== '' || link == 'http://'){
						return;
					}

					if(text){
						editor.Insert('<a href="'+link+'">'+text+'</a>',editor.__sel);
					}else{
						editor.Insert('<a href="'+link+'">'+link+'</a>',editor.__sel);
					}

				});
			break;

			case 'image':
				editor.SaveFocus();

				var dialog = '';
				dialog += '<table width="100%"><tr><td width="70">图片地址</td><td><input rtpe="text" in="image_url" style="width:180px;" /></td></tr><tr><td width="">高度</td><td><input rtpe="text" in="image_height" style="width:50px;" /></td></tr><tr><td width="">宽度</td><td><input rtpe="text" in="image_width" style="width:50px;" /></td></tr></table>'; 
				editor.AddDialog('插入连接', dialog, function(){
					var link = editor.editor.find('input[in=image_url]').val();
					var height = editor.editor.find('input[in=image_height]').val();
					var width = editor.editor.find('input[in=image_width]').val();

					if (!link || link== ''){
						return;
					}

					editor.Insert('<img src="{0}" {1} {2}/>'.format(link, (height ? 'height="{0}"'.format(height) : ''), (width ? 'width="{0}"'.format(width) : '')),editor.__sel);
				});
			break;

			case 'forecolor':
			case 'backcolor':
				editor.ColorPanel(btn[0],function(color){editor.Command(type,color);});
			break;

			case 'model':
				if (btn.attr('focus')==1){
					editor.textArea.hide();
					editor.iframe.show();
					editor.doc.body.innerHTML = editor.textArea.val();
					btn.removeClass('hover');
					btn.removeClass('focus');
					btn.attr('focus', '');
					editor.status = 'view';
				}else{
					editor.textArea.show();
					editor.iframe.hide();
					editor.textArea.val(editor.doc.body.innerHTML);
					btn.removeClass('hover');
					btn.addClass('focus');
					btn.attr('focus', '1');
					editor.status = 'code';
				}
			break;
		}
	});
}

HtmlEditor.prototype.SaveFocus = function(){
	if(this.isIe){
		if(this.status=='view'){
			this.win.focus();
			this.__sel = this.doc.selection.createRange();
		}else{
			this.textArea[0].focus();
			this.__sel = document.selection.createRange();
		}
	}
 }

HtmlEditor.prototype.Command = function(type,arg){
	if (this.status == 'view'){
		// 在诡异的IE下面,触发this.win.focus();的空间必须是某些标签(a/button等等)  table就不能正确的取得焦点和选区
		this.win.focus();
		this.doc.execCommand(type, false, arg);
		return true;
	}else{
		switch (type){
			case 'bold':
				this.WrapTag('b',false);
				break;
			case 'underline':
				this.WrapTag('u',false);
				break;
			case 'italic':
				this.WrapTag('i',false);
				break;
			case 'justifyleft':
				this.WrapTag('align','left', 'div');
				break;
			case 'justifycenter':
				this.WrapTag('align','center', 'div');
				break;
			case 'justifyright':
				this.WrapTag('align','right', 'div');
				break;
			case 'forecolor':
				this.WrapTag('style',"color:"+arg+";", 'span');
				break;
			case 'backcolor':
				this.WrapTag('style',"background-color:"+arg+";", 'span');
				break;
		}
	}
}

HtmlEditor.prototype.WrapTag = function(attr,arg,tag){
	var selection = this.GetSelection();
	if(arg !== false){
		var tagStart = '<' + tag + ' ' + attr + '=' + arg + '>';
		var tagClose = '</' + tag + '>';
	}else{
		var tagStart = '<' + attr + '>';
		var tagClose = '</' + attr + '>';
	}

	var string = tagStart + selection + tagClose;
	this.Insert(string);
}

HtmlEditor.prototype.Insert = function(string,sel){
	if (this.status == 'view'){
		if (this.isIe){	  
			this.win.focus();
			if (typeof sel == 'undefined'){
				var sel = this.doc.selection.createRange();
			}
			sel.pasteHTML(string);
		}else{
			var fragment = this.doc.createDocumentFragment();
			var holder = this.doc.createElement('span');
			holder.innerHTML = string;

			while(holder.firstChild){
				fragment.appendChild(holder.firstChild);
			}

			this.InsertNodeAtSelection(fragment);
		}
	}else{
		this.textArea[0].focus();
		if(typeof this.textArea[0].selectionStart != 'undefined'){
			var prepos = this.textArea[0].selectionStart;
			this.textArea[0].value = this.textArea[0].value.substr(0,prepos) + string + this.textArea[0].value.substr(this.textArea[0].selectionEnd);

			this.textArea[0].selectionStart = prepos + string.length;
			this.textArea[0].selectionEnd = prepos + string.length;
		}else if(document.selection && document.selection.createRange){
			if (typeof sel == 'undefined'){
				var sel = document.selection.createRange();
			}
			sel.text = string.replace(/\r?\n/g, '\r\n');
			sel.select();
		}else{
			this.textArea[0].value += string;
		}
	}
}

HtmlEditor.prototype.InsertNodeAtSelection = function(text){
	this.iframe[0].focus();

	var sel = this.win.getSelection();
	var range = sel ? sel.getRangeAt(0) : this.doc.createRange();
	sel.removeAllRanges();
	range.deleteContents();

	var node = range.startContainer;
	var pos = range.startOffset;

	switch(node.nodeType){
		case Node.ELEMENT_NODE:
			if(text.nodeType == Node.DOCUMENT_FRAGMENT_NODE){
				selNode = text.firstChild;
			}else{
				selNode = text;
			}
			node.insertBefore(text, node.childNodes[pos]);
			this.AddRange(selNode);
			break;

		case Node.TEXT_NODE:
			if(text.nodeType == Node.TEXT_NODE){
				var text_length = pos + text.length;
				node.insertData(pos, text.data);
				range = editor.doc.createRange();
				range.setEnd(node, text_length);
				range.setStart(node, text_length);
				sel.addRange(range);
			}else{
				node = node.splitText(pos);
				var selNode;
				if(text.nodeType == Node.DOCUMENT_FRAGMENT_NODE){
					selNode = text.firstChild;
				}else{
					selNode = text;
				}
				node.parentNode.insertBefore(text, node);
				this.AddRange(selNode);
			}
			break;
	}
}

HtmlEditor.prototype.AddRange = function(node){
	this.iframe[0].focus();
	var sel = this.win.getSelection();
	var range = this.doc.createRange();
	range.selectNodeContents(node);
	sel.removeAllRanges();
	sel.addRange(range);
}

HtmlEditor.prototype.GetSelection = function(){
	if(this.status=='view'){
		if(!this.isIe){
			selection = this.win.getSelection();
			this.win.focus();
			range = selection ? selection.getRangeAt(0) : this.doc.createRange();
			return this.ReadNodes(range.cloneContents(), false);
		}else{
			var range = this.doc.selection.createRange();
			if(range.htmlText && range.text){
				return range.htmlText;
			}else{
				var htmltext = '';
				for(var i = 0; i < range.length; i++){
					htmltext += range.item(i).outerHTML;
				}
				return htmltext;
			}
		}
	}else{
		this.textArea[0].focus();
		if(typeof this.textArea[0].selectionStart != 'undefined'){
			return this.textArea[0].value.substr(this.textArea[0].selectionStart, this.textArea[0].selectionEnd - this.textArea[0].selectionStart);
		}else if(document.selection && document.selection.createRange){
			return document.selection.createRange().text;
		}else if(window.getSelection){
			return window.getSelection() + '';
		}else{
			return false;
		}
	}
}


HtmlEditor.prototype.ReadNodes = function (root, toptag){
	var html = "";
	var moz_check = /_moz/i;

	switch(root.nodeType){
		case Node.ELEMENT_NODE:
		case Node.DOCUMENT_FRAGMENT_NODE:
			var closed;
			if(toptag){
				closed = !root.hasChildNodes();
				html = '<' + root.tagName.toLowerCase();
				var attr = root.attributes;
				for(var i = 0; i < attr.length; ++i){
					var a = attr.item(i);
					if(!a.specified || a.name.match(moz_check) || a.value.match(moz_check)){
						continue;
					}
					html += " " + a.name.toLowerCase() + '="' + a.value + '"';
				}
				html += closed ? " />" : ">";
			}
			for(var i = root.firstChild; i; i = i.nextSibling){
				html += this.ReadNodes(i, true);
			}
			if(toptag && !closed){
				html += "</" + root.tagName.toLowerCase() + ">";
			}
			break;

		case Node.TEXT_NODE:
			html = root.data;
			break;
	}
	return html;
}

HtmlEditor.prototype.AddMask = function(){
	var height = this.editor.height();
	var html = $('<div class="editor-mask"></div>');
	this.editor.append(html.css('height', height+1));
}

HtmlEditor.prototype.AddDialog = function(title,content,okHandler,cancelHandler){
	this.AddMask();
	var html = $('<div class="editor-dialog"><div class="editor-dialog-head">{0}</div><div class="editor-dialog-main">{1}</div><div class="editor-dialog-bottom"><table class="editor-btn focus" cellspacing="0" cellpadding="0" style="float:right;" type="cancel"><tr><td class="editor-btn-left"></td><td class="editor-btn-main">&nbsp;取消&nbsp;</td><td class="editor-btn-right"></td></tr></table><table class="editor-btn focus" cellspacing="0" cellpadding="0" style="float:right;margin-right:5px;" type="ok"><tr><td class="editor-btn-left"></td><td class="editor-btn-main">&nbsp;确定&nbsp;</td><td class="editor-btn-right"></td></tr></table></div></div>'.format(title,content));

	if (okHandler){
		html.find('table[type=ok]').click(okHandler);
	}

	if (cancelHandler){
		html.find('table[type=cancel]').click(cancelHandler);
	}

	var editor = this;
	html.find('table[type=cancel]').click(function(){
		editor.RemoveDialog();
	});

	html.find('table[type=ok]').click(function(){
		editor.RemoveDialog();
	});

	var left = this.editor.width() / 2 - 180;
	this.editor.append(html.css('left', left).css('top', '40px'));
}

HtmlEditor.prototype.RemoveDialog = function(){
	this.editor.find('.editor-dialog').remove();
	this.editor.find('.editor-mask').remove();
}

HtmlEditor.prototype.ColorPanel = function(btn,handler){
	var offset = $(btn).offset();
	var list = ["#000000","#993300","#333300","#003300","#003366","#000080","#333399","#333333","#800000","#FF6600","#808000","#008000","#008080","#0000FF","#666699","#808080","#FF0000","#FF9900","#99CC00","#339966","#33CCCC","#3366FF","#800080","#969696","#FF00FF","#FFCC00","#FFFF00","#00FF00","#00FFFF","#00CCFF","#993366","#C0C0C0","#FF99CC","#FFCC99","#FFFF99","#CCFFCC","#CCFFFF","#99CCFF","#CC99FF","#FFFFFF"];

	var html = '<div class="editor-color-panel clearfix">';

	for (var i = 0; i<list.length; i++){
		html += '<a class="editor-color-panel-block" style="background-color:{0};" href="javascript:void(0);" color="{0}"></a>'.format(list[i]);
	}

	html += '</div>';

	var top = $(btn).height() + offset.top;
	var left = offset.left;

	$('body').find('.editor-color-panel').remove();
	this.__ColorLock = 0;

	$('body').append(html);
	$('.editor-color-panel').css('top', top);
	$('.editor-color-panel').css('left', left);

	var editor = this;
	setTimeout(function(){
		editor.__ColorLock = 1;
	}, 100);

	$('.editor-color-panel-block').click(function(){
		var color = $(this).attr('color');
		handler(color);
		$('body').find('.editor-color-panel').remove();
		editor.__ColorLock = 0;
	});

	$(document).click(function(){
		if (editor.__ColorLock == 1){
			$('body').find('.editor-color-panel').remove();
			editor.__ColorLock = 0;
		}
	});

	editor.iframe.focus(function(){
		if (editor.__ColorLock == 1){
			$('body').find('.editor-color-panel').remove();
			editor.__ColorLock = 0;
		}
	});
}

if(typeof EditorRun == 'function'){
	EditorRun();
}