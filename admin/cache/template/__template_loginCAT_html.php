<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2017-08-23 00:11:34
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
html{background:url(CAT/loginBG<?php echo $BgNum; ?>.jpg) no-repeat center top; overflow:hidden;}
</style>
<link rel="stylesheet" type="text/css" href="css/CAT.css">
<script src="scr1ipt/jquery-1.3.2.js"></script>
<script src="scr1ipt/common.js"></script>
<title>HCenter -login</title>

<style type="text/css">
#loginBox {
    float: right;
    width: 380px;
    height: 380px;
    position: relative;
    background: #ab1b1b url(../CAT/tableBG.jpg) no-repeat right top;
}


.loginName {
    position: absolute;
    left: 100px;
    top: 120px;
    width: 150px;
    height: 22px;
    line-height: 22px;
    border: 0px;
    font-size: 20px;
     /*background: url(../CAT/blank2.gif) no-repeat; */
     background: white; 
}

.loginPass {
    position: absolute;
    left: 100px;
    top: 182px;
    width: 150px;
    height: 22px;
    line-height: 22px;
    border: 0px;
    font-size: 20px;
     /*background: url(../CAT/blank2.gif) no-repeat; */
     background: white; 
}


</style>

</head>
<body>
<div id="footer">HShopCenter administrator login</div>


<div id="mainner">

<div id="logoBox"><img src="CAT/logoCAT.png" width="0" height="0" /></div>
<div id="tableBox">
<ul id="newBox"><br /><br /><img src="CAT/logo_1.png" width="436" height="108" /><br />We Can Do Better</ul>
<ul id="loginBox">
<form method=post action="">
<!-- 用户名： --><input type="text" name="name" size="30"  class="loginName" value="admin" />
<!-- 密码： --><input type="password" name="password" size="20" class="loginPass" value="admin888" />
<input type="submit" value=""  class="loginBtn"/>
</form>
<li id="InfoBox">
<span id="dateBox"></span>
<script type="text/javascript">
d=new Date();
dateBox.innerHTML=d.getFullYear()+'年'+(d.getMonth()+1)+'月'+d.getDate()+'日'+'<br>星期'+'日一二三四五六'.charAt(d.getDay())+'<br>'+d.toLocaleTimeString();
setInterval("ds=new Date();dateBox.innerHTML=ds.getFullYear()+'年'+(ds.getMonth()+1)+'月'+ds.getDate()+'日'+'<br>星期'+'日一二三四五六'.charAt(ds.getDay())+'<br>'+ds.toLocaleTimeString();", 1000);
</script>
<iframe id="weatherBox" allowtransparency="true" frameborder="0" width="255" height="98" scrolling="no" ids="http://tianqi.23cc45.com/plugin/widget/index.htm?s=1&z=1&t=1&v=0&d=1&k=&f=1&q=1&e=0&a=1&c=54511&w=255&h=98"></iframe>
</li>
</ul>
</div>

</div>
</body>
</html>