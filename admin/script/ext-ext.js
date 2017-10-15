Ext.form.AutoCompleteField = Ext.extend(Ext.form.ComboBox,{
		hideTrigger:true,
		//firstTriggerShow:true,
		triggerClass:'x-form-clear-trigger',
	    mode: 'local',
	    editable:true,
		enableKeyEvents:true,
		onKeyUp:function(e,combo){
	 		var key = e.getKey()||undefined;
	 		if(37<=key && key<=40 || key==13)return;
	 		//console.log(this,arguments,this.getRawValue());
			this.store.baseParams = this.store.baseParams||{};
			this.store.baseParams[this.queryId] = this.getRawValue();
			clearTimeout(this.timeoutStoreLoad||null);
	 		this.timeoutStoreLoad = this.fetchList.defer(500,this);
		},
		initList:function(){
			if(!this.tpl)this.tpl='<tpl for=".">'+
				'<div class="x-combo-list-item" style="height:48px;">'+
					'<div><b>{name}</b></div>'+
					'<div>'+
						'<div>流水号：{id}</div>'+
						'<div>编号：{no}</div>'+
						'<div style="clear:both"></div>'+
					'</div>'+
				'</div>'+
			'</tpl>';
			 Ext.form.AutoCompleteField.superclass.initList.call(this);
		},
		fetchList:function(){
			this.store.reload();
		},
		onTriggerClick:function(){
			this.clearValue();
			this.trigger.visibilityMode = Ext.Element.DISPLAY;
			this.trigger.hide();
			this.setWidth(this.width);
			this.syncSize();
		},
		listeners:{
			select:function(){
				this.trigger.show();
				this.setWidth(this.width);
				this.syncSize();
			}
		}
});
	 
Ext.reg('autocomplete',  Ext.form.AutoCompleteField);


var autoComplateSupplierStore = new Ext.data.JsonStore({
	fields: ['code','name','id'],
	url:'?mod=product.supplier.ajax.search',
	totalProperty: 'count',
	remoteSort: true
});
var autoComplateSupplierTemplate = '<tpl for=".">'+
	'<div class="x-combo-list-item" style="height:auto;">'+
		'<div>'+
		'<div><b>[{id}]</b> / {name}</div>'+
			//'<div>供应商ID:{id}</div>'+
			'<div style="clear:both"></div>'+
		'</div>'+
	'</div>'+
'</tpl>';

var autoUserStore = new Ext.data.JsonStore({
	fields: ['name','id', 'mail'],
	url:'user.do',
	root: 'data',
	totalProperty: 'count',
	remoteSort: true
});
var autoUserTemplate = '<tpl for=".">'+
	'<div class="x-combo-list-item" style="height:auto;">'+
		'<div>'+
		'<div><b>{name}</b>({mail})</div>'+
			'<div style="clear:both"></div>'+
		'</div>'+
	'</div>'+
'</tpl>';

if (typeof(supplierId)=='undefined'){
	supplierId = 0;
}
var autoComplateProductStore = new Ext.data.JsonStore({
	fields: ['name','id'],
	url:'?mod=product.ajax.search&supplier_id='+supplierId,
	remoteSort: true
});
var autoComplateProductTemplate = '<tpl for=".">'+
	'<div class="x-combo-list-item" style="height:auto;">'+
		'<div>'+
		'<div><b>{id}</b>{name}</div>'+
			'<div style="clear:both"></div>'+
		'</div>'+
	'</div>'+
'</tpl>';


var autoComplateProductSale = new Ext.data.JsonStore({
	fields: ['name','id'],
	url:'?mod=product.ajax.search',
	remoteSort: true
});
var autoComplateProductSaleTemplate = '<tpl for=".">'+
	'<div class="x-combo-list-item" style="height:auto;">'+
		'<div>'+
		'<div><b>{id}</b>　{name}</div>'+
			'<div style="clear:both"></div>'+
		'</div>'+
	'</div>'+
'</tpl>';


if (typeof(warehouseId)=='undefined'){
	warehouseId = 0;
}

var autoComplatePlaceStore = new Ext.data.JsonStore({
	fields: ['code','name','id', 'nick_name'],
	url:'?mod=warehouse.place.ajax.search&warehouse_id='+warehouseId,
	totalProperty: 'count',
	remoteSort: true
});
var autoComplatePlaceTemplate = '<tpl for=".">'+
	'<div class="x-combo-list-item" style="height:auto;">'+
		'<div>'+
		'<div><b>{name}</b>({nick_name})</div>'+
		'</div>'+
	'</div>'+
'</tpl>';

if (typeof(channelId)=='undefined'){
	channelId = 0;
}

var autoComplateChannelProductStore = new Ext.data.JsonStore({
	fields: ['name','id','target_id'],
	url:'?mod=product.collate.ajax.search&channel_id='+channelId,
	remoteSort: true
});
var autoComplateChannelProductTemplate = '<tpl for=".">'+
	'<div class="x-combo-list-item" style="height:auto;">'+
		'<div>'+
		'<div style="padding-top:2px;"><span style="float:left;height:20px;"><b>商品ID：</b>{id}</span><span style="float:right;text-align:right;"><b>渠道编号：</b>{target_id}</span></div>'+
			'<div style="clear:both"></div>'+
		'</div>'+
		'<div>'+
		'<div>{name}</div>'+
			'<div style="clear:both"></div>'+
		'</div>'+
	'</div>'+
'</tpl>';