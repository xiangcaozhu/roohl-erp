var userAgent = navigator.userAgent.toLowerCase();
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);

function DateCheck(y,m,d){
	var  date =  new  Date(y, m-1, d);

	if (date.getFullYear() == y && ((date.getMonth()+1) == m) && date.getDate() == d){
		return true;
	}else{
		return false;
	}
}

function GetFileExt(name){
	return String(name.match(/\.\w{1,4}$/gi)).replace('.', '').toLowerCase();
}

function GetFilename(path){
	return path.match(/[^\/\\]+$/gi)[0];
}

String.prototype.sub = function(n){var r = /[^\x00-\xff]/g;if(this.replace(r, "mm").length <= n) return this;n = n - 3;var m = Math.floor(n/2);for(var i=m; i<this.length; i++){if(this.substr(0, i).replace(r, "mm").length>=n){return this.substr(0, i) +"...";}}return this;}

String.prototype.format = function(){
	var str = this;
	for(var i=0;i<arguments.length;i++){
		var arg = arguments[i];
		var re = new RegExp('\\{' + (i) + '\\}','gm');
		str = str.replace(re, arg);
		var re2 = new RegExp('\\%7B' + (i) + '\\%7D','gm');
		str = str.replace(re2, arg);
	}
	return str;
}
function   preg_quote(str)   
  {   
          var   reg   =   /(\$\&)/g;   
          var   str=   str.replace(reg,"\$\&")   
          return   str;   
  }

  function code(test)
  {
    var  str = ""
     for( i=0;    i<test.length; i++ )
     {
      temp = test.charCodeAt(i).toString(16);
      str    += "\\u"+ new Array(5-String(temp).length).join("0") +temp;
     }
return str;
  }

function fetchOffset(obj) {
	var left_offset = obj.offsetLeft;
	var top_offset = obj.offsetTop;
	while((obj = obj.offsetParent) != null) {
		left_offset += obj.offsetLeft;
		top_offset += obj.offsetTop;
	}
	return { 'left' : left_offset, 'top' : top_offset };
}

var SubStr=function(str,length){
    var a=str.match(/[^\x00-\xff]|\w{1,2}/g);
    return a.length<length?str:a.slice(0,length).join("")+"……";
}


  function   FormatMoney(number)   {   
	  if ( isNaN(number) ){
		return '0.00';
	  }
            if(number<0)   
                  return   '-'+FormatDollars(Math.floor(Math.abs(number)-0)   +   '')   +   FormatCents(Math.abs(number)   -   0);   
            else   
                  return   FormatDollars(Math.floor(number-0)   +   '')   +   FormatCents(number   -   0);   
            
                  }   
    
                  function   FormatDollars(number)   {   
                  if   (number.length<=   3)   
                          return   (number   ==   ''   ?   '0'   :   number);   
                  else   {   
                              var   mod   =   number.length%3;   
                              var   output   =   (mod   ==   0   ?   ''   :   (number.substring(0,mod)));
                              for   (i=0   ;   i<   Math.floor(number.length/3)   ;   i++)   {
                              if   ((mod   ==0)   &&   (i   ==0))
                                  output+=   number.substring(mod+3*i,mod+3*i+3);   
                              else
                                  output+=   ','   +   number.substring(mod+3*i,mod+3*i+3);   
                              }
                  return   (output);   
                    }
                }
    
              function   FormatCents(amount)   {   
                amount   =   Math.round(   (   (amount)   -   Math.floor(amount)   )   *100);   
                return   (amount<10   ?   '.0'   +   amount   :   '.'   +   amount);   
              }


function ShareDialog(html,callback){
	$('body').find('#mask').remove();
	$('body').find('.dialog').remove();

	$('body').append('<div id="mask"><iframe src="javascript:false" style="position:absolute; visibility:inherit;top:0px;left:0px;width:100%;height:100%;z-index:-1;   filter=\'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)\';"></div><div class="dialog"><div class="dialog_title">推荐</div><div class="block5"></div>'+html+'<div class="mf"><div class="mleft">评论：</div><div class="mright"><textarea id="share_description" style="width:300px;height:50px;"></textarea></div></div><div class="dialog_bottom"><input type="button" class="btn" id="dialog_ok" value="确定" /> <input type="button" class="btn" value="取消" onclick="UnDialog();" /></div></div>');

	$('#dialog_ok').click(callback);
}

function Dialog(title, html, callback,callback2,callback3,okTitle,cancelTitle,appendWidth){
	$('body').find('#mask').remove();
	$('body').find('.dialog').remove();

	okTitle = okTitle ? okTitle : '确定';
	cancelTitle = cancelTitle ? cancelTitle : '取消';

	var win = $('<div><div id="mask"></div><div class="dialog"><div class="dialog-title" ><span class="txt">'+title+'</span><a href="javascript:void(0);" class="close">关闭</a></div><div class="dialog-main"><div class="dialog-bottom"><input type="button" class="btn-1" id="dialog_ok" value="'+okTitle+'" /> <input type="button" class="btn-2" value="'+cancelTitle+'" id="dialog_cancel" /></div><div class="dialog-shadow"></div></div></div>');

	if (typeof(html) == 'object'){
		win.find('.dialog-bottom').before(html);
	}else{
		if(html.length>0){
			win.find('.dialog-bottom').before($(html));
		}else{
			win.find('.dialog-bottom').before($("<center>empty</center>"));
		}
	}

	$('body').append(win);

	if (appendWidth > 0){
		win.find('.dialog').css('width', (parseInt(win.find('.dialog').css('width'))+appendWidth).toString()+'px');
		win.find('.dialog').css('margin-left', (parseInt(win.find('.dialog').css('margin-left')) - appendWidth / 2).toString()+'px');
		win.find('.dialog-shadow').css('width', (parseInt(win.find('.dialog-shadow').css('width'))+appendWidth).toString()+'px');
	}

	if (callback3){
		callback3.call();
	}

	$('#dialog_ok').click(callback);
	$('#dialog_cancel').click(callback2);
	$('#dialog_cancel').click(function(){UnDialog();});
	$('.dialog .close').click(callback2);
	$('.dialog .close').click(function(){UnDialog();});

	if (!callback){
		$('#dialog_ok').click(function(){UnDialog();});
	}

//	$('.dialog').draggable({handle:'.dialog-title'});
}


function Dialog_1(title, html, callback,callback2,callback3,okTitle,cancelTitle,appendWidth){
	$('body').find('#mask').remove();
	$('body').find('.dialog').remove();

	okTitle = okTitle ? okTitle : '确定';
	cancelTitle = cancelTitle ? cancelTitle : '取消';

	var win = $('<div><div id="mask"></div><div class="dialog"><div class="dialog-title" ><span class="txt">'+title+'</span><a href="javascript:void(0);" class="close">关闭</a></div><div class="dialog-main"><div class="dialog-bottom"><input type="button" class="btn-11" id="dialog_ok" value="'+okTitle+'" /> <input type="button" class="btn-12" value="'+cancelTitle+'" id="dialog_cancel" /></div><div class="dialog-shadow"></div></div></div>');

	if (typeof(html) == 'object'){
		win.find('.dialog-bottom').before(html);
	}else{
		if(html.length>0){
			win.find('.dialog-bottom').before($(html));
		}else{
			win.find('.dialog-bottom').before($("<center>empty</center>"));
		}
	}

	$('body').append(win);

	if (appendWidth > 0){
		win.find('.dialog').css('width', (parseInt(win.find('.dialog').css('width'))+appendWidth).toString()+'px');
		win.find('.dialog').css('margin-left', (parseInt(win.find('.dialog').css('margin-left')) - appendWidth / 2).toString()+'px');
		win.find('.dialog-shadow').css('width', (parseInt(win.find('.dialog-shadow').css('width'))+appendWidth).toString()+'px');
	}

	if (callback3){
		callback3.call();
	}

	$('#dialog_ok').click(callback);
	$('#dialog_cancel').click(callback2);
	$('#dialog_cancel').click(function(){UnDialog();});
	$('.dialog .close').click(callback2);
	$('.dialog .close').click(function(){UnDialog();});

	if (!callback){
		$('#dialog_ok').click(function(){UnDialog();});
	}

//	$('.dialog').draggable({handle:'.dialog-title'});
}


function Win(title, html, callback,init){
	$('body').find('.dialog').remove();

	$('body').append('<div class="dialog"><div class="dialog_title">'+title+'</div><div class="block20"></div><div style="padding:0px 10px;">'+html+'</div><div class="dialog_bottom"><input type="button" class="button" id="dialog_ok" value="确定" /> <input type="button" class="button" value="取消" onclick="UnDialog();" /></div>');

	if (init){
		init.call();
	}

	$('#dialog_ok').click(callback);
}

function Loading(title,html){
	$('body').find('#mask').remove();
	$('body').find('.dialog').remove();

	var title = title ? title : '正在处理...';
	var html = html ? html : '<img src="image/rule-ajax-loader.gif" align="absmiddle"> Loading...';

	$('body').append('<div id="mask"></div><div class="dialog"><div class="dialog-title"><span class="txt">'+title+'</span></div><div class="dialog-main" style="text-align:center">'+html+'</div><div class="dialog-shadow"></div></div>');

	$('#mask').click(function(){
		$('.dialog-shadow')
			.animate({opacity: 0.2},{queue:false,duration:50})
			.animate({opacity: 0.9},{duration:50})
			.animate({opacity: 0.2},{duration:50})
			.animate({opacity: 0.9},{duration:50})
			.animate({opacity: 0.4},{duration:50});
	});
}

function UnLoading(){
	$('body').find('#mask').remove();
	$('body').find('.dialog').remove();
}

function UnDialog(){
	$('body').find('#mask').remove();
	$('body').find('.dialog').remove();
}

function isFloat(val){
var re = /^[0-9\.]+$/ig;
if (!re.test(val))
{
return true;
}else{
return false; 
} 
}


function htmlspecialchars(txt,space){

	
	txt = txt.replace(/&/g, '&amp;');
	txt = txt.replace(/"/g, '&quot;');
	txt = txt.replace(/'/g, '&#039;');
	txt = txt.replace(/</g, '&lt;');
	txt = txt.replace(/>/g, '&gt;');

	if (space){
		txt = txt.replace(/ /g, '&nbsp;');
	}

	return txt;
}

function clone(myObj)   
{   
    if(typeof(myObj) != 'object') return myObj;   
    if(myObj == null) return myObj;   
   
    var myNewObj = new Object();   
   
    for(var i in myObj)   
        myNewObj[i] = clone(myObj[i]);   
   
    return myNewObj;   
}

var __ColorLock = 0;
function ColorPanel(btn,input){
	var offset = $(btn).offset();
	var list = ["#000000","#993300","#333300","#003300","#003366","#000080","#333399","#333333","#800000","#FF6600","#808000","#008000","#008080","#0000FF","#666699","#808080","#FF0000","#FF9900","#99CC00","#339966","#33CCCC","#3366FF","#800080","#969696","#FF00FF","#FFCC00","#FFFF00","#00FF00","#00FFFF","#00CCFF","#993366","#C0C0C0","#FF99CC","#FFCC99","#FFFF99","#CCFFCC","#CCFFFF","#99CCFF","#CC99FF","#FFFFFF"];

	var html = '<div class="color-panel clearfix">';

	for (var i = 0; i<list.length; i++){
		html += '<a class="color-panel-block" style="background-color:{0};" href="javascript:void(0);" color="{0}"></a>'.format(list[i]);
	}

	html += '</div>';

	var top = $(btn).height() + offset.top;
	var left = $(btn).width() + offset.left;

	$('body').find('.color-panel').remove();
	__ColorLock = 0;

	$('body').append(html);
	$('.color-panel').css('top', top);
	$('.color-panel').css('left', left);

	setTimeout(function(){
		__ColorLock = 1;
	}, 100);

	$('.color-panel-block').click(function(){
		input.value = $(this).attr('color');
		$('body').find('.color-panel').remove();
		__ColorLock = 0;
	});

	$(document).click(function(){
		if (__ColorLock == 1){
			$('body').find('.color-panel').remove();
			__ColorLock = 0;
		}
	});
}


function PageBar(page, total, onePage, offset, onclick){
	var totalPage = Math.ceil( total / onePage );
	
	if ( !totalPage ) {
			totalPage = 1;
	}

	if ( page > totalPage || !page ){
			page = 1;
	}

	var mid = Math.floor( offset / 2 );
	var last = offset - 1;
	var minPage = ( page - mid ) < 1 ? 1 : page - mid;
	var maxPage = minPage + last;

	if ( maxPage > totalPage ){
		maxPage = totalPage;
		minPage = maxPage - last;
		minPage = minPage < 1 ? 1 : minPage;
	}

	var numPageBar = "";

	if (minPage != 1){
		//numPageBar += "<a href=\"javascript:void(0);\">1</a>...";
	}

	for ( var i = minPage; i <= maxPage; i++ ){
		if ( i == page ){
			numPageBar += " <b>" + i + "</b> ";
		}else{
			numPageBar += ' <a href="javascript:void(0);" rel="'+i+'">' + i + '</a> ';
		}
	}

	if (maxPage != totalPage){
		numPageBar += '... <a href="javascript:void(0);" rel="'+totalPage+'">' + totalPage + '</a> ';
	}

	var nextPageBar = "";
	if ( page < totalPage ){
		var nextPage = page + 1;
		nextPageBar = '<a href=\"javascript:void(0);\" rel="'+nextPage+'">Next</a>';
	}

	return numPageBar + nextPageBar;
}

(function($) {   
$.fn.SortDom = function(fetch) {
	var num = this.length;
	var list = [];
	for( var i = 0; i < this.length; i++){
		list.push(this.eq(i));
	}

	for(var n = 0 ; n < num; n++){
		for( var i = 0; i < list.length; i++){
			if (i == list.length - 1)
				break;

			var o1 = list[i];
			var o2 = list[i+1];

			if (parseInt(fetch.call(o1)) < parseInt(fetch.call(o2))){
				list[i] = o2;
				list[i+1] = o1;

				o1.before(o2);
			}
		}
	}
};
})(jQuery);

function dump(arr,level) {
var dumped_text = "";
if(!level) level = 0;

//The padding given at the beginning of the line.
var level_padding = "";
for(var j=0;j<level+1;j++) level_padding += "&nbsp;&nbsp;&nbsp;&nbsp;";
if (typeof(value) != 'function')
{
if(typeof(arr) == 'object') { //Array/Hashes/Objects
 for(var item in arr) {
  var value = arr[item];
 
  if (typeof(value) != 'function')
  {
  if(typeof(value) == 'object' && level<3) { //If it is an array,
   dumped_text += level_padding + "'" + item + "'&nbsp;...<br>";
   dumped_text += dump(value,level+1);
  } else {
   dumped_text += level_padding + "'" + item + "'&nbsp;=>&nbsp;\"" + value + "\"<br>";
  }
 }
 }
} else { //Stings/Chars/Numbers etc.
 dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
}
}
return dumped_text;
}


SetCookie = function(name,value)
{
  var Days = 1;
  var exp  = new Date();
  exp.setTime(exp.getTime() + Days*24*60*60*1000);
  document.cookie = name + "="+ escape(value);
};

GetCookie = function(name)
{
  var arr = document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));
  if(arr != null) return unescape(arr[2]); return null;
};

DelCookie = function(name)
{
  var exp = new Date();
  exp.setTime(exp.getTime() - 1);
  var cval=getCookie(name);
  if(cval!=null) document.cookie=name +"="+cval+";expires="+exp.toGMTString();
};

function Thumb(obj, width){
	if(obj.width > width){
		obj.width = width;
	}
}