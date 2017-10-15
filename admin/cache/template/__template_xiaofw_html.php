<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-11-25 17:05:33
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en"><head>
<title>信用卡分期邮购核心业务系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


<link rel="stylesheet" type="text/css" href="css/reset.css" media="all">
<link rel="stylesheet" type="text/css" href="css/boxes.css" media="all">
<link rel="stylesheet" type="text/css" href="css/menu.css" media="screen, projection">
<link rel="stylesheet" type="text/css" href="css/calendar-win2k-1.css">
<link rel="stylesheet" type="text/css" href="css/self.css">
<link rel="stylesheet" type="text/css" href="css/attribute.css">
<style>
*{font-family:'宋体'; margin:0px; padding:0px;}
#TopUser a{font-size:13px; color:#333333; text-decoration:none;}
#TopBox{position:absolute;left:0px;top:0px;width:100%;height:67px; background:url(img/topBG.gif);}
#LeftBox{position:absolute;left:0px;top:77px;width:160px; padding:0px 20px;height:auto; background:url(img/LeftBG.gif) repeat-y left top;}
#MainBox{position:absolute;left:200px;top:80px;height:auto; width:auto;overflow:scroll;overflow-x:hidden;}
</style>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie.css">
<![endif]-->

<!--[if !IE]>
<link rel="stylesheet" type="text/css" href="css/noie.css">
<![endif]-->


<script src="script/jquery-1.3.2.js"></script>
<script src="script/jquery-ui-1.7.1.js"></script>
<script src="script/common.js"></script>
<script language="javascript" type="text/javascript" src="script/attribute.js"></script>
</head>
<body>
<ol style=" position:absolute;left:0px;top:67px;width:100%;height:10px; background:url(img/Line.gif) repeat-x left center;"><div style=" background:url(img/Line.gif) no-repeat left top;float:left;width:200px;height:10px;"></div></ol><ol style=" position:absolute;left:0px;bottom:0px;width:200px;height:10px; background:url(img/Line.gif) repeat-y left bottom;"></ol>


<ol id="TopBox">
<div style="float:right;width:270px; padding-top:15px;">
<ul id="TopUser" style="float:left;width:270px;height:22px;font-size:13px;">[管理员：<font color="#990000"><?php echo $session['user_real_name']; ?></font>]　<a href="?mod=system.administrator.edit_s&id=<?php echo $session['user_id']; ?>" class="link-logout">修改密码</a> | <a href="?mod=logout" class="link-logout">退出系统</a></ul>
<ul style="float:left;font-size:13px;color:#333333;border:#D8D8D8 1px solid; background:#FFFFFF; padding:2px 10px;" id="TimerBox"></ul><script language=JavaScript>
var timerID = null;
var timerRunning = false;


function stopclock (){
if(timerRunning)
clearTimeout(timerID);
timerRunning = false;}

function startclock () {
stopclock();
showtime();}

function showtime () {
var now = new Date();

var day=now.getDay();  
var week;
var arr_week=new Array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
week=arr_week[day];



var hours = now.getHours();
var minutes = now.getMinutes();
var seconds = now.getSeconds()
var timeValue = "" +((hours >= 12) ? "下午 " : "上午 " )
timeValue += ((hours >12) ? hours :hours)
timeValue += ((minutes < 10) ? ":0" : ":") + minutes
timeValue += ((seconds < 10) ? ":0" : ":") + seconds
//document.clock.thetime.value = timeValue;
$("#TimerBox").html(getNowFormatDate()  +"　"+ week +"　"+ timeValue)
timerID = setTimeout("showtime()",1000);
timerRunning = true;}




function getNowFormatDate() 
{ 
var day = new Date(); 
var Year = 0; 
var Month = 0; 
var Day = 0; 
var CurrentDate = ""; 
//初始化时间 
//Year= day.getYear();//有火狐下2008年显示108的bug 
Year= day.getFullYear();//ie火狐下都可以 
Month= day.getMonth()+1; 
Day = day.getDate(); 
//Hour = day.getHours(); 
// Minute = day.getMinutes(); 
// Second = day.getSeconds(); 
CurrentDate += Year + "年"; 
if (Month >= 10 ) 
{ 
CurrentDate += Month + "月"; 
} 
else 
{ 
CurrentDate += "0" + Month + "日"; 
} 
if (Day >= 10 ) 
{ 
CurrentDate += Day ; 
} 
else 
{ 
CurrentDate += "0" + Day ; 
} 
return CurrentDate; 
}
showtime();
</SCRIPT>
</div>
<div style="float:left;"><img src="img/logo.png" alt="" /></div>
<div style="float:left;">


<ul id="nav">
			<?php
if ( $menu_list )
{
foreach ( $menu_list as $item1 )
{
?>
			<li <?php
if ( $item1['sub'] )
{
?>class="parent level0" parent="1"<?php
}
else
{
?>class="level0"<?php
}
?>>
				<a href="<?php
if ( $item1['path'] )
{
?>?mod=<?php echo $item1['path']; ?><?php
}
else
{
?>javascript:void(0);<?php
}
?>"><span><?php echo $item1['name']; ?></span></a>
				<?php
if ( $item1['sub'] )
{
?>
				<ul>
				<?php
if ( $item1['sub'] )
{
foreach ( $item1['sub'] as $item2 )
{
?>
					<li class="level1 <?php
if ( $item2['end'] )
{
?>last<?php
}
?> <?php
if ( $item2['sub'] )
{
?>parent<?php
}
?>" <?php
if ( $item2['sub'] )
{
?>parent="1"<?php
}
?>>
						<a href="<?php
if ( $item2['sub'] )
{
?>javascript:void(0);<?php
}
else
{
?>?mod=<?php echo $item2['path']; ?><?php
}
?>" class=""><span><?php echo $item2['name']; ?></span></a>
						<?php
if ( $item2['sub'] )
{
?>
						<ul>
						<?php
if ( $item2['sub'] )
{
foreach ( $item2['sub'] as $item3 )
{
?>
							<li class="level2 <?php
if ( $item3['end'] )
{
?>last<?php
}
?> <?php
if ( $item3['sub'] )
{
?>parent<?php
}
?>" <?php
if ( $item3['sub'] )
{
?>parent="1"<?php
}
?>>
								<a href="<?php
if ( $item3['sub'] )
{
?>javascript:void(0);<?php
}
else
{
?>?mod=<?php echo $item3['path']; ?><?php
}
?>" class=""><span><?php echo $item3['name']; ?></span></a>
								<?php
if ( $item3['sub'] )
{
?>
								<ul>
								<?php
if ( $item3['sub'] )
{
foreach ( $item3['sub'] as $item4 )
{
?>
									<li class="level2 <?php
if ( $item4['end'] )
{
?>last<?php
}
?>">
										<a href="?mod=<?php echo $item4['path']; ?>" class=""><span><?php echo $item4['name']; ?></span></a>
									</li>
								<?php
}
}
?>
								</ul>
								<?php
}
?>
							</li>
						<?php
}
}
?>
						</ul>
						<?php
}
?>
					</li>
				<?php
}
}
?>
				</ul>
				<?php
}
?>
			</li>
			<?php
}
}
?>

		</ul>
		
</div>

</ol>
<ol id="LeftBox">


<div style="float:left;">
		<div class="HY-content-header clearfix">
			<h3 class="icon-head head-categories">商品分类</h3>
			<div class="left">
				<!-- <button type="button" class="scalable" onclick="window.location='?mod=<?php echo $_GET['mod']; ?>';"><span>查看全部分类</span></button> -->
			</div>
		</div>

		<div style="margin-bottom:2px;margin-right:10px;" class="clearfix">
			<div class="left">
				<input name="tree_search" id="tree_search" value="" class="input-text" type="text" style="width:100px;"/>
			</div>
			<div class="right">
				<button type="button" class="" onclick="ExpandAll();">展开</button>
				<button type="button" class="" onclick="CollapseAll();">收起</button>
			</div>
		</div>
		<div id="tree-list" style="margin-right:10px;width:180px;"></div>

	</div>
	
	
	
	
</ol>


<ol id="MainBox">
	<?php echo $module; ?>
</ol>


















<div id="tpl_add_product" style="display:none; font-size:14px; ">
<table width="100%;" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><input type="text" id="-_-dialog_pid_name" value="" /></td>
  </tr>
  <tr>
    <td>&nbsp;<input type="hidden" id="-_-dialog_sku" value="" class="input-text"/>
</td>
  </tr>
</table>

</div>

</body>
</html>


<script language="JavaScript">
$(document).ready(function(){
	$('#grid_table tr').mouseover(function(){
		$(this).css('background-color', '#eee');
	});

	$('#grid_table tr').mouseout(function(){
		$(this).css('background-color', '');
	});

	$('.HY-grid tr').mouseover(function(){
		$(this).css('background-color', '#eee');
	});

	$('.HY-grid tr').mouseout(function(){
		$(this).css('background-color', '');
	});

	$('#nav > li[parent=1]').mouseover(function(){
		$(this).addClass('over');
		$(this).attr('in', 1);
	});

	$('#nav > li[parent=1]').mouseout(function(){
		var oo = this;
		$(this).attr('in', 0);
		setTimeout(function(){
			if ($(oo).attr('in')!=1){
				$(oo).removeClass('over');
				$(oo).attr('in', 0);
			}
		}, 100);
	});

	$('#nav > li > ul > li[parent=1]').mouseover(function(){
		$(this).addClass('over');
		$(this).attr('in', 1);
	});

	$('#nav > li > ul > li[parent=1]').mouseout(function(){
		var oo = this;
		$(this).attr('in', 0);
		setTimeout(function(){
			if ($(oo).attr('in')!=1){
				$(oo).removeClass('over');
				$(oo).attr('in', 0);
			}
		}, 100);
	});

	$('#nav > li > ul > li > ul > li[parent=1]').mouseover(function(){
		$(this).addClass('over');
		$(this).attr('in', 1);
	});

	$('#nav > li > ul > li > ul > li[parent=1]').mouseout(function(){
		var oo = this;
		$(this).attr('in', 0);
		setTimeout(function(){
			if ($(oo).attr('in')!=1){
				$(oo).removeClass('over');
				$(oo).attr('in', 0);
			}
		}, 100);
	});

	if (!$.browser.msie){
		$('form,select,input').attr('autocomplete', 'off');
	}
});
</script>





<script language="JavaScript">

$(document).ready(function(){
	$('#view-sku').click(function(){
		GlobalGetProduct();
	});
});

var productId = 0;

function GlobalGetProduct(){
	var html = $('#tpl_add_product').html().replace(/-_-/ig, '');
	Dialog('SKU查询',html,GlobalGetProductId,false,function(){
		var auto = new Ext.form.AutoCompleteField({
			applyTo: 'dialog_pid_name',
			hideTrigger:true,
			width:200,
			hiddenName:'dialog_pid',
			store:autoComplateProductStore,	
			mode: 'local',
			tpl:autoComplateProductTemplate,
			valueField:'id',
			displayField:'name',
			queryId:'key',
			emptyText:'请输入商品编号或者名称进行查找...'
		});
	});
}

function GlobalGetProductId(){
	var pid = $('#dialog_pid').val();
	if (!pid){
		alert('请输入产品');
		return;
	}

	GlobalViewProduct(pid);
}

function GlobalViewProduct(pid){
	$.ajax({
		url: '?mod=product.ajax.sku&pid='+pid+'&type=get_product_all&rand=' + Math.random(),
		processData: true,
		dataType:'json',
		success: function(info){
			if (!info.product||!info.product.id){
				alert('没有找到指定的商品');
				return;
			}

			productId = pid;

			if (info.have_attribute==1){
				var html = info.attribute_html;
				Dialog('选择属性',html,GlobalViewSku,false,function(){AttributeEventNoLimit();});
			}else{
				if (!info.sku){
					alert('没有查询到SKU');
					return;
				}

				Dialog('SKU', '<p><b>SKU：</b>' + info.sku + '</p>');
			}
		},
		error:function(info){
			alert("网络传输错误,请重试...");
			return false;
		}
	});
}

function GlobalViewSku(){
	var postData = $('#dialog-attribute-form').serialize();
	$.ajax({
		url: '?mod=product.ajax.sku&pid='+productId+'&type=get_sku&rand=' + Math.random(),
		processData: true,
		type:"POST",
		dataType:'json',
		data:postData,
		success: function(info){
			if (!info.product||!info.product.id){
				alert('没有找到指定的商品');
				return;
			}

			if (!info.sku){
				alert('没有查询到SKU');
				return;
			}

			Dialog('SKU', '<p><b>SKU：</b>' + info.sku + '</p>');
		},
		error:function(info){
			alert("网络传输错误,请重试...");
			return false;
		}
	});
}


function AddProductToRow(){
	var html = $('#tpl_add_product').html().replace(/-_-/ig, '');
	Dialog('添加采购商品',html,GetProductToRow,false,function(){
		var auto = new Ext.form.AutoCompleteField({
			applyTo: 'dialog_pid_name',
			hideTrigger:true,
			width:410,
			hiddenName:'dialog_pid',
			store:autoComplateProductStore,	
			mode: 'local',
			tpl:autoComplateProductTemplate,
			valueField:'id',
			displayField:'name',
			queryId:'key',
			emptyText:'请输入商品编号或者名称进行查找...'
		});
	});
}

function GetProductToRow(){
	var pid = $('#dialog_pid').val();
	var sku = $('#dialog_sku').val();
	if (!pid && !sku){
		alert('请输入产品');
		return;
	}

	if (sku){
		$.ajax({
			url: '?mod=product.ajax.sku&sku='+sku+'&type=check_sku&times=<?php echo $_POST['times']; ?>&rand=' + Math.random(),
			processData: true,
			dataType:'json',
			success: function(info){
				if (!info.product||!info.product.id){
					alert('没有找到指定的商品');
					return;
				}

				if (!info.sku){
					alert('没有查询到SKU');
					return;
				}

				AddRow(info);
			},
			error:function(info){
				alert("网络传输错误,请重试...");
				return false;
			}
		});

		return true;
	}

	$.ajax({
		url: '?mod=product.ajax.sku&pid='+pid+'&sku='+sku+'&type=get_product&rand=' + Math.random(),
		processData: true,
		dataType:'json',
		success: function(info){
			if (!info.product||!info.product.id){
				alert('没有找到指定的商品');
				return;
			}

			productId = pid;

if (info.have_attribute==1){
				var html = info.attribute_html;
				Dialog('选择属性',html,GetSkuToRow,false,function(){AttributeEventNoLimit();});
}else{
				if (!info.sku){
					alert('没有查询到SKU');
					return;
				}
				AddRow(info);
				AddProductToRow()

}
		},
		error:function(info){
			alert("网络传输错误,请重试...");
			return false;
		}
	});
}

function GetSkuToRow(){
	var postData = $('#dialog-attribute-form').serialize();//alert(postData)
	if (postData.indexOf('noselect')>0)
	{
	//alert(postData)
	//return false;
	}
	$.ajax({
		url: '?mod=product.ajax.sku&pid='+productId+'&type=get_sku&rand=' + Math.random(),
		processData: true,
		type:"POST",
		dataType:'json',
		data:postData,
		success: function(info){
			if (!info.product||!info.product.id){
				alert('没有找到指定的商品');
				return;
			}

			if (!info.sku){
				alert('没有查询到SKU');
				return;
			}

			AddRow(info);
		},
		error:function(info){
			alert("网络传输错误,请重试...");
			return false;
		}
	});
}

</script>


<script type="text/javascript" src="script/swfupload/swfupload.js"></script>
<script type="text/javascript" src="script/uploader.js"></script>
<script language="javascript" type="text/javascript" src="script/attribute.js"></script>


<link rel="stylesheet" type="text/css" href="script/ext/css/ext-all.css" />
<link rel="stylesheet" type="text/css" href="script/ext/css/core.css" />

<style>
.x-tree-node,
.x-menu-item
{font-size:12px;}
html,body{ overflow:hidden;}
</style>

<script type="text/javascript" src="script/ext/ext-base.js"></script>
<script type="text/javascript" src="script/ext/ext-all.js"></script>
<script type="text/javascript" src="script/ext-ext.js"></script>

<script language="JavaScript">

Ext.BLANK_IMAGE_URL = 'script/ext/s.gif';
var mainWidth=$(window).width()-200;
$('#MainBox').width(mainWidth);
var mainHeight=$(window).height()-80;
$('#MainBox').height(mainHeight);


$("#LeftBox").css({height:mainHeight-7+"px"})

if($("#callBox"))
{
var TL=($(window).width()+250)/2-464;
var TH=(mainHeight-$("#callBox").height())/2
$("#callBox").css({left:TL+"px",top:TH+"px"})


}
</script>