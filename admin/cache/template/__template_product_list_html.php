<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2014-10-27 09:16:59
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<link href="css/cal/zpcal.css" rel="stylesheet" type="text/css">
<link href="css/cal/template.css" rel="stylesheet" type="text/css">
<link href="css/cal/maroon.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src='script/zapatec.js'></script>
<script type="text/javascript" src="script/calendar.js"></script>
<script type="text/javascript" src="script/calendar-zh.js"></script>

<div class="HY-main-columns clearfix">
	<div class="HY-main-columns-left">
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
		<div id="tree-list" style="margin-right:10px;"></div>

	</div>
	<div class="HY-main-columns-right">
		<div class="HY-content-header clearfix-overflow">
			<h3>商品列表</h3>
			<div class="right">
				<button type="button" class="scalable back" onclick="window.location='?mod=product.add&cid=<?php echo $_GET['cid']; ?>&nid=<?php echo $_GET['nid']; ?>';" style=""><span>添加产品(当前分类)</span></button>
			</div>
		</div>

		<div class="block5"></div>

		<div class="HY-grid-title">
			<div class="HY-grid-title-inner">
				分页:<?php echo $page_bar; ?> 每页20条商品 总共<?php echo $total; ?>条商品 <?php echo $page; ?>/<?php echo $page_num; ?>
			</div>
		</div>
		<div class="HY-grid">
			<table cellspacing="0">
				<thead>
					<tr class="header">
						<th width="40">ID</th>
						<th width="32" style="display:none">&nbsp;</th>
						<th width="68">产品经理</th>
						<th width=""><nobr>商品名称<nobr></th>
						
						<th width="250">商品库存</th>
						<th width="100" align="center" style="display:none">商品分类</th>
						<th width="100" style="display:none">产品经理</th>
						<th width="140" align="center"  style="display:none"><a href="?<?php echo $order_uri; ?>&by=add_time&order=<?php
if ( $_GET['order'] == 'asc' )
{
?>desc<?php
}
else
{
?>asc<?php
}
?>">添加时间<?php
if ( $_GET['by'] == 'add_time' )
{
?><?php
if ( $_GET['order'] == 'desc' )
{
?>↑<?php
}
elseif ( $_GET['order'] == 'asc' )
{
?>↓<?php
}
?><?php
}
?></a></th>
						<th width="100" align="center"  style="display:none"><a href="?<?php echo $order_uri; ?>&by=update_time&order=<?php
if ( $_GET['order'] == 'asc' )
{
?>desc<?php
}
else
{
?>asc<?php
}
?>">更新时间<?php
if ( $_GET['by'] == 'update_time' )
{
?><?php
if ( $_GET['order'] == 'desc' )
{
?>↑<?php
}
elseif ( $_GET['order'] == 'asc' )
{
?>↓<?php
}
?><?php
}
?></th>
						<th width="40" align="center">操作</th>
					</tr>
					<tr class="filter">
						<form method="get" id="search_form">
						<th>
							<div class="input-field">
								<input type="text" name="pid" id="pid" value="<?php echo $_GET['pid']; ?>">
								<input type="hidden" name="mod" value="<?php echo $_GET['mod']; ?>">
							<input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>">
							<input type="hidden" name="nid" value="<?php echo $_GET['nid']; ?>">
							</div>						</th>
						<th  style="display:none">&nbsp;</th>
						<th>&nbsp;</th>
						<th>
							<div class="input-field">
								<input type="text" name="word" id="word" value="<?php echo $_GET['word']; ?>">
							</div>						</th>
						<th><button type="button" onclick="$('#search_form').submit();">过滤</button></th>
						
						<th  style="display:none">&nbsp;</th>
						
						
						<th style="display:none"><select name="manager_user_id" style="width:100px;">
										<option value="">------无------</option>
										<?php
if ( $user_list )
{
foreach ( $user_list as $val )
{
?>
										<option value="<?php echo $val['user_id']; ?>" title="<?php echo $val['user_name']; ?>" <?php
if ( $_GET['manager_user_id'] == $val['user_id'] )
{
?>selected<?php
}
?>> <?php echo $val['user_real_name']; ?></option>
										<?php
}
}
?>
									</select></th>
						<th  style="display:none">
							<div class="input-from">
								<div class="clearfix">
									<div class="left">开始:</div>
									<input type="text" name="begin_date" id="begin_date" value="<?php echo $_GET['begin_date']; ?>">
									<img src="image/grid-cal.gif" alt="" class="v-middle" id="begin_date_btn" />								</div>
								<div class="clearfix">
									<div class="left">结束:</div>
									<input type="text" name="end_date" id="end_date" value="<?php echo $_GET['end_date']; ?>">
									<img src="image/grid-cal.gif" alt="" class="v-middle" id="end_date_btn" />								</div>
							</div>						</th>
						<th  style="display:none">&nbsp;</th>
						<th></th>
						</form>
					</tr>
				</thead>
				<form method="post" action="" id="list_form">
				<tbody>
					<?php
if ( $product_list )
{
foreach ( $product_list as $product )
{
?>
					<tr>
						<td align="center"><?php echo $product['id']; ?><br /><a href="javascript:void(0);" ctype="view-sku" pid="<?php echo $product['id']; ?>">SKU</a></td>
						<td  style="display:none"><img src="<?php echo $product['image_list_url']; ?>" style="margin:2px;padding:1px;border:1px solid #333;width:24px;" align="absmiddle" /></td>
						<td><?php echo $product['Manage_name']; ?></td>
<td><?php echo $product['name']; ?>
<?php
if ( $product['myinfo'] )
{
?><span style="color: #CC0000">　　购买属性：<b><?php echo $product['myinfo']; ?></b></span><?php
}
?><br />

<?php
if ( $product['collate_list'] )
{
foreach ( $product['collate_list'] as $collate )
{
?>
<a href="<?php echo $collate['bank_link']; ?>" target="_blank"><?php echo $collate['channel_name']; ?>-<?php echo $collate['target_id']; ?></a>&nbsp;&nbsp;
<?php
}
}
?>


<span style="float:right; display:none">
<?php
if ( $user_list )
{
foreach ( $user_list as $val )
{
?>
<button type="button" onclick="edit_Users(<?php echo $product['id']; ?>,<?php echo $val['user_id']; ?>,'#js_user_real_name_<?php echo $product['id']; ?>');" title="<?php echo $val['user_name']; ?>"><?php echo $val['user_real_name']; ?></button>
<?php
}
}
?>
</span>
</td>
						
						
<td align="center">
						<table cellspacing="0" class="data" id="grid_table">
					<thead>
						<tr class="header">
							<th width="">属性</th>
							<th width="30"><div align="center">在途</div></th>
							<th width="30"><div align="center">库存</div></th>
							<th width="30"><div align="center">锁定</div></th>
							<th width="30"><div align="center">可用</div></th>
							<th width="30"><div align="center">销售</div></th>
						</tr>
					</thead>
					<tbody>
						<?php
if ( $product['attributeList'] )
{
foreach ( $product['attributeList'] as $val )
{
?>
						<?php
if ( $val['service'] < 1 )
{
?>
						<tr>
							<td><?php echo $val['attribute']; ?></td>
							<td align="center"><font color="#999900"><b><?php echo $val['onroad_quantity']; ?></b></font></td>
							<td align="center"><font color="green"><b><?php echo $val['warehouse_quantity']; ?></b></font></td>
							<td align="center"><font color="red"><b><?php echo $val['warehouse_lock_quantity']; ?></b></font></td>
							<td align="center"><font color="blue"><b><?php echo $val['warehouse_live_quantity']; ?></b></font></td>
							<td align="center"><font color="#663399"><b><?php echo $val['sale']; ?></b></font></td>
						</tr>
						<?php
}
?>
						<?php
}
}
?>
					</tbody>
</table>


</td>
						<td align="center"  style="display:none">
							<?php echo $product['category']; ?>						</td> 
						<td align="center" id="js_user_real_name_<?php echo $product['id']; ?>" style="display:none">
							<?php echo $product['manager_user_real_name']; ?>						</td> 
						<td align="center"  style="display:none"><?php echo $product['add_time']; ?></td>
						<td align="center"  style="display:none"><?php echo $product['update_time']; ?></td>
						<td align="center" style="line-height:1.8;">
						<a href="?mod=product.edit&id=<?php echo $product['id']; ?>&cid=<?php echo $_GET['cid']; ?>">编辑</a>
<?php
if ( $product['Manage_edit'] == 1 )
{
?>
<br /><a href="?mod=product.move&id=<?php echo $product['id']; ?>&fcid=<?php echo $product['cid']; ?>">移动</a>
<?php
}
else
{
?>
&nbsp;
<?php
}
?>
						</td>
					</tr>
					<?php
}
}
?>
				</tbody>
				</form>
			</table>
		</div>
	</div>
</div>


<script type="text/javascript">

var cal = new Zapatec.Calendar.setup({
	inputField     :    "begin_date",     // id of the input field
	ifFormat       :    "%Y-%m-%d",     // format of the input field
	showsTime      :     false,
	button         :    "begin_date_btn",  // trigger button (well, IMG in our case)
	weekNumbers    :    false,  // allows user to change first day of week
	firstDay       :    1, // first day of week will be Monday
	align          :    "Bl"           // alignment (defaults to "Bl")
});

var cal = new Zapatec.Calendar.setup({
	inputField     :    "end_date",     // id of the input field
	ifFormat       :    "%Y-%m-%d",     // format of the input field
	showsTime      :     false,
	button         :    "end_date_btn",  // trigger button (well, IMG in our case)
	weekNumbers    :    false,  // allows user to change first day of week
	firstDay       :    1, // first day of week will be Monday
	align          :    "Bl"           // alignment (defaults to "Bl")
});
</script>



<script language="JavaScript">
function edit_Users(product_id,user_id,obj){
	$.ajax({
		url: '?mod=product.user&product_id='+product_id+'&user_id='+user_id+'&rand=' + Math.random(),
		type:'POST',
		data:'',
		success: function(info){
			if (info!=''){
			alert(info);
			$(obj).text(info);
			}
		},
		error:function(info){
			alert('网络错误,请重试');
		}
	});
}




function EditPrice(obj, id){
	var price = $(obj).text();
	Dialog('编辑价格', '<div><center>价格:<input type="text" id="price" size="20" value="'+price+'"/></center></div>', function(){
		var newPrice = $('#price').val();
		$.ajax({
			url: '?mod=product.ajax&type=price_modify&randnum={0}'.format(Math.random()),
			processData: true,
			dataType:'json',
			type: "POST",
			data: {"price":newPrice, id:id}, 
			success: function(info){
				$(obj).text(newPrice);
				UnDialog();
			},
			error:function(){
				alert( '网络错误' );
				UnDialog();
			}
		});
	
	});
}

</script>


<link rel="stylesheet" type="text/css" href="script/ext/css/tree.css" />
<link rel="stylesheet" type="text/css" href="script/ext/css/menu.css" />
<link rel="stylesheet" type="text/css" href="script/ext/css/core.css" />

<style>
.x-tree-node,
.x-menu-item
{font-size:12px;}
</style>

<script type="text/javascript" src="script/ext/ext-base.js"></script>
<script type="text/javascript" src="script/ext/ext-all.js"></script>

<script language="JavaScript">

Ext.BLANK_IMAGE_URL = 'script/ext/s.gif';

var tree;

Ext.onReady(function(){
	tree = new Ext.tree.TreePanel({
		el:'tree-list',
		height: 600,
		useArrows:true,
		autoScroll:true,
		animate:true,
		enableDD:false,
		containerScroll: true,
		rootVisible: false,
		frame: false,
		bodyStyle: 'border:1px solid #ccc;',
		root: new Ext.tree.AsyncTreeNode(),
		loader: new Ext.tree.TreeLoader({
			dataUrl: '?mod=product.category.list.json',
			preloadChildren: true,
			clearOnLoad: false
		})
	});

tree.on('click',function(node,e){

if(node.childNodes.length==0){node.expand();}

if(node.childNodes.length==0){
		var id = node.attributes.id;
		window.location='?mod=product.list&cid={0}'.format(id);
}
else{

var opens=0;
		var treeCookie = GetCookie('ext_tree_path');
		var pathList = treeCookie ? treeCookie.split(',') : (new Array());
		for(var i=0; i<pathList.length;i++){
			var str=pathList[i]+"/";var strs="/"+node.id+"/";
			 if (str.indexOf(strs)>=0){node.collapse();opens=1;}
		}


if(opens==0){node.expand();}
}	
	
	});

	tree.on('expandnode',function(node){
		if (node.childNodes.length>0){//alert(node)
			var treeCookie = GetCookie('ext_tree_path');
			var pathList = treeCookie ? treeCookie.split(',') : (new Array());
			var path = node.getPath();

			if ($.inArray(path,pathList)==-1){
				pathList[pathList.length] = node.getPath();
				SetCookie('ext_tree_path', pathList.join(','));
			}
		}
	});

	tree.on('collapsenode',function(node){
		if (node.childNodes.length>0){//alert(2)
			var treeCookie = GetCookie('ext_tree_path');
			var pathList = treeCookie ? treeCookie.split(',') : (new Array());
			var path = node.getPath();

			pathList = $.map(pathList, function(p){
				if (p.substring(0, path.length) == path)
					return null;
				else
					return p;
			});

			SetCookie('ext_tree_path', pathList.join(','));
		}
	});

	tree.getLoader().on('load',function(){
		var treeCookie = GetCookie('ext_tree_path');
		var pathList = treeCookie ? treeCookie.split(',') : (new Array());
		for(var i=0; i<pathList.length;i++){
			tree.expandPath(pathList[i]);
		}

		var selectId = GetCookie('ext_tree_id');

		if (selectId){
			var selectNode = tree.getNodeById(selectId);
			if (selectNode){
				<?php
if ( $_GET['cid'] )
{
?>
				selectNode.select();
				<?php
}
?>
			}
		}
	});

	tree.on('click',function(node){
		SetCookie('ext_tree_id', node.id);
	});

	tree.getRootNode().attributes.id = 0;
	tree.getRootNode().attributes.name = '根分类';

	tree.render();

	var filter = new Ext.tree.TreeFilter(tree, 
		{
			clearBlank: true,
			autoClear: true
		}
	);

	var input = Ext.get("tree_search");
	input.on('keydown', filterTree, input, {buffer:350});

	var hiddenPkgs  = [];
	var markCount	= [];

	// filter the tree for hits
	function filterTree(e){
		var text = e.target.value;
		Ext.each(hiddenPkgs, function(n){
			n.ui.show();
		});
		
		markCount  = [];	
		hiddenPkgs = [];
		
		if( text.trim().length > 0 ){
			tree.expandAll();


			var re = new RegExp( Ext.escapeRe(text), 'i');
			tree.root.cascade( function( n ){
				if( re.test(n.text) )
					markToRoot( n, tree.root );
			});

			// hide empty packages that weren't filtered		
			tree.root.cascade(function(n){
				if( ( !markCount[n.id] || markCount[n.id] == 0 ) && n != tree.root ){
					n.ui.hide();
					hiddenPkgs.push(n);
				}
			});
		}
	}

	function markToRoot( n, root ){
		
		if( markCount[n.id] )
			return;
		markCount[n.id] = 1;

		if( n.parentNode != null )
			markToRoot(n.parentNode, root);
	}
});

function ExpandAll(){
	tree.getRootNode().expand(true);
}

function CollapseAll(){
	tree.getRootNode().collapseChildNodes(true);
	SetCookie('ext_tree_path','');
	SetCookie('ext_tree_id','');
}


$(document).ready(function(){
	$('a[ctype=view-sku]').click(function(){
		GlobalViewProduct($(this).attr('pid'));
	});
});


</script>