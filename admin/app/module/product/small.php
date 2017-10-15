<?php
/*
@@acc_free
*/
?>
<script src="script/jquery-1.3.2.js"></script>

<style>

*{
	font: 16px/1 Tahoma, Helvetica, Arial, "\5b8b\4f53", sans-serif; /* 用 ascii 字符表示，使得在任何编码下都无问题 */
	color:#000;
}

a{
	color:blue;
}
</style>

<script language="JavaScript">

function UseThis(cid,pid,obj){
	$.ajax({
		url: '?mod=product.small_set&product_id='+pid+'&collate_id='+cid+'&rand=' + Math.random(),
		success: function(info){
			if (info=='200'){
				$(obj).parents('ol').parents('li').css('color', '#ccc');
				$(obj).parents('ol').find('li').css('color', '#ccc');
			}else{
				alert(info);
			}
		},
		error:function(info){
			alert("网络传输错误,请重试...");
			return false;
		}
	});
}

function NoThis(cid,obj){
	$.ajax({
		url: '?mod=product.small_set&collate_id='+cid+'&rand=' + Math.random(),
		success: function(info){
			if (info=='200'){
				$(obj).parents('li').css('color', '#000');
				$(obj).parents('li').find('ol li').css('color', '#000');
			}else{
				alert(info);
			}
		},
		error:function(info){
			alert("网络传输错误,请重试...");
			return false;
		}
	});
}

</script>



<?php



set_time_limit(0);

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );



$productList = $CenterProductModel->GetList( array() );



/*

foreach ( $productList as $key=>  $val )
{
	foreach ( $productList as $k => $v )
	{
		if ( $v['is_s'] )
			continue;

		if ( $v['id'] == $val['id'] )
			continue;

		$a = 0;
		similar_text( $val['name'], $v['name'], $a );

		if ( $a > 90 )
		{
			$productList[$k]['is_s'] = true;
			$productList[$key]['si'][] = array( 'name'=>$v['name'], 'id' => $v['id'] );
		}
	}
}


foreach ( $productList as $key=>  $val )
{
	if ( $val['si'] )
	{
		echo $val['id'] . ' ' . $val['name'];
		echo "<br>";

		foreach ( $val['si'] as $v )
		{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo $v['id'] . ' ' . $v['name'];
			echo "<br>";
		}
	}
}

*/



$list = $ProductCollateModel->GetList( array() );

foreach ( $list as $key => $val )
{
	if ( $val['sku_id'] )
		continue;
	
	foreach ( $productList as $k => $v )
	{
		$a = 0;
		similar_text( $val['import_name'], $v['name'], $a );

		if ( $a > 75 )
		{
			$list[$key]['si'][] = array( 'name'=>$v['name'], 'id' => $v['id'] );
		}
	}
}

echo "<ul>";

$i = 1;
foreach ( $list as $key=>  $val )
{
	if ( $val['si'] )
	{
		echo "<li>";
		echo $i;
		echo $val['import_name'];
		echo "[<a href='###' onclick='NoThis({$val['id']},this);'>还原</a>]";
		echo "<ol>";

		foreach ( $val['si'] as $v )
		{
			echo "<li>";
			echo $v['id'] . ' ' . $v['name'];
			echo "[<a href='###' onclick='UseThis({$val['id']}, {$v['id']},this);'>使用</a>]";
			echo "</li>";
		}

		echo "</ol></li>";

		$i++;

	}
}

echo "</ul>";

?>