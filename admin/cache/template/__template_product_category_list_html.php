<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-07-08 01:48:21
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<script type="text/javascript" src="script/swfupload/swfupload.js"></script>
<script type="text/javascript" src="script/uploader.js"></script>
<script type="text/javascript" src="script/cms-block.js"></script>

<script type="text/javascript" src="script/jtip/jtip.js"></script>
<link rel="stylesheet" type="text/css" href="script/jtip/global.css" />

<div class="HY-main-columns clearfix">
	<div class="HY-main-columns-left">
			
		<div class="HY-content-header clearfix">
			<h3 class="icon-head head-categories">商品分类</h3>
		</div>

		<div style="margin-bottom:2px;margin-right:10px;" class="clearfix2">
			<div class="left">
				<input name="tree_search" id="tree_search" value="" class="input-text" type="text" style="width:100px;"/>
			</div>
			<div class="right">
				<button type="button" class="" onclick="ExpandAll();"><span>展开</span></button>
				<button type="button" class="" onclick="CollapseAll();"><span>收起</span></button>
			</div>
		</div>
		<div id="tree-list" style="margin-right:10px;"></div>

	</div>
	<div class="HY-main-columns-right">
		<div class="HY-content-header clearfix-overflow">
			<h3>
				<?php
if ( $info_id && !$_GET['add'] )
{
?>
				修改商品分类:<?php echo $info_name; ?>(ID:<?php echo $info_id; ?>)
				<?php
}
elseif ( $info_id && $_GET['add'] )
{
?>
				添加新的商品分类 (<?php echo $info_name; ?>)的子分类
				<?php
}
else
{
?>
				添加新的商品分类
				<?php
}
?>
			</h3>
			<div class="right">
				<button type="button" class="scalable " onclick="$('form').reset();"><span>重置</span></button>
				<button type="button" class="scalable save" onclick="$('form').submit();"><span>保存数据</span></button>
			</div>
		</div>
		<ul class="HY-h-tab clearfix2">
			<li>
				<a href="#" onclick="TabSelect(this,'base');" class="tab-item-link active"><span>基本信息</span></a>
			</li>
			<li>
				<a href="#" onclick="TabSelect(this,'brand');" class="tab-item-link"><span>品牌</span></a>
			</li>
		</ul>
		<form method="post" enctype="multipart/form-data" <?php
if ( $info && !$_GET['add'] )
{
?>action="?mod=product.category.edit&id=<?php echo $_GET['id']; ?>&nid=<?php echo $_GET['nid']; ?>"<?php
}
else
{
?>action="?mod=product.category.add&id=<?php echo $_GET['id']; ?>&nid=<?php echo $_GET['nid']; ?>"<?php
}
?>>
		<div class="HY-form-table" id="base">
			<div class="HY-form-table-header">
				填写基本信息
			</div>
			<div class="HY-form-table-main">
				<table cellspacing="0" class="HY-form-table-table">
					<tbody>
						<tr>
							<td class="label"><label>分类名称<span class="required">*</span></label></td>
							<td class="value"><input name="name" id="name" value="<?php echo $info['name']; ?>" class="input-text" type="text"/></td>
							<td><small>&nbsp;</small></td>
						</tr>
						<tr>
							<td class="label"><label>短名称<span class="required"></span></label></td>
							<td class="value"><input name="sort_name" id="sort_name" value="<?php echo $info['sort_name']; ?>" class="input-text" type="text" style="width:100px;"/></td>
							<td><small>&nbsp;</small></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="HY-form-table" id="brand" style="display:none;">
			<div class="HY-form-table-header">
				品牌
			</div>
			<div class="HY-form-table-main">
				<table cellspacing="0" class="HY-form-table-table">
					<tbody>
						<tr>
							<td class="label"><label>选择品牌</label></td>
							<td class="value">
								<div style="width:600px;" class="clearfix">
									<?php
if ( $brand_list )
{
foreach ( $brand_list as $brand )
{
?>
									<label style="float:left;width:120px;"><input type="checkbox" name="brand[]" value="<?php echo $brand['id']; ?>" <?php
if ( $brand['selected'] )
{
?>checked<?php
}
?>><?php echo $brand['name']; ?></label>
									<?php
}
}
?>
								</div>
							</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		</form>
	</div>
</div>

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
		enableDD:true,
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

	tree.on('beforemovenode', function(tree, node, oldParentNode, newParentNode, index){

		var beforeNodeId = index < newParentNode.childNodes.length ? newParentNode.childNodes[index].attributes.id : 0;
		var parentId = newParentNode.attributes.id;
		var nodeId = node.attributes.id;

		if (oldParentNode.id==newParentNode.id){
			if(window.confirm('确定要调整排序吗?')){
				$.ajax({
					url: '?mod=product.category.edit.order&pid={0}&cid={1}&next_cid={2}&rand={3}'.format(parentId,nodeId,beforeNodeId,Math.random()),
					processData: true,
					dataType:'json',
					success: function(info){
						if (info.code!=200){
							Dialog('提示', '调整失败,请重试',false,false,false,'确定','关闭');
							TreeReload();
						}
					},
					error:function(info){
						Dialog('提示', '调整失败,请重试',false,false,false,'确定','关闭');
						TreeReload();
					}
				});
				return true;
			}else{
				return false;
			}
		}else{
			if(window.confirm('将分类 `{0}` 移动到 `{1}` 下面吗?'.format(node.attributes.name, newParentNode.attributes.name))){
				$.ajax({
					url: '?mod=product.category.edit.move&pid={0}&cid={1}&next_cid={2}&rand={3}'.format(parentId,nodeId,beforeNodeId,Math.random()),
					processData: true,
					dataType:'json',
					success: function(info){
						if (info.code!=200){
							Dialog('提示', '调整失败,请重试',false,false,false,'确定','关闭');
							TreeReload();
						}
					},
					error:function(info){
						Dialog('提示', '调整失败,请重试',false,false,false,'确定','关闭');
						TreeReload();
					}
				});
				return true;
			}else{
				return false;
			}
		}
	});

	tree.on('click',function(node,e){
		var id = node.attributes.id;
		window.location='?mod=product.category&id={0}'.format(id);
	});

	tree.on('expandnode',function(node){
		if (node.childNodes.length>0){
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
		if (node.childNodes.length>0){
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
				selectNode.select();
			}
		}
	});

	tree.on('click',function(node){
		SetCookie('ext_tree_id', node.id);
	});

	tree.on('contextmenu',contextmenu);

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

function TreeReload(){
	tree.getRootNode().reload();
}

function contextmenu(node, e) {
	var treeMenu = new Ext.menu.Menu( {
	id: 'treeMenu',
	items: [
		new Ext.menu.Item({
			id: 'view',
			text:'查看产品',
			iconCls: "tree-view",
			handler: viewProduct
		}),
		new Ext.menu.Item({
			id: 'add',
			text:'添加子分类',
			iconCls: "tree-add",
			handler: addChild
		}),
		new Ext.menu.Item({
			id: 'delete',
			text:'删除',
			iconCls: "tree-delete",
			handler: deleteCategory
		}),
		new Ext.menu.Item({
			id: 'edit',
			text: '编辑',
			iconCls: "tree-edit",
			handler: editCategory
		})
	]});


	function addChild(){
		window.location = '?mod=product.category&id={0}&add=1'.format(node.attributes.id);
	}

	function viewProduct(){
		SetCookie('ext_tree_id', node.attributes.id);
		window.location = '?mod=product.list&cid={0}'.format(node.attributes.id);
	}

	function editCategory(){
		window.location = '?mod=product.category&id={0}'.format(node.attributes.id);
	}

	function deleteCategory(){
		window.location = '?mod=product.category.del&id={0}'.format(node.attributes.id);
	}

	if(node.attributes.children.length > 0 ){
		treeMenu.items.get('delete')['disable']();
	}

	treeMenu.showAt(e.getXY());
	node.select();
}

</script>

<style>
.tree-add {
	background-image:url(./image/icon/add.png) !important;
}

.tree-view {
	background-image:url(./image/icon/application_view_icons.png) !important;
}

.tree-delete {
	background-image:url(./image/icon/delete.png) !important;
}

.tree-edit {
	background-image:url(./image/icon/page_edit.png) !important;
}

</style>


<script language="JavaScript">
<!--

function TabSelect(obj,id){
	$('.HY-form-table').hide();
	$('#'+id).show();
	$('li').find('a').removeClass('active');
	$(obj).addClass('active');
}
//-->
</script>