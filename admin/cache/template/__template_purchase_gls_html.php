<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2015-12-22 16:03:15
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>

<style type="text/css">

body{
	padding:0px 0px;
}

*{
	padding:0px;
	margin:0px;
	font-family:tahoma,"Lucida Grande","Lucida Sans",sans,Hei;
	font-size:12px;
}

a{
	color:#0066CC;
	text-decoration:underline;
}

a:hover{
	color:#FF7031;
	text-decoration:none;
}

h3{
	font-size:14px;
	font-weight:bold;
	color:#444;
	margin-bottom:10px;
}

input {
	vertical-align:middle;
	padding:3px;
}

input.in{
	padding:2px;
	width:220px;
	border:0px solid #ccc;
	height:20px;
	padding-top:10px;
}

select{
	padding:3px;
	/*font-size:11px;*/
}

input.btn {
	cursor:pointer;
	height:28px;
}

.img{
	border:1px solid #ccc;
	padding:2px;
}

ul {list-style-image:none;list-style-position:none;list-style-type:none;}

#tab{
	width:960px;
}

#tab td{
	padding:4px;
}

#tab th{
	padding:2px;
}


</style>

</head>


<body>
<table border="0" width="750" align="center" style="margin:10px auto 0px;">
	<tr>
		<td align="center"><h1 style="font-size:18px;"><?php echo $company_name; ?>格兰仕独立采购</h1></td>
	</tr>
</table>



<?php
if ( $need_list )
{
foreach ( $need_list as $val )
{
?>
<?php
if ( $val['list'] )
{
foreach ( $val['list'] as $row )
{
?>
<table width="100%" border="0" cellspacing="1" style="margin:10px auto;" bgcolor="#333333" id="order_<?php echo $val['order_id']; ?>">
<tr><td colspan="10" bgcolor="#FFFFFF" style=" padding:5px 0px">
<div style="float:left; padding-left:15px;">订 单 号：<?php echo $val['order_id']; ?>　<?php echo $val['channel_name']; ?>　<?php echo DateFormat($val['order_time'],'Y-m-d H:i'); ?>　<?php echo $val['channel_target_id']; ?></div>
<div style="float:right; padding-right:15px;">[<a href="#" onclick="hurry_store(<?php echo $row['order_id']; ?>)">采购完成</a>]</div>
</td></tr>
<tr class="header">
<th width="50" bgcolor="#FFFFFF" style=" padding:5px 0px"><div align="center">商品ID</div></th>
<th width="90" bgcolor="#FFFFFF" style=" padding:5px 0px"><div align="center">商品SKU</div></th>
<th width="40" bgcolor="#FFFFFF" style=" padding:5px 0px"><div align="center">属性</div></th>
<th width="60" bgcolor="#FFFFFF" style=" padding:5px 0px"><div align="center">单价</div></th>
<th width="400" bgcolor="#FFFFFF" style=" padding:5px 0px"><div align="left">　商品名称</div></th>
<th width="40" bgcolor="#FFFFFF" style=" padding:5px 0px"><div align="center">数量</div></th>
<th width="80" bgcolor="#FFFFFF" style=" padding:5px 0px"><div align="center">收货人</div></th>
<th width="150" bgcolor="#FFFFFF"  style=" padding:5px 0px"><div align="center">电话</div></th>
<th bgcolor="#FFFFFF"  style=" padding:5px 0px"><div align="left">　地址</div></th>
<th width="60" bgcolor="#FFFFFF" style=" padding:5px 0px"><div align="center">邮编</div></th>
</tr>
<tr>
<td align="center" bgcolor="#FFFFFF" style="padding:5px;"><div align="center"><?php echo $val['sku_info']['product']['id']; ?></div></td>
<td align="center" bgcolor="#FFFFFF" style="padding:5px;"><div align="center"><?php echo $val['sku']; ?></div></td>
<td align="center" bgcolor="#FFFFFF" style="padding:5px;"><div align="center"><?php echo $val['sku_info']['attribute']; ?></div></td>
<td align="center" bgcolor="#FFFFFF" style="padding:5px;"><div align="center"><?php echo $row['price']; ?></div></td>
<td align="center" bgcolor="#FFFFFF" style="padding:5px;"><?php echo $val['sku_info']['product']['name']; ?></td>
<td align="center" bgcolor="#FFFFFF" style="padding:5px;"><div align="center"><?php echo $row['quantity']; ?></div></td>
<td align="center" bgcolor="#FFFFFF" style="padding:5px;"><div align="center"><?php echo $val['order_shipping_name']; ?></div></td>
<td align="center" bgcolor="#FFFFFF" style="padding:5px;">
  <div align="center"><?php echo $val['order_shipping_phone']; ?>
    <?php
if ( $val['order_shipping_phone'] && $val['order_shipping_mobile'] )
{
?> 
    / 
    <?php
}
?>
    <?php echo $val['order_shipping_mobile']; ?></div></td>
<td bgcolor="#FFFFFF" style="padding:5px;" ><?php echo $val['order_shipping_address']; ?></td>
<td bgcolor="#FFFFFF" style="padding:5px;" align="center"><div align="center"><?php echo $val['order_shipping_zip']; ?></div></td>
</tr>
</table>

<?php
}
}
?>

<?php
}
}
?>

<script>
function hurry_store(orderId)
{
	$.ajax({
		url: '?mod=store.hurry&id='+orderId+'&rand=' + Math.random(),
		type:'GET',
		//data:post,
		success: function(info){
			if (info=='200' || info==200){
			$('#order_'+orderId+'').css('display','none')
				//Loading('处理成功', '正在跳转到列表页面...');
				//window.location='?mod=order.check.service&service_check=<?php echo $_GET['service_check']; ?>';
				//window.location='?mod=order.check.service&service_check=<?php echo $_GET['service_check']; ?>';
				alert('处理成功');
			}else{
				alert(info);
				//UnLoading();
			}
		},
		error:function(info){
			alert('网络错误,请重试');
			//UnLoading();
		}
	});
}
</script>
</body>
</html>