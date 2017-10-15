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

function UseThis(pid,pid2,obj){
	$.ajax({
		url: '?mod=product.small_product_set&pid='+pid+'&pid2='+pid2+'&rand=' + Math.random(),
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

</script>



<?php



set_time_limit(0);

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$CenterCategoryModel = Core::ImportModel( 'CenterCategory' );

$CenterProductModel = Core::ImportModel( 'CenterProduct' );
$ProductCollateModel = Core::ImportModel( 'ProductCollate' );
$CenterProductExtra = Core::ImportExtra( 'CenterProduct' );



$productList = $CenterProductModel->GetList( array() );



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



echo "<ul>";

$i = 1;
foreach ( $productList as $key=>  $val )
{
	if ( $val['si'] )
	{
		echo "<li>";
		echo $i;
		echo $val['name'];
		echo "<ol>";

		foreach ( $val['si'] as $v )
		{
			echo "<li>";
			echo $v['id'] . ' ' . $v['name'];
			//echo "[<a href='###' onclick='UseThis({$val['id']}, {$v['id']},this);'>删除</a>]";
			echo "</li>";
		}

		echo "</ol></li>";
		echo "<li>&nbsp;";
		echo "</li>";

		$i++;

	}
}

echo "</ul>";

?>