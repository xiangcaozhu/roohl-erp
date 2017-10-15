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

exit;

$list = $ProductCollateModel->GetList( array() );

$newList = array();

foreach ( $list as $key => $val )
{
	if ( $val['sku_id'] )
		continue;

	$newList[$val['import_name']][] = $val;
}

Core::LoadDom( 'CenterProduct' );

echo "<ol>";
foreach ( $newList as $name => $val )
{
	if ( !trim( $name ) )
	{
		continue;
	}

	$data = array();
	$data['name'] = trim( $name );
	$data['summary'] = trim( $name );
	$data['cid'] = 0;
	$data['brand_id'] = 0;
	$data['image_list'] = '';
	$data['add_time'] = time();
	$data['update_time'] = time();
	$data['supplier_id'] = 0;
	$data['weight'] = 0;
	$data['buy_attribute_template_id'] = 0;


	/******** Insert ********/
	$productId = $CenterProductModel->Add( $data );

	$CenterProductDom = new CenterProductDom( $productId );
	$sku = $CenterProductDom->GetBaseSku();

	echo "<li>";
	echo $name;
	echo '-';
	foreach ( $val as $v )
	{
		$ProductCollateModel->Update( $v['id'], array( 'sku_id' => $CenterProductExtra->Sku2Id( $sku ) ) );
		echo $v['id'];
		echo '-';
	}
	echo "</li>";
}
echo "</ol>";


exit;


?>