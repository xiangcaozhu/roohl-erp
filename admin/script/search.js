(function($){
//封包开始
////////////////////////////////////////////////////////查找
$.MiniSearch = function(){
	var A = this;

	A.hide = function (){
		$("var.MSearch_box[init=1]").find('.MS_lis[ms=2]').hide();
		$("var.MSearch_box[init=1]").find('.MS_pybox[ms=2]').hide();
		$("var.MSearch_box[init=1]").find('.MS_lis').attr("ms",2);
		$("var.MSearch_box[init=1]").find('.MS_pybox').attr("ms",2);
	}

	A.init = function (){////A.init 
		$("var.MSearch_box[init=0]").each(function(){
			var one = $(this);
			var AW = parseInt(one.attr("AW"));
			var DefaultboxW=0;
			if(AW==1){
				DefaultboxW = one.width();
			}

			one.css({"width":"1000px"})


			var Sobj = one.find("select");
			var Sopt = one.find("option");
			var Smod = one.attr("mod");
			var PYtrue = one.attr("py");
			    if(PYtrue){PYtrue=parseInt(PYtrue)}else{PYtrue=0;}
			var str = '<input class="data" type="hidden" id="'+Sobj.attr("name")+'" name="'+Sobj.attr("name")+'" value="0">';
				str +='<em style="float:left;margin-left:10px;color:#666666;font-style:normal;" class="MS_tit">'+one.attr("MSname")+'</em><em style="float:left;cursor:pointer;font-style:normal;padding-right:25px;overflow:hidden;" class="MS_now"></em>';
				
				if(PYtrue>0){
				str +='<em style="float:left;background:#D8D8D8;border:#181818 3px solid;border-bottom:0px;color:#000000;z-index:999;font-style:normal;" class="MS_pybox" ms="2">';
				str +='<p style="float:left;text-align:right;width:75px;padding-top:8px;font-size:12px;font-style:normal;" >拼音简写：</p>';
				str +='<input type="text" style="float:left;border:#000000 1px solid;height:20px;margin-top:4px;padding-left:5px;ime-mode:disabled;" class="MS_PY"></em>';
				str +='<em style="float:left;background:#FFFFFF;border:#181818 3px solid;border-top:0px;z-index:999;font-style:normal;" ms="2" class="MS_lis">';
				}else{
				str +='<em style="float:left;background:#FFFFFF;border:#181818 3px solid;z-index:999;font-style:normal;" ms="2" class="MS_lis">';
				}
			
			if(PYtrue>0){
				Sopt.each(function(i){
					var tmpOnes = $(this);
					if(tmpOnes.val()>-1){
					var act=0;if(tmpOnes.attr("selected")){act=1;}
					str+='<i op="0" style="float:left;border-top:#181818 1px solid;font-style:normal;" act="'+act+'" value="'+tmpOnes.val()+'" class="MS__no">';
					str+='<p style="display:none;">'+tmpOnes.attr("op")+'</p><p class="MS_biaoti">'+tmpOnes.text()+'</p></i>';
					}
				});
			}else{
				Sopt.each(function(i){
					var tmpOnes = $(this);
					if(tmpOnes.val()>-1){
					var act=0;if(tmpOnes.attr("selected")){act=1;}
					str+='<i op="0" style="float:left;border-top:#181818 1px solid;font-style:normal;" act="'+act+'" value="'+tmpOnes.val()+'" class="MS__no">';
					str+='<p class="MS_biaoti">'+tmpOnes.text()+'</p></i>';
					}
				});
			}
			
			str+='</em>';
			one.html(str);


		
			var selectedObj = one.find("[act=1]");
			if(selectedObj.length>0){
					var MS_biaoti = selectedObj.find(".MS_biaoti").text();
					one.find("input.data").val(selectedObj.attr("value"));
					one.find("em.MS_now").text(MS_biaoti);
					
					selectedObj.attr('class', 'MS_act');
					selectedObj.css({"background":"#000000","color":"#FFFFFF","cursor":"default"});

			}


			var boxH = one.height();
			var lineH = one.find('.MS_tit').height();
			var lineP = parseInt((boxH - lineH)/2);
			var linePS = boxH;
			var lineHH = boxH-lineP;


			var lineW = 0;
			one.find('i').each(function(i){
				if($(this).width()>lineW){lineW=$(this).width();}
				
				$(this).mouseover(function(){if($(this).attr('class')!="MS_act"){$(this).css({"background":"#B8B8B8","color":"#000","cursor":"pointer"});}});
				$(this).mouseout(function(){if($(this).attr('class')!="MS_act"){$(this).css({"background":"#FFFFFF","color":"#000000","cursor":"default"});}});
				$(this).click(function(){
					one.find('i').attr('act', '0');one.find('i').attr('class', 'MS__no');
					one.find('i').css({"background":"#FFFFFF","color":"#000000","cursor":"default"});
					$(this).attr('act', '1');$(this).attr('class', 'MS_act');
					$(this).css({"background":"#000000","color":"#FFFFFF","cursor":"default"});
					
					var MS_biaoti = $(this).find(".MS_biaoti").text();
					one.find('.MS_now').text(MS_biaoti);
					one.find('input.data').val($(this).attr("value"));
					
					if(PYtrue>0){
					one.find('.MS_PY').val("");
					one.find('.MS_lis').find("i").attr("op",1);
					one.find('.MS_lis').find("i").show();
					one.find('.MS_pybox').attr('ms',2);
					}

					
					one.find('.MS_lis').attr('ms',2);
					
					if(Sobj.attr("action")){
						eval(Sobj.attr("action"));
					}
					//one.find('.MS_PY').hide();
					//one.find('.MS_lis').hide();
					//eval(Sobj.attr("action"));
				});
			});
			
			lineW = lineW;



			var Tcolor = one.attr("Tcolor");
			    if(!Tcolor){Tcolor="#888888";}
			var Tweight = one.attr("Tweight");
			    if(!Tweight){Tweight="normal";}
			
			one.find('.MS_tit').css({"color":Tcolor,"font-weight":Tweight});
			var titW = one.find('.MS_tit').width()+10;
			var linW = lineW+25;
			//var linW = lineW;
			var boxW = titW+linW;
			
			if(AW==1){
				boxW = DefaultboxW;
				lineW = boxW-titW-25;
			}
			
			one.css({"width":boxW+"px","position":"relative"});
			one.find('i').css({"width":boxW-35+"px","padding":"5px 0px 5px 10px"});
			
			var mh = $(window).height()-one.find('.MS_tit').offset().top-100;
			var th = one.find('i').eq(0).height()+11;
			    mht = parseInt(mh/th);
			var mhh = mht*th;
			
			var ah = one.find('i').length*th;
			if(mh>ah){mhh=ah;}
			
			var mt = boxH+3;
			
			var mtt = boxH+3;
			
			if(PYtrue>0){
			one.find('.MS_pybox').css({"top":mt+"px","left":"-1px","width":boxW-4+"px","height":"30px","position":"absolute"});
			one.find('.MS_PY').css({"width":boxW-95+"px"});
			mtt = boxH+36;
			}
			one.find('.MS_lis').css({"top":mtt+"px","left":"-1px","width":boxW-4+"px","height":mhh+"px","overflow":"scroll","overflow-x":"hidden","padding-right":"0px","position":"absolute"});



			var Tcolor = one.attr("Tcolor");if(Tcolor==""){Tcolor="#000000";}
			var Tweight = one.attr("Tweight");if(Tweight==""){Tweight="normal";}
			
			one.find('.MS_tit').css({"padding-top":lineP+"px","height":lineHH+"px"});
			
			one.find('.MS_now').css({"height":linePS+"px","width":lineW+"px","line-height":linePS+"px"});

			one.find('.MS_now').click(function(){
				if(PYtrue>0){
				one.find('.MS_pybox').show();one.find('.MS_pybox').attr('ms',1);
				one.find('.MS_PY').val("");
				one.find('.MS_lis').find("i").attr("op",0);
				one.find('.MS_lis').find("i").show();
				}
				one.find('.MS_lis').show();one.find('.MS_lis').attr('ms',1);
				


				var mh = $(window).height()-$(this).offset().top-100;
				var th = one.find('i').eq(0).height()+11;
				     mht = parseInt(mh/th);
					 mhh = mht*th;
				var ah = one.find('i').length*th;
				if(mh>ah){mhh=ah;}

				one.find('.MS_lis').css({"height":mhh+"px"});
			});




			if(PYtrue>0){
				one.find('.MS_PY').click(function(){
					one.find('.MS_pybox').attr('ms',0);
					one.find('.MS_lis').attr('ms',0);
				});
			
				one.find('.MS_PY').keyup(function(){
					one.find('.MS_lis').find("i").attr("op",0);
					one.find('.MS_lis').find("i").show();
					var Skey = $(this).val();
					var Skey = Skey.replace(/[^\a-\z\A-\Z]/g,'')
					     Skey=Skey.toUpperCase();
					     $(this).val(Skey);
					one.find('.MS_lis').find("p:contains('"+Skey+"')").parent("i").attr("op",1);
					one.find('.MS_lis').find("i[op=0]").hide();
				});
			}
			
			one.attr("init",1)


		
		});
		A.hide();
	}////A.init 



}
////////////////////////////////////////////////////////查找

//封包结尾
})(jQuery);

$(document).ready(function(){
	var MSearch = new $.MiniSearch();
	MSearch.init();
//点击屏幕关闭
$().click(function(){MSearch.hide();});
//点击屏幕关闭

});








