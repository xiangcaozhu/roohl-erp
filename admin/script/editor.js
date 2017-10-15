var Editor = function(textAreaId){
	this.textAreaId = textAreaId;
	this.isIe = $.browser.msie;
	this.viewEditor = true;
	this.toolBar = true;
	this.submitBtn = false;
	this.otherBtn = '';
}

Editor.prototype.Init = function(){
	if ($('#'+this.textAreaId).length == 0){
		return false;
	}

	this.textArea = document.getElementById(this.textAreaId);

	if (this.viewEditor){
		this.InitIframe();
	}

	if (this.toolBar){
		this.InitToolBar();
	}

	this.status = 'code';

	var editor = this;
	$(this.textArea).parents('form').submit(function(){
		if (editor.status == 'view'){
			editor.textArea.value = editor.doc.body.innerHTML;
		}
		//editor.textArea.value = ParseUrl(editor.textArea.value);
	});
}

Editor.prototype.Value = function(){
		if (this.status == 'view'){
			return editor.doc.body.innerHTML;
		}else{
			return this.textArea.value;
		}
}

Editor.prototype.InitIframe = function(){
	var iframe = document.createElement('iframe');
	iframe.id = this.textAreaId + '_iframe';
	this.iframe = iframe;
	this.iframe.border = 0;
	this.iframe.frameBorder = 0;

	$(this.textArea).addClass('editor_area');

	$(this.textArea).after($(this.iframe));
	$(this.iframe).css('width',parseInt($(this.textArea).css('width').replace('px', '')) + 4);
	$(this.iframe).css('height',$(this.textArea).css('height'));
	$(this.iframe).css('border',$(this.textArea).css('border'));
	if (this.isIe){
		$(this.iframe).css('margin-top', '1px');
	}

	this.win = this.iframe.contentWindow;
	this.doc = this.iframe.contentWindow.document;

	this.parentForm = $(this.textArea).parents('form');
	this.parentFormAction = this.parentForm.attr('action');
	this.parentFormTarget = this.parentForm.attr('target');
	this.parentFormEnctype = this.parentForm.attr('enctype');
	this.parentFormEncoding = this.parentForm.attr('encoding');

	this.doc.open();
	this.doc.write('<style>*{padding:0px;margin:0px;font-family:"Lucida Grande",Tahoma,"Luxi Sans",Verdana,sans;font-size:12px;}body{padding:4px;background-color:'+$(this.textArea).css('background-color')+';}</style><body></body>');
	this.doc.close();

//	this.doc.body.contentEditable = true;
	this.doc.designMode = 'on';

	$(this.iframe).hide();
}

Editor.prototype.InitToolBar = function(){
	var imgBox = "";
	imgBox += '<div class="editor_box">';
	imgBox += '<p>图片地址:<br /><input size="30" in="img_url"></p>';
	imgBox += '<p><button btn="'+this.textAreaId+"_box"+'" ctype="img"> 确定 </button> <button btn="'+this.textAreaId+"_box"+'" ctype="close"> 取消 </button></p>';
	imgBox += '</div>';

	var linkBox = "";
	linkBox += '<div class="editor_box">';
	linkBox += '<p>链接地址:<input size="25" in="link_url"></p>';
	linkBox += '<p>链接文字:<input size="15" in="link_text"> (如留空就以地址为链接文字)</p>';
	linkBox += '<p><br /></p>';
	linkBox += '<p><button btn="'+this.textAreaId+"_box"+'" ctype="link"> 确定 </button> <button btn="'+this.textAreaId+"_box"+'" ctype="close"> 取消 </button></p>';
	linkBox += '</div>';

	var mediaBox = "";
	mediaBox += '<div class="editor_box">';
	mediaBox += '<p>文件地址:<input size="25" in="media_url"></p>';
	mediaBox += '<p>媒体类型:<label><input type="radio" value="flash" name="media_type" checked>Flash</label> <label><input type="radio" value="mp3" name="media_type">MP3</label><label> <input type="radio" value="avi" name="media_type">AVI</label></p>';
	//mediaBox += '<p>显示尺寸:宽:<input size="3" in="media_width"> 高:<input size="3" in="media_height"></p>';
	mediaBox += '<p>自动播放:<label><input type="radio" value="1" name="media_run">是</label> <label><input type="radio" value="0" name="media_run" checked>否</label></p>';
	mediaBox += '<p><button btn="'+this.textAreaId+"_box"+'" ctype="media"> 确定 </button> <button btn="'+this.textAreaId+"_box"+'" ctype="close"> 取消 </button></p>';
	mediaBox += '</div>';

	var html = '';

	html += '<div class="editor_tb">';

	if (this.viewEditor){
		html += '	<span class="editor_tb_right on"><a btn="'+this.textAreaId+"_btn"+'" type="switch_code" href="javascript:void(0);">代码编辑</a></span>';
		html += '	<span class="editor_tb_right"><a btn="'+this.textAreaId+"_btn"+'" type="switch_view" href="javascript:void(0);">可视化编辑</a></span>';
	}

	html += '	<span><a btn="'+this.textAreaId+"_btn"+'" type="bold" href="javascript:void(0);"><b>B</b></a></span>';
	html += '	<span><a btn="'+this.textAreaId+"_btn"+'" type="underline" href="javascript:void(0);"><u>U</u></a></span>';
	html += '	<span><a btn="'+this.textAreaId+"_btn"+'" type="italic" href="javascript:void(0);"><i>I</i></a></span>';
	html += '	<span><a btn="'+this.textAreaId+"_btn"+'" type="img" href="javascript:void(0);">Img</a>'+imgBox+'</span>';
	html += '	<span><a btn="'+this.textAreaId+"_btn"+'" type="link" href="javascript:void(0);">Link</a>'+linkBox+'</span>';
	html += '	<span><a btn="'+this.textAreaId+"_btn"+'" type="media" href="javascript:void(0);">媒体</a>'+mediaBox+'</span>';
	html += '	<div class="clear"></div>';
	html += '</div>';

	$(this.textArea).before(html);
	
	$('.editor_tb').css('width', parseInt($(this.textArea).css('width').replace('px', ''))+6)

	var editor = this;

	$('.editor_tb').find('button[btn='+this.textAreaId+'_box]').click(function(){
		var type = $(this).attr('ctype');

		switch (type){
			case 'img':
				var url = $(this).parents('.editor_box').find('input').attr('value');
				if (!url){
					break;
				}
				if (editor.status=='view'){
					editor.Insert('<img src="'+url+'" />',editor.__sel);
				}else{
					editor.Insert('[img]'+url+'[/img]',editor.__sel);
				}
				break;
			case 'link':
				var url = $(this).parents('.editor_box').find('input[in=link_url]').attr('value');
				var text = $(this).parents('.editor_box').find('input[in=link_text]').attr('value');
				if (!url){
					break;
				}
				if (editor.status=='view'){
					if(text){
						editor.Insert('<a href="'+url+'">'+text+'</a>',editor.__sel);
					}else{
						editor.Insert('<a href="'+url+'">'+url+'</a>',editor.__sel);
					}
				}else{
					if(text){
						editor.Insert('[url='+url+']'+text+'[/url]',editor.__sel);
					}else{
						editor.Insert('[url]'+url+'[/url]',editor.__sel);
					}
				}
				break;

			case 'close':
				$(this).parents('.editor_box').animate({width:'hide', height:'hide', opacity:'hide'},'fast');
				break;
		}

		if (type=='img'||type=='link'||type=='media'){
			$(this).parents('.editor_box').find('input[type="text"]').attr('value', '');
			$(this).parents('.editor_box').animate({width:'hide', height:'hide', opacity:'hide'},'fast');
		}
		return false;
	});

	$('.editor_tb>span>a[btn='+this.textAreaId+'_btn]').click(function(){
		var type = $(this).attr('type');

		switch (type)
		{
			case 'switch_code':
				$(editor.textArea).show();
				$(editor.iframe).hide();
				editor.status = 'code';
				editor.textArea.value = editor.doc.body.innerHTML;
				$(this).parent().addClass('on');
				$(this).parent().siblings('span>a[type=switch_view]').removeClass('on');
				break;
			case 'switch_view':
				$(editor.textArea).hide();
				$(editor.iframe).show();
				editor.status = 'view';
				editor.doc.body.innerHTML = editor.textArea.value;
				$(this).parent().addClass('on');
				$(this).parent().siblings('span>a[type=switch_code]').removeClass('on');
				break;

			case "bold":
			case "underline":
			case "italic":
					editor.Command(type);
			break;

			case 'img':
			case 'link':
			case 'media':
				if(editor.isIe){
					if(editor.status=='view'){
						editor.win.focus();
						editor.__sel = editor.doc.selection.createRange();
					}else{
						editor.textArea.focus();
						editor.__sel = document.selection.createRange();
					}
				}
				if ($(this).siblings('.editor_box').css('display')=='none'){
					// 动画
					$(this).siblings('.editor_box').animate({width:'show', height:'show', opacity:'show'},'fast',function(){
							if($(this).find('input[type=text]').length>0){
								$(this).find('input[type=text]').eq(0).focus();
							}else{
								$(this).focus();
							}
						});
				}else{
					// 动画
					$(this).siblings('.editor_box').animate({width:'hide', height:'hide', opacity:'hide'},'fast');
				}


			break;		
		}

		// 动画的时间差
		$('.editor_tb .editor_box').hide();

		$(this)[0].blur();
	});


	$('#'+this.textAreaId+ '_btn').click(function(){
		if (editor.status=='view'){
			editor.win.focus();
			editor.doc.execCommand('Bold', false, null);
			return false;
		}
	});
}

Editor.prototype.Command = function(type){
	if (this.status == 'view'){
		this.win.focus();
		this.doc.execCommand(type, false, null);
		return false;
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
		}
	}
}

Editor.prototype.WrapTag = function(tag,arg){
	var selection = this.GetSelection();
	if(arg !== false){
		var tagStart = '<' + tag + '=' + arg + '>';
	}else{
		var tagStart = '<' + tag + '>';
	}

	var tagClose = '</' + tag + '>';

	var string = tagStart + selection + tagClose;
	this.Insert(string);
}

Editor.prototype.Add = function(string){
	if (this.status == 'view'){
		this.doc.body.innerHTML += string;
	}else{
		this.textArea.focus();
		this.textArea.value += string;
	}
}

Editor.prototype.Insert = function(string,sel){
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
		this.textArea.focus();
		if(typeof this.textArea.selectionStart != 'undefined'){
			var prepos = this.textArea.selectionStart;
			this.textArea.value = this.textArea.value.substr(0,prepos) + string + this.textArea.value.substr(this.textArea.selectionEnd);

			this.textArea.selectionStart = prepos + string.length;
			this.textArea.selectionEnd = prepos + string.length;
		}else if(document.selection && document.selection.createRange){
			if (typeof sel == 'undefined'){
				var sel = document.selection.createRange();
			}
			sel.text = string.replace(/\r?\n/g, '\r\n');
			sel.select();
		}else{
			this.textArea.value += string;
		}
	}
}

Editor.prototype.InsertNodeAtSelection = function(text){
	this.iframe.focus();

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

Editor.prototype.AddRange = function(node){
	this.iframe.focus();
	var sel = this.win.getSelection();
	var range = this.doc.createRange();
	range.selectNodeContents(node);
	sel.removeAllRanges();
	sel.addRange(range);
}

Editor.prototype.GetSelection = function(){
	if(this.status=='view'){
		if(!this.isIe){
			selection = this.win.getSelection();
			this.win.focus();
			range = selection ? selection.getRangeAt(0) : editdoc.createRange();
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
		if(typeof this.textArea.selectionStart != 'undefined'){
			return this.textArea.value.substr(this.textArea.selectionStart, this.textArea.selectionEnd - this.textArea.selectionStart);
		}else if(document.selection && document.selection.createRange){
			return document.selection.createRange().text;
		}else if(window.getSelection){
			return window.getSelection() + '';
		}else{
			return false;
		}
	}
}


Editor.prototype.ReadNodes = function (root, toptag){
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
				html += readNodes(i, true);
			}
			if(toptag && !closed){
				html += "</" + root.tagName.toLowerCase() + ">";
			}
			break;

		case Node.TEXT_NODE:
			html = htmlspecialchars(root.data);
			break;
	}
	return html;
}

function Code2Html(code){
	code = HtmlEncode(code);
	code = code.replace(/ /ig, "&nbsp;");
	code = code.replace(/\r\n/ig, "<br />");
	code = code.replace(/\n/ig, "<br />");

	code = ParseUrl(code);

	code = code.replace(/\[(b|u|i)\]/ig,'<$1>');
	code = code.replace(/\[\/(b|u|i)\]/ig,'</$1>');

	code = code.replace(/\[img\]([^\[]*)\[\/img\]/ig,'<img src="$1" border="0" />');
	code = code.replace(/\[url\]([^\[]+)\[\/url\]/ig, '<a href="$1">'+'$1'+'</a>');
	code = code.replace(/\[f:([0-9]+)\]/ig,'<img src="/image/face/$1.gif" />');

	return code;
}

function Html2Code(html){

	html = html.replace("\r\n", "");
	html = html.replace("\n", "");

	html = html.replace(/<br[^>]*>/ig,'\n');
	html = html.replace(/<img[^>]*src=[\'\"\s]*[^\s\'\"]*\/image\/face\/([0-9]+)\.gif[^>]*>/ig,'[f:$1]');
	html = html.replace(/<img[^>]*src=[\'\"\s]*([^\s\'\"]+)[^>]*>/ig,'[img]'+'$1'+'[/img]');
	html = html.replace(/<a[^>]*href=[\'\"\s]*([^\s\'\"]*)[^>]*>(.+?)<\/a>/ig,'[url]'+'$1'+'[/url]');

	html = SearchTag('p', html,'HtmlP', 1);
	html = SearchTag('div', html,'HtmlSpan', 1);
	html = SearchTag('span', html,'HtmlSpan', 1);
	html = SearchTag('b', html,'HtmlB', 1);
	html = SearchTag('strong', html,'HtmlB', 1);
	html = SearchTag('i', html,'HtmlI', 1);
	html = SearchTag('em', html,'HtmlI', 1);
	html = SearchTag('u', html,'HtmlU', 1);

	html = html.replace(/<[^>]*?>/ig, '');
	html = html.replace(/&amp;/ig, '&');
	html = html.replace(/&lt;/ig, '<');
	html = html.replace(/&gt;/ig, '>');
	html = html.replace(/&nbsp;/ig, " ");

	return html;
}

function HtmlEncode(str){
	str = str.replace(/&/ig, "&amp;");
	str = str.replace(/</ig, "&lt;");
	str = str.replace(/>/ig, "&gt;");
	str = str.replace(/\x22/ig, "&quot;");

	return str;
}

function SearchTag(tagname,str,action,type){
	if(type == 2){
		var tag = ['[',']'];
	}else{
		var tag = ['<','>'];
	}

	var head = tag[0] + tagname;
	var head_len = head.length;
	var foot = tag[0] + '/' + tagname + tag[1];
	var foot_len = foot.length;
	var strpos = 0;
	
	do{
		var strlower = str.toLowerCase();
		var begin = strlower.indexOf(head,strpos);
		if(begin == -1){
			break;
		}
		var strlen = str.length;

		for(var i = begin + head_len; i < strlen; i++){
			if(str.charAt(i)==tag[1]) break;
		}
		if(i>=strlen) break;

		var firsttag = i;
		var style = str.substr(begin + head_len, firsttag - begin - head_len);

		var end = strlower.indexOf(foot,firsttag);
		if (end == -1) break;

		var nexttag = strlower.indexOf(head,firsttag);
		while(nexttag != -1 && end != -1){
			if(nexttag > end) break;
			end = strlower.indexOf(foot, end + foot_len);
			nexttag = strlower.indexOf(head, nexttag + head_len);
		}
		if(end == -1){
			strpos = firsttag;
			continue;
		}

		firsttag++;
		var findstr = str.substr(firsttag, end - firsttag);

		str = str.substr(0,begin) + eval(action)(style,findstr,tagname) + str.substr(end+foot_len);

		strpos = begin;

	}while(begin != -1);

	return str;
}

function HtmlP(style,code){
	if(style.indexOf('align=') != -1){
		style = Findvalue(style,'align=');
		code  = '[align=' + style + ']' + code + '[/align]';
	}else{
		code += "\n";
	}
	return code;
}

function HtmlSpan(style,code){
	var styles = [
		['align' , 1, 'align='],
		['align', 1 , 'text-align:'],
		['color' , 2 , 'color:'],
		['font' , 1 , 'font-family:'],
		['b' , 0 , 'font-weight:' , 'bold'],
		['i' , 0 , 'font-style:' , 'italic'],
		['u' , 0 , 'text-decoration:' , 'underline'],
		['strike' , 0 , 'text-decoration:' , 'line-through']
	];

	style = style.toLowerCase();

	for(var i=0;i<styles.length;i++){
		var begin = style.indexOf(styles[i][2]);
		if(begin == -1){
			continue;
		}
		var value = '';
		if(styles[i][1] < 2){
			value = Findvalue(style,styles[i][2]);
		}else{
			begin = style.indexOf('rgb',begin);
			if(begin == -1){
				continue;
			}else{
				value = WYSIWYD._colorToRgb(style.substr(begin,style.indexOf(')')-begin+1));
			}
		}
		if(styles[i][1] == 0){
			if(value == styles[i][3]){
				code = '[' + styles[i][0] + ']' + code + '[/' + styles[i][0] + ']';
			}
		}else{
			code = '[' + styles[i][0] + '=' + value + ']' + code + '[/' + styles[i][0] + ']';
		}
	}
	
	return code;
}

function HtmlB(style,code){
	code = "[b]"+code+"[/b]";
	return code;
}

function HtmlI(style,code){
	code = "[i]"+code+"[/i]";
	return code;
}

function HtmlU(style,code){
	code = "[u]"+code+"[/u]";
	return code;
}

function Findvalue(style,find){
	var firstpos = style.indexOf(find)+find.length;
	var len = style.length;
	var start = 0;
	for(var i=firstpos;i<len;i++){
		var t_char = style.charAt(i);
		if(start==0){
			if(t_char == '"' || t_char == "'"){
				start = i+1;
			} else if(t_char != ' '){
				start = i;
			}
			continue;
		}
		if(t_char=='"' || t_char=="'" || t_char==' ' || t_char==';'){
			break;
		}
	}
	return style.substr(start,i-start);
}

function ParseUrl(str){
	str = str.replace(/([^>=\]"'\/@]|^)((((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|ed2k|thunder|synacast):\/\/))([\w\-]+\.)*[:\.@\-\w\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!#]*)*)/ig, '$1[url]$2[/url]');
	return str;
}

if(typeof EditorRun == 'function'){
	EditorRun();
}