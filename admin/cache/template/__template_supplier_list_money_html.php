<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-08-27 11:55:45
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>
<div class="HY-content-header clearfix">
	<h3 class="head-tax-rule">供应商列表 </h3>
	<p class="right">
		<button  id="" type="button" class="scalable back" onclick="window.location='?mod=purchase.supplier.add';" style=""><span>添加供应商</span></button>
	</p>
</div>

<div class="HY-grid-title">
	<div class="HY-grid-title-inner">
		分页:<?php echo $page_bar; ?> 每页20条记录 总共<?php echo $total; ?>条记录 <?php echo $page; ?>/<?php echo $page_num; ?>
	</div>
</div>
<div class="HY-grid">
	<table cellspacing="0" class="data" id="grid_table">
		<thead>
			<tr class="header">
			<th width="40"><div align="center">序号</div></th>
				<th width="80">产品经理</th>
				<th width="">公司名称</th>
				<th width="120">采购总金额</th>
				<th width="120">付款总金额</th>
				<th width="120">应付款总金额</th>
				<th width="120">已请款</th>
				<th width="120">未请款</th>
			</tr>
		</thead>
		<tbody>
			<?php
if ( $list )
{
foreach ( $list as $supplierinfo )
{
?>
			<?php
if ( $supplierinfo['supplier_money']['total_money'] > 0 )
{
?>
			<tr>
			<td align="center"><?php echo $supplierinfo['id']; ?></td>
				<td ><?php echo $supplierinfo['manage_name']; ?></td>
				<td ><?php echo $supplierinfo['name']; ?></td>
				<td>
				货款：<?php echo FormatMoney($supplierinfo['supplier_money']['total_money']['total_money']); ?><br />
				运费：<?php echo FormatMoney($supplierinfo['supplier_money']['total_money']['total_cost']); ?><br />
				合计：<font color="#FF0000"><?php echo FormatMoney($supplierinfo['supplier_money']['total_money']['all_money']); ?></font>
				</td>
				<td >
				货款：<?php echo FormatMoney($supplierinfo['supplier_money']['pay_money']['pay_total_money']); ?><br />
				运费：<?php echo FormatMoney($supplierinfo['supplier_money']['pay_money']['pay_total_cost']); ?><br />
				合计：<font color="#FF0000"><?php echo FormatMoney($supplierinfo['supplier_money']['pay_money']['pay_all_money']); ?></font>
				</td>
				<td >
				货款：<?php echo FormatMoney($supplierinfo['supplier_money']['yfk_money']['yfk_total_money']); ?><br />
				运费：<?php echo FormatMoney($supplierinfo['supplier_money']['yfk_money']['yfk_total_cost']); ?><br />
				合计：<font color="#FF0000"><?php echo FormatMoney($supplierinfo['supplier_money']['yfk_money']['yfk_all_money']); ?></font>
				</td>
				<td >
				货款：<?php echo FormatMoney($supplierinfo['supplier_money']['ready_money']['ready_total_money']); ?><br />
				运费：<?php echo FormatMoney($supplierinfo['supplier_money']['ready_money']['ready_total_cost']); ?><br />
				合计：<font color="#FF0000"><?php echo FormatMoney($supplierinfo['supplier_money']['ready_money']['ready_all_money']); ?></font>
				</td>
				<td >
				货款：<?php echo FormatMoney($supplierinfo['supplier_money']['wqk_money']['wqk_total_money']); ?><br />
				运费：<?php echo FormatMoney($supplierinfo['supplier_money']['wqk_money']['wqk_total_cost']); ?><br />
				合计：<font color="#FF0000"><?php echo FormatMoney($supplierinfo['supplier_money']['wqk_money']['wqk_all_money']); ?></font>
				</td>
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
</div>

