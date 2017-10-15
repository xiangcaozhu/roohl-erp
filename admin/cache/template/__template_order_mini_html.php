<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-08-12 09:27:03
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta HTTP-EQUIV= "Refresh" content= "300">
<style>
a{color:#FFFFFF; text-decoration:none;}
a:hover{color:#FFFFFF; text-decoration:underline;}
</style>
</head>
<body>
<div style="float:left;width:150px;height:100px; padding:5px;border:#000000 5px solid; background:#FFFFFF;">
<?php
if ( $purchase_check_total > 0 )
{
?>
<div style="float:left;width:140px; text-align:center; background:#990000;color:#FFFFFF;font-size:13px; padding:5px;"><a href="?mod=order.check.purchase&purchase_check=0" target="_blank">有新订单商品需要确认</a></div>
<?php
}
?>

<?php
if ( $purchase_total > 0 )
{
?>
<div style="float:left;width:140px; text-align:center; background:#990000;color:#FFFFFF;font-size:13px; padding:5px;margin-top:5px;"><a href="?mod=purchase.need" target="_blank">有新订单商品需要采购</a></div>
<?php
}
?>



</div>
</body>
</html>