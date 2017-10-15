<?php
/**
* Compiled by NEATTemplate 1.0.0
* Created on : 2013-01-08 10:35:38
*/
?>
<?php if ( !defined( 'IN_NTP' ) ) exit( 'Access Denied' ); ?>


<div class="HY-content-header clearfix-overflow">
	<h3>新建渠道订单</h3>
	<div class="right">
		<button type="button" class="scalable back" onclick="$('#main_form').submit();" style=""><span>下一步</span></button>
	</div>
</div>

<form method="post" id="main_form" onsubmit="return false;">

<div class="HY-form-table" id="base_tab">
	<div class="HY-form-table-header">
		选择渠道
	</div>
	<div class="HY-form-table-main">
		<table cellspacing="0" class="HY-form-table-table">
			<tbody>
				<tr>
					<td class="label"><label>渠道</label></td>
					<td class="value">
						<select name="channel_id">
							<option value="0">----</option>
							<?php
if ( $channel_list )
{
foreach ( $channel_list as $val )
{
?>
							<option value="<?php echo $val['id']; ?>" <?php
if ( $val['id'] == $order['channel_id'] )
{
?>selected<?php
}
?>><?php echo $val['name']; ?></option>
							<?php
}
}
?>
						</select>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
				<tr>
					<td class="label"><label>分期</label></td>
					<td class="value">
						<select name="times">
							<option value="0">----</option>
							<option value="1">1</option>
							<option value="3">3</option>
							<option value="6">6</option>
							<option value="12">12</option>
							<option value="15">15</option>
							<option value="18">18</option>
							<option value="24">24</option>
						</select>
					</td>
					<td><small>&nbsp;</small></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>


</form>