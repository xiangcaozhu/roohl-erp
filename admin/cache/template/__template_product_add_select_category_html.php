<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-02-28 10:03:39
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>

<div class="HY-main-columns clearfix">
	<div class="HY-main-columns-left">
		<h3>添加新的品</h3>
		<ul class="HY-v-tab">
			<li ><a href="javascript:void(0);" class="active"><span>选择一个分类</span></a></li>
		</ul>
	</div>
	<div class="HY-main-columns-right">
		<div class="HY-content-header clearfix">
			<h3>添加新的产品 - 选择一个分类</h3>
		</div>

		<div style="margin-bottom:2px;margin-right:10px;width:230px;" class="clearfix2">
			<div class="left">
				<input name="tree_search" id="tree_search" value="" class="input-text" type="text" style="width:100px;"/>
			</div>
			<div class="right">
				<button type="button" class="" onclick="ExpandAll();"><span>展开</span></button>
				<button type="button" class="" onclick="CollapseAll();"><span>收起</span></button>
			</div>
		</div>
		<div id="tree-list" style="margin-right:10px;width:230px;"></div>
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


/*
	tree.on('click',function(node,e){
		var id = node.attributes.id;
		window.location='?mod=product.add&cid={0}'.format(id);
	});
*/


tree.on('click',function(node,e){

if(node.childNodes.length==0){node.expand();}

if(node.childNodes.length==0){
		var id = node.attributes.id;
		window.location='?mod=product.add&cid={0}'.format(id);
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

</script>