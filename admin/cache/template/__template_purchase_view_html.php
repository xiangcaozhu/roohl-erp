<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-03-05 12:11:44
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3>查看采购单</h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="$('#main_form').submit();" style=""><span>保存采购单</span></button>
	</div>
</div>

<form method="post" id="main_form">

<div class="clearfix">
	<div class="left">
		当前状态：<?php echo $info['workflow_status_name']; ?> <?php
if ( $info['workflow_allow_do'] )
{
?>( <a href="?mod=purchase.check&id=<?php echo $info['id']; ?>" onclick="return confirm('确定要审核通过吗?');">审核通过</a> )<?php
}
?>
	</div>
	<div class="right">
		<table><tr><td>供应商：</td><td><?php echo $info['supplier_name']; ?></td><td>&nbsp;&nbsp;&nbsp;&nbsp;预计到货时间：</td><td><?php echo DateFormat($info['plan_arrive_time'], 'Y-m-d'); ?></td></tr></table>
	</div>
</div>
<div class="block5"></div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		采购商品列表
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0">
		<thead>
			<tr class="header">
				<th width="100">商品ID</th>
				<th width="120">SKU</th>
				<th width=""><nobr>商品名称<nobr></th>
				<th width="190">采购数量</th>
				<th width="100">采购价格</th>
				<th width="100">历史价格</th>
				<th width="220">备注</th>
				<!-- <th width="120">操作</th> -->
			</tr>
		</thead>
		<tbody id="purchase_row">
			<?php
if ( $list )
{
foreach ( $list as $val )
{
?>
			<tr id="row_{1}">
				<td><small><?php echo $val['product_id']; ?></small></td>
				<td><small><?php echo $val['sku']; ?></small></td>
				<td>
					<b>名称：</b><?php echo $val['sku_info']['product']['name']; ?>
					<br>
					<span><?php
if ( $val['sku_info']['attribute'] )
{
?><b>属性：</b><?php echo $val['sku_info']['attribute']; ?><?php
}
?></span>
				</td>
				<td align="center">
					<?php echo $val['quantity']; ?>
					<?php
if ( $val['relation_list'] )
{
?>
					<div class="HY-grid">
						<table cellspacing="0" class="data" style="margin-top:5px;">
							<thead>
								<tr class="header">
									<th width="">订单号</th>
									<th width="40">数量</th>
									<th width="40">售价</th>
									<th width="40">费率</th>
								</tr>
							</thead>
							<tbody>
								<?php
if ( $val['relation_list'] )
{
foreach ( $val['relation_list'] as $row )
{
?>
								<tr>
									<td align="center"><small><?php echo $row['order_id']; ?></small></td>
									<td align="center"><small><?php echo $row['quantity']; ?></small></td>
									<td align="center"><small><?php echo $row['price']; ?></small></td>
									<td align="center"><small><?php echo $row['payout_rate']; ?></small></td>
								</tr>
								<?php
}
}
?>
							</tbody>
						</table>
					</div>
					<?php
}
?>
				</td>
				<td align="center">
					&yen;<?php echo $val['price']; ?>
				</td>
				<td align="center">
					&yen;<?php echo $val['history_price']; ?>
				</td>
				<td align="center">
					<?php echo $val['comment']; ?>&nbsp;
				</td>
				<!-- <td align="center">
					<a href="javascript:void(0);" name="remove">移除</a>
				</td> -->
			</tr>
			<?php
}
}
?>
		</tbody>
	</table>
</div>

<div class="HY-form-table" id="base_tab">
	<div class="HY-form-table-header">
		其他
	</div>
	<div class="HY-form-table-main">
		<table width="100%">
			<tr>
				<td width="100">备注</td>
				<td><?php echo $info['comment']; ?></td>
			</tr>
		</table>
		<br />
		<table style="display:none">
			<tr>
				<td width="100">产品经理：</td>
				<td width="180"><?php echo $info['sign_pro_mg_name']; ?> <?php
if ( $info['sign_pro_mg_time'] )
{
?><small>(<?php echo DateFormat($info['sign_pro_mg_time']); ?>)</small><?php
}
?></td>

				<td width="100">业务总监签名：</td>
				<td width="180"><?php echo $info['sign_ope_mj_name']; ?> <?php
if ( $info['sign_ope_mj_time'] )
{
?><small>(<?php echo DateFormat($info['sign_ope_mj_time']); ?>)</small><?php
}
?></td>

				<td width="100">业务副总签名：</td>
				<td width="180"><?php echo $info['sign_ope_vc_name']; ?> <?php
if ( $info['sign_ope_vc_time'] )
{
?><small>(<?php echo DateFormat($info['sign_ope_vc_time']); ?>)</small><?php
}
?></td>
			</tr>
		</table>
	</div>
</div>